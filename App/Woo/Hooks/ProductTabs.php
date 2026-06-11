<?php
namespace App\Woo\Hooks;

use WC_Product;

defined('ABSPATH') || exit;

class ProductTabs {

    private static $instance = null;
    private $cache = [];

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function register() {
        add_action('theme_single_product_tabs', [$this, 'render']);
    }

    public function render() {
        if (!is_product()) {
            return;
        }

        // فقط یک بار رندر کن
        static $rendered = false;
        if ($rendered) {
            return;
        }


        //get_template_part('template-parts/product/tabs/tab');
        $rendered = true;
    }

    /**
     * بررسی وجود محتوا برای تب
     */
    public function tabHasContent($tab, $product = null) {

        if (!$product) {
            $product = wc_get_product(get_the_ID());
        }

        if (!$product instanceof WC_Product) {
            return false;
        }

        $product_id = $product->get_id();
        $cache_key = $product_id . '_' . $tab;

        if (isset($this->cache[$cache_key])) {
            return $this->cache[$cache_key];
        }

        switch ($tab) {
            case 'intro':
                $content = $product->get_short_description();
                break;

            case 'description':
                $content = $product->get_description();
                break;

            case 'specs':
                $specs = $this->getProductSpecifications($product);
                $content = !empty($specs);
                break;

            default:
                $content = false;
                break;
        }

        $this->cache[$cache_key] = !empty($content);
        return $this->cache[$cache_key];
    }

    /**
     * دریافت معرفی محصول
     */
    public function getProductIntro($product = null) {

        if (!$product) {
            global $product;
        }

        if (!$product instanceof WC_Product) {
            return '';
        }

        $description = $product->get_description();

        if (!$description) {
            return '';
        }

        return apply_filters('the_content', $description);
    }

    /**
     * دریافت مشخصات فنی محصول
     */
    public function getProductSpecifications($product = null): array
    {

        if (!$product) {
            global $product;
        }

        if (!$product instanceof WC_Product) {
            return [];
        }

        $attributes = $product->get_attributes();

        if (empty($attributes)) {
            return [];
        }

        $specs = [];

        foreach ($attributes as $attribute) {

            // Skip hidden attributes
            if (!$attribute->get_visible()) {
                continue;
            }

            $name = wc_attribute_label($attribute->get_name());
            $value = '';

            // Taxonomy attribute (pa_*)
            if ($attribute->is_taxonomy()) {

                $terms = wc_get_product_terms(
                    $product->get_id(),
                    $attribute->get_name(),
                    ['fields' => 'names']
                );

                if (!empty($terms)) {
                    $value = implode('، ', $terms);
                }

            } else {
                // Custom product attribute
                $value = implode('، ', $attribute->get_options());
            }

            if ($value) {
                $specs[] = [
                    'label' => $name,
                    'value' => $value,
                ];
            }
        }

        return $specs;
    }
}