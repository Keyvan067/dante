<?php
$product_category= $args['product_category'] ?? null;
$parent_term = null;
$child_term = null;
if (!empty($product_category) && !is_wp_error($product_category)) {
    foreach ($product_category as $term) {
        if ($term->parent !== 0) {
            $child_term = $term;
            break;
        }
    }
    if ($child_term) {
        $parent_term = get_term($child_term->parent, 'product_cat');
    } else {
        $parent_term = $product_category[0];
    }
}
?>

<div class="flex items-center gap-2">
    <?php if ($parent_term): ?>
        <a href="<?php echo esc_url(get_term_link($parent_term)); ?>" target="_blank"
           rel="noopener noreferrer">
            <strong class="font-normal">
                <?php echo esc_html($parent_term->name); ?>
            </strong>
        </a>
    <?php endif; ?>

    <?php if ($child_term): ?>
        <span>،</span>
        <a href="<?php echo esc_url(get_term_link($child_term)); ?>" target="_blank"
           rel="noopener noreferrer">
            <strong class="font-normal">
                <?php echo esc_html($child_term->name); ?>
            </strong>
        </a>
    <?php endif; ?>

    <?php if (!$parent_term && !$child_term): ?>
        <span class="text-gray-500">بدون دسته‌بندی</span>
    <?php endif; ?>
</div>
