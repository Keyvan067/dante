<?php
defined('ABSPATH') || exit;

$product_id = $args['product_id'] ?? get_the_ID();
$info_items = woo()->getProductExtraInfo($product_id);

if (empty($info_items)) {
    return;
}
?>

<div class="product-extra-info flex flex-col gap-4 items-start justify-center py-2">
    <?php foreach ($info_items as $item): ?>
        <div class="extra-info-item flex items-center justify-start gap-2">
            <?php if (!empty($item['icon'])): ?>
                <i class="<?php echo esc_attr($item['icon']); ?> text-strong text-lg"></i>
            <?php endif; ?>
            <span class="text-sm text-gray-700"><?php echo esc_html($item['text']); ?></span>
        </div>
    <?php endforeach; ?>
</div>