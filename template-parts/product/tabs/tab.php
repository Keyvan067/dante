<?php
defined('ABSPATH') || exit;
global $product;

// لیست تمام تب‌ها
$all_tabs = [
    'intro' => 'معرفی محصول',
    'description' => 'توضیحات',
    'specs' => 'مشخصات',
    'reviews' => 'دیدگاه‌ها',
    'questions' => 'پرسش و پاسخ'
];
?>


<section class="w-full block">
    <!-- TABS... -->
    <div id="tabs" class="container sticky bg-base-100 block z-30">
        <div class="w-auto mx-auto relative">
            <div class="flex justify-start items-center gap-8 px-8 w-full border-b border-base-200">
                <?php foreach ($all_tabs as $tab_key => $tab_label) : ?>

                    <?php
                    $has_content = true;
                    if (in_array($tab_key, ['intro', 'description', 'specs'])) {
                        $has_content = woo()->tabHasContent($tab_key, $product);
                    }
                    if ($has_content) : ?>
                        <button data-target="<?php echo esc_attr($tab_key); ?>"
                                class="tab-btn py-3 px-1 text-gray-600 text-xs">
                            <?php echo esc_html($tab_label); ?>
                        </button>
                    <?php
                    endif;
                endforeach;
                ?>
            </div>
            <span id="indicator" class="indicator"></span>
        </div>
    </div>
    <!-- TAB-SECTIONS... -->
    <div class="relative w-full block gap-12 pt-20">
        <div class="tabs-section flex grow flex-col space-y-10 px-4 justify-start items-start basis-auto">
            <!-- ::INTRO... -->
            <?php get_template_part('template-parts/product/tabs/intro'); ?>
            <!-- ::DESCRIPTION... -->
            <?php get_template_part('template-parts/product/tabs/description'); ?>
            <!-- ::SPECIF... -->
            <?php get_template_part('template-parts/product/tabs/specifications'); ?>
            <!-- ::REVIEWS... -->
            <?php get_template_part('template-parts/product/tabs/reviews'); ?>
            <!-- ::QUESTIONS... -->
        </div>
    </div>
</section>
