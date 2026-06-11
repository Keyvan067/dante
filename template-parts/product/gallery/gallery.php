<?php
defined('ABSPATH') || exit;
// دریافت تصاویر از آرگومان‌ها
$images = $args['images'] ?? [];
$customer_images = $args['customer_images'] ?? [];
// اگه هیچ تصویری نبود، خارج شو
if (empty($images) && empty($customer_images)) {
    return;
}
// تصویر اصلی (اولین تصویر از گالری اصلی یا اولین تصویر کاربران)
$main_image_id = !empty($images) ? $images[0] : (!empty($customer_images) ? $customer_images[0]['id'] : null);
// بقیه تصاویر برای thumbnail (از گالری اصلی)
$thumb_images = array_slice($images, 0, 6);
$thumb_count = count($thumb_images);

// داده‌های مورد نیاز برای گالری
$gallery_data = [
    'main_image_id' => $main_image_id,
    'thumb_images' => $thumb_images,
    'thumb_count' => $thumb_count,
    'images' => $images,
    'customer_images' => $customer_images,
];
extract($gallery_data);
?>
<!--DESKTOP-GALLERY...-->
<div class="gallery-desktop">
    <!-- GALLERY-CONTENT... -->
    <div class="product-thumbnail">
        <?php get_template_part('template-parts/widgets/tooltip'); ?>
        <div class="product-thumbnail-main">
            <?php
            if ($main_image_id) {
                echo wp_get_attachment_image($main_image_id, 'full');
            } else {
                echo wc_placeholder_img('woocommerce_single');
            }
            ?>
        </div>
    </div>
    <!-- PREVIEW-GALLERY-THUMBNAILS...-->
    <div class="block w-full">
        <div class="swiper pdk-thumbnail-gallery w-auto">
            <div class="swiper-wrapper">
                <!-- Thumbnails گالری اصلی -->
                <?php if ($thumb_images) :
                    global $all_images;
                    foreach ($thumb_images as $index => $id) : ?>
                        <div class="swiper-slide" data-index="<?php echo $index; ?>"
                             onclick="openGallery(<?php echo $index; ?>, 'main')">
                            <div>
                                <button type="button" class="pdk-thumb" data-id="<?php echo esc_attr($id); ?>">
                                    <?php echo wp_get_attachment_image($id, 'x_small', false, ['loading' => 'lazy']); ?>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="flex-sbc w-full pl-3 *:text-[.75em]">
        <a href="#" class="flex-cc gap-2">
              <span class="*:w-5 h-auto">
                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24">
                  <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M5.322 9.683c2.413-4.271 3.62-6.406 5.276-6.956a4.45 4.45 0 0 1 2.804 0c1.656.55 2.863 2.685 5.276 6.956c2.414 4.27 3.62 6.406 3.259 8.146c-.2.958-.69 1.826-1.402 2.48C19.241 21.5 16.827 21.5 12 21.5s-7.241 0-8.535-1.19a4.66 4.66 0 0 1-1.402-2.48c-.362-1.74.845-3.876 3.259-8.147M11.992 16h.009M12 13V9"
                        color="currentColor"/>
                </svg>
              </span>
            <span> گزارش مشخصات کالا یا موارد قانونی </span>
        </a>
        <div><span class="tracking-wide text-neutral-400">pdk-642279254</span></div>
    </div>
</div>
<script>
    function openGallery(index, type) {
        // ارسال به مودال گالری با نوع و ایندکس مشخص
        if (window.openGalleryModal) {
            window.openGalleryModal(index, type);
        }
    }
</script>