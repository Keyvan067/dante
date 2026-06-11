<section>
    <div class="w-full h-fit flex flex-col gap-4">
        <!-------------------------------->
        <?php get_template_part('template-parts/widgets/divider.php'); ?>
        <!-------------------------------->
        <div class="swiper special-products w-full !py-5 !px-4">
            <div class="swiper-wrapper">
                <?php

                $new_products = new WP_Query([
                    'post_type'           => 'product',
                    'post_status'         => 'publish',
                    'posts_per_page'      => 10,
                    'orderby'             => 'date',
                    'order'               => 'DESC',
                    'no_found_rows'       => true,
                ]);

                if ( $new_products->have_posts() ) :
                while ( $new_products->have_posts() ) :
                $new_products->the_post();

                $product = wc_get_product( get_the_ID() );

                if ( ! $product ) {
                    continue; // 👈 نه return
                }

                //=============>>-->>
                ?>

                <div class="swiper-slide">
                    <div class="product-card-wrapper">
                        <div class="product-card-inner">
                            <div class="product-card--image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    if ( has_post_thumbnail() ) {
                                        the_post_thumbnail( 'medium', ['class' => 'mx-auto'] );
                                    } else {
                                        echo '<img height="240" width="240" style="object-fit:cover;" src="' . get_template_directory_uri() . '/assets/images/placeholder-1.jpg">';
                                    }
                                    ?>
                                </a>
                            </div>
                            <div class="product-card--title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </div>
                            <div class="product-card--details">
                                <div class="product-card--detail-stock">
                                    موجودی
                                    <span><?php echo $product->get_stock_quantity(); ?></span>
                                </div>
                                <div class="product-card--detail-rating">
                                    <span><?php echo $product->get_average_rating(); ?></span>
                                    <i class="fa-solid fa-star"></i>
                                </div>
                            </div>
                            <div class="product-card--actions">
                                <div class="product-card--action-addtocart">
                                    <?php if($product->is_in_stock() && $product->get_price() && $product->get_price_html()) { ?>
                                    <button class="product-card--action-addtocart-btn btn-primary">
                                        افزودن به سبد
                                    </button>
                                    <div class="product-card--action-addtocart-quantity"></div>
                                    <?php } ?>
                                </div>
                                <div class="product-card--action-price">
                                    <div class="product-card--content-price">
                                        <span class="product-card--content-price-no-discount">
                                             <?php if ($product->is_in_stock() && $product->is_on_sale()) { ?>
                                                <span class="product-card--content-price-no-discount-price">
                                                    <?php echo wc_price( $product->get_regular_price()); ?>
                                                </span>
                                                <?php
                                                 $regular = (float) $product->get_regular_price();
                                                 $sale    = (float) $product->get_sale_price();

                                                    if ( $regular > 0 && $sale > 0 ) :
                                                    $percentage = round( ( ( $regular - $sale ) / $regular ) * 100 );
                                                    ?>
                                                        <span class="product-card--content-price-discounted-percentage">
                                                         <span><?php echo $percentage; ?></span>
                                                         <i class="fa-solid fa-percent"></i>
                                                        </span>
                                                    <?php endif; ?>
                                                 <?php } ?>
                                        </span>
                                        <span class="product-card--content-price-discounted-amount">
                                            <span>
                                                <?php if($product->is_in_stock() && $product->get_price_html()) { ?>

                                                <?php echo wc_price( $product->get_price()); ?>

                                                <?php
                                                }elseif (!$product->is_in_stock()) {
                                                 ?>
                                                    <span class=""> ناموجود </span>
                                                <?php
                                                }else{
                                                ?>
                                                    <span class=""> تماس بگیرید </span>
                                                <?php } ?>
                                            </span>
                                            <span>
                                                <span class="currency-symbol currency-irr"></span>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                endwhile;
                wp_reset_postdata();
                endif;

                ?>

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>