<?php
$product_attributes = $args['product_attributes'] ?? null;
$product_id = $args['product_id'] ?? null;
$max_attributes_to_show = get_query_var('max_attributes_to_show', 8);
$shown_attributes = 0;
?>

<?php if (!empty($product_attributes)): ?>
    <div class="w-full block py-2">
        <ul class="mini-spec-ul overflow-visible">
            <?php foreach ($product_attributes as $attribute): ?>
                <?php if ($shown_attributes >= $max_attributes_to_show) {
                    break;
                } ?>
                <?php
                $attribute_name = $attribute->get_name();
                $attribute_label = wc_attribute_label($attribute_name);
                $attribute_values = array();

                if ($attribute->is_taxonomy()) {
                    $terms = wp_get_post_terms(
                        $product_id,
                        $attribute_name,
                        array('fields' => 'names')
                    );
                    if (!is_wp_error($terms)) {
                        $attribute_values = $terms;
                    }
                } else {
                    $attribute_values = $attribute->get_options();
                }

                if (empty($attribute_values)) {
                    continue;
                }

                $shown_attributes++;
                ?>
                <li class="mini-spec-li">
                    <div class="tooltip tooltip-neutral xl:tooltip-bottom">
                        <div class="tooltip-content">
                            <div><?php echo esc_html(implode('، ', $attribute_values)); ?></div>
                        </div>
                        <p class="text-muted text-md line-clamp-1"><?php echo esc_html($attribute_label); ?></p>
                        <p class="text-strong font-normal text-md line-clamp-1"><?php echo esc_html(implode('، ', $attribute_values)); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        if (is_array($product_attributes) && count($product_attributes) > $max_attributes_to_show):
            ?>
            <div class="flex items-center justify-center gap-3 mt-4">
                <hr class="section_spec grow border-none">
                <button class="border border-base-200 px-4 py-3 rounded-field gap-2 flex items-center justify-center">
                    <span class="text-sm text-strong">مشاهده همه ویژگی‌ها</span>
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </button>
                <hr class="section_spec grow border-none">
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>