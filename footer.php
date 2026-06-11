<!-- MOBILE-BOTTOM-NAVIGATIONS... -->
<div class="!fixed !hidden bg-base-100 bottom-0 left-0 right-0 z-[999] h-20 w-screen bg-neutral-000 border-t border-base-300 max-lg:block">
    <div class="relative px-4 py-2 block h-full">
        <div class="w-full h-full flex justify-between items-center flex-row">
            <!-- TAB-HOME... -->
            <a href="#HomePage" class="flex-cc flex-col flex-1">
                    <span class="text-lg text-primary">
                        <i class="fa-solid fa-house"></i>
                    </span>
                <p class="max-[370px]:hidden text-primary text-md">
                    خانه
                </p>
            </a>
            <!-- TAB-CATEGORY... -->
            <a href="#CATEGORY" class="flex-cc flex-col flex-1">
                    <span class="text-lg text-medium">
                        <i class="fa-solid fa-grid-round-2"></i>
                    </span>
                <p class="max-[370px]:hidden text-medium text-md">
                    دسته بندی ها
                </p>
                <!-- TAB-BASKET... -->
            </a>
            <a href="#BASKET" class="flex-cc flex-col flex-1">
                    <span class="text-lg text-medium">
                        <i class="fa-solid fa-cart-shopping-fast"></i>
                    </span>
                <p class="max-[370px]:hidden text-medium text-md">
                    سبد خرید
                </p>
                <!-- TAB-BLOG... -->
            </a>
            <a href="#BLOG" class="flex-cc flex-col flex-1">
                    <span class="text-lg text-medium">
                        <i class="fa-solid fa-blog"></i>
                    </span>
                <p class="max-[370px]:hidden text-medium text-md">
                    بلاگ
                </p>
                <!-- TAB-PROFILE... -->
            </a>
            <a href="#PROFILE" class="flex-cc flex-col flex-1">
                    <span class="text-lg text-medium">
                        <i class="fa-solid fa-user"></i>
                    </span>
                <p class="max-[370px]:hidden text-medium text-md">
                    پروفایل
                </p>
            </a>
        </div>
    </div>
</div>

<div id="modal-overly"
     class="fixed top-0 left-0 hidden opacity-0 w-screen backdrop-blur-[1px]- h-screen backdrop-grayscale-50 backdrop-brightness-50 pointer-events-none modal-overly">
</div>
<!-- FOOTER... -->
<footer class="container-4xl-w w-full block h-[50rem] relative !-z-[1] bg-base-100 mt-20 pt-8 mx-auto">
    <div class="flex h-full flex-row gap-8">
        <!-- right... -->
        <div class="w-full flex grow">

            <div class="w-full h-full flex flex-col justify-start items-start px-8 gap-8">
                <!-- راه های ارتباطی -->
                <aside class="flex justify-start itcems-center gap-4 text-xs border-b border-gray-100 py-4 w-full">
                    <p> تلفن پشتیبانی <?php the_field('support_contact_numbers', 'option'); ?></p>
                    <span class="w-[2px] h-3 bg-gray-300"></span>
                    <p> <?php the_field('support_contact_numbers_i', 'option'); ?> </p>
                    <span class="w-[2px] h-3 bg-gray-300"></span>
                    <p><?php the_field('working_hours_text', 'option'); ?></p>
                </aside>
                <!-- ویجت ها -->
                <div class="w-full block">
                    <ul class="flex items-center justify-start gap-8">
                        <?php if (have_rows('footer_store_widget', 'option')): ?>
                            <?php while (have_rows('footer_store_widget', 'option')): the_row();
                                $widget_name = get_sub_field('widget_name');
                                $widget_link = get_sub_field('widget_url');
                                $widget_icon = get_sub_field('widget_icon') ?? '';
                                $widget_image_icon = get_sub_field('widget_image_icon') ?? '';
                                ?>
                                <li>
                                    <a href="<?php echo esc_url($widget_link); ?>"
                                       class="flex-cc gap-1 bg-gray-50/0 shadow-gray-100 px-6 py-3 rounded-[1.2em] shadow-lg"
                                       target="_blank" rel="noopener noreferrer"
                                       title="<?php echo esc_attr($widget_name); ?>">
                                        <span>
                                        <?php
                                        // بررسی اینکه آیکون Font Awesome وجود دارد یا خیر
                                        if (empty(trim($widget_icon))) {

                                            $img_url = '';
                                            $img_alt = $widget_name;

                                            // حالت Array
                                            if (is_array($widget_image_icon)) {
                                                $img_url = $widget_image_icon['url'] ?? '';
                                                $img_alt = $widget_image_icon['alt'] ?? $widget_name;

                                                // حالت ID
                                            } elseif (is_numeric($widget_image_icon)) {
                                                $img_url = wp_get_attachment_url($widget_image_icon);

                                                // حالت URL
                                            } elseif (is_string($widget_image_icon)) {
                                                $img_url = $widget_image_icon;
                                            }

                                            // فقط اگر URL معتبر وجود دارد نمایش بده
                                            if (!empty($img_url)) {
                                                ?>
                                                <img src="<?php echo esc_url($img_url); ?>"
                                                     alt="<?php echo esc_attr($img_alt); ?>"
                                                     style="width:50px;height:auto;object-fit:contain">
                                                <?php
                                            }

                                        } else {
                                            // نمایش آیکون Font Awesome
                                            ?>
                                            <i class="text-2xl <?php echo esc_attr($widget_icon); ?>"></i>
                                        <?php } ?>
                                        </span>
                                        <span class="mr-2 text-base"> <?php echo esc_attr($widget_name); ?> </span>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- footer-guide -->
                <div class="flex flex-row gap-6 justify-between w-full">
                    <!-- Contact us -->
                    <aside class="flex flex-col justify-start items-start gap-4 basis-1/3">
                        <div class="flex-cc text-lg gap-2 *:font-bold py-4">
                            <span><i class="fa-solid fa-headset"></i></span>
                            <span class="text-rose-500">راه های </span>
                            <span> ارتباطی </span>
                        </div>
                        <div class="flex gap-2 *:text-sm justify-start items-start">
                            <span class="text-gray-500"> آدرس </span>
                            :
                            <p class="font-bold !text-xs leading-6"><?php the_field('footer_contact__address', 'option'); ?></p>
                        </div>
                        <div class="flex-cc gap-2">
                            <span class="text-gray-500"> شماره تماس : </span>
                            <span>
                  <bdi class="text-lg font-bold text-primary"> <?php the_field('footer_contact__telephone_number_prefix', 'option'); ?> <bdi
                              class="text-xl text-rose-500"><?php the_field('footer_contact__telephone_number', 'option'); ?></bdi></bdi>
                </span>
                        </div>
                        <div class="flex-cc text-xs gap-2">
                            <span class="text-gray-500"> آدرس ایمیل : </span>
                            <span class="tracking-wider font-bold"><?php the_field('footer_contact__email', 'option'); ?></span>
                        </div>
                    </aside>
                    <!-- خدمات مشتریان -->
                    <aside class="flex flex-col justify-start items-start gap-4 basis-1/3">
                        <div class="flex-cc text-lg gap-2 *:font-bold py-4">
                            <span><i class="fa-solid fa-headset"></i></span>
                            <span class="text-rose-500"> خدمات </span>
                            <span> مشتریان </span>
                        </div>
                        <div class="flex flex-col justify-start items-start gap-4 pr-4">
                            <?php
