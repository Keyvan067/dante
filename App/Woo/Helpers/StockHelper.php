<?php

namespace App\Woo\Helpers;

use WC_Product;

defined('ABSPATH') || exit;

class StockHelper
{

    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * تعیین وضعیت موجودی محصول برای نمایش فرم سبد خرید
     *
     * @param WC_Product $product
     * @return string (outofstock|backorder|simple|variable|external|grouped|virtual|downloadable)
     */
    public function getProductStockView(WC_Product $product): string
    {
        // اول بررسی کن محصول از نوع خارجی هست
        if ($product->is_type('external')) {
            return 'external';
        }

        // محصول گروهی
        if ($product->is_type('grouped')) {
            return $this->handleGroupedProduct($product);
        }

        // اگر قابل خرید نیست
        if (!$product->is_purchasable()) {
            // اگه ناموجود هست، بگو outofstock
            if (!$product->is_in_stock()) {
                return 'outofstock';
            }
            return 'not-purchasable';
        }

        // محصول ساده
        if ($product->is_type('simple')) {
            return $this->handleSimpleProduct($product);
        }

        // محصول متغیر
        if ($product->is_type('variable')) {
            return $this->handleVariableProduct($product);
        }

        return 'other';
    }

    /**
     * پردازش محصول ساده
     */
    private function handleSimpleProduct(WC_Product $product): string
    {
        // بررسی نوع مجازی یا دانلودی
        if ($product->is_virtual() || $product->is_downloadable()) {
            return 'virtual';
        }

        // سفارش‌گذاری (backorder)
        if ($product->is_on_backorder(1)) {
            return 'backorder';
        }

        // ناموجود
        if (!$product->is_in_stock()) {
            return 'outofstock';
        }

        // موجود
        return 'simple';
    }

    /**
     * پردازش محصول متغیر
     */
    private function handleVariableProduct(WC_Product $product): string
    {
        // اگر هیچ variation قابل خریدی نداره
        if (!$product->is_in_stock()) {
            return 'outofstock';
        }

        $has_backorder = false;
        $has_in_stock = false;

        // بررسی variation‌ها
        foreach ($product->get_children() as $variation_id) {
            $variation = wc_get_product($variation_id);

            if (!$variation) {
                continue;
            }

            // اگر موجود باشه
            if ($variation->is_in_stock()) {
                $has_in_stock = true;
            }

            // اگر backorder باشه
            if ($variation->is_on_backorder(1)) {
                $has_backorder = true;
            }
        }

        // اگر هم موجود داریم هم backorder
        if ($has_in_stock && $has_backorder) {
            return 'variable-mixed';
        }

        // اگر فقط backorder داریم
        if ($has_backorder) {
            return 'backorder';
        }

        // اگر موجود داریم
        if ($has_in_stock) {
            return 'variable';
        }

        return 'outofstock';
    }

    /**
     * پردازش محصول خارجی/افیلیت
     */
    private function handleExternalProduct(WC_Product $product): string
    {
        return 'external';
    }

    /**
     * پردازش محصول گروهی
     */
    private function handleGroupedProduct(WC_Product $product): string
    {
        $children = $product->get_children();

        if (empty($children)) {
            return 'grouped-empty';
        }

        $has_in_stock = false;

        foreach ($children as $child_id) {
            $child = wc_get_product($child_id);
            if ($child && $child->is_in_stock()) {
                $has_in_stock = true;
                break;
            }
        }

        return $has_in_stock ? 'grouped-available' : 'grouped-outofstock';
    }

    /**
     * پردازش محصول مجازی یا دانلودی
     */
    private function handleVirtualProduct(WC_Product $product): string
    {
        // محصولات مجازی و دانلودی همیشه موجود هستن (معمولاً)
        return 'virtual';
    }

    /**
     * دریافت متن وضعیت موجودی برای نمایش
     */
    public function getStockStatusText(WC_Product $product): string
    {
        $status = $this->getProductStockView($product);

        $messages = [
            'simple' => __('موجود در انبار', 'dante'),
            'variable' => __('موجود در انبار', 'dante'),
            'variable-mixed' => __('تعداد محدود', 'dante'),
            'virtual' => __('محصول دیجیتال - آماده دانلود', 'dante'),
            'backorder' => __('پیش‌سفارش', 'dante'),
            'outofstock' => __('ناموجود', 'dante'),
            'external' => __('محصول خارجی', 'dante'),
            'grouped-available' => __('مجموعه محصولات', 'dante'),
            'grouped-outofstock' => __('ناموجود', 'dante'),
            'grouped-empty' => __('بدون محصول', 'dante'),
            'not-purchasable' => __('قابل خرید نیست', 'dante'),
            'other' => __('نامشخص', 'dante'),
        ];

        return $messages[$status] ?? __('نامشخص', 'dante');
    }

    /**
     * دریافت کلاس CSS برای وضعیت موجودی
     */
    public function getStockStatusClass(WC_Product $product): string
    {
        $status = $this->getProductStockView($product);

        $classes = [
            'simple' => 'in-stock',
            'variable' => 'in-stock',
            'variable-mixed' => 'limited-stock',
            'virtual' => 'in-stock',
            'backorder' => 'on-backorder',
            'outofstock' => 'out-of-stock',
            'external' => 'external-product',
            'grouped-available' => 'in-stock',
            'grouped-outofstock' => 'out-of-stock',
            'grouped-empty' => 'out-of-stock',
            'not-purchasable' => 'not-purchasable',
            'other' => 'unknown',
        ];

        return $classes[$status] ?? 'unknown';
    }

    /**
     * بررسی اینکه آیا محصول نیاز به فرم خرید داره
     */
    public function needsAddToCartForm(WC_Product $product): bool
    {
        $type = $this->getProductStockView($product);

        // محصولات خارجی و گروهی فرم جداگانه دارن
        return !in_array($type, ['external', 'grouped-available', 'grouped-outofstock']);
    }

    /**
     * بررسی اینکه آیا محصول قابل نمایش هست
     */
    public function isPurchasable(WC_Product $product): bool
    {
        return $product->is_purchasable();
    }

    /**
     * بررسی وضعیت backorder
     */
    public function isOnBackorder(WC_Product $product, $quantity = 1): bool
    {
        return $product->is_on_backorder($quantity);
    }

    /**
     * بررسی موجود بودن
     */
    public function isInStock(WC_Product $product): bool
    {
        return $product->is_in_stock();
    }
}