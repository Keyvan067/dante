<?php
namespace App\Woo\Listeners;

use App\Woo\Helpers\StockNotificationHelper;
use App\Woo\Queue\NotificationQueue;

defined('ABSPATH') || exit;

class StockListener
{
    private static $instance = null;
    private $notificationHelper;
    private $queue;

    // فاصله زمانی امن بین تغییرات (ثانیه)
    const SAFE_INTERVAL = 300; // 5 دقیقه

    // تعداد ارسال در هر بسته
    const BATCH_SIZE = 50;

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
        $this->queue = NotificationQueue::getInstance();
    }

    public function register()
    {
        // قبل از ذخیره، مقدار قبلی رو ذخیره کن
        add_action('woocommerce_before_product_object_save', [$this, 'beforeProductSave'], 10, 2);

        // بعد از ذخیره، چک کن تغییر کرده
        add_action('woocommerce_after_product_object_save', [$this, 'afterProductSave'], 10, 2);
    }

    /**
     * قبل از ذخیره محصول - مقدار قبلی رو ذخیره کن
     */
    public function beforeProductSave($product, $data_store)
    {
        if (!$product->get_id()) {
            return;
        }

        $product_id = $product->get_id();
        $old_status = get_post_meta($product_id, '_stock_status', true);

        // ذخیره در کش موقت
        wp_cache_set('old_stock_status_' . $product_id, $old_status, 'stock_listener', 30);

        // همچنین در متای محصول هم ذخیره کن برای استفاده‌های بعدی
        update_post_meta($product_id, '_previous_stock_status', $old_status);

        //error_log("Before save - Product #{$product_id} old status: " . ($old_status ?: 'empty'));
    }

    /**
     * بعد از ذخیره محصول - بررسی کن تغییر کرده
     */
    public function afterProductSave($product, $data_store)
    {
        $product_id = $product->get_id();
        // دریافت قیمت قبلی از دیتابیس
        $old_price = get_post_meta($product_id, '_price', true);
        $new_price = $product->get_price();
//        error_log("💰 Price change - Product #$product_id old: $old_price, new: $new_price");
        // اگه قیمت تغییر کرده بود، توی تاریخچه ثبت کن
        if ($old_price !== $new_price) {
            $this->recordPriceHistory($product_id, $new_price);
        }

        // دریافت مقدار قبلی از کش
        $old_status = wp_cache_get('old_stock_status_' . $product_id, 'stock_listener');
        $new_status = $product->get_stock_status();

        // اگه توی کش نبود، از متای قبلی استفاده کن
        if (!$old_status) {
            $old_status = get_post_meta($product_id, '_previous_stock_status', true);
        }

       // error_log("After save - Product #{$product_id} old: {$old_status}, new: {$new_status}");

        // فقط وقتی از outofstock به instock تغییر کرده
        if ($old_status === 'outofstock' && $new_status === 'instock') {
            $this->handleStockBecameAvailable($product_id);
        }

        // پاک کردن کش
        wp_cache_delete('old_stock_status_' . $product_id, 'stock_listener');

        if ($old_status === 'outofstock' && $new_status === 'instock') {
           // error_log("✅ Product became in stock! Checking waiters...");

            $waiters = $this->notificationHelper->getWaiters($product_id);
           // error_log("Found " . count($waiters) . " waiters with status=pending");

            $this->handleStockBecameAvailable($product_id);
        }
    }

    /**
     * مدیریت وقتی محصول موجود شد
     */
    private function handleStockBecameAvailable($product_id)
    {
        // بررسی تغییرات سریع و مکرر
        if (!$this->isSafeToNotify($product_id)) {
            //error_log("⏱️ Product #{$product_id}: تغییر مجدد در کمتر از " . self::SAFE_INTERVAL . " ثانیه - نادیده گرفته شد");
            return;
        }

        // ثبت زمان آخرین تغییر
        update_post_meta($product_id, '_last_stock_change', current_time('mysql'));

        // دریافت لیست منتظران
        $waiters = $this->notificationHelper->getWaiters($product_id);
        $total_waiters = count($waiters);

       // error_log("✅ Product #{$product_id} became in stock! Found {$total_waiters} waiters");

        if (empty($waiters)) {
            return;
        }

        // تغییر وضعیت همه به processing
        $this->notificationHelper->markAsProcessing($product_id);

        // ارسال تدریجی
        $this->scheduleBatchNotifications($product_id, $waiters);
    }

    /**
     * بررسی امن بودن زمان برای اطلاع‌رسانی
     */
    private function isSafeToNotify($product_id)
    {
        $last_change = get_post_meta($product_id, '_last_stock_change', true);

        if (!$last_change) {
            return true; // اولین باره
        }

        $time_diff = time() - strtotime($last_change);

        // اگه کمتر از فاصله امن گذشته، اطلاع‌رسانی نکن
        return $time_diff >= self::SAFE_INTERVAL;
    }

    /**
     * برنامه‌ریزی ارسال تدریجی
     */
    private function scheduleBatchNotifications($product_id, $waiters)
    {
        $batches = array_chunk($waiters, self::BATCH_SIZE);
        $delay = 0;

        foreach ($batches as $index => $batch) {
            foreach ($batch as $waiter) {
                // هر بسته با تأخیر متفاوت
                $this->queue->addToQueue($waiter->id, $delay);
            }

            // بین بسته‌ها ۵ دقیقه فاصله بذار
            $delay += 300; // 5 دقیقه
        }

//        error_log("📦 Scheduled " . count($batches) . " batches for product #{$product_id}");
    }

}