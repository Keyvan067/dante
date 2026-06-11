<?php

namespace App\Woo\Hooks;

defined('ABSPATH') || exit;

class ProductHooks
{

    private static $instance = null;
    /**
     * @var ProductTabs|null
     */
    private $productTabs;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->productTabs = ProductTabs::getInstance();
    }

    /**
     * ثبت همه هوک‌های مربوط به محصولات
     */
    public function register()
    {
        $this->productTabs->register();
        // حذف هوک‌های پیش‌فرض
        $this->removeDefaultHooks();

        // اضافه کردن هوک‌های سفارشی
        $this->addCustomHooks();

        // هوک‌های تب‌های محصول
        $this->registerProductTabs();
    }


// دسترسی به توابع تب‌ها از طریق ProductHooks
    public function tabHasContent($tab, $product = null)
    {
        return $this->productTabs->tabHasContent($tab, $product);
    }

    public function getProductIntro($product = null)
    {
        return $this->productTabs->getProductIntro($product);
    }

    public function getProductSpecifications($product = null): array
    {
        return $this->productTabs->getProductSpecifications($product);
    }

    /**
     * حذف هوک‌های پیش‌فرض ووکامرس
     */
    private function removeDefaultHooks()
    {
        // حذف wrapperهای پیش‌فرض
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

        // غیرفعال کردن گالری و تخفیف
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

        // حذف breadcrumb
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    }

    /**
     * اضافه کردن هوک‌های سفارشی
     */
    private function addCustomHooks()
    {
        // wrapperهای سفارشی
        add_action('woocommerce_before_main_content', [$this, 'themeWrapperStart'], 10);
        add_action('woocommerce_after_main_content', [$this, 'themeWrapperEnd'], 10);

        // Disable default WooCommerce product tabs completely
        add_filter('woocommerce_product_tabs', [$this, 'themeDisableWooTabs'], 99);

        // فیلد تعداد محصول
        add_action('woocommerce_before_quantity_input_field', [$this, 'beforeQuantityInput'], 10);
        add_action('woocommerce_after_quantity_input_field', [$this, 'afterQuantityInput'], 10);

        // تغییر نوع input تعداد
        add_filter('woocommerce_quantity_input_type', [$this, 'forceQuantityInputType'], 10);
    }

    //Theme-Wrapper-MainContent.
    public function themeWrapperStart()
    {
        echo '<main class="product-page container-4xl-w">';
    }

    public function themeWrapperEnd()
    {
        echo '</main>';
    }

    public function themeDisableWooTabs($tabs): array
    {
        return array();
    }

    //Render-Single-Product-Tabs.

    /**
     * ثبت تب‌های محصول
     */
    private function registerProductTabs()
    {
        add_action('theme_single_product_tabs', [$this, 'renderProductTabs']);
    }

    /**
     * رندر تب‌های محصول
     */
    public function renderProductTabs()
    {
        if (!is_product()) {
            return;
        }

        get_template_part('template-parts/product/tabs/tab');
    }

    /**
     * قبل از فیلد تعداد
     */
    public function beforeQuantityInput()
    {
        echo '<span class="minus dis"></span>';
    }

    /**
     * بعد از فیلد تعداد
     */
    public function afterQuantityInput()
    {
        echo '<span class="plus"></span>';
    }

    /**
     * تغییر نوع input تعداد به text
     */
    public function forceQuantityInputType($type): string
    {
        return 'text'; // یا number
    }
}