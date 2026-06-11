<?php

namespace App\Woo\Email;

use App\Woo\Helpers\StockNotificationHelper;

defined('ABSPATH') || exit;

class EmailSender
{

    private static $instance = null;
    private $notificationHelper;
    private $max_attempts = 3;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->notificationHelper = StockNotificationHelper::getInstance();
    }

    /**
     * ارسال ایمیل با مدیریت خطا
     */
    public function send($request_id)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_notifications';

        // لود درخواست
        $request = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM $table_name WHERE id = %d AND status IN ('processing', 'pending')",
            $request_id
        ));

//        if (!$request) {
//            error_log("❌ Request not found: $request_id");
//            return false;
//        } else {
//            error_log("✅ Request found: " . print_r($request, true));
//        }
//
//        if (!$request) {
//            error_log("EmailSender: Request #$request_id not found");
//            return false;
//        }

        // بررسی تعداد تلاش‌ها
        if ($request->attempts >= $this->max_attempts) {
            $this->markAsFailed($request_id, 'max_attempts');
            //error_log("EmailSender: Max attempts reached for request #$request_id");
            return false;
        }

        // لود محصول
        $product = wc_get_product($request->product_id);
        if (!$product) {
            $this->markAsFailed($request_id, 'product_not_found');
            //error_log("EmailSender: Product #$request->product_id not found");
            return false;
        }

        // به‌روزرسانی تعداد تلاش‌ها
        $wpdb->update(
            $table_name,
            [
                'attempts' => $request->attempts + 1,
                'last_attempt' => current_time('mysql')
            ],
            ['id' => $request_id],
            ['%d', '%s'],
            ['%d']
        );

        // ساخت قالب ایمیل
        $subject = $this->getEmailSubject($product);
        $message = $this->getEmailTemplate($product, $request);
        $headers = ['Content-Type: text/html; charset=UTF-8'];

        //error_log("📧 About to send email to: " . $request->email);
        //error_log("📧 Subject: " . $subject);
        // $phpmailer = "";
        // $phpmailer->setFrom(get_option('admin_email'), get_bloginfo('name'));
        // ارسال ایمیل
        $sent = wp_mail($request->email, $subject, $message, $headers);

        if ($sent) {
            // موفقیت
            $wpdb->update(
                $table_name,
                [
                    'status' => 'notified',
                    'notified_at' => current_time('mysql')
                ],
                ['id' => $request_id],
                ['%s', '%s'],
                ['%d']
            );

            //error_log("EmailSender: Email sent to {$request->email} for product #{$request->product_id}");
            return true;
        }
        // error_log("EmailSender: Failed to send email to {$request->email} (Attempt {$request->attempts})");
        // اگه هنوز فرصت هست، بذار processing بمونه برای تلاش مجدد
        if ($request->attempts < $this->max_attempts) {
            return false;
        }
        $this->markAsFailed($request_id, 'send_failed');
        return false;
    }

    /**
     * علامت‌گذاری به عنوان failed
     */
    private function markAsFailed($request_id, $reason = '')
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_notifications';

        $wpdb->update(
            $table_name,
            [
                'status' => 'failed',
                'last_attempt' => current_time('mysql')
            ],
            ['id' => $request_id],
            ['%s', '%s'],
            ['%d']
        );

        // به ادمین ایمیل بزن (اختیاری)
        if ($reason) {
            $this->notifyAdmin($request_id, $reason);
        }
    }

    /**
     * اطلاع به ادمین در صورت خطا
     */
    private function notifyAdmin($request_id, $reason)
    {
        $admin_email = get_option('admin_email');
        $subject = 'خطا در ارسال ایمیل اطلاع‌رسانی';
        $message = "درخواست #$request_id با خطا مواجه شد.\nدلیل: $reason";

        wp_mail($admin_email, $subject, $message);
    }

    private function getEmailSubject($product)
    {
        return sprintf('✅ %s - محصول مورد نظر شما موجود شد', get_bloginfo('name'));
    }

    private function getEmailTemplate($product, $request)
    {
        $product_name = $product->get_name();
        $product_url = get_permalink($product->get_id());
        $site_name = get_bloginfo('name');
        $site_logo = get_theme_mod('custom_logo') ? wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') : '';
        $home_url = home_url();

        ob_start();
        ?>
        <!DOCTYPE html>
        <html dir="rtl" lang="fa">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>موجودی محصول</title>
        </head>
        <body style="font-family: Tahoma, Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
        <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

            <!-- Header -->
            <div style="background-color: #4CAF50; padding: 20px; text-align: center;">
                <?php if ($site_logo): ?>
                    <img src="<?php echo esc_url($site_logo); ?>" alt="<?php echo esc_attr($site_name); ?>"
                         style="max-height: 50px; margin-bottom: 10px;">
                <?php endif; ?>
                <h1 style="color: #ffffff; margin: 0; font-size: 24px;">✅ محصول مورد نظر شما موجود شد!</h1>
            </div>

            <!-- Body -->
            <div style="padding: 30px;">

                <p style="font-size: 16px; line-height: 1.6; color: #333; margin-bottom: 20px;">
                    سلام،<br>
                    محصول <strong style="color: #4CAF50;"><?php echo esc_html($product_name); ?></strong> که منتظرش
                    بودید،
                    در فروشگاه <?php echo esc_html($site_name); ?> موجود شد.
                </p>

                <!-- Product Info -->
                <div style="background-color: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                    <h3 style="margin-top: 0; color: #333;">اطلاعات محصول</h3>
                    <p style="margin: 5px 0;"><strong>نام محصول:</strong> <?php echo esc_html($product_name); ?></p>
                    <p style="margin: 5px 0;"><strong>قیمت:</strong> <?php echo wc_price($product->get_price()); ?></p>
                    <?php if ($product->is_in_stock()): ?>
                        <p style="margin: 5px 0; color: #4CAF50;"><strong>وضعیت:</strong> موجود در انبار</p>
                    <?php endif; ?>
                </div>

                <!-- Button -->
                <div style="text-align: center; margin: 30px 0;">
                    <a href="<?php echo esc_url($product_url); ?>"
                       style="background-color: #4CAF50; color: #ffffff; padding: 15px 40px;
                                  text-decoration: none; border-radius: 5px; font-size: 18px; font-weight: bold;
                                  display: inline-block; transition: background-color 0.3s;">
                        🛒 مشاهده و خرید محصول
                    </a>
                </div>

                <!-- Additional Info -->
                <div style="background-color: #f0f8ff; border: 1px solid #cce5ff; border-radius: 5px; padding: 15px; margin-top: 20px;">
                    <p style="margin: 0; color: #0066cc; font-size: 14px;">
                        <strong>ℹ️ نکته:</strong> این ایمیل به دلیل درخواست شما برای اطلاع‌رسانی موجودی محصول ارسال شده
                        است.
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div style="background-color: #f8f8f8; padding: 20px; text-align: center; border-top: 1px solid #e0e0e0;">
                <p style="margin: 0; color: #666; font-size: 13px;">
                    &copy; <?php echo date('Y'); ?> <?php echo esc_html($site_name); ?> - تمامی حقوق محفوظ است.<br>
                    <a href="<?php echo esc_url($home_url); ?>"
                       style="color: #4CAF50; text-decoration: none;"><?php echo esc_html($site_name); ?></a>
                </p>
            </div>
        </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}