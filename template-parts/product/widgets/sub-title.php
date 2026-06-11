<?php
defined('ABSPATH') || exit;
$product_id = $args['product_id'] ?? null;
$variant_info = get_field('variant_info', $product_id);
?>
<div class="product-subtitle">
    <span class="product-condition"> کارکرده </span>
    <?php if (!empty($variant_info)): ?>
        <span>
            <?php echo esc_html($variant_info); ?>
        </span>
    <?php endif; ?>
</div>
