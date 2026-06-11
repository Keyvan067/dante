<?php
namespace App\Modules\Admin;

use App\Contracts\ModuleInterface;

class ACFPages implements ModuleInterface {

    private static $instance = null;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * ثبت همه هوک‌های مربوط به ACF
     */
    public function register() {
        add_action('init', [$this, 'addACFOptionsPages']);
        add_action('admin_head', [$this, 'customMenuIcon']);
    }

    public function boot() {
        // کاری نداریم
    }

    /**
     * اضافه کردن صفحات گزینه‌های ACF
     */
    public function addACFOptionsPages() {
        // اول بررسی کنیم ACF فعال هست؟
        if (!function_exists('acf_add_options_page')) {
            return; // اگه ACF نیست، هیچ کاری نکن
        }

        // صفحه تنظیمات ویجت‌ها
        acf_add_options_page([
            'page_title' => 'تنظیمات ویجت ها',
            'menu_title' => 'ویجت ها',
            'menu_slug'  => 'widgets-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'position'   => 50,
        ]);

        // صفحه تنظیمات فوتر
        acf_add_options_page([
            'page_title' => 'تنظیمات فوتر',
            'menu_title' => 'فوتر سایت',
            'menu_slug'  => 'footer-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
        ]);
    }

    /**
     * تغییر آیکون منوی ویجت‌ها
     */
    public function customMenuIcon() {
        ?>
        <style>
            #toplevel_page_widgets-settings .wp-menu-image:before {
                /* font-family: "Font Awesome 6 Free" !important; */
                font-family: dashicons;
                font-weight: 400;
                content: "\f116";
                /* content: "\f022"; */
                font-size: 1.4em;
            }
        </style>
        <?php
    }

    /**
     * (اختیاری) اضافه کردن فونت آیکون در ادمین
     * اگه Font Awesome هنوز لود نشده
     */
    public function enqueueAdminFonts() {
        add_action('admin_enqueue_scripts', function() {
            wp_enqueue_style(
                'font-awesome',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css',
                [],
                '6.0.0'
            );
        });
    }
}