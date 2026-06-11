<?php

get_header();

global $wp_query;
?>
<main id="search-page" class="container mx-auto py-12">

    <!-- عنوان صفحه -->
    <header class="mb-10">
        <h1 class="h1_title">
            نتیجه جستجو برای:
            <span class="text-primary">
                "<?php echo get_search_query(); ?>"
            </span>
        </h1>

        <p class="text-muted-foreground mt-2">
            <?php echo $wp_query->found_posts; ?> نتیجه پیدا شد
        </p>
    </header>

    <!-- نتایج -->
    <?php if ( have_posts() ) : ?>
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part('template-parts/search/card'); ?>
            <?php endwhile; ?>

        </section>

        <!-- صفحه‌بندی -->
        <div class="mt-12">
            <?php the_posts_pagination(); ?>
        </div>

    <?php else : ?>

        <div class="bg-muted p-8 rounded-2xl text-center">
            <p class="text-lg">نتیجه‌ای پیدا نشد 😕</p>
        </div>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
