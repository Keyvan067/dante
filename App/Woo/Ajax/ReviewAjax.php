<?php

namespace App\Woo\Ajax;

defined('ABSPATH') || exit;

class ReviewAjax
{

    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function register(): void
    {
        add_action('wp_ajax_submit_simple_review', [$this, 'submitSimpleReview']);
        add_action('wp_ajax_nopriv_submit_simple_review', [$this, 'submitSimpleReview']);

        add_action('wp_ajax_submit_product_review', [$this, 'submitProductReview']);
        add_action('wp_ajax_nopriv_submit_product_review', [$this, 'submitProductReview']);

        // وقتی دیدگاه در ادمین حذف میشه
        add_action('delete_comment', [$this, 'onCommentDelete'], 10, 2);
    }

    /**
     * فرم ساده دیدگاه
     */
    public function submitSimpleReview(): void
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'simple_review_nonce')) {
            wp_send_json_error(['message' => 'خطای امنیتی. لطفاً صفحه را رفرش کنید.']);
        }

        $product_id = (int)($_POST['product_id'] ?? 0);
        $comment = sanitize_textarea_field($_POST['comment'] ?? '');
        $is_edit = $_POST['is_edit'] === '1';

        if (!$product_id || empty($comment) || strlen($comment) < 10) {
            wp_send_json_error(['message' => 'متن دیدگاه باید حداقل ۱۰ کاراکتر باشد']);
        }

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error(['message' => 'لطفاً ابتدا وارد شوید']);
        }

        $result = $this->saveSimpleReview($product_id, $user_id, $comment, $is_edit);

        if ($result) {
            wp_send_json_success(['message' => 'دیدگاه شما با موفقیت ثبت شد']);
        } else {
            wp_send_json_error(['message' => 'خطا در ثبت دیدگاه']);
        }
    }

    private function saveSimpleReview($product_id, $user_id, $comment, $is_edit)
    {
        if ($is_edit) {
            $comments = get_comments([
                'user_id' => $user_id,
                'post_id' => $product_id,
                'type' => 'review',
                'number' => 1
            ]);

            if (!empty($comments)) {
                return wp_update_comment([
                    'comment_ID' => $comments[0]->comment_ID,
                    'comment_content' => $comment,
                    'comment_approved' => 0
                ]);
            }
        }

        $user = get_userdata($user_id);

        return wp_insert_comment([
            'comment_post_ID' => $product_id,
            'comment_author' => $user->display_name,
            'comment_author_email' => $user->user_email,
            'comment_content' => $comment,
            'comment_type' => 'review',
            'user_id' => $user_id,
            'comment_approved' => 0
        ]);
    }

    /**
     * فرم پیشرفته دیدگاه (خریداران)
     */
    public function submitProductReview(): void
    {
        // 1️⃣ Nonce validation
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'secure_review')) {
            wp_send_json_error(['message' => 'خطای امنیتی. لطفاً صفحه را رفرش کنید.']);
        }

        // 2️⃣ Data acquisition
        $product_id = (int)($_POST['product_id'] ?? 0);
        $rating = (int)($_POST['rating'] ?? 0);
        $comment = sanitize_textarea_field($_POST['pdk_review'] ?? '');
        $title = sanitize_text_field($_POST['review_title'] ?? '');
        $shipping = sanitize_text_field($_POST['shipping'] ?? '');
        $packaging = sanitize_text_field($_POST['packaging'] ?? '');
        $accept_terms = isset($_POST['accept_terms']) && $_POST['accept_terms'] === 'on';

        // 3️⃣ Validation
        if ($product_id <= 0 || get_post_type($product_id) !== 'product') {
            wp_send_json_error(['message' => 'محصول نامعتبر است.']);
        }

        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_send_json_error(['message' => 'لطفاً ابتدا وارد حساب کاربری خود شوید.']);
        }

        if ($rating < 1 || $rating > 5) {
            wp_send_json_error(['message' => 'امتیاز باید بین ۱ تا ۵ باشد.']);
        }

        $trimmed_comment = trim($comment);
        if (empty($trimmed_comment) || mb_strlen($trimmed_comment) < 10) {
            wp_send_json_error(['message' => 'متن دیدگاه باید حداقل ۱۰ کاراکتر باشد.']);
        }

        if (!$accept_terms) {
            wp_send_json_error(['message' => 'لطفاً قوانین را تأیید کنید.']);
        }

        // 4️⃣ Check for existing comment (edit mode)
        $is_edit = false;
        $comment_id = 0;

        $existing = get_comments([
            'post_id' => $product_id,
            'user_id' => $user_id,
            'type' => 'review',
            'number' => 1,
            'status' => 'all',
        ]);

        if (!empty($existing)) {
            $is_edit = true;
            $comment_id = $existing[0]->comment_ID;

            if ((int)$existing[0]->user_id !== $user_id) {
                wp_send_json_error(['message' => 'شما اجازه ویرایش این دیدگاه را ندارید.']);
            }

            wp_update_comment([
                'comment_ID' => $comment_id,
                'comment_content' => $comment,
                'comment_approved' => 0,
            ]);
        }

        // 5️⃣ Insert new comment
        if (!$is_edit) {
            $user = get_userdata($user_id);

            $comment_data = [
                'comment_post_ID' => $product_id,
                'comment_content' => $comment,
                'comment_type' => 'review',
                'comment_approved' => 0,
                'user_id' => $user_id,
                'comment_author' => $user->display_name,
                'comment_author_email' => $user->user_email,
                'comment_date' => current_time('mysql'),
                'comment_date_gmt' => current_time('mysql', 1),
            ];

            $comment_id = wp_insert_comment($comment_data);

            if (!$comment_id || is_wp_error($comment_id)) {
                wp_send_json_error(['message' => 'خطا در ثبت دیدگاه.']);
            }
        }

        // 6️⃣ Save metadata
        update_comment_meta($comment_id, 'rating', $rating);
        if (!empty($title)) {
            update_comment_meta($comment_id, 'review_title', $title);
        }
        if (!empty($shipping)) {
            update_comment_meta($comment_id, 'shipping_experience', $shipping);
        }
        if (!empty($packaging)) {
            update_comment_meta($comment_id, 'packaging_quality', $packaging);
        }

        // 7️⃣ Handle images
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        // دریافت تصاویر موجود قبلی
        $existing_image_ids = [];
        if (isset($_POST['existing_images'])) {
            $existing_image_ids = json_decode(stripslashes($_POST['existing_images']), true);
            if (!is_array($existing_image_ids)) {
                $existing_image_ids = [];
            }
        }

        // دریافت تصاویر حذف شده
        $deleted_image_ids = [];
        if (isset($_POST['deleted_images'])) {
            $deleted_image_ids = json_decode(stripslashes($_POST['deleted_images']), true);
            if (!is_array($deleted_image_ids)) {
                $deleted_image_ids = [];
            }
        }

        // حذف فیزیکی تصاویر حذف شده
        foreach ($deleted_image_ids as $attach_id) {
            wp_delete_attachment($attach_id, true);
//            error_log("Deleted attachment: $attach_id");
        }

        // آپلود تصاویر جدید
        $uploaded_images = $this->handleImageUpload($comment_id, $product_id);

        // ترکیب نهایی: تصاویر باقی‌مانده + تصاویر جدید
        $final_image_ids = array_merge($existing_image_ids, $uploaded_images);

        if (!empty($final_image_ids)) {
            update_comment_meta($comment_id, 'review_images', $final_image_ids);
        } else {
            delete_comment_meta($comment_id, 'review_images');
        }

//        error_log('Final images count: ' . count($final_image_ids));

        // 8️⃣ Success response
        wp_send_json_success([
            'message' => $is_edit
                ? 'دیدگاه شما با موفقیت ویرایش شد و پس از تأیید نمایش داده می‌شود.'
                : 'دیدگاه شما با موفقیت ثبت شد و پس از تأیید نمایش داده می‌شود.',
            'comment_id' => $comment_id,
            'is_edit' => $is_edit,
        ]);
    }

    /**
     * Upload images for review
     */
    private function handleImageUpload($comment_id, $product_id): array
    {

        static $already_called = false;
        if ($already_called) {
//            error_log('handleImageUpload called twice - prevented');
            return [];
        }
        $already_called = true;
        if (empty($_FILES['review_images']) || empty($_FILES['review_images']['name'][0])) {
            return [];
        }

        $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $uploaded_images = [];
        $files_count = count($_FILES['review_images']['name']);

        for ($i = 0; $i < $files_count; $i++) {
            if ($_FILES['review_images']['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            $file_name = $_FILES['review_images']['name'][$i];
            $file_type = $_FILES['review_images']['type'][$i];
            $file_tmp = $_FILES['review_images']['tmp_name'][$i];
            $file_size = $_FILES['review_images']['size'][$i];

            if (!in_array($file_type, $allowed_types, true)) {
                continue;
            }

            if ($file_size > 5 * 1024 * 1024) {
                continue;
            }

            $file = [
                'name' => $file_name,
                'type' => $file_type,
                'tmp_name' => $file_tmp,
                'error' => $_FILES['review_images']['error'][$i],
                'size' => $file_size,
            ];

            $upload = wp_handle_upload($file, ['test_form' => false]);

            if (isset($upload['error'])) {
                continue;
            }

            $attachment = [
                'post_mime_type' => $upload['type'],
                'post_title' => sanitize_file_name(pathinfo($file_name, PATHINFO_FILENAME)),
                'post_content' => '',
                'post_status' => 'inherit',
                'post_parent' => $product_id,
            ];

            $attach_id = wp_insert_attachment($attachment, $upload['file'], $product_id);

            if (!is_wp_error($attach_id)) {
                $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
                wp_update_attachment_metadata($attach_id, $attach_data);
                update_post_meta($attach_id, 'review_comment_id', $comment_id);
                $uploaded_images[] = $attach_id;
            }
        }

        return $uploaded_images;
    }


    /**
     * وقتی دیدگاه در ادمین حذف میشه
     */
    public function onCommentDelete($comment_id, $comment): void
    {
        // حذف تصاویر مرتبط
        $image_ids = get_comment_meta($comment_id, 'review_images', true);
        if (is_array($image_ids) && !empty($image_ids)) {
            foreach ($image_ids as $attach_id) {
                wp_delete_attachment($attach_id, true);
//                error_log("Deleted attachment: $attach_id for comment: $comment_id");
            }
        }

        // حذف متاهای دیدگاه
        delete_comment_meta($comment_id, 'rating');
        delete_comment_meta($comment_id, 'review_title');
        delete_comment_meta($comment_id, 'review_images');
        delete_comment_meta($comment_id, 'shipping_experience');
        delete_comment_meta($comment_id, 'packaging_quality');
    }
}