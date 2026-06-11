<?php

namespace App\Modules\Theme;

use App\Contracts\ModuleInterface;

class Setup implements ModuleInterface
{

    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function register()
    {
        add_action('after_setup_theme', [$this, 'registerMenus']);
        add_action('after_setup_theme', [$this, 'themeSetup']);
        add_action('widgets_init', [$this, 'registerWidgets']);
    }

    public function boot()
    {
    }

    /**
     * تنظیمات اصلی تم
     */
    public function themeSetup(): void
    {
        // پشتیبانی از RSS feed
        add_theme_support('automatic-feed-links');
        // پشتیبانی از title تگ
        add_theme_support('title-tag');
        // پشتیبانی از تصویر شاخص
        add_theme_support('post-thumbnails');
        // پشتیبانی از لوگوی سفارشی
        add_theme_support('custom-logo', [
            'height' => 100,
            'width' => 400,
            'flex-height' => true,
            'flex-width' => true,
        ]);
        // پشتیبانی از HTML5
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ]);
        // پشتیبانی از ووکامرس (اگه فعال باشه)
        if (class_exists('WooCommerce')) {
            add_theme_support('woocommerce');
            add_theme_support('wc-product-gallery-zoom');
            add_theme_support('wc-product-gallery-lightbox');
            add_theme_support('wc-product-gallery-slider');

            // ✅ این خط رو اضافه کن
//            add_filter('woocommerce_template_path', function() {
//                return 'woocommerce/';
//            });
        }
    }

    /**
     * ثبت منوهای ناوبری
     */
    public function registerMenus()
    {
        $menus = [
            'main-menu' => __('منوی اصلی', 'dante'),
            'mega-menu' => __('مگا منو و دسته بندی فروشگاه', 'dante'),
            'footer-guide' => __('راهنمای خرید', 'dante'),
            'footer-support' => __('خدمات مشتریان', 'dante'),
            'footer-help-menu' => __('منو راهنمای کاربر', 'dante'),
        ];

        register_nav_menus($menus);
    }

    /**
     * ثبت سایدبارها و ویجت‌ها
     */
    public function registerWidgets()
    {
        register_sidebar([
            'name' => __('سایدبار اصلی', 'dante'),
            'id' => 'sidebar-main',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ]);

        register_sidebar([
            'name' => __('فوتر', 'dante'),
            'id' => 'sidebar-footer',
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="footer-widget-title">',
            'after_title' => '</h4>',
        ]);
    }
}