<?php
/**
 * Product Timer Template
 *
 * @package YourTheme
 */

global $product;

if (!$product || !is_a($product, 'WC_Product')) {
    return;
}
?>

<!-- کانتینر اصلی تایمر - مخفی در ابتدا -->
<div id="variation-timer-container"
     class="p-3 bg-primary rounded-box mb-6 flex-col justify-center items-center gap-3"
     style="direction: ltr; display: none;">
    <!-- بنر پیشنهاد ویژه -->
    <div class="w-full flex flex-row justify-between items-center px-2 gap-4">
        <div class="wc-countdown min-w-fit text-xl font-bold text-base-100"></div>
        <img style="width: auto; height: 1.5rem; object-fit: contain;"
             src="<?php echo get_template_directory_uri() . '/assets/images/offer-single.svg'; ?>"
             alt="پیشنهاد ویژه">
    </div>
    <!-- تایمر شمارش معکوس -->
    <div class="wc-countdown-wrapper *:text-base-100"
         data-expire=""
         data-show-labels="false"
         data-label-days="روز"
         data-label-hours="ساعت"
         data-label-minutes="دقیقه"
         data-label-seconds="ثانیه"
         data-show-stock="false"
         data-total-sold="0"
         data-total-stock="0"
         data-show-progress="false">
        <div class="wc-countdown-progress hidden">
<!--            <div class="progress-stats hidden">-->
<!--                <span>فروخته شده: <span class="progress-sold">0</span></span>-->
<!--                <span>موجودی: <span class="progress-stock">0</span></span>-->
<!--            </div>-->
            <div class="progress-bar">
                <div class="progress-fill" style="width: 0%;"></div>
            </div>
            <div class="progress-footer">
                <span class="progress-message">از موجودی فروش رفته</span>
                <span class="progress-percent text-md mx-1 font-bold">0%</span>
            </div>
        </div>
        <div class="wc-countdown-finished hidden">
            ⏰ زمان پیشنهاد ویژه به پایان رسید
        </div>
    </div>
</div>