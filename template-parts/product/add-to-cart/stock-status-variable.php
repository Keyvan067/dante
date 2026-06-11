<?php
defined('ABSPATH') || exit;

$product = $args['product'] ?? null;
if (!$product || !$product->is_type('variable')) {
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
    <!-- المان ناموجود بودن ورییشن های محصول -->
    <div class="variation-not-available">
        <span> این ترکیب فعلا در دسترس نیست </span>
    </div>
    <div class="add-to-card-wrapper">
        <div id="variable-price-display" class="variable-price-display">
            <div class="variation-discount-badge"><span>%<span class="variation-discount-percent"></span></span></div>
        </div>
        <!-- Add-to-cart-Form -->
        <div class="pdk-quantity-block">
            <div class="pdk-add-to-cart">
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
    <!--END-WOO-FORM..-->
</div>
<!-- قیمت و تخفیف به صورت داینامیک با JS به‌روزرسانی میشه -->
<script>
    jQuery(document).ready(function ($) {
        $(document).on('found_variation', '.variations_form', function (event, variation) {
            let regularPrice = parseFloat(variation.display_regular_price);
            let salePrice = parseFloat(variation.display_price);

            // نمایش قیمت
            if (regularPrice > salePrice) {
                // تخفیف خورده
                $('.regular-price').text(wooFormatPrice(regularPrice)).removeClass('hidden');
                $('.sale-price').text(wooFormatPrice(salePrice));

                // محاسبه درصد تخفیف
                let discount = Math.round((regularPrice - salePrice) / regularPrice * 100);
                $('.variation-discount-percent').text(discount);
                $('.variation-discount-percent-sm').text(discount);
                $('.variation-discount-badge').removeClass('hidden');
            } else {
                // بدون تخفیف
                $('.regular-price').addClass('hidden');
                $('.sale-price').text(wooFormatPrice(salePrice));
                $('.variation-discount-badge').addClass('hidden');
            }
        });

        $(document).on('reset_data', '.variations_form', function () {
            // برگشت به حالت اولیه
            $('.regular-price').addClass('hidden');
            $('.sale-price').text('');
            $('.variation-discount-badge').addClass('hidden');
        });

        // تابع فرمت کردن قیمت (مشابه wc_price)
        function wooFormatPrice(price) {
            return new Intl.NumberFormat('fa-IR', {
                style: 'currency',
                currency: 'IRR',
                minimumFractionDigits: 0
            }).format(price);
        }
    });
</script>