<?php
defined('ABSPATH') || exit;
// دریافت مقادیر ارسال شده
$product = $args['product'] ?? null;
$discount_percent = $args['discount_percent'] ?? 0;
$regular_price = $args['regular_price'] ?? 0;
$sale_price = $args['sale_price'] ?? 0;
if (empty($regular_price) && isset($product)) {
    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();
}
//if (!$product) {
//    return;
//}
// بررسی‌های امنیتی
if (!$product || !is_a($product, 'WC_Product')) {
    return;
}
$product_id = $product->get_id();
?>
<div class="product--info">
    <!-- آیتم‌های اضافه -->
    <?php if ($product->is_in_stock()) { ?>
        <div class="notice-statistics">
            <?php get_template_part('template-parts/product/widgets/extra-info'); ?>
            <!-- notice-last-price-update -->
            <?php get_template_part('template-parts/product/widgets/notice-last-price-update', null, array('product' => $product)); ?>
            <!-- notice-sales-statistics -->
            <?php get_template_part('template-parts/product/widgets/notice-sales-statistics', null, array('product_id' => $product_id)); ?>
        </div>
        <!-- live-information-ticker -->
        <div class="live-information-ticker">
            <?php get_template_part('template-parts/product/widgets/live-information-ticker', null, array('product_id' => $product_id)); ?>
        </div>
    <?php } ?>
    <!-- بخش قیمت -->
    <div class="add-to-card-wrapper">
        <?php if ($discount_percent > 0): ?>
        <div class="pdk-simple-price text-left">
            <div id="variable-price-display" class="variable-price-display">
                <div class="variation-discount-badge">
                <span>
                    %<span class="variation-discount-percent"><?php echo esc_html($discount_percent); ?></span>
                </span>
                </div>
            </div>
        <?php endif; ?>
            <?php if ($sale_price > 0): ?>
                <del class="regular-price"><?php echo wc_price($regular_price); ?></del>
                <span class="flex flex-nowrap items-center gap-1">
                <ins class="sale-price"><?php echo wc_price($sale_price); ?></ins>
                <span class="currency-symbol currency-irr"></span>
            </span>
            <?php else: ?>
                <span class="regular-price"><?php echo wc_price($regular_price); ?></span>
                <span class="currency-symbol currency-irr"></span>
            <?php endif; ?>
        </div>

        <!--فرم افزودن به سبد خرید ووکامرس...-->
        <div class="pdk-quantity-block">
            <div class="pdk-add-to-cart simple-card">
                <?php
                woocommerce_template_single_add_to_cart();
                ?>
            </div>
        </div>
    </div>
    <?php if ($product->is_in_stock()) { ?>
        <div class="notice-statistics border-none">
            <!-- notice-reward-points -->
            <?php get_template_part('template-parts/product/widgets/notice-reward_points', null, array('product_id' => $product_id)); ?>
        </div>
    <?php } ?>
</div>