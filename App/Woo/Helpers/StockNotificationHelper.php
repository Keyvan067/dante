<?php

namespace App\Woo\Helpers;

use WC_Product;

defined('ABSPATH') || exit;

class StockNotificationHelper
{

    private static $instance = null;
    private $table_name;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'stock_notifications';
    }

    /**
     * ایجاد جدول در زمان فعال‌سازی
     */
    public function createTable() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        product_id BIGINT(20) UNSIGNED NOT NULL,
        user_id BIGINT(20) UNSIGNED NULL,
        guest_ip VARCHAR(45) NULL,
        guest_agent TEXT NULL,
        email VARCHAR(190) NOT NULL,
        phone VARCHAR(20) NULL,
        status VARCHAR(20) DEFAULT 'pending',
        attempts INT DEFAULT 0,
        last_attempt DATETIME NULL,
        created_at DATETIME NOT NULL,
        notified_at DATETIME NULL,
        PRIMARY KEY (id),
        KEY product_id (product_id),
        KEY user_id (user_id),
        KEY guest_ip (guest_ip),
        KEY product_status (product_id, status),
        KEY product_email (product_id, email)
    ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * دریافت تاریخ پیش‌بینی موجودی
     */
    public function getExpectedRestockDate($product_id): string
    {
        $date = get_post_meta($product_id, '_expected_restock_date', true);
        if (empty($date)) {
            return '';
        }

        return helpers()->date()->jdate('d F Y', strtotime($date));
    }

    /**
     * دریافت IP کاربر
     */
    private function getUserIP(): string
    {
        $ip = '';

        // بررسی هدرهای مختلف proxy
        $headers = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ip_list = explode(',', $_SERVER[$header]);
                $ip = trim($ip_list[0]);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    break;
                }
            }
        }

        return $ip ?: '0.0.0.0';
    }


    /**
     * دریافت User Agent با sanitize
     */
    private function getUserAgent()
    {
        return isset($_SERVER['HTTP_USER_AGENT'])
            ? substr(sanitize_text_field($_SERVER['HTTP_USER_AGENT']), 0, 255)
            : '';
    }

    /**
     * ایجاد کوکی منحصر به فرد برای کاربر مهمان
     */
    private function setGuestCookie($product_id)
    {
        if (!isset($_COOKIE['stock_notifier_guest'])) {
            $guest_id = wp_generate_uuid4();
            setcookie('stock_notifier_guest', $guest_id, time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
        } else {
            $guest_id = $_COOKIE['stock_notifier_guest'];
        }

        // ذخیره درخواست در کوکی مخصوص این محصول
        $product_cookie = 'stock_notifier_product_' . $product_id;
        if (!isset($_COOKIE[$product_cookie])) {
            setcookie($product_cookie, 'requested', time() + YEAR_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
        }
    }

    /**
     * بررسی درخواست تکراری برای کاربر مهمان
     */
    public function hasGuestRequested($product_id): bool
    {
        // بررسی کوکی محصول
        $product_cookie = 'stock_notifier_product_' . $product_id;
        if (isset($_COOKIE[$product_cookie])) {
            return true;
        }

        // بررسی با IP
        $guest_ip = $this->getUserIP();
        global $wpdb;

        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$this->table_name} 
        WHERE product_id = %d AND guest_ip = %s AND status != 'notified'",
            $product_id,
            $guest_ip
        ));

        return !empty($exists);
    }

    /**
     * ذخیره درخواست برای کاربر مهمان
     */
    public function saveGuestRequest($product_id, $email, $phone): array
    {
        global $wpdb;

//        $guest_ip = $this->getUserIP();
//        $guest_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
//
//        error_log("Guest IP: $guest_ip");
//        error_log("Guest Agent: $guest_agent");

        $guest_ip = $this->getUserIP();
        $guest_agent = $this->getUserAgent();

        // بررسی تکراری نبودن
        if ($this->hasGuestRequested($product_id)) {
            return [
                'success' => false,
                'message' => 'شما قبلاً برای این محصول درخواست داده‌اید.'
            ];
        }

        // ذخیره با IP و User Agent
        $result = $wpdb->insert(
            $this->table_name,
            [
                'product_id' => $product_id,
                'user_id' => 0,
                'guest_ip' => $guest_ip,
                'guest_agent' => $guest_agent,
                'email' => $email,
                'phone' => $phone,
                'status' => 'pending',
                'created_at' => current_time('mysql')
            ],
            ['%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s']
        );

        if ($result) {
            $this->setGuestCookie($product_id);
            return [
                'success' => true,
                'message' => 'درخواست شما با موفقیت ثبت شد.'
            ];
        }

        return [
            'success' => false,
            'message' => 'خطا در ثبت درخواست.'
        ];
    }

    /**
     * دریافت آخرین تاریخ موجودی
     */
    public function getLastInStockDate($product_id): string
    {
        $date = get_post_meta($product_id, '_last_in_stock_date', true);
        if (empty($date)) {
            return '';
        }

        return human_time_diff(strtotime($date)) . ' پیش';
    }

    /**
     * دریافت دسته‌بندی اول محصول
     */
    public function getFirstCategorySlug($product_id)
    {
        $categories = wp_get_post_terms($product_id, 'product_cat', ['fields' => 'slugs']);
        return !empty($categories) ? $categories[0] : '';
    }

    /**
     * دریافت آدرس صفحه تماس
     */
    public function getContactPageUrl()
    {
        $contact_page = get_page_by_path('contact');
        return $contact_page ? get_permalink($contact_page) : home_url('/contact');
    }

    /**
     * دریافت آدرس فروشگاه با فیلتر دسته‌بندی
     */
    public function getShopCategoryUrl($category_slug)
    {
        if (empty($category_slug)) {
            return get_permalink(wc_get_page_id('shop'));
        }

        return add_query_arg('category', $category_slug, get_permalink(wc_get_page_id('shop')));
    }

    /**
     * دریافت اطلاعات کاربر فعلی
     */
    public function getCurrentUserInfo(): array
    {
        $user_id = 0;
        $user_email = '';
        $user_phone = '';

        if (is_user_logged_in()) {
            $user = wp_get_current_user();
            $user_id = $user->ID;
            $user_email = $user->user_email;
            $user_phone = get_user_meta($user->ID, 'billing_phone', true);
        }

        return [
            'user_id' => $user_id,
            'email' => $user_email,
            'phone' => $user_phone
        ];
    }

    /**
     * بررسی وجود درخواست تکراری
     */
    public function hasPendingRequest($product_id, $email): bool
    {
        global $wpdb;

        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$this->table_name} 
            WHERE product_id = %d AND email = %s AND status = 'pending'",
            $product_id,
            $email
        ));

        return !empty($exists);
    }


    public function hasUserRequested($product_id, $email) {
        global $wpdb;

        $exists = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$this->table_name} 
        WHERE product_id = %d AND email = %s AND status != 'notified'",
            $product_id,
            $email
        ));

        return !empty($exists);
    }

    /**
     * ذخیره درخواست جدید (بدون بررسی تکراری چون کاربر عضو هست)
     */
    /**
     * ذخیره درخواست برای کاربر عضو
     */
    public function saveRequest($product_id, $user_id, $email, $phone): array
    {
        global $wpdb;

        // دریافت IP حتی برای کاربر عضو
        $guest_ip = $this->getUserIP();
        $guest_agent = $this->getUserAgent();

        // بررسی درخواست قبلی (چه pending چه notified)
        $existing = $wpdb->get_row($wpdb->prepare(
            "SELECT status FROM {$this->table_name} 
        WHERE product_id = %d AND email = %s",
            $product_id,
            $email
        ));

        if ($existing) {
            $message = $existing->status === 'notified'
                ? 'شما قبلاً برای این محصول درخواست داده‌اید و ایمیل اطلاع‌رسانی دریافت کرده‌اید.'
                : 'شما قبلاً برای این محصول درخواست داده‌اید. در اولین فرصت به شما اطلاع می‌دهیم.';

            return [
                'success' => false,
                'message' => $message
            ];
        }

        $result = $wpdb->insert(
            $this->table_name,
            [
                'product_id' => $product_id,
                'user_id' => $user_id,
                'guest_ip' => $guest_ip,
                'guest_agent' => $guest_agent,
                'email' => $email,
                'phone' => $phone,
                'status' => 'pending',
                'created_at' => current_time('mysql')
            ],
            ['%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s'] // 8 تا
        );

        if ($result) {
            return [
                'success' => true,
                'message' => 'درخواست شما با موفقیت ثبت شد.'
            ];
        }

        return [
            'success' => false,
            'message' => 'خطا در ثبت درخواست.'
        ];
    }

    /**
     * دریافت لیست منتظران یک محصول
     */
    public function getWaiters($product_id)
    {
        global $wpdb;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table_name} 
            WHERE product_id = %d AND status = 'pending' AND notified_at IS NULL",
            $product_id
        ));
    }

    /**
     * تغییر وضعیت به processing
     */
    public function markAsProcessing($product_id)
    {
        global $wpdb;

        $wpdb->update(
            $this->table_name,
            ['status' => 'processing'],
            ['product_id' => $product_id, 'status' => 'pending'],
            ['%s'],
            ['%d', '%s']
        );
    }

    /**
     * تغییر وضعیت به notified
     */
    public function markAsNotified($id)
    {
        global $wpdb;

        $wpdb->update(
            $this->table_name,
            [
                'status' => 'notified',
                'notified_at' => current_time('mysql')
            ],
            ['id' => $id],
            ['%s', '%s'],
            ['%d']
        );
    }

    /**
     * ارسال ایمیل به یک درخواست
     */
    public function sendNotificationEmail($request)
    {
        $product = wc_get_product($request->product_id);
        if (!$product) return false;

        $to = $request->email;
        $subject = sprintf('✅ %s موجود شد', $product->get_name());

        $message = $this->getEmailTemplate($product, $request);

        $headers = ['Content-Type: text/html; charset=UTF-8'];

        return wp_mail($to, $subject, $message, $headers);
    }

    /**
     * قالب ایمیل
     */
    private function getEmailTemplate($product, $request): string
    {
        $product_name = $product->get_name();
        $product_url = get_permalink($product->get_id());
        $site_name = get_bloginfo('name');

        return "
        <html>
        <body style='font-family: Tahoma, Arial; direction: rtl;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 10px;'>
                <h2 style='color: #4CAF50;'>✅ محصول مورد نظر شما موجود شد!</h2>
                
                <p style='font-size: 16px; line-height: 1.6;'>
                    سلام،<br>
                    محصول <strong>{$product_name}</strong> که منتظرش بودید، در فروشگاه {$site_name} موجود شد.
                </p>
                
                <div style='text-align: center; margin: 30px 0;'>
                    <a href='{$product_url}' 
                       style='background-color: #4CAF50; color: white; padding: 12px 30px; 
                              text-decoration: none; border-radius: 5px; font-size: 16px;'>
                        🛒 مشاهده و خرید محصول
                    </a>
                </div>
                
                <hr style='border: 1px solid #f0f0f0;'>
                
                <p style='color: #666; font-size: 14px;'>
                    این ایمیل به درخواست شما ارسال شده است.
                    اگر تمایل به دریافت این ایمیل‌ها ندارید، می‌توانید از طریق پنل کاربری تنظیمات خود را تغییر دهید.
                </p>
            </div>
        </body>
        </html>
        ";
    }
}