/*                            wp_nav_menu([
                                'theme_location' => 'footer-support',
                                'container' => false,
                                'items_wrap' => '%3$s', // حذف ul
                                'walker' => new \App\Modules\Helpers\Walkers\FooterLinksWalker(),
                            ]);
                            */?><!--
                            <?php echo helpers()->footerMenuSupport(); ?>
                            <a href="#">پاسخ به پرسش‌های متداول</a>-->
                        </div>
                    </aside>
                    <aside class="flex flex-col justify-start items-start gap-4 basis-1/3">
                        <div class="flex-cc text-lg gap-2 *:font-bold py-4">
                            <span><i class="fa-solid fa-headset"></i></span>
                            <span class="text-rose-500"> راهنمای </span>
                            <span> خرید از فروشگاه </span>
                        </div>
                        <div class="flex flex-col justify-start items-start gap-4 pr-4">
                            <?php
                            echo helpers()->footerMenuGuide();
                            /* wp_nav_menu([
                                 'theme_location' => 'footer-guide',
                                 'container' => false,
                                 'items_wrap' => '%3$s', // حذف ul
                                 'walker' => new Footer_Links_Walker(),
                             ]);*/
                            ?>
                        </div>
                    </aside>
                </div>
                <!-- درباره فروشگاه -->
                <div class="w-full block border-b border-base-200 py-6">
                    <aside class="flex items-center gap-8 justify-start">
                        <div>
                            <img style="max-width: 10rem;height: auto;object-fit: contain"
                                 src="<?php the_field('footer_about__logo', 'option'); ?>" alt="logo">
                        </div>
                        <div>
                            <p class="text-body-sm">
                                <?php the_field('footer_about__description', 'option'); ?>
                            </p>
                        </div>
                        <ul class="flex flex-row items-start gap-3 justify-center-center *:text-[1.2em]">
                            <?php if (have_rows('store_permissions', 'option')): ?>
                                <?php while (have_rows('store_permissions', 'option')): the_row();
                                    $permissions_text = get_sub_field('permissions_text');
                                    $permissions_image = get_sub_field('permissions_image');
                                    $permissions_link = get_sub_field('permissions_link');
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url($permissions_link) ?? ''; ?>" target="_blank"
                                           rel="noopener noreferrer"
                                           title="<?php echo esc_attr($permissions_text) ?? ''; ?>">
                                            <div class="size-40 hover:bg-gray-400 transition-all flex-cc rounded-md bg-base-100">
                                                <img
                                                        style="max-width:8rem;height:auto;object-fit:contain"
                                                        src="<?php echo esc_url($permissions_image) ?? ''; ?>"
                                                        alt="<?php echo esc_attr($permissions_text) ?? ''; ?>"
                                                >
                                            </div>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </ul>
                    </aside>
                </div>
                <!-- حق نشر فروشگاه -->
                <div class="w-full block mt-4">
                    <div class="flex-cc py-6">
                        <p class="copy-right text-sm text-base-content/70">
                            <?php the_field('footer__copyright_notices', 'option'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- left... -->
            <div class="flex shrink-0 gap-8 p-2 flex-col justify-between items-center basis-10 max-w-28 h-full border-r border-dashed border-base-200">
                <div class="flex shrink-0 gap-8 flex-col justify-center items-center">
                    <!-- منو کناری - لوگو -->
                    <div class="flex-cc font-extrabold text-rose-700 text-lg">
                        <img style="max-width: 5rem;height: auto;object-fit: contain"
                             src="<?php the_field('footer_about__logo', 'option'); ?>" alt="logo">
                    </div>
                    <!-- منو کناری فوتر -->
                    <div class="w-full block mb-4">

                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer-help-menu',
                            'menu' => 'ul',
                            'menu_class' => 'flex flex-col gap-3 text-[.85em] justify-center  items-center',
                            'container' => false,
                            'container_class' => false,
                            'fallback_cb' => '',
                            'depth' => 1,
                        ));
                        ?>
                    </div>
                    <!--side-menu---button--go-to-up...-->
                </div>
                <!--social links...-->
                <div>
                    <div class="flex-cc mb-4">
                        <button id="backToTop" class="rounded-full size-10 bg-primary transition-all flex-cc">
                            <i class="fa-solid fa-angle-up fa-lg text-base-100"></i>
                        </button>
                    </div>
                    <div class="w-full block mb-4">
                        <ul class="flex flex-col items-start gap-3 justify-center *:text-xs">
                            <?php if (have_rows('footer_social', 'option')): ?>
                                <?php while (have_rows('footer_social', 'option')): the_row();
                                    $social_name = get_sub_field('social_name');
                                    $social_link = get_sub_field('social_url');
                                    $social_icon = get_sub_field('social_icon');
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url($social_link); ?>" target="_blank"
                                           rel="noopener noreferrer" title="<?php echo esc_attr($social_name); ?>">
                                            <div class="size-10 hover:bg-base-300 transition-all flex-cc rounded-full bg-base-200">
                                                <i class="<?php echo esc_attr($social_icon); ?> fa-xl text-base-content/70"></i>
                                            </div>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- END-FOOTER... -->

