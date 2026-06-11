<?php


defined('ABSPATH') || exit;

global $product;
// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if (!is_a($product, WC_Product::class) || !$product->is_visible()) {
    return;
}
?>
<li <?php wc_product_class('', $product); ?>>

</li>