<div class="p-4 space-y-4">

    <?php if ($terms): ?>
        <div>
            <h4 class="text-sm font-bold mb-2">دسته‌بندی‌ها</h4>
            <?php foreach ($terms as $term): ?>
                <a href="<?php echo get_term_link($term); ?>"
                   class="block text-sm hover:text-primary">
                    <?php echo $term->name; ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($products->have_posts()): ?>
        <div>
            <h4 class="text-sm font-bold mb-2">محصولات</h4>
            <?php while ($products->have_posts()): $products->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="block text-sm">
                    <?php the_title(); ?>
                </a>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <?php if ($posts->have_posts()): ?>
        <div>
            <h4 class="text-sm font-bold mb-2">مقالات</h4>
            <?php while ($posts->have_posts()): $posts->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="block text-sm">
                    <?php the_title(); ?>
                </a>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

</div>
