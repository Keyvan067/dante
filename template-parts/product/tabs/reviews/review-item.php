<?php
defined('ABSPATH') || exit;
$comment = $args['comment'] ?? null;
$product_id = $args['product_id'] ?? 0;
if (!$comment || !$product_id) {
    return;
}
// دریافت امتیاز دیدگاه
$rating = (int)get_comment_meta($comment->comment_ID, 'rating', true);
$pros = get_comment_meta($comment->comment_ID, 'review_pros', true);
$cons = get_comment_meta($comment->comment_ID, 'review_cons', true);
?>

<article class="flex flex-col gap-3 justify-start items-start py-12 border-b border-base-200 *:last:border-none">
    <!-- نام کاربر + امتیاز + تاریخ و لایک -->
    <div class="flex justify-between items-center gap-2 w-full">
        <div class="flex flex-col justify-start items-start gap-4">
            <div class="leading-0">
                <span class="font-bold text-default">
                    <?php echo esc_html($comment->comment_author); ?>
                </span>
                <?php if (get_comment_meta($comment->comment_ID, 'verified', true)) : ?>
                    <span class="mx-2 bg-rose-500 text-white px-2 py-1 rounded-full text-xs">خریدار</span>
                <?php endif; ?>

                <!-- <?php
                /*                $verified = get_comment_meta($comment->comment_ID, 'verified', true);
                                if ($verified === '1' || $verified === true) :
                                    */ ?>
                    <span class="mx-2 bg-rose-500 text-white px-2 py-1 rounded-full text-xs">خریدار</span>
                --><?php /*endif; */ ?>
            </div>
            <div class="flex-cc gap-4 *:text-xs font-bold max-[720px]:flex-col">
                <div class="flex-cc *:text-amber-600">
                    <?php echo woo()->displayStars($rating); ?>
                </div>
                <div class="text-default tracking-wider">
                    <?php echo get_comment_date('Y/m/d', $comment); ?>
                </div>
            </div>
        </div>
        <div class="flex justify-end items-center gap-2 max-[720px]:scale-90">
            <button class="btn !bg-gray-50 btn-lg rounded-full review-like"
                    data-id="<?php echo esc_attr($comment->comment_ID); ?>">
                <span class="like-count">0</span>
                <i class="fa-regular fa-thumbs-up"></i>
            </button>
            <button class="btn !bg-gray-50 btn-lg rounded-full review-dislike"
                    data-id="<?php echo esc_attr($comment->comment_ID); ?>">
                <span class="dislike-count">0</span>
                <i class="fa-regular fa-thumbs-down"></i>
            </button>
            <button class="btn-lg rounded-full !w-12.5">
                <i class="fa-regular fa-ellipsis-vertical"></i>
            </button>
        </div>
    </div>
    <!-- عنوان دیدگاه -->
    <?php $title = get_comment_meta($comment->comment_ID, 'review_title', true); ?>
    <?php if ($title) : ?>
        <div class="w-full block mt-6">
            <span class="text-body-1 !font-bold !text-sm">
                <?php echo esc_html($title); ?>
            </span>
        </div>
    <?php endif; ?>
    <!-- متن دیدگاه -->
    <div class="review-detail-content w-full flex flex-col gap-4">
        <div class="w-full block">
            <p class="text-body-1 tracking-wide text-justify">
                <?php echo esc_html($comment->comment_content); ?>
            </p>
        </div>
        <!-- USERs-GALLERY-THUMBNAILS... -->
        <div class="block w-full">
            <div class="swiper users-galleryThumbnail w-auto">
                <div class="swiper-wrapper">
                    <?php
                    global $_index_slides;
                    $start_index = $_index_slides ?? 0;

                    // اگه رشته بود، به آرایه تبدیل کن
                    $cus_images = get_comment_meta($comment->comment_ID, 'review_images', true);
                    if (is_string($cus_images)) {
                        $cus_images = maybe_unserialize($cus_images);
                    }

                    if (!empty($cus_images) && is_array($cus_images)):
                        foreach ($cus_images as $img_id):
                            $image_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                            if (!$image_url) continue;
                            ?>
                            <div class="swiper-slide" data-index="<?php echo $start_index; ?>">
                                <button type="button" class="review-thumb" data-id="<?php echo esc_attr($img_id); ?>">
                                    <img class=""
                                         onclick="openGalleryById(<?php echo $img_id; ?>,<?php echo $start_index; ?>)"
                                         src="<?php echo esc_url($image_url); ?>"
                                         alt="تصویر کاربر">
                                </button>
                            </div>
                        <?php
                        endforeach;
                        // به‌روزرسانی ایندکس سراسری برای دیدگاه بعدی
                        $_index_slides = $start_index;
                    endif;
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

    </div>
</article>