<?php
namespace App\Woo\Ajax;

use App\Woo\Helpers\StockNotificationHelper;

defined('ABSPATH') || exit;

class StockNotificationAjax {

    private static $instance = null;
    private $notificationHelper;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->notificationHelper = StockNotificationHelper::getInstance();
    }

    public function register() {
        add_action('wp_ajax_outofstock_notify', [$this, 'handleNotification']);
        add_action('wp_ajax_nopriv_outofstock_notify', [$this, 'handleNotification']);
    }

    public function handleNotification() {
        //error_log('===== Stock Notification Request =====');
        //error_log('POST data: ' . print_r($_POST, true));
        // بررسی nonce
        if (!isset($_POST['outofstock_nonce']) || !wp_verify_nonce($_POST['outofstock_nonce'], 'outofstock_notify')) {
            wp_send_json_error(['message' => 'خطای امنیتی']);

            //error_log('Nonce failed');
            wp_send_json_error(['message' => 'خطای امنیتی']);
        }

        $product_id = (int)($_POST['product_id'] ?? 0);
        $email = sanitize_email($_POST['email'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');

        if (!$product_id || !is_email($email)) {
            wp_send_json_error(['message' => 'ایمیل نامعتبر است']);
        }

        if (is_user_logged_in()) {
            // کاربر عضو
            $user_id = get_current_user_id();
            $result = $this->notificationHelper->saveRequest($product_id, $user_id, $email, $phone);
        } else {
            // کاربر مهمان
            $result = $this->notificationHelper->saveGuestRequest($product_id, $email, $phone);
        }

        if ($result['success']) {
            wp_send_json_success(['message' => $result['message']]);
        } else {
            wp_send_json_error(['message' => $result['message']]);
        }
    }
}