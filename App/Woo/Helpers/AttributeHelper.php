<?php
namespace App\Woo\Helpers;

use WC_Product;

defined('ABSPATH') || exit;

class AttributeHelper {

    private static $instance = null;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * دریافت ویژگی‌های متغیر محصول
     */
    public function getVariationAttributes(WC_Product $product): array
    {
        if (!$product->is_type('variable')) {
            return [];
        }

        $attributes = $product->get_variation_attributes();
        $default_attributes = $product->get_default_attributes();

        $formatted_attributes = [];

        foreach ($attributes as $attribute_name => $attribute_values) {

            $taxonomy = str_replace('attribute_', '', $attribute_name);
            $terms = wc_get_product_terms($product->get_id(), $taxonomy);

            if (empty($terms) || is_wp_error($terms)) {
                continue;
            }

            $attribute_type = $this->detectAttributeType($terms);

            $formatted_attributes[] = [
                'name'           => $attribute_name,
                'taxonomy'       => $taxonomy,
                'label'          => wc_attribute_label($taxonomy),
                'terms'          => $terms,
                'default_value'  => $default_attributes[$taxonomy] ?? '',
                'type'           => $attribute_type,
            ];
        }

        return $formatted_attributes;
    }

    /**
     * تشخیص نوع ویژگی (رنگ یا متن)
     */
    private function detectAttributeType($terms): string
    {
        foreach ($terms as $term) {
            $color = get_term_meta($term->term_id, 'product_attribute_color', true);
            if (!empty($color)) {
                return 'color';
            }
        }
        return 'text';
    }

    /**
     * دریافت رنگ یک ترم
     */
    public function getTermColor($term_id): string
    {
        return get_term_meta($term_id, 'product_attribute_color', true);
    }

    /**
     * بررسی اینکه آیا ترم رنگ دارد
     */
    public function termHasColor($term_id): bool
    {
        return !empty($this->getTermColor($term_id));
    }
}