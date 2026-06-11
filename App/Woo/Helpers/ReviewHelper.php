<?php
namespace App\Woo\Helpers;

defined('ABSPATH') || exit;

class ReviewHelper {

    private static $instance = null;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * دریافت وضعیت کاربر برای ثبت دیدگاه
     *
     * @return array
     */
    public function getReviewContext() {
        global $product;

        if (!is_user_logged_in()) {
            return [
                'state' => 'guest',
                'product' => $product
            ];
        }

        $user_id = get_current_user_id();
        $product_id = $product->get_id();

        // بررسی خرید قبلی کاربر
        $has_purchased = true;
//        $has_purchased = wc_customer_bought_product($user_id, '', $product_id);

        // بررسی دیدگاه قبلی
        $has_reviewed = $this->hasUserReviewed($product_id, $user_id);

        if (!$has_purchased) {
            if ($has_reviewed) {
                return [
                    'state' => 'logged_no_purchase_reviewed',
                    'product' => $product
                ];
            }
            return [
                'state' => 'logged_no_purchase_no_review',
                'product' => $product
            ];
        }

        if ($has_reviewed) {
            return [
                'state' => 'purchased_reviewed',
                'product' => $product
            ];
        }

        return [
            'state' => 'purchased_no_review',
            'product' => $product
        ];
    }

    /**
     * بررسی اینکه کاربر قبلاً دیدگاه ثبت کرده
     */
    private function hasUserReviewed($product_id, $user_id): bool
    {
        $comments = get_comments([
            'post_id' => $product_id,
            'user_id' => $user_id,
            'type' => 'review',
            'status' => 'approve',
            'count' => true
        ]);

        return $comments > 0;
    }

    //تاریخ اخرین خرید...
    public function getCustomerLastOrderDate($product_id) {
        if (!is_user_logged_in()) {
            return 'تاریخ خرید: نامشخص';
        }

        $user_id = get_current_user_id();
        $orders = wc_get_orders([
            'customer_id' => $user_id,
            'status' => ['completed', 'processing'],
            'limit' => 1,
            'return' => 'ids'
        ]);

        if (empty($orders)) {
            return 'تاریخ خرید: نامشخص';
        }

        $order = wc_get_order($orders[0]);
        return $order->get_date_created()->date_i18n('Y/m/d');
    }

    public function submitPurchaserReview() {
        // بررسی nonce
        // بررسی user logged in
        // ذخیره امتیاز، عنوان، متن، تصاویر، shipping، packaging
        // بازگشت نتیجه
    }

}