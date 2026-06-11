<?php
defined('ABSPATH') || exit;

global $product;

if (!$product) {
    return;
}

// دریافت مشخصات فنی با متد جدید
$specs = woo()->getProductSpecifications($product);

if (empty($specs)) {
    return;
}
?>

<section id="specs" class="pdk-tabs h-auto w-full mx-auto">
    <div class="w-full flex flex-col justify-start items-start gap-4">

        <div>
            <h3 class="h2_title">مشخصات محصول</h3>
        </div>

        <div class="w-full block">
            <div class="block w-full my-4">
                <!-- مشخصات کلی -->
                <div class="pb-8">
                    <dl class="pr-4 w-auto grow overflow-hidden *:bg-background *:odd:bg-slate-50 text-sm">
                        <?php foreach ($specs as $spec) : ?>
                            <div class="flex">
                                <dt class="w-1/3 px-4 py-3.5 text-default font-medium">
                                    <?php echo esc_html($spec['label']); ?>
                                </dt>
                                <dd class="w-2/3 px-4 py-4 flex text-neutral-900 text-wrap text-justify break-words leading-7">
                                    <?php echo esc_html($spec['value']); ?>
                                </dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                </div>

                <!--
                // در صورت نیاز به بخش‌بندی دستی می‌تونی از این روش استفاده کنی
                <div class="pb-8">
                    <h5 class="px-4 py-3 text-sm font-bold">صفحه نمایش</h5>
                    <dl class="*:last:border-none pr-4 w-auto grow overflow-hidden">
                        <div class="flex border-b border-[var(--border-base)]">
                            <dt class="w-1/3 px-4 py-3.5 text-xs text-neutral-500">فناوری صفحه‌ نمایش</dt>
                            <dd class="w-2/3 px-4 py-4 flex text-xs text-neutral-900 font-normal text-wrap text-justify break-words leading-7">
                                Dynamic LTPO AMOLED ۲X
                            </dd>
                        </div>
                    </dl>
                </div>
                -->

            </div>
        </div>

    </div>
</section>