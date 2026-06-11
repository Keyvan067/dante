<?php
if (!defined('ABSPATH')) {
    exit;
}
global $product;
$product_rating = $product->get_average_rating();
?>


<!-- TOOLTIP... -->
<div class="tooltip-dmg absolute top-0 right-0 p-1 z-10 flex flex-col gap-2 backdrop-blur-xs bg-base-200/40 rounded-2xl">
    <?php if ($product_rating > 0): ?>
    <div class="tooltip-sp">
                <span tooltip="<?php echo esc_html(number_format($product_rating, 1)); ?>" flow="left" class="*:w-6 text-base *:h-auto">
                  <i class="fa-solid fa-star text-amber-500"></i>
                </span>
    </div>
    <?php endif; ?>
    <!-- --- -->
    <div class="tooltip-sp">
                <span tooltip="افزودن به لیست علاقه مندی" flow="left" class="*:w-6 text-base *:h-auto">
                  <i class="fa-regular fa-lg fa-heart"></i>
                </span>
    </div>
    <!-- --- -->
    <div class="tooltip-sp">
                <span tooltip="اطلاع‌رسانی شگفت‌انگیز" flow="left" class="*:w-6 text-base *:h-auto">
                  <i class="fa-regular fa-lg fa-bell"></i>
                </span>
    </div>
    <!-- --- -->
    <div class="tooltip-sp">
                <span tooltip="نمودار قیمت" flow="left" class="*:w-6 text-base *:h-auto">
                  <i class="fa-regular fa-lg fa-chart-sine"></i>
                </span>
    </div>
    <!-- --- -->
    <div class="tooltip-sp">
                <span tooltip="مقایسه کالا" flow="left" class="*:w-6 text-base *:h-auto">
                  <i class="fa-regular fa-lg fa-code-compare"></i>
                </span>
    </div>
    <!-- --- -->
    <div class="tooltip-sp" data-modal-target="pdk_share-modal">
        <span tooltip="به اشتراک‌گذاری کالا" flow="left" class="*:w-6 text-base *:h-auto"><i
                    class="fa-regular fa-lg fa-share-nodes"></i></span>
    </div>
    <!-- --- -->
    <?php if (get_field('product_introduction_video')): ?>
        <div class="tooltip-sp" data-modal-target="pdk_video-modal">
            <span tooltip="ویدئو معرفی محصول" flow="left" class="*:w-6 text-base *:h-auto"><i
                        class="fa-regular fa-lg fa-circle-play"></i></span>
        </div>
    <?php endif; ?>
</div>


<!-------------||MODAL-BOX||-------------->
<!--======|| Modal Video ||======-->
<div data-modal="pdk_video-modal"
     class="modal fixed inset-0 z-50 hidden items-center justify-center">
    <div data-modal-close class="modal-backdrop absolute inset-0 bg-black/60"></div>
    <div data-modal-box
         class="relative w-full max-w-3xl bg-background rounded-2xl p-6 scale-95 opacity-0 transition-all duration-300">
        <div class="w-full flex-sbc py-2 mb-4">
            <span class="text-default"> لینک اشتراک گذاری محصول</span>
            <span data-modal-close class="w-4 h-4 rounded-full cursor-pointer text-xs bg-black/20 p-4 flex-cc"><i
                        class="fa-solid fa-xmark"></i></span>
        </div>
        <div class="w-full block">
            <video controls class="size-full max-w-[840px]">
                <source src="<?php the_field('product_introduction_video') ?>">
            </video>
        </div>
    </div>
</div>
<!--======|| Modal Product Share ||======-->
<div data-modal="pdk_share-modal"
     class="modal fixed inset-0 z-50 hidden items-center justify-center">
    <div data-modal-close class="modal-backdrop absolute inset-0 bg-black/60"></div>
    <div data-modal-box
         class="relative w-full max-w-3xl bg-background rounded-2xl p-6 scale-95 opacity-0 transition-all duration-300">
        <div class="w-full flex-sbc py-2 mb-4">
            <span class="text-default"> لینک اشتراک گذاری محصول</span>
            <span data-modal-close class="w-4 h-4 rounded-full cursor-pointer text-xs bg-black/20 p-4 flex-cc"><i
                        class="fa-solid fa-xmark"></i></span>
        </div>
        <?php if ($product instanceof WC_Product) :
            $product_url = get_permalink($product->get_id());
            ?>
            <!-- لینک محصول -->
            <div class="w-full mb-4">
            <textarea id="pdk-product-link"
                      readonly
                      class="w-full p-6 rounded border border-accent resize-none text-base"
                      rows="2"><?php echo esc_url($product_url); ?></textarea>
            </div>
            <div class="flex justify-between items-center w-full">
                <!-- دکمه کپی -->
                <button id="pdk-copy-link my-2"
                        class="mb-6 px-4 py-2 rounded bg-primary text-white text-base">
                    کپی لینک
                </button>
                <!-- اشتراک گذاری -->
                <div class="flex gap-3 items-center justify-end text-lg">
                    <a href="https://t.me/share/url?url=<?php echo rawurlencode($product_url); ?>"
                       target="_blank" rel="noopener noreferrer text-md">
                        <i class="fa-brands fa-telegram fa-lg"></i>
                    </a>

                    <a href="https://wa.me/?text=<?php echo rawurlencode($product_url); ?>"
                       target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-whatsapp fa-lg"></i>
                    </a>

                    <a href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode($product_url); ?>"
                       target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-x-twitter fa-lg"></i>
                    </a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode($product_url); ?>"
                       target="_blank" rel="noopener noreferrer">
                        <i class="fa-brands fa-meta fa-lg"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    document.addEventListener('click', function (e) {
        const copyBtn = e.target.closest('#pdk-copy-link');
        if (!copyBtn) return;

        const textarea = document.getElementById('pdk-product-link');
        if (!textarea) return;

        textarea.select();
        textarea.setSelectionRange(0, 99999);

        navigator.clipboard.writeText(textarea.value).then(() => {
            copyBtn.innerText = 'کپی شد ✔';
            setTimeout(() => {
                copyBtn.innerText = 'کپی لینک';
            }, 2000);
        });
    });
</script>

