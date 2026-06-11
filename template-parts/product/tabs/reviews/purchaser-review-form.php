<?php
/**
 * purchaser-review-form.php
 * Multi-step form for registering and editing buyer comments.
 * @version 2.0.0 - Compatible with modular structure
 */

defined('ABSPATH') || exit;

global $product;

if (!$product || !is_a($product, 'WC_Product')) {
    echo '<p>محصول نامعتبر است.</p>';
    return;
}
$product_id = $product->get_id();
$user_id = get_current_user_id();

// ===== بررسی دیدگاه قبلی کاربر =====
$is_editing = false;
$existing_comment_id = 0;
$rating = 0;
$review_title = '';
$existing_shipping = '';
$existing_packaging = '';
$initial_comment = '';
$existing_images = [];


if ($user_id > 0) {
    $comments = get_comments([
        'post_id' => $product_id,
        'user_id' => $user_id,
        'type' => 'review',
        'number' => 1,
        'status' => 'all'
    ]);

    if (!empty($comments)) {
        $existing_comment = $comments[0];
        $is_editing = true;
        $existing_comment_id = $existing_comment->comment_ID;

        $rating = (int)get_comment_meta($existing_comment_id, 'rating', true);
        $review_title = get_comment_meta($existing_comment_id, 'review_title', true);
        $existing_shipping = get_comment_meta($existing_comment_id, 'shipping_experience', true);
        $existing_packaging = get_comment_meta($existing_comment_id, 'packaging_quality', true);
        $initial_comment = $existing_comment->comment_content;

        // تصاویر قبلی
        $image_ids = get_comment_meta($existing_comment_id, 'review_images', true);
        if (is_array($image_ids) && !empty($image_ids)) {
            foreach ($image_ids as $attach_id) {
                $image_url = wp_get_attachment_image_url($attach_id, 'thumbnail');
                if ($image_url) {
                    $existing_images[] = [
                        'id' => (int)$attach_id,
                        'url' => $image_url,
                        'name' => get_post_meta($attach_id, '_wp_attachment_image_alt', true) ?: 'تصویر محصول'
                    ];
                }
            }
        }
    }
}


// ===== آخرین تاریخ خرید =====
$order_date = 'تاریخ خرید: نامشخص';
if (is_user_logged_in()) {
    $orders = wc_get_orders([
        'customer_id' => $user_id,
        'status' => ['completed', 'processing'],
        'limit' => 1,
        'return' => 'ids'
    ]);
    if (!empty($orders)) {
        $order = wc_get_order($orders[0]);
        $order_date = $order->get_date_created()->date_i18n('Y/m/d');
    }
}

