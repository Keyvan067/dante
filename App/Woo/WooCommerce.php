<?php

namespace App\Woo;

use App\Contracts\ModuleInterface;

class WooCommerce implements ModuleInterface
{

    private static $instance = null;
    private $productHelper;
    private $productHooks;
    private $stockHelper;
    private $attributeHelper;
    /**
     * @var Helpers\ProductInfoHelper|null
     */
    private $productInfoHelper;
    /**
     * @var Helpers\StockNotificationHelper|null
     */
    private $notificationHelper;
    /**
     * @var Ajax\StockNotificationAjax|null
     */
    private $ajax;
    private $stockListener;
    private $queue;
    private $reviewHelper;
    private $reviewAjax;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->productHelper = Helpers\ProductHelper::getInstance();
        $this->productHooks = Hooks\ProductHooks::getInstance();
        $this->stockHelper = Helpers\StockHelper::getInstance();
        $this->attributeHelper = Helpers\AttributeHelper::getInstance();
        $this->productInfoHelper = Helpers\ProductInfoHelper::getInstance();
        $this->notificationHelper = Helpers\StockNotificationHelper::getInstance();
        //@AJAX...
        $this->ajax = Ajax\StockNotificationAjax::getInstance();
        //...
        $this->stockListener = Listeners\StockListener::getInstance();
        $this->queue = Queue\NotificationQueue::getInstance();

        $this->reviewHelper = Helpers\ReviewHelper::getInstance();
        $this->reviewAjax = Ajax\ReviewAjax::getInstance();
    }

    public function register()
    {
        // ثبت هوک‌ها
        $this->productHooks->register();
        //#AJAX
        $this->ajax->register();
        //...
        $this->stockListener->register();
        $this->queue->register();
        $this->reviewAjax->register();
    }

    public function boot()
    {
    }

    // ===== توابع محصول =====
    public function getProductImages($product): array
    {
        return $this->productHelper->getProductImages($product);
    }

    public function getProductCategories($product_id): false|array
    {
        return $this->productHelper->getProductCategories($product_id);
    }

    public function getProductBrands($product_id): false|array
    {
        return $this->productHelper->getProductBrands($product_id);
    }

    public function getProductRating($product): float
    {
        return $this->productHelper->getProductRating($product);
    }

    public function getProductDiscountPercent($product): int
    {
        return $this->productHelper->getProductDiscountPercent($product);
    }

    public function getRegularPrice($product): string
    {
        return $this->productHelper->getRegularPrice($product);
    }

    public function getSalePrice($product): string
    {
        return $this->productHelper->getSalePrice($product);
    }

    public function tabHasContent($tab, $product = null)
    {
        return $this->productHooks->tabHasContent($tab, $product);
    }

    public function getProductIntro($product = null)
    {
        return $this->productHooks->getProductIntro($product);
    }

    public function getProductSpecifications($product = null): array
    {
        return $this->productHooks->getProductSpecifications($product);
    }

    // ===== توابع موجودی =====
    public function getProductStockView($product): string
    {
        return $this->stockHelper->getProductStockView($product);
    }

    public function getStockStatusText($product): string
    {
        return $this->stockHelper->getStockStatusText($product);
    }

    public function getStockStatusClass($product): string
    {
        return $this->stockHelper->getStockStatusClass($product);
    }

    public function isPurchasable($product): bool
    {
        return $this->stockHelper->isPurchasable($product);
    }

    public function isInStock($product): bool
    {
        return $this->stockHelper->isInStock($product);
    }

    // ===== دریافت ویژگی های محصول متغیر =====
    public function getVariationAttributes($product): array
    {
        return $this->attributeHelper->getVariationAttributes($product);
    }

    public function getTermColor($term_id): string
    {
        return $this->attributeHelper->getTermColor($term_id);
    }

    public function getPriceUpdateDate($product): string
    {
        return $this->productHelper->getPriceUpdateDate($product);
    }

    public function getWeeklySalesStat($product_id): string
    {
        return $this->productHelper->getWeeklySalesStat($product_id);
    }

    // دریافت آیتم های اضافه (متن و آیکون)...
    public function getProductExtraInfo($product_id): array
    {
        return $this->productInfoHelper->getProductExtraInfo($product_id);
    }

    public function hasExtraInfo($product_id): bool
    {
        return $this->productInfoHelper->hasExtraInfo($product_id);
    }


    //StockNotificationHelper...
    //دریافت و ارسال پارامتر ها برای محصول ناموجود...
    // ===== توابع اطلاع‌رسانی =====
    public function getExpectedRestockDate($product_id): string
    {
        return $this->notificationHelper->getExpectedRestockDate($product_id);
    }

    public function getLastInStockDate($product_id): string
    {
        return $this->notificationHelper->getLastInStockDate($product_id);
    }

    public function getFirstCategorySlug($product_id)
    {
        return $this->notificationHelper->getFirstCategorySlug($product_id);
    }

    public function getContactPageUrl(): false|string|null
    {
        return $this->notificationHelper->getContactPageUrl();
    }

    public function getShopCategoryUrl($category_slug): false|string
    {
        return $this->notificationHelper->getShopCategoryUrl($category_slug);
    }

    /*
     * comments...
     */

    public function getCurrentUserInfo(): array
    {
        return $this->notificationHelper->getCurrentUserInfo();
    }

    public function displayStars($rating): string
    {
        return $this->productHelper->displayStars($rating);
    }

    public function getReviewContext(): array
    {
        return $this->reviewHelper->getReviewContext();
    }

    public function getCustomerGalleryImages($product_id): array
    {
        return $this->productHelper->getCustomerGalleryImages($product_id);
    }

}