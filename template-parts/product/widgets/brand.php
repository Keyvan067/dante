<?php
$brands = $args['brands'] ?? null;
if ($brands && !is_wp_error($brands)): ?>
    <div class="flex items-center gap-2">
        <?php
        $brand_names = array();
        foreach ($brands as $brand) {
            $brand_names[] = sprintf(
                '<a href="%s" target="_blank" rel="noopener noreferrer">%s</a>',
                esc_url(get_term_link($brand)),
                esc_html($brand->name)
            );
        }
        echo wp_kses(
            implode('<span>،</span>', $brand_names),
            [
                'a' => [
                    'href' => [],
                    'target' => [],
                    'rel' => []
                ],
                'span' => []
            ]
        );
        ?>
    </div>
<?php endif; ?>