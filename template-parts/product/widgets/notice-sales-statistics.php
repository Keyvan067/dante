<?php
defined('ABSPATH') || exit;
$product_id = $args['product_id'] ?? null;
?>

<div class="w-full flex items-center justify-start py-2">
    <i class="fa-solid fa-fire-flame-curved"></i>
    <span><?php echo esc_html(woo()->getWeeklySalesStat($product_id)); ?></span>
</div>
