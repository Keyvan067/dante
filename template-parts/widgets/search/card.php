<article class="border border-accent rounded-2xl overflow-hidden hover:shadow-lg transition">

    <?php if ( has_post_thumbnail() ) : ?>
        <figure class="aspect-video overflow-hidden">
            <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
        </figure>
    <?php endif; ?>

    <div class="p-4 space-y-3">
        <h2 class="h3_title">
            <a href="<?php the_permalink(); ?>" class="hover:text-primary">
                <?php the_title(); ?>
            </a>
        </h2>

        <p class="text-body-sm line-clamp-3">
            <?php echo get_the_excerpt(); ?>
        </p>

        <div class="text-xs text-muted-foreground">
            <?php echo get_post_type_object(get_post_type())->labels->singular_name; ?>
        </div>
    </div>

</article>
