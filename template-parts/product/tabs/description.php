<?php
defined('ABSPATH') || exit;
global $product;
if (!$product) {
    return;
}
// بررسی وجود محتوا با متد جدید
if (!woo()->tabHasContent('description', $product)) {
    return;
}
?>
<section id="description" class="pdk-tabs h-auto w-full mx-auto">
    <div class="w-full flex flex-col justify-start items-start gap-8">
        <div>
            <h3 class="h2_title">بررسی تخصصی</h3>
        </div>
        <article>
            <div class="w-full flex flex-col gap-8 text-justify">
                <?php
                // استفاده از متد get_description با فیلتر the_content
                echo apply_filters('the_content', $product->get_description());
                ?>
            </div>
        </article>
    </div>
</section>