<?php
defined('ABSPATH') || exit;
global $product;
?>
<section id="reviews" class="pdk-tabs w-full mx-auto flex flex-col items-start gap-4">
    <div>
        <h3 class="h2_title"> امتیاز و دیدگاه کاربران </h3>
    </div>
    <!--review-filters...-->
<!--    --><?php //get_template_part('template-parts/product/tabs/reviews/reviews-filter'); ?>
    <!--review-ai...-->
<!--    --><?php //get_template_part('template-parts/product/tabs/reviews/ai-summery-reviews'); ?>
    <!-- ::show-review... -->
    <?php get_template_part('template-parts/product/tabs/reviews/show-reviews'); ?>
</section>

<?php get_template_part('template-parts/product/modals/send-review'); ?>


