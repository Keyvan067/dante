<section>
    <!-------------------------------->
    <?php get_template_part('template-parts/widgets/divider'); ?>
    <!-------------------------------->
    <div class="grid grid-rows-auto gap-8 grid-cols-5 items-start justify-center max-xl:grid-cols-4 max-lg:grid-cols-3 max-sm:grid-cols-2 max-[480px]:!grid-cols-1">

        <!--PHP CODE--->
        <?php
        $args = array(
            'post_type'      => 'blog',     // نوع پست (نوشته‌ها)
            'posts_per_page' => 9,          // تعداد پست‌ها
            'post_status'    => 'publish',  // فقط منتشرشده‌ها
            'no_found_rows'  => true,       //صفحه بندی
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) : $query->the_post();
                ?>

                <article class="latest-post-item inline-block">
                    <div class="swiper-slide max-w-72 w-72 max-h-[280px] h-[280px]">
                        <a href="<?php the_permalink(); ?>" class="flex h-full flex-col *:flex-cc space-y-4 bg-base-100 rounded-xl overflow-hidden border border-base-200 relative">
                            <div class="w-full *:!w-full !h-48 *:!object-cover block">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('small-blog-post');
                                }else{?>
                                    <figure>
                                        <img style="width: 100%;height: auto;object-fit: cover" src="<?php echo get_template_directory_uri() . '/assets/images/placeholder.gif' ?>" alt="">
                                    </figure>
                                <?php } ?>
                            </div>
                            <div class="px-4">
                                <h4 class="h4_title line-clamp-2"><?php the_title(); ?></h4>
                            </div>
                            <div class="flex justify-between items-center p-4">
                                <div>
                                    <span><i class="fa-regular fa-clock"></i></span>
                                    <span><?php smart_post_date(); ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </article>
        <?php
        endwhile;
        }
        wp_reset_postdata();
        ?>
    </div>
</section>