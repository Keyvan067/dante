<?php
defined('ABSPATH') || exit;
$product_id = $args['product_id'] ?? null;
?>

<div class="w-full flex items-center justify-start gap-2 py-3 border-t border-base-200">
    <i class="fa-regular fa-trophy-star"></i>
    <div class="text-default">
        <?php
        /* $reward_points = get_post_meta($product_id, '_reward_points', true);
         $points = $reward_points ? absint($reward_points) : 120;*/
        ?>
        <span class="h4_title !text-amber-500">20<?php //echo esc_html($points); ?></span>
        <span class="h5_title !text-amber-500"> امتیاز </span>
        <span> با خرید محصول دریافت می‌کنید </span>
    </div>
</div>
