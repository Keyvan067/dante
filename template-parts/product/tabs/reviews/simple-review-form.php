<?php
/**
 * Simple comment form for non-expert users.
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

global $product;

// دریافت وضعیت از متد جدید
$review_context = woo()->getReviewContext();
$state = $review_context['state'];

// بررسی دیدگاه قبلی کاربر
$existing_text = '';
$existing_comment_id = 0;


//if (is_user_logged_in() && str_contains($state, 'reviewed')) {
//or
if (is_user_logged_in() && strpos($state, 'reviewed') !== false) {
    $user_id = get_current_user_id();
    $product_id = $product->get_id();

    $comments = get_comments([
        'user_id' => $user_id,
        'post_id' => $product_id,
        'type' => ['review', 'comment'],
        'number' => 1,
        'status' => 'all'
    ]);

    if (!empty($comments)) {
        $existing_text = $comments[0]->comment_content;
        $existing_comment_id = $comments[0]->comment_ID;
    }
}
$is_editing = ($state === 'logged_no_purchase_reviewed');
$simple_review_nonce = wp_create_nonce('simple_review_nonce');
?>

<div class="simple-review-form">
    <!--simple-modal-header-->
    <div class="simple-modal-header">
        <h4 id="modal-title" class="h4_title">
            <?php echo $is_editing ? 'ویرایش دیدگاه' : 'ثبت دیدگاه'; ?>
        </h4>
        <form method="dialog">
            <button class="btn btn-circle">
                <i class="fa-solid fa-times"></i>
            </button>
        </form>
    </div>
    <!--modal-show-product-->
    <div class="modal-show-product">
        <div class="product-images">
            <?php
            if (method_exists($product, 'get_image')) {
                echo $product->get_image('thumbnail');
            } else {
                echo '<div class="skeleton h-16 w-16"></div>';
            }
            ?>
        </div>
        <div class="product-detail">
            <p class="h3_title line-clamp-1"><?php echo esc_html($product->get_name()); ?></p>
        </div>
    </div>
    <!--simple-modal-body-->
    <form id="simple-review-form" data-product-id="<?php echo esc_attr($product->get_id()); ?>">

        <input type="hidden" id="simple-review-nonce" name="nonce"
               value="<?php echo esc_attr($simple_review_nonce); ?>">
        <input type="hidden" id="existing-comment-id" name="comment_id"
               value="<?php echo esc_attr($existing_comment_id); ?>">

        <div class="modal-content">
            <div class="mb-4">
                <label for="simple-review-comment">
                    <span class="text-rose-400">*</span> متن کامل دیدگاه
                </label>
                <textarea id="simple-review-comment"
                          name="comment"
                          placeholder="نظر خود را درباره این محصول بنویسید..."
                          required><?php echo esc_textarea($existing_text); ?></textarea>

                <p class="text-muted text-sm mt-3">
                    <?php if ($is_editing): ?>
                        می‌توانید دیدگاه قبلی خود را ویرایش کنید.
                    <?php else: ?>
                        شما این محصول را خریداری نکرده‌اید. دیدگاه شما به عنوان نظر عمومی ثبت می‌شود.
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-block btn-primary !py-6 !w-full btn-square">
                <?php echo $is_editing ? 'ویرایش دیدگاه' : 'ثبت دیدگاه'; ?>
            </button>

            <div class="simple-review-rules">
                 <span>
                    ثبت دیدگاه به معنی موافقت با
                    <a href="<?php echo esc_url(home_url('/rules')); ?>">قوانین انتشار فروشگاه</a>
                    است.
                </span>
            </div>
        </div>
    </form>
</div>

<!--<script type="text/javascript">
    window.ajaxurl = '<?php /*echo admin_url('admin-ajax.php'); */ ?>';
    window.review_nonce = '<?php /*echo $simple_review_nonce; */ ?>';
</script>
-->