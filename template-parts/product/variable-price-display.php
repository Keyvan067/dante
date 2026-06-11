<?php
defined('ABSPATH') || exit;

$product = $args['product'] ?? null;
if (!$product || !$product->is_type('variable')) {
    return;
}
?>

<div class="variable-price-display" id="variable-price-display">
    <!-- قیمت و تخفیف به صورت داینامیک با JS به‌روزرسانی میشه -->
    <div class="flex items-center gap-4">
        <div class="price-section">
            <span class="regular-price hidden line-through text-gray-400"></span>
            <span class="sale-price font-bold text-xl text-primary"></span>
        </div>
        <div class="discount-badge bg-red-500 text-white px-2 py-1 rounded hidden">
            <span class="discount-percent"></span>% تخفیف
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {
        $(document).on('found_variation', '.variations_form', function(event, variation) {
            let regularPrice = parseFloat(variation.display_regular_price);
            let salePrice = parseFloat(variation.display_price);

            // نمایش قیمت
            if (regularPrice > salePrice) {
                // تخفیف خورده
                $('.regular-price').text(wooFormatPrice(regularPrice)).removeClass('hidden');
                $('.sale-price').text(wooFormatPrice(salePrice));

                // محاسبه درصد تخفیف
                let discount = Math.round((regularPrice - salePrice) / regularPrice * 100);
                $('.discount-percent').text(discount);
                $('.discount-badge').removeClass('hidden');
            } else {
                // بدون تخفیف
                $('.regular-price').addClass('hidden');
                $('.sale-price').text(wooFormatPrice(salePrice));
                $('.discount-badge').addClass('hidden');
            }
        });

        $(document).on('reset_data', '.variations_form', function() {
            // برگشت به حالت اولیه
            $('.regular-price').addClass('hidden');
            $('.sale-price').text('');
            $('.discount-badge').addClass('hidden');
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