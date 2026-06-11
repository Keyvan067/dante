<?php
/**
 * Product Details – Custom Layout
 *
 * @package BLUETheme
 *
 **********************************
 * Product Stock Status - Backorder
 * برای محصولاتی که قابل پیش‌خرید هستند *
 *
 *
 */

defined('ABSPATH') || exit;

$product = $args['product'];

if (!$product || !is_a($product, 'WC_Product')) {
    return;
}

?>
<div
    class="pdk-action-stock sticky top-[14rem] w-full flex flex-col items-center justify-center p-4 shrink-0 basis-2/6 px-4 h-fit overflow-hidden">
    <!-- نمودار تغییرات قیمت -->
    stock-status-backorder!
    <div class="w-full block mb-8">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-200">
            <h4 class="text-lg font-bold mb-4 text-gray-800">تغییرات قیمت در یک ماه گذشته</h4>
            <div id="productPriceChart" class="w-full h-64"></div>
            <p class="text-xs text-gray-500 mt-3 text-center">
                نمودار بر اساس قیمت‌های ثبت شده در ۳۰ روز گذشته
            </p>
        </div>
    </div>
    <!-- فرم استعلام قیمت -->
    <div class="w-full block">
        <div class="w-full flex flex-col items-center justify-center gap-4 mb-6">
            <img width="140" height="auto"
                src="<?php echo esc_url(get_template_directory_uri() . '/assets/icons/product-contact-price.png'); ?>"
                alt="<?php esc_attr_e('استعلام قیمت', 'aban-theme'); ?>">
            <div class="text-center">
                <h4 class="font-bold text-gray-800 mb-2">محصول موجود نیست</h4>
                <p class="text-gray-600 text-sm">
                    این محصول در حال حاضر موجود نمی‌باشد اما قابل پیش‌خرید است.
                    برای استعلام قیمت و زمان تحویل تماس بگیرید.
                </p>
            </div>
        </div>
        <!-- دکمه‌های اقدام -->
        <div class="flex flex-col gap-3">
            <!-- دکمه تماس -->
            <button class="btn-primary w-full !py-4" id="callButton">
                <i class="fa-regular fa-phone-volume ml-2"></i>
                <span>تماس بگیرید</span>
            </button>
            <!-- فرم ثبت برای اطلاع‌رسانی -->
            <div class="mt-4">
                <h5 class="font-bold text-gray-700 mb-2">زنگوله را بزنید!</h5>
                <p class="text-sm text-gray-600 mb-3">
                    به محض موجود شدن، از طریق ایمیل یا پیامک به شما اطلاع می‌دهیم.
                </p>

                <form id="backorderNotifyForm" class="flex gap-2">
                    <?php wp_nonce_field('backorder_notify', 'backorder_nonce'); ?>
                    <input type="hidden" name="product_id" value="<?php echo esc_attr($product->get_id()); ?>">

                    <input type="email" name="email" placeholder="ایمیل خود را وارد کنید" required
                        class="flex-grow px-3 py-2 border border-gray-300 rounded-lg text-sm">

                    <button type="submit"
                        class="bg-amber-500 text-white px-4 py-2 rounded-lg hover:bg-amber-600 transition-colors">
                        <i class="fa-regular fa-bell"></i>
                    </button>
                </form>

                <p class="text-xs text-gray-500 mt-2">
                    با ثبت ایمیل، موافقت خود را با
                    <a href="<?php echo esc_url(get_privacy_policy_url()); ?>" class="text-blue-500 hover:underline">
                        حریم خصوصی
                    </a>
                    اعلام می‌کنید.
                </p>
            </div>
            <!-- دکمه پیش‌خرید -->
            <?php if ($product->is_purchasable() && $product->is_in_stock()): ?>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <button class="btn-secondary w-full !py-3" onclick="document.querySelector('form.cart').submit();">
                        <i class="fa-regular fa-cart-plus ml-2"></i>
                        <span>پیش‌خرید محصول</span>
                    </button>
                    <p class="text-xs text-gray-500 text-center mt-2">
                        پرداخت بعد از موجود شدن انجام می‌شود
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    document.getElementById('callButton').addEventListener('click', function () {
        window.location.href = 'tel:<?php echo esc_js(get_theme_mod('store_phone', '021-12345678')); ?>';
    });
</script>
<!-- اسکریپت مدیریت فرم -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notifyForm = document.getElementById('backorderNotifyForm');
        if (notifyForm) {
            notifyForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);

                // نمایش وضعیت بارگذاری
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                submitBtn.disabled = true;

                // ارسال درخواست AJAX
                fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.data.message || 'با موفقیت ثبت شد! به محض موجود شدن به شما اطلاع می‌دهیم.');
                            notifyForm.reset();
                        } else {
                            alert(data.data.message || 'خطایی رخ داد. لطفا مجدد تلاش کنید.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('خطا در ارتباط با سرور');
                    })
                    .finally(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
            });
        }
    });
</script>