$review_nonce = wp_create_nonce('purchaser_review_nonce');
?>
<div id="reviewModal" class="purchaser-review-form" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <form id="multiStepReviewForm"
          action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"
          method="POST"
          enctype="multipart/form-data">
        <!-- Required fields -->
        <input type="hidden" name="nonce" value="<?php echo esc_attr($review_nonce); ?>">
        <input type="hidden" name="action" value="submit_product_review">
        <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
        <input type="hidden" id="shipping_input" name="shipping" value="<?php echo esc_attr($existing_shipping); ?>">
        <input type="hidden" id="packaging_input" name="packaging" value="<?php echo esc_attr($existing_packaging); ?>">

        <div class="modal-wrapper">
            <div class="review-modal-header">
                <div>
                    <h4 id="modal-title" class="h4_title">
                        <?php echo $is_editing ? 'ویرایش تجربه خرید' : 'ثبت تجربه خرید'; ?>
                    </h4>
                    <button id="closeModal" type="button" aria-label="بستن">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                <!--indicators...-->
                <div class="review-modal-indicators">
                    <div class="review-indicator-steps" role="tablist">
                        <?php for ($i = 1; $i <= 4; $i++): ?>
                            <div class="step-indicator"
                                 data-step="<?php echo $i; ?>"
                                 role="tab"
                                 aria-selected="<?php echo $i === 1 ? 'true' : 'false'; ?>"
                                 id="step<?php echo $i; ?>-tab"></div>
                        <?php endfor; ?>
                    </div>
                    <span id="stepText">مرحله 1 از 4</span>
                </div>
            </div>
            <!-- modal show this product -->
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
            <!-- modal content -->
            <div class="modal-content" aria-live="polite" aria-atomic="true">
                <!-- STEP-1 : rating... -->
                <div id="step1" class="step-content step-one active" role="tabpanel" aria-labelledby="step1-tab">
                    <div class="rating-section">
                        <label>
                            به این کالا چه امتیازی می‌دهید؟
                        </label>
                        <div class="rating-system">
                            <input type="hidden" id="final-rating" name="rating"
                                   value="<?php echo esc_attr($rating); ?>" required>
                            <div class="stars-box" dir="ltr" id="stars-container"></div>
                            <div class="rating-feedback">
                                <div class="text-lg font-medium text-gray-700" id="rating-message">
                                    لطفا امتیاز دهید
                                </div>
                                <div class="text-sm text-gray-500 mt-1" id="rating-hint">
                                    روی ستاره‌ها کلیک کنید
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="rating-error" class="review-err"></div>
                </div>
                <!-- STEP-2 : textarea... -->
                <div id="step2" class="step-content step-two hidden" role="tabpanel" aria-labelledby="step2-tab">
                    <div class="reviewer-title">
                        <label for="review_title">
                            عنوان دیدگاه (اختیاری)
                        </label>
                        <input type="text"
                               id="review_title"
                               name="review_title"
                               value="<?php echo esc_attr($review_title); ?>"
                               placeholder="مثلاً: کیفیت عالی، ارزش خرید خوب">
                    </div>
                    <div class="reviewer-text-comment">
                        <label for="review-comment-text">
                            <span class="text-rose-400">*</span> متن کامل دیدگاه
                        </label>
                        <textarea id="review-comment-text"
                                  name="pdk_review"
                                  placeholder="تجربه خرید و استفاده خود از این محصول را به طور کامل شرح دهید..."
                                  required><?php echo esc_textarea($initial_comment); ?></textarea>
                        <!-- counter-for-characters -->
                        <div class="counter-characters">
                            <div id="comment-error" class="review-err"></div>
                            <div id="charCount">0/2000</div>
                        </div>
                        <!-- suggestion-ai -->
                        <div class="ai-suggestion">
                            <div>
                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/ai/1.gif'); ?>"
                                     alt="AI">
                                <span>پیشنهاد برای دیدگاه کامل‌تر:</span>
                            </div>
                            <ul>
                                <li>کیفیت ساخت محصول چگونه بود؟</li>
                                <li>آیا ارزش قیمت پرداختی را داشت؟</li>
                                <li>نقاط قوت و ضعف آن چیست؟</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- STEP-3 : upload-images... -->
                <div id="step3" class="step-content step-three hidden relative" role="tabpanel"
                     aria-labelledby="step3-tab">
                    <div class="upload-user-images">
                        <label>تصاویر از محصول (اختیاری)</label>
                        <label for="review-images-input" class="sr-only">انتخاب تصاویر محصول</label>
                        <div id="drop-area">
                            <i class="fa-solid fa-cloud-upload-alt"></i>
                            <p class="mb-3">
                                تصاویر محصول را اینجا رها کنید یا برای انتخاب کلیک کنید
                            </p>
                            <button type="button" id="select-images-btn" class="btn-outline">
                                <i class="fa-solid fa-plus ml-1"></i> انتخاب تصاویر
                            </button>
                            <input type="file"
                                   id="review-images-input"
                                   name="review_images[]"
                                   multiple
                                   accept="image/*"
                                   class="!hidden">
                        </div>
                        <!--preview-images...-->
                        <div id="image-preview"></div>
                        <p class="image-preview-notice">
                            حداکثر ۵ تصویر - فرمت‌های مجاز: JPG, PNG, GIF, WEBP
                        </p>
                        <div id="image-error" class="review-err"></div>
                    </div>
                    <!--loading-upload-images...-->
                    <div id="upload-loading">
                        <div>
                            <div class="upload-loading-spin"></div>
                            <span>در حال بارگذاری تصاویر...</span>
                        </div>
                        <div id="cancel-upload-btn" class="btn btn-circle btn-error">
                            <i class="fa-solid fa-times"></i>
                        </div>
                    </div>
                </div>
                <!-- STEP 4 :shopping-experience + summary & rules... -->
                <div id="step4" class="step-content step-four hidden" role="tabpanel" aria-labelledby="step4-tab">
                    <!-- purchased-chips -->
                    <div class="purchased-chips"><h4><i class="fa-solid fa-badge-check"></i> بخش ویژه خریداران</h4>
                        <div class="space-y-4">
                            <!--packet-sending-speed-->
                            <div class="packet-sending-speed">
                                <label>سرعت ارسال محصول</label>
                                <div class="flex gap-2">
                                    <?php
                                    $shipping_options = [
                                        'fast' => 'سریع',
                                        'normal' => 'معمولی',
                                        'slow' => 'کند'
                                    ];
                                    foreach ($shipping_options as $val => $label):
                                        ?>
                                        <button type="button"
                                                class="chip-review <?php echo $existing_shipping === $val ? 'active' : ''; ?>"
                                                data-name="shipping"
                                                data-value="<?php echo $val; ?>"
                                            <?php echo $is_editing ? 'disabled' : ''; ?>>
                                            <?php echo $label; ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- packaging-quality -->
                            <div class="packaging-quality">
                                <label>کیفیت بسته‌بندی</label>
                                <div class="flex gap-2">
                                    <?php
                                    $packaging_options = [
                                        'excellent' => 'عالی',
                                        'good' => 'خوب',
                                        'poor' => 'ضعیف'
                                    ];
                                    foreach ($packaging_options as $val => $label):
                                        ?>
                                        <button type="button"
                                                class="chip-review <?php echo $existing_packaging === $val ? 'active' : ''; ?>"
                                                data-name="packaging"
                                                data-value="<?php echo $val; ?>"
                                            <?php echo $is_editing ? 'disabled' : ''; ?>>
                                            <?php echo $label; ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- summary-of-info-->
                    <div class="summary-of-information">
                        <h4>
                            <i class="fa-solid fa-clipboard-check"></i> خلاصه اطلاعات
                        </h4>
                        <div class="summary-info">
                            <div>
                                <span>امتیاز:</span>
                                <span id="summaryRating" class="font-medium mr-2">-</span>
                            </div>
                            <div>
                                <span>تصاویر:</span>
                                <span id="summaryImages" class="font-medium mr-2">0</span>
                            </div>
                            <div>
                                <span>سرعت ارسال:</span>
                                <span id="summaryShipping" class="font-medium mr-2">-</span>
                            </div>
                            <div>
                                <span>بسته‌بندی:</span>
                                <span id="summaryPackaging" class="font-medium mr-2">-</span>
                            </div>
                        </div>
                    </div>
                    <!-- summary-rules -->
                    <div class="summary-rules">
                        <div class="flex items-start gap-2">
                            <input id="acceptTerms" type="checkbox" name="accept_terms"
                                   class="mt-1 radio radio-xl radio-neutral"
                                   required <?php echo $is_editing ? 'checked' : ''; ?> />
                            <label for="acceptTerms" class="text-sm">
                                با <a href="<?php echo esc_url(get_permalink(get_page_by_path('terms'))); ?>"
                                      class="text-sky-700 underline" target="_blank">قوانین و شرایط</a> موافقم
                            </label>
                        </div>
                        <div id="terms-error" class="review-err"></div>
                    </div>
                </div>
            </div>
            <!-- footer-modal... -->
            <div class="review-modal-footer">
                <div class="w-fit">
                    <button id="prevBtn" type="button"
                            class="btn-circle btn btn-lg p-2">
                        <i class="fa-solid fa-angle-right fa-lg"></i>
                    </button>
                    <button id="nextBtn" type="button"
                            class="btn btn-circle btn-lg p-2">
                        <i class="fa-solid fa-angle-left fa-lg"></i>
                    </button>
                </div>
                <div class="w-fit">
                    <button id="cancelBtn" type="button" class="btn btn-xl text-lg">
                        انصراف
                    </button>
                    <button id="submitBtn" type="submit"
                            class="btn-primary btn-xl text-lg btn btn-square">
                        <?php echo $is_editing ? 'ویرایش تجربه خرید' : 'ثبت تجربه خرید'; ?>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    window.reviewFormConfig = {
        existingImages: <?php echo json_encode($existing_images, JSON_UNESCAPED_UNICODE); ?>,
        isEditing: <?php echo $is_editing ? 'true' : 'false'; ?>
    };
</script>