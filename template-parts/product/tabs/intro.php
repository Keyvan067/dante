<?php
defined('ABSPATH') || exit;

global $product;

if (!$product) {
    return;
}

// بررسی وجود محتوا با متد جدید
if (!woo()->tabHasContent('intro', $product)) {
    return;
}
?>

<section id="intro" class="pdk-tabs h-auto w-full mx-auto">
    <div class="w-full flex flex-col justify-start items-start gap-8">

        <div>
            <h3 class="h2_title">معرفی محصول</h3>
        </div>

        <article>
            <div class="block w-full *:text-justify">
                <?php
                echo wp_kses_post(woo()->getProductIntro($product));
                ?>
            </div>
        </article>

    </div>
</section>