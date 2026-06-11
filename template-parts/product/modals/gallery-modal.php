<!-- GALLERY SCOPE... -->
<?php
defined('ABSPATH') || exit;

$images = $args['images'] ?? [];
$customer_images = $args['customer_images'] ?? [];

if (empty($images) && empty($customer_images)) {
    return;
}
$preview_images = array_slice($images, 0, 6);
$main_image_id = $preview_images[0] ?? null;
?>
<div class="gallery-modal fixed inset-0 top-0 right-0 left-0 w-screen h-screen">
    <div class="modal-container">
        <div class="modal-content">
            <!-- Tabs gallery routes... -->
            <div class="modal-header <?php echo is_admin_bar_showing() ? 'mt-12 ' : 'mt-5'; ?>">
                <div class="w-20"><!--for-flex--></div>
                <div class="gallery-modal-tabs border_solid_1_ruSm">
                    <div class="headerGalleryTabs_children active" data-category="main">
                        <span>رسمی</span>
                    </div>
                    <div class="headerGalleryTabs_children border_x_solid_1" data-category="user_category_images">
                        <span>خریداران</span>
                    </div>
                    <div class="headerGalleryTabs_children" data-category="magnet_category_images">
                        <span>ویدئو های مگنت</span>
                    </div>
                </div>
                <!-- close gallery... -->
                <div class="w-20">
                    <span class="close-gallery-modal">
                        <i class="fa-regular fa-xmark"></i>
                    </span>
                </div>
            </div>
            <!-- BASE GALLERY FULL-SIZE IMAGES... -->
            <section class="gallery-modal-body" style="background:none">
                <div>
                    <div>
                        <div class="swiper base-productGallery">
                            <div class="swiper-wrapper baseSwiper-productGallery">
                                <!--::SCOPE-STORE-PRODUCT-IMAGES...-->
                                <?php
                                $slide_index = 0;
                                if ($images) {
                                    foreach ($images as $id): ?>
                                        <div class="swiper-slide" data-category="main"
                                             data-index="<?php echo $slide_index++; ?>">
                                            <?php echo wp_get_attachment_image($id, 'x_large'); ?>
                                        </div>
                                    <?php endforeach;
                                } ?>
                                <!-- ======= USERS PRODUCT IMAGES ======= -->
                                <?php foreach ($customer_images as $customer_img): ?>
                                    <div class="swiper-slide" data-category="user_category_images"
                                         data-index="<?php echo $slide_index++; ?>">
                                        <img style="mix-blend-mode: darken" class="mix-blend-plus-darker"
                                             src="<?php echo esc_url($customer_img['full_url']); ?>"
                                             alt=" تصویر ارسالی کاربر <?php echo esc_attr($customer_img['author']); ?>"
                                             loading="lazy"/>
                                    </div>
                                <?php endforeach; ?>
                                <!-- ======= VIDEO REVIEW FOR PRODUCT ======= -->
                                <!--                                <?php /*// ویدئوها (در صورت وجود)
                                if (false): // شرط ویدئو */ ?>
                                <div class="swiper-slide" data-category="magnet_category_images" data-index="<?php /*echo $slide_index++; */ ?>">
                                    <img class="mix-blend-plus-darker"
                                         src="<?php /*echo get_template_directory_uri() . '/assets/images/placeholder.gif' */ ?>"
                                         alt="PRODUCTS__TITLE"/>
                                </div>
                                --><?php /*endif; */ ?>
                                <!-- END MAIN SWIPER IMAGES...! -->
                                <!-- =========================== -->
                            </div>
                        </div>
                        <!-- /////////////////////////////////////////////////// -->
                        <div class="bgs-btn-next">
                            <i class="fa-solid fa-angle-left"></i>
                        </div>
                        <div class="bgs-btn-prev">
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <!-- /////////////////////////////////////////////////// -->
                    </div>
                </div>
            </section>
            <!-- BASE GALLERY THUMBNAILS-SLIDER IMAGES... -->
            <div class="modal-footer">
                <div thumbsSlider="" class="swiper base-galleryThumbnail">
                    <div class="thumbnail-slider swiper-wrapper">

                        <!-- >>> MAIN PICTURES... <<< -->
                        <div class="swiper-thumbnail-category">
                            <div>
                                <i class="fa-regular fa-border-all fa-lg"></i>
                            </div>
                            <span> همه <br>تصاویر </span>
                        </div>
                        <?php
                        // thumbnail تصاویر رسمی (ایندکس از 0 تا count-1)
                        $thumb_index = 0;
                        $total_main = count($images);
                        $main_counter = 0;
                        foreach ($images as $id):
                            $extra_class = '';
                            if ($main_counter === 0) $extra_class = 'first-main-slide rounded-r-lg';
                            if ($main_counter === $total_main - 1) $extra_class = 'last-main-slide rounded-l-lg';
                            if ($total_main === 1) $extra_class = 'first-main-slide last-main-slide rounded-lg';
                            ?>
                            <div class="swiper-slide swiper-thumbnail-img <?php echo $extra_class; ?>"
                                 data-category="main"
                                 data-index="<?php echo $thumb_index++; ?>">
                                <div>
                                    <div>
                                        <?php echo wp_get_attachment_image($id, 'small'); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $main_counter++;
                        endforeach;
                        ?>
                        <!-- >>> MAIN PICTURES... <<< -->
                        <?php if (!empty($customer_images)): ?>
                            <div class="swiper-thumbnail-category">
                                <div>
                                    <i class="fa-regular fa-user fa-lg"></i>
                                </div>
                                <span> کاربران <br>تصاویر </span>
                            </div>

                            <!-- >>> USER PICTURES... <<< -->
                            <?php
                            // thumbnail تصاویر کاربران (ایندکس از count($images) شروع شود)
                            $thumb_index = $total_main;
                            $total_customer = count($customer_images);
                            $customer_counter = 0;
                            foreach ($customer_images as $item):
                                $customer_class = '';
                                if ($customer_counter === 0) $customer_class = 'first-customer-slide rounded-r-lg';
                                if ($customer_counter === $total_customer - 1) $customer_class = 'last-customer-slide rounded-l-lg';
                                ?>
                                <div class="swiper-slide swiper-thumbnail-img <?php echo $customer_class; ?>"
                                     data-category="user_category_images"
                                     data-index="<?php echo $thumb_index++; ?>">
                                    <div>
                                        <div>
                                            <img style="object-fit: contain" src="<?php echo esc_url($item['url']); ?>"
                                                 alt="<?php echo esc_attr($item['author']); ?>"></div>
                                    </div>
                                </div>
                                <?php
                                $customer_counter++;
                            endforeach;
                            ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>