<!-- SCRIPTS... -->
<?php wp_footer(); ?>

<script>
    jQuery(function($){

        let countdownInterval = null;

        function destroyTimer() {
            if(countdownInterval){
                clearInterval(countdownInterval);
                countdownInterval = null;
            }

            $('#variation-timer-container').hide();
            $('.wc-countdown').html('');
            $('.wc-countdown-progress').addClass('hidden');
        }

        function initTimer(expireISO){

            const wrapper = $('.wc-countdown-wrapper');
            wrapper.attr('data-expire', expireISO);

            const expireDate = new Date(expireISO).getTime();

            countdownInterval = setInterval(function(){

                const now = new Date().getTime();
                const distance = expireDate - now;

                if(distance <= 0){
                    clearInterval(countdownInterval);
                    $('.wc-countdown').html('');
                    $('.wc-countdown-finished').removeClass('hidden');
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
                const minutes = Math.floor((distance / (1000 * 60)) % 60);
                const seconds = Math.floor((distance / 1000) % 60);

                $('.wc-countdown').html(
                    `${days} : ${hours} : ${minutes} : ${seconds}`
                );

            }, 1000);

        }

        $(document).on('found_variation', 'form.variations_form', function(event, variation){

            destroyTimer();

            if(!variation) return;

            // بررسی فروش ویژه
            if(
                variation.display_price < variation.display_regular_price &&
                variation.date_on_sale_to
            ){

                const expireISO = new Date(variation.date_on_sale_to * 1000).toISOString();

                $('#variation-timer-container').css('display','flex');
                $('.wc-countdown-finished').addClass('hidden');

                initTimer(expireISO);

                // بررسی درصد تخفیف
                const discountPercent =
                    ((variation.display_regular_price - variation.display_price)
                        / variation.display_regular_price) * 100;

                if(discountPercent >= 50){

                    $('.wc-countdown-progress').removeClass('hidden');

                    const sold = variation.total_sales || 0;
                    const stock = variation.max_qty || 0;

                    $('.progress-sold').text(sold);
                    $('.progress-stock').text(stock);

                    if(stock > 0){
                        const percent = Math.min(100, (sold / stock) * 100);
                        $('.progress-fill').css('width', percent + '%');
                        $('.progress-percent').text(Math.round(percent) + '%');
                    }

                }

            } else {
                destroyTimer();
            }

        });

    });
</script>
</body>
</html>