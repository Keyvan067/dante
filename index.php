<?php get_header(); ?>
    <!--stories-->
<?php get_template_part('template-parts/widgets/index','stories'); ?>
    <!--index-main-swiper-->
<?php get_template_part('template-parts/widgets/swipers/index','main-swiper'); ?>
    <!-- MAIN-COMTAINER... -->
    <main class="container-4xl-w flex px-4 flex-col mx-auto gap-20 mt-0 h-auto grow mb-8">
        <!-- index-amazing-swiper... -->
<!--        --><?php //get_template_part('template-parts/widgets/swipers/index','amazing-swiper-nocolor-bg'); ?>
        <!-- BANNER FULL... -->
        <?php get_template_part('template-parts/widgets/banners/index','banner-full'); ?>
        <!-- BUY BY CATEGORY...:). -->
        <?php get_template_part('template-parts/widgets/category/index','category-swiper-grid'); ?>
        <!-- PRODUCTS-PRIME... -->
        <?php get_template_part('template-parts/widgets/category/index','product-packs'); ?>
        <!-- BANNER 4X... -->
        <?php get_template_part('template-parts/widgets/banners/index','banner-4x'); ?>
        <!-- OFFERS & DISCOUNTS ON THE BEST SELLER PRODUCTS... -->
        <?php get_template_part('template-parts/widgets/category/index','promotional-grid-products'); ?>
        <!-- BANNER 2X... -->
        <?php get_template_part('template-parts/widgets/banners/index','banner-2x'); ?>
        <!-- SPECIAL PRODUCTS... -->
        <?php get_template_part('template-parts/widgets/swipers/index','special-products'); ?>
        <!-- OFFER PRODUCTS (UP TO 60% OFFERS) -->
        <!-- NEW PRODUCTS... -->
        <!-- BANNER FULL... -->
        <?php get_template_part('template-parts/widgets/banners/index','banner-full'); ?>
        <!-- ADS-&-BLOG BOX CONTAIENR... -->
        <?php get_template_part('template-parts/widgets/index','blog'); ?>
    </main>
    <!-- MODAL-OVERLY... -->

<?php get_footer(); ?>