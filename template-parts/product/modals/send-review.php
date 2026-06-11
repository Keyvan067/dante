<?php
defined('ABSPATH') || exit;
global $product;

$review_context = woo()->getReviewContext();
?>

<!-- Open the modal using ID.showModal() method -->
<dialog id="sendReview__Modal" class="modal">
    <div class="modal-box w-xl max-w-2xl max-h-[90vh]">
        <?php
        switch($review_context['state']):
            case 'guest':
                get_template_part('template-parts/product/tabs/reviews/login-form');
                break;

            case 'logged_no_purchase_no_review':
            case 'logged_no_purchase_reviewed':
                get_template_part('template-parts/product/tabs/reviews/simple-review-form');
                break;

            case 'purchased_no_review':
            case 'purchased_reviewed':
                get_template_part('template-parts/product/tabs/reviews/purchaser-review-form');
                break;

            default:
                echo 'وضعیت نامشخص: ' . $review_context['state'];
        endswitch;
        ?>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>