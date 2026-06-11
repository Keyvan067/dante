<?php
require_once __DIR__ . '/App/Core/Autoload.php';
\App\Core\Autoload::register();
if (class_exists('WooCommerce')) {
    add_theme_support('woocommerce');
}

// توابع کمکی
if (!function_exists('helpers')) {
    function helpers()
    {
        return \App\Modules\Helpers\Helpers::getInstance();
    }
}

if (!function_exists('assets')) {
    function assets()
    {
        return \App\Modules\Assets\Assets::getInstance();
    }
}

if (!function_exists('theme')) {
    function theme()
    {
        return \App\Core\Loader::getInstance();
    }
}

// همه ماژول‌ها register میشن
add_action('after_setup_theme', function () {
    theme()->registerModules();
});


add_action('init', function () {
    theme()->boot();
});


if (!function_exists('woo')) {
    function woo()
    {
        return \App\Woo\WooCommerce::getInstance();
    }
}

// ایجاد جدول stock_notifications در زمان فعال‌سازی تم
add_action('after_switch_theme', function () {
    $notificationHelper = \App\Woo\Helpers\StockNotificationHelper::getInstance();
    $notificationHelper->createTable();
});

add_filter('template_include', function ($template) {
    if (is_singular('product')) {
        $new_template = get_template_directory() . '/woocommerce/single-product.php';
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}, 99);

@ini_set('upload_max_filesize', '10M');
@ini_set('post_max_size', '10M');
@ini_set('max_execution_time', '300');