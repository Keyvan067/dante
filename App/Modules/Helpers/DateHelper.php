<?php
namespace App\Modules\Helpers;

/**
 * کلاس مدیریت تاریخ
 * تبدیل تاریخ میلادی به شمسی
 */
class DateHelper {

    private static $instance = null;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * تبدیل تاریخ میلادی به شمسی
     * با پشتیبانی از افزونه‌های تاریخ شمسی
     *
     * @param string $format فرمت تاریخ
     * @param int $timestamp Timestamp (اختیاری)
     * @param string $timezone منطقه زمانی (اختیاری)
     * @return string
     */
    public function jdate($format, $timestamp = null, $timezone = null)
    {
        // اگر timestamp داده نشده، از زمان فعلی استفاده کن
        if (is_null($timestamp)) {
            $timestamp = current_time('timestamp');
        }

        // اگر افزونه WP-Persian یا wp-jalali نصب شده باشد
        if (function_exists('wp_date') && function_exists('gregorian_to_jalali')) {
            // استفاده از توابع افزونه‌های فارسی
            return wp_date($format, $timestamp, $timezone);
        }

        // اگر افزونه تاریخ شمسی وجود ندارد، از تاریخ میلادی استفاده کن
        return date_i18n($format, $timestamp);
    }

    /**
     * دریافت تاریخ خوانا به فارسی
     * مثال: "۳ روز پیش" یا "۱۵ دی ۱۴۰۲"
     *
     * @param string $date تاریخ (مثلاً 2023-12-15)
     * @return string
     */
    public function getPersianDate($date)
    {
        if (empty($date)) {
            return '';
        }

        $timestamp = strtotime($date);
        $time_diff = time() - $timestamp;

        // اگر کمتر از ۲۴ ساعت گذشته
        if ($time_diff < 86400) {
            return human_time_diff($timestamp) . ' پیش';
        }

        // نمایش تاریخ شمسی
        return $this->jdate('d F Y', $timestamp);
    }

    /**
     * دریافت تاریخ شمسی با فرمت عددی
     * مثال: ۱۴۰۲/۱۰/۱۵
     *
     * @param string $date تاریخ میلادی
     * @return string
     */
    public function getPersianNumericDate($date)
    {
        if (empty($date)) {
            return '';
        }

        $timestamp = strtotime($date);
        return $this->jdate('Y/m/d', $timestamp);
    }

    /**
     * بررسی اینکه تاریخ امروز هست یا نه
     *
     * @param string $date تاریخ
     * @return bool
     */
    public function isToday($date)
    {
        $timestamp = strtotime($date);
        $today = strtotime(date('Y-m-d'));

        return date('Y-m-d', $timestamp) == date('Y-m-d', $today);
    }
}