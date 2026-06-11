<?php

namespace App\Woo\Helpers;

use WC_Product;

class ProductHelper
{

    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //دریافت تصاویر محصول...
    public function getProductImages(WC_Product $product): array
    {
        if (!$product->get_image_id()) {
            return [];
        }

        $gallery_ids = $product->get_gallery_image_ids();
        $main_id = $product->get_image_id();

        return array_values(
            array_unique(
                array_filter(array_merge([$main_id], $gallery_ids))
            )
        );
    }

    //دریافت دسته‌بندی‌های محصول...

    /**
     * @param int $product_id
     * @return array|false
     **/
    public function getProductCategories($product_id): false|array
    {
        return get_the_terms($product_id, 'product_cat');
    }


    // دریافت برند محصول...

    /**
     * taxonomy product_brand
     * @param int $product_id
     * @return array|false
     */
    public function getProductBrands($product_id): false|array
    {
        if (taxonomy_exists('product_brand')) {
            return get_the_terms($product_id, 'product_brand');
        }
        return false;
    }

    /*دریافت امتیاز محصول...*/
    /**
     * @param WC_Product $product
     * @return float
     */
    public function getProductRating(WC_Product $product): float
    {
        return $product->get_average_rating();
    }

    /**
     * نمایش ستاره‌های امتیاز به صورت HTML
     *
     * @param float $rating
     * @return string
     */
    public function displayStars(float $rating): string
    {
        $full_stars = floor($rating);
        $half_star = ($rating - $full_stars) >= 0.5;
        $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

        $stars = '';

        // ستاره‌های پر
        for ($i = 0; $i < $full_stars; $i++) {
            $stars .= '<i class="fa-solid fa-star text-amber-500"></i>';
        }

        // نیم‌ستاره
        if ($half_star) {
            $stars .= '<i class="fa-regular fa-star-half-alt text-amber-500"></i>';
        }

        // ستاره‌های خالی
        for ($i = 0; $i < $empty_stars; $i++) {
            $stars .= '<i class="fa-regular fa-star text-amber-500"></i>';
        }

        return $stars;
    }
   /* دریافت درصد تخفیف محصول...*/
    /**
     * @param WC_Product $product
     * @return int
     */
    public function getProductDiscountPercent(WC_Product $product): int
    {
        if (!$product->is_on_sale()) {
            return 0;
        }

        $regular_price = (float)$product->get_regular_price();
        $sale_price = (float)$product->get_sale_price();

        if ($regular_price > 0 && $sale_price > 0 && $regular_price > $sale_price) {
            return round((($regular_price - $sale_price) / $regular_price) * 100);
        }

        return 0;
    }

    /*دریافت قیمت اصلی محصول (با فرمت)...*/
    public function getRegularPrice(WC_Product $product): string
    {
        return wc_price($product->get_regular_price());
    }

    /*دریافت قیمت فروش محصول (با فرمت)...*/
    public function getSalePrice(WC_Product $product): string
    {
        return wc_price($product->get_sale_price());
    }

    /**
     * دریافت تاریخ آخرین بروزرسانی قیمت به صورت شمسی
     */
    public function getPriceUpdateDate($product): string
    {
        $modified_date = $product->get_date_modified();

        if (!$modified_date) {
            return 'نامشخص';
        }

        $timestamp = $modified_date->getTimestamp();
        return helpers()->date()->jdate('j F', $timestamp);
    }

    /**
     * دریافت آمار فروش هفتگی
     *
     * @param int $product_id
     * @return string
     */
    public function getWeeklySalesStat($product_id): string
    {
        $sales_last_week = get_post_meta($product_id, '_sales_last_week', true);

        if ($sales_last_week && is_numeric($sales_last_week)) {
            return sprintf(
                __('%d+ فروش در هفته اخیر', 'dante'),
                absint($sales_last_week)
            );
        }

        // تیکر فروشنگان دیجیتال...محصول فروش نداشته ولی این ترفند بازاره متاسفانه.
        return __('محصول پرفروش', 'dante');
    }

    /**
     * ذخیره تاریخچه قیمت
     */
    public function recordPriceHistory($product_id, $new_price): void
    {
        $history = get_post_meta($product_id, '_price_history', true);
        if (!is_array($history)) {
            $history = [];
        }

        // اضافه کردن رکورد جدید
        array_unshift($history, [
            'date' => current_time('mysql'),
            'price' => $new_price
        ]);

        // نگه داشتن فقط ۵۰ رکورد آخر
        $history = array_slice($history, 0, 50);

        update_post_meta($product_id, '_price_history', $history);
    }

    /*
     * دریافت تصاویر ارسالی کاربر-خریدار *
     */
    public function getCustomerGalleryImages($product_id): array
    {
        $customer_images = [];

        $comments = get_comments([
            'post_id' => $product_id,
            'type'    => 'review',
            'status'  => 'approve',
            'meta_key' => 'review_images',
            'meta_compare' => 'EXISTS'
        ]);

        foreach ($comments as $comment) {
            $image_ids = get_comment_meta($comment->comment_ID, 'review_images', true);
            if (is_array($image_ids)) {
                foreach ($image_ids as $id) {
                    $full_url = wp_get_attachment_image_url($id, 'full');
                    $thumb_url = wp_get_attachment_image_url($id, 'thumbnail');
                    if ($full_url) {
                        $customer_images[] = [
                            'id'         => $id,
                            'url'        => $thumb_url,
                            'full_url'   => $full_url,
                            'author'     => $comment->comment_author,
                            'comment_id' => $comment->comment_ID,
                        ];
                    }
                }
            }
        }

        return $customer_images;
    }

}