<?php

namespace App\Modules\Assets;

use App\Contracts\ModuleInterface;

class Assets implements ModuleInterface
{
    private static $instance = null;
    private $version;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $theme = wp_get_theme();
        $this->version = $theme->get('Version') ?: '1.0.0';
    }

    public function register(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueFrontend']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin']);
    }

    public function boot(): void
    {
        // کاری نداریم
    }

    public function enqueueFrontend(): void
    {
        // ۱. لود فونت‌ها
        $this->enqueueFonts();

        // ۲. لود استایل‌ها
        $this->enqueueStyles();

        // ۳. لود اسکریپت‌ها
        $this->enqueueScripts();

        // ۳. لود ازاکس
        $this->enqueueAjax();
    }

    //::IMPORTS-STYLESHEETS...
    public function enqueueStyles(): void
    {
        // Main Style
        wp_enqueue_style(
            'style',
            get_stylesheet_uri(),
            array(),
            $this->version
        );
        wp_enqueue_style(
            'swiper-bundle',
            get_theme_file_uri('/assets/css/swiper-bundle.min.css'),
            array(),
            $this->version
        );
        wp_enqueue_style(
            'FontAwesome',
            get_theme_file_uri('/assets/icons/FontAwesome/css/all.css'),
            array(),
            '7.2.0'
        );
        wp_enqueue_style(
            'fonts',
            get_theme_file_uri('/assets/fonts/fonts.css'),
            array(),
            $this->version
        );
        wp_enqueue_style(
            'stories-options',
            get_theme_file_uri('/assets/css/stories.css'),
            array(),
            $this->version
        );
        wp_enqueue_style(
            'stylesheet',
            get_theme_file_uri('/assets/css/style.css'),
            array(),
            $this->version
        );
        wp_enqueue_style(
            'single-product-stylesheet',
            get_theme_file_uri('/assets/css/single-product.css'),
            array(),
            $this->version
        );
        wp_enqueue_style(
            'daisyUI-output',
            get_theme_file_uri('public/output.css'),
            array(),
            $this->version
        );
    }

    //::IMPORTS-JAVASCRIPT...
    public function enqueueScripts(): void
    {
        // Main JS
        wp_enqueue_script(
            'app-main',
            get_theme_file_uri('/assets/js/main.js'),
            ['jquery'],
            $this->version,
            true
        );
        wp_enqueue_script(
            'apexcharts',
            get_template_directory_uri() . '/assets/js/apexcharts.js',
            array('jquery'),
            '1.0.0',
            false
        );
        wp_enqueue_script(
            'tailwind', get_template_directory_uri() . '/assets/js/tailwind.js',
            array(),
            '4.1.13',
            true
        );
        wp_enqueue_script(
            'stories',
            get_theme_file_uri('/assets/js/stories.js'),
            ['jquery'],
            $this->version,
            true
        );
        wp_enqueue_script(
            'swiper-options',
            get_theme_file_uri('/assets/js/swiper-options.js'),
            ['jquery'],
            $this->version,
            true
        );
        wp_enqueue_script(
            'swiper-bundle',
            get_theme_file_uri('/assets/js/swiper-bundle.min.js'),
            ['jquery'],
            $this->version,
            true
        );
        wp_enqueue_script(
            'FontAwesome',
            get_theme_file_uri('/assets/icons/FontAwesome/js/all.js'),
            ['jquery'],
            '7.2.0',
            true
        );
        wp_enqueue_script(
            'header-options',
            get_theme_file_uri('/assets/js/header.js'),
            ['jquery'],
            $this->version,
            true
        );

        wp_enqueue_script(
            'product-gallery',
            get_theme_file_uri('/assets/js/product-gallery.js'),
            ['jquery'],
            $this->version,
            true
        );
        wp_enqueue_script(
            'product-variable',
//            get_theme_file_uri('/assets/js/product-variable.js'),
            get_template_directory_uri() . '/assets/js/product-variable.js',
            array(),
            $this->version,
            true,
        );
        wp_enqueue_script(
            'single-product-tabs',
            get_theme_file_uri('/assets/js/single-product-tabs.js'),
            ['jquery'],
            $this->version,
            true
        );
        wp_enqueue_script(
            'custom-modal',
            get_theme_file_uri('/assets/js/modal.js'),
            ['jquery'],
            $this->version,
            true
        );

        wp_enqueue_script(
            'simple-review',
            get_theme_file_uri('/assets/js/simple-review.js'),
            ['jquery'],
            $this->version,
            true
        );

        wp_enqueue_script(
            'purchaser-review',
            get_theme_file_uri('/assets/js/purchaser-review.js'),
            ['jquery'],
            $this->version,
            true
        );

        /*۲. استایل ووکامرس (اگه ووکامرس فعال بود)*/
        /*if ($this->isWooCommerceActive()) {
            wp_enqueue_style(
                'my-shop-woocommerce',
                get_template_directory_uri() . '/assets/css/woocommerce.css',
                array(),
                $this->version
            );
        }*/
        /*اسکریپت سبد خرید*/
        /* if (is_cart()) {
             wp_enqueue_script(
                 'my-shop-cart',
                 get_template_directory_uri() . '/assets/js/cart.js',
                 ['jquery', 'my-shop-main'],
                 $this->version,
                 true
             );
         }*/

    }

    public function enqueueAdmin($hook): void
    {

        wp_enqueue_style(
            'admin-ui',
            get_theme_file_uri('public/admin-ui.css'),
            array(),
            $this->version
        );

        // مثلاً فقط در صفحه تنظیمات تم
        /*        if ($hook == 'themes.php') {
                    wp_enqueue_style('App-admin', get_template_directory_uri() . '/assets/css/admin.css');

                    //Import-FontAwesome...
                    wp_enqueue_style(
                        'FontAwesome',
                        get_theme_file_uri('/assets/icons/FontAwesome/css/all.css'),
                        array(),
                        null,
                        '7.2.0'
                    );
                    wp_enqueue_script(
                        'FontAwesome',
                        get_theme_file_uri('/assets/icons/FontAwesome/js/all.js'),
                        array(),
                        '7.2.0',
                        true
                    );
                }*/
    }


    public function enqueueAjax(): void
    {
        // ارسال داده به JS برای فرم‌های دیدگاه
        if (is_product()) {
            wp_localize_script('app-main', 'pdkData', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'simpleReviewNonce' => wp_create_nonce('simple_review_nonce'),
                'secureReviewNonce' => wp_create_nonce('secure_review'),
                'themeUrl' => get_template_directory_uri(),
                'assetsUrl' => get_template_directory_uri() . '/assets',
                'imagesUrl' => get_template_directory_uri() . '/assets/images',
            ]);
        }
    }

    /**
     * داده‌هایی که به جاوااسکریپت میفرستیم
     */
    private function getLocalizeData(): array
    {
        return [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('my_shop_nonce'),
//            'simple_review_nonce' => wp_create_nonce('simple_review_nonce'),
            'isUserLoggedIn' => is_user_logged_in(),
            'cartUrl' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : '',
            'checkoutUrl' => function_exists('wc_get_checkout_url') ? wc_get_checkout_url() : '',
        ];
    }


    /**
     * بررسی فعال بودن ووکامرس
     */
    /*    private function isWooCommerceActive() {
            return class_exists('WooCommerce');
        }*/


    /**
     * متد کمکی برای گرفتن آدرس تصاویر
     */
    public function getImage($path)
    {
        return get_template_directory_uri() . '/assets/images/' . ltrim($path, '/');
    }


    /**
     * متد کمکی برای گرفتن آدرس فونت‌ها
     */
    private function enqueueFonts()
    {
        /*// روش ترکیبی: اول فونت محلی، اگه نبود گوگل
        $local_font = get_template_directory() . '/assets/fonts/vazir/vazir.css';

        if (file_exists($local_font)) {
            // فونت محلی موجوده
            wp_enqueue_style(
                'vazir-font',
                get_template_directory_uri() . '/assets/fonts/vazir/vazir.css',
                [],
                $this->version
            );
        } else {
            // فالت به گوگل فونت
            wp_enqueue_style(
                'vazir-font',
                'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700&display=swap',
                [],
                null
            );
        }*/
    }

}