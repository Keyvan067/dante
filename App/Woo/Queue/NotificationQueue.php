<?php

namespace App\Woo\Queue;

use App\Woo\Email\EmailSender;

defined('ABSPATH') || exit;

class NotificationQueue
{

    private static $instance = null;
    private $emailSender;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->emailSender = EmailSender::getInstance();
    }

    public function register()
    {
        add_action('init', [$this, 'setupActionScheduler']);
        add_action('stock_notifier_send_email', [$this, 'processEmail'], 10, 1);
    }

    /**
     * راه‌اندازی Action Scheduler اگه وجود داشت
     */
    public function setupActionScheduler()
    {
        if (function_exists('as_enqueue_async_action')) {
            add_action('stock_notifier_send_email_action', [$this, 'processEmail'], 10, 1);
        }
    }

    /**
     * دریافت تعداد آیتم‌های در حال انتظار در صف
     */
    private function getQueueCount(): int
    {
        if (function_exists('as_get_scheduled_actions')) {
            $actions = as_get_scheduled_actions([
                'hook' => 'stock_notifier_send_email_action',
                'status' => \ActionScheduler_Store::STATUS_PENDING
            ]);
            return count($actions);
        }

        // fallback برای وقتی Action Scheduler نیست
        return 0;
    }

    /**
     * اضافه کردن به صف
     */
    public function addToQueue($request_id, $custom_delay = null)
    {
        // چک کن چند تا توی صف هست
        $queue_count = $this->getQueueCount();

        if ($custom_delay !== null) {
            $delay = $custom_delay;
        } elseif ($queue_count > 100) {
            $delay = 300; // 5 دقیقه
        } elseif ($queue_count > 50) {
            $delay = 120; // 2 دقیقه
        } else {
            $delay = 30;  // 30 ثانیه
        }

        //error_log("Queue: Adding request #$request_id to queue (delay: {$delay}s)");

        if (function_exists('as_enqueue_async_action')) {
            as_enqueue_async_action(
                'stock_notifier_send_email_action',
                ['request_id' => $request_id],
                '',
                $delay
            );
            //error_log("Queue: Added to Action Scheduler");
        } else {
            wp_schedule_single_event(time() + $delay, 'stock_notifier_send_email', [$request_id]);
            //error_log("Queue: Added to WP Cron");
        }
    }

    /**
     * پردازش ایمیل
     */
    public function processEmail($request_id)
    {
        //error_log("Queue: Processing request #$request_id");
        $result = $this->emailSender->send($request_id);
//        if ($result) {
//            error_log("Queue: Email sent successfully for request #$request_id");
//        } else {
//            error_log("Queue: Failed to send email for request #$request_id");
//        }
    }

    /**
     * پردازش دستی صف (برای دیباگ)
     */
    public function processQueue($product_id = null)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_notifications';

        $where = "status = 'processing'";
        if ($product_id) {
            $where .= $wpdb->prepare(" AND product_id = %d", $product_id);
        }

        $requests = $wpdb->get_results("SELECT * FROM $table_name WHERE $where");

        foreach ($requests as $request) {
            $this->processEmail($request->id);
        }
    }

    /**
     * پاک کردن صف (برای دیباگ)
     */
    public function clearQueue()
    {
        if (function_exists('as_unschedule_all_actions')) {
            as_unschedule_all_actions('stock_notifier_send_email_action');
            as_unschedule_all_actions('stock_notifier_send_email');
            //error_log("Queue: All actions cleared");
        }
    }
}