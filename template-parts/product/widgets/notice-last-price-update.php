<?php
defined('ABSPATH') || exit;
$product = $args['product'] ?? null;
?>
<div class="w-full flex items-center justify-start gap-4 py-2">
    <span class="text-right">
        <i class="fa-regular fa-acorn fa-lg"></i>
        آخرین بروزرسانی قیمت
    </span>
    <span><?php echo esc_html(woo()->getPriceUpdateDate($product)); ?></span>
</div>