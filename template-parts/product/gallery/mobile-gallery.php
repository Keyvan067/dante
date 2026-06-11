<?php
$images = $args['images'] ?? [];
if (empty($images)) {
    return;
}
?>
<div class="gallery-mobile">
    <div class="relative bg-base-300">
        <div class="swiper swiper-gallery-mobile">
            <div class="swiper-wrapper">
                <?php foreach ($images as $id) : ?>
                    <div class="swiper-slide">
                        <figure>
                            <?php echo wp_get_attachment_image($id, 'large', false, [
                                'class' => 'object-contain w-full h-full'
                            ]); ?>
                        </figure>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="gms-navigation">
                <div class="widgets-info">0</div>
                <div class="swi-navigation">
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>
