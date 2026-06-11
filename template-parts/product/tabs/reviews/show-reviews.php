<?php
defined('ABSPATH') || exit;
global $product;
$product_id = $product->get_id();

if (!$product_id) {
    return;
}

// تنظیمات صفحه‌بندی
$page = isset($_GET['review_page']) ? (int)$_GET['review_page'] : 1;
$per_page = 5;
$offset = ($page - 1) * $per_page;

// دریافت دیدگاه‌های تأیید شده
$comments = get_comments([
    'post_id' => $product_id,
    'type' => ['review', 'comment'],
    'status' => 'approve',
    'number' => $per_page,
    'offset' => $offset,
]);

// تعداد کل دیدگاه‌ها برای صفحه‌بندی
$total_comments = get_comments([
    'post_id' => $product_id,
    'type' => ['review', 'comment'],
    'status' => 'approve',
    'count' => true
]);

?>
    <div class="review-wrapper">
        <!--review-widgets & send-review-button-->
        <aside class="review-aside-wrapper">
            <div class="block w-full h-fit">
                <div class="reviews-info">
                    <div class="w-full">
                        <?php
                        $average_rating = woo()->getProductRating($product);
                        $review_count = $total_comments;
                        ?>
                        <div class="average-rating">
                            <span class="rating-number"><?php echo number_format($average_rating, 1); ?></span>
                            <span class="rating-stars"><?php echo woo()->displayStars($average_rating); ?></span>
                        </div>
                        <span class="text-center block">امتیاز کاربران</span>
                    </div>
                    <div class="block text-sm text-muted">
                        <span>شما هم درباره این کالا دیدگاه ثبت کنید</span>
                    </div>
                </div>
                <div class="block w-full my-4">
                    <button type="button" onclick="sendReview__Modal.showModal()"
                            class="bg-white rounded-box border border-base-300 gap-4 py-4 px-6 w-full flex items-center justify-between">
                        <span class="flex-ss flex-col gap-4">
                            <span class="h3_title"> ثبت دیدگاه </span>
                            <span class="text-xs text-muted">5 امتیاز برای ثبت دیدگاه</span>
                        </span>
                        <span>
                            <i class="fa-regular fa-comment-arrow-up fa-2xl"></i>
                        </span>
                    </button>
                </div>
            </div>
        </aside>
        <!--review-items...-->
        <div class="product-reviews w-full" data-product-id="<?php echo esc_attr($product_id); ?>">
            <!-- لیست دیدگاه‌ها -->
            <div class="reviews-list text-right w-full block">
                <?php if (empty($comments)): ?>
                    <div>
                        <p class="no-reviews h3_title">شما هم می‌توانید تجربه خرید خود را برای این محصول ثبت کنید.</p>
                        <span class="mt-4 text-muted text-sm">
                        چنانچه این محصول را پیشتر خریداری کرده باشید، دیدگاه شما با برچسب «خریدار» در سایت درج خواهد شد.
                        همچنین می‌توانید دیدگاه خود را بصورت ناشناس نیز ارسال کنید.
                    </span>
                    </div>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <?php get_template_part('template-parts/product/tabs/reviews/review-item', null, ['comment' => $comment, 'product_id' => $product_id]); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- صفحه‌بندی -->
<!--            --><?php //get_template_part('template-parts/product/tabs/reviews/review-pagination', null, [
//                'total' => $total_comments,
//                'per_page' => $per_page,
//                'current' => $page,
//                'product_id' => $product_id
//            ]); ?>
        </div>
    </div>


