<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <!--    <link rel="icon" type="image/x-icon" href="./favicon.ico" />-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- PLUGINS... -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<!-- HEADER... -->
<header class="<?php echo is_admin_bar_showing() ? '' : 'm-0'; ?> header-container fixed">
    <div class="header-wrapper">
        <div class="container-4xl-w header-wrapper_top">
            <div class="flex-sbc">
                <div class="header-right-content">
                    <div class="logo-wrapper">
                        <a href="#" class="flex-cc overflow-hidden">
                            <img width="100" height="60" style="object-fit: contain"
                                 src="<?php echo get_template_directory_uri() . '/assets/images/'; ?>full-horizontal.svg"
                                 alt="#"/>
                        </a>
                    </div>
                    <div class="search-wrapper">
                        <div class="relative z-50 max-lg:grow">
                            <div class="flex-sbc bg-base-100">
                                <?php get_search_form(); ?>
                            </div>
                            <!-- Modal-Search... -->
                            <div id="search-ecommerce-modal"
                                 class="absolute hidden ca__fx-mask-wipeInLeft w-full max-h-[70vh] min-h-52 top-full left-0 mt-3 rounded-lg shadow-box bg-base-200 backdrop-blur-xs overflow-y-auto z-50">
                                <div class="grow">
                                    <div class="hidden-- flex flex-col justify-start items-start gap-0">
                                        <!-- Search-Result...display-none... -->
                                        <div class="hidden-- flex w-full grow flex-1 pb-4 *:font-[600] text-default">

                                            <div id="live-search-results"
                                                 class="flex grow flex-col py-2 max-lg:px-4 min-lg:px-10 min-xl:pl-16">

                                                <div class="w-full pb-4">

                                                            <span class="flex items-center py-2 gap-2 my-1">
                                                                <i class="fa-jelly-fill fa-regular fa-layer-group"></i>
                                                                <p>همه دسته ها</p>
                                                            </span>
                                                    <!-- جستوجو در دسته بندی ها -->
                                                    <div class="searching-categories">
                                                        <div
                                                                class="flex items-start justify-start gap-3 py-2 cursor-pointer">
                                                                    <span><i
                                                                                class="fa-solid fa-magnifying-glass"></i></span>
                                                            <span>
                                                                        <p class="font-bold text-primary">
                                                                            مادربرد
                                                                        </p>
                                                                        <div class="flex gap-1.5 py-1">
                                                                            <span class="text-muted">در دسته</span>
                                                                            <span class="text-primary">مادربرد</span>
                                                                        </div>
                                                                    </span>
                                                        </div>
                                                    </div>
                                                    <!-- جستوجو در دسته بندی ها -->
                                                    <div class="searching-categories">
                                                        <div
                                                                class="flex items-start justify-start gap-3 py-2 cursor-pointer">
                                                                    <span><i
                                                                                class="fa-solid fa-magnifying-glass"></i></span>
                                                            <span>
                                                                        <p class="font-bold text-primary">
                                                                            مادربرد
                                                                        </p>
                                                                        <div class="flex gap-1.5 py-1">
                                                                            <span class="text-base-500">در دسته</span>
                                                                            <span class="text-rose-500">مادربرد</span>
                                                                        </div>
                                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Searching-Suggested... -->
                                                <div class="w-full border-t border-base-200 pt-4">
                                                    <!-- Search-Result-Suggest... -->
                                                    <div class="py-2 break-words block">
                                                        <div
                                                                class="flex-sbc text-base-500 cursor-pointer">
                                                                    <span class="flex shrink-0 ml-4">
                                                                        <i class="fa-light fa-magnifying-glass"></i>
                                                                    </span>
                                                            <span class="grow text-right">
                                                                        <p class="grow">مادربرد</p>
                                                                    </span>
                                                            <span class="shrink-0 mr-4 flex items-center">
                                                                        <div class="flex-cc">
                                                                            <i class="fa-regular fa-arrow-up-right"></i>
                                                                        </div>
                                                                    </span>
                                                        </div>
                                                    </div>
                                                    <!-- Search-Result-Suggest... -->
                                                    <div class="py-2 break-words block">
                                                        <div
                                                                class="flex-sbc text-base-500 cursor-pointer">
                                                                    <span class="flex shrink-0 ml-4">
                                                                        <i class="fa-light fa-magnifying-glass"></i>
                                                                    </span>
                                                            <span class="grow text-right">
                                                                        <p class="grow">مادربرد</p>
                                                                    </span>
                                                            <span class="shrink-0 mr-4 flex items-center">
                                                                        <div class="flex-cc">
                                                                            <i class="fa-regular fa-arrow-up-right"></i>
                                                                        </div>
                                                                    </span>
                                                        </div>
                                                    </div>
                                                    <!-- Search-Result-Suggest... -->
                                                    <div class="py-2 break-words block">
                                                        <div
                                                                class="flex-sbc text-base-500 cursor-pointer">
                                                                    <span class="flex shrink-0 ml-4">
                                                                        <i class="fa-light fa-magnifying-glass"></i>
                                                                    </span>
                                                            <span class="grow text-right">
                                                                        <p class="grow">مادربرد</p>
                                                                    </span>
                                                            <span class="shrink-0 mr-4 flex items-center">
                                                                        <div class="flex-cc">
                                                                            <i class="fa-regular fa-arrow-up-right"></i>
                                                                        </div>
                                                                    </span>
                                                        </div>
                                                    </div>
                                                    <!-- Search-Result-Suggest... -->
                                                    <div class="py-2 break-words block">
                                                        <div
                                                                class="flex-sbc text-base-500 cursor-pointer">
                                                                    <span class="flex shrink-0 ml-4">
                                                                        <i class="fa-light fa-magnifying-glass"></i>
                                                                    </span>
                                                            <span class="grow text-right">
                                                                        <p class="grow">مادربرد</p>
                                                                    </span>
                                                            <span class="shrink-0 mr-4 flex items-center">
                                                                        <div class="flex-cc">
                                                                            <i class="fa-regular fa-arrow-up-right"></i>
                                                                        </div>
                                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Search-Ads... -->
                                        <div class="hidden --flex w-full h-auto grow items-center justify-center p-8">
                                            <a href="#">
                                                <figure class="flex grow rounded-lg overflow-hidden">
                                                    <img width="auto" height="auto"
                                                         src="<?php echo get_template_directory_uri() . './assets/images'; ?>/a666541b058f235cf56056d340eff074a4fb2917_1758605118.webp"
                                                         alt=""/>
                                                </figure>
                                            </a>
                                        </div>
                                        <!-- Search-Swiper-Tags... -->
                                        <div class="hidden --flex flex-col items-start justify-center w-full gap-4 px-3 mb-4">
                                            <div class="flex-cc gap-1 text-base font-bold">
                                                <i class="fa-regular fa-fire-flame-curved"></i>
                                                <h4>جستوجوهای اخیر</h4>
                                            </div>
                                            <!-- Swiper -->
                                            <div class="swiper search-swiper-tags grow max-h-9">
                                                <div
                                                        class="swiper-wrapper *:bg-base-100 *:border *:border-base-200 text-[.7em] font-[600] text-gray-600 *:px-3 *:py-2 *:rounded-full *:gap-2">
                                                    <div class="swiper-slide max-w-fit">
                                                        <a href="#" class="flex-cc">
                                                            <span>گوشی سامسونگ</span>
                                                            <span><i
                                                                        class="fa-regular fa-chevron-left"></i></span>
                                                        </a>
                                                    </div>

                                                    <div class="swiper-slide max-w-fit">
                                                        <a href="#" class="flex-cc">
                                                            <span> پرینتر </span>
                                                            <span><i
                                                                        class="fa-regular fa-chevron-left"></i></span>
                                                        </a>
                                                    </div>
                                                    <div class="swiper-slide max-w-fit">
                                                        <a href="#" class="flex-cc">
                                                            <span> دستبند طلا ناریا </span>
                                                            <span><i
                                                                        class="fa-regular fa-chevron-left"></i></span>
                                                        </a>
                                                    </div>

                                                    <div class="swiper-slide max-w-fit">
                                                        <a href="#" class="flex-cc">
                                                            <span> برنج </span>
                                                            <span><i
                                                                        class="fa-regular fa-chevron-left"></i></span>
                                                        </a>
                                                    </div>
                                                    <div class="swiper-slide max-w-fit">
                                                        <a href="#" class="flex-cc">
                                                            <span>شیائومی</span>
                                                            <span><i
                                                                        class="fa-regular fa-chevron-left"></i></span>
                                                        </a>
                                                    </div>
                                                    <div class="swiper-slide max-w-fit">
                                                        <a href="#" class="flex-cc">
                                                            <span> موبایل </span>
                                                            <span><i
                                                                        class="fa-regular fa-chevron-left"></i></span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden max-lg:flex mr-6 shrink-0">
                    <button class="size-10 rounded-lg bg-base-300">
                        <span class="text-primary"><i class="fa-regular fa-bell"></i></span>
                    </button>
                </div>
                <div class="flex items-center gap-4 max-lg:hidden">
                    <div class="rounded-lg h-12 flex-sbc gap-8">
                        <a href="" class="flex transition-all rounded-lg relative">
                            <i class="fa-regular fa-user fa-xl"></i>
                        </a>
                        <a class="flex transition-all rounded-lg relative">
                            <i class="fa-regular fa-bell fa-xl"></i>
                        </a>
                    </div>
                    <div class="relative">
                        <!-- Put this part before </body> tag -->
                        <div class="px-1 cursor-pointer" data-modal-target="header-basket">
                            <i class="fa-regular fa-xl fa-cart-shopping"></i>
                            <div class="indicator">
                                    <span class="indicator-item indicator-start sm:indicator-middle md:indicator-bottom lg:indicator-center xl:indicator-end badge badge-secondary">
                                        10
                                    </span>
                            </div>
                        </div>
                        <!-------------------------------->
                        <div data-modal="header-basket"
                             class="custom-modal hidden !left-0 top-full w-max max-w-lg !right-auto inset-0 z-50 items-center justify-center shadow-lg">
                            <div data-modal-close class="modal-backdrop fixed inset-0 bg-transparent"></div>
                            <div data-modal-box
                                 class="relative w-full bg-base-100 rounded-box opacity-0 transition-all duration-300">
                                <div class="w-full block pt-5">
                                    <ul class="w-full max-w-xl *:border-b *:border-base-200 *:last:border-none  max-h-[45vh] overflow-y-scroll overflow-x-hidden p-4">
                                        <li class="p-4 pb-2 text-xs opacity-60 tracking-wide font-bold">6 کالا</li>
                                        <li class="flex justify-between items-start gap-3 p-4">
                                            <div class="text-4xl font-thin opacity-50 tabular-nums">01</div>
                                            <div class="max-w-fit w-fit">
                                                <img width="100" height="auto" class="rounded-box"
                                                     src="https://img.daisyui.com/images/profile/demo/1@94.webp"/>
                                            </div>
                                            <div class="w-full flex flex-col gap-3 items-start justify-start">
                                                <p class="block !line-clamp-1 h5_title">
                                                    مانیتور گیمینگ خمیده 34 اینچ شیائومی مدل G34WQi، رزولوشن QHD -
                                                    2K، نرخ بروزرسانی 180 هرتز، پنل VA، نسبت تصویر 21:9 - Ultra
                                                    Wide، قابلیت HDR10، قابلیت تنظیم ارتفاع، حالت گیمینگ FreeSync
                                                    Premium
                                                </p>
                                                <div class="flex w-full text-xs font-semibold opacity-60">
                                                    رنگ: مشکی
                                                </div>
                                                <div class="flex flex-col space-y-1 w-full items-end">
                                                    <span class="text-lg font-semibold text-default">52,599,000</span>
                                                    <div class="flex gap-3 items-center grow">
                                                        <span class="badge badge-lg badge-primary">6%</span>
                                                        <span class="line-through text-primary">51,520,000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="flex justify-between items-start gap-3 p-4">
                                            <div class="text-4xl font-thin opacity-50 tabular-nums">01</div>
                                            <div class="max-w-fit w-fit">
                                                <img width="100" height="auto" class="rounded-box"
                                                     src="https://img.daisyui.com/images/profile/demo/1@94.webp"/>
                                            </div>
                                            <div class="w-full flex flex-col gap-3 items-start justify-start">
                                                <p class="block !line-clamp-1 h5_title">
                                                    مانیتور گیمینگ خمیده 34 اینچ شیائومی مدل G34WQi، رزولوشن QHD -
                                                    2K، نرخ بروزرسانی 180 هرتز، پنل VA، نسبت تصویر 21:9 - Ultra
                                                    Wide، قابلیت HDR10، قابلیت تنظیم ارتفاع، حالت گیمینگ FreeSync
                                                    Premium
                                                </p>
                                                <div class="flex w-full text-xs font-semibold opacity-60">
                                                    رنگ: مشکی
                                                </div>
                                                <div class="flex flex-col space-y-1 w-full items-end">
                                                    <span class="text-lg font-semibold text-default">52,599,000</span>
                                                    <div class="flex gap-3 items-center grow">
                                                        <span class="badge badge-lg badge-primary">6%</span>
                                                        <span class="line-through text-primary">51,520,000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="flex justify-between items-start gap-3 p-4">
                                            <div class="text-4xl font-thin opacity-50 tabular-nums">01</div>
                                            <div class="max-w-fit w-fit">
                                                <img width="100" height="auto" class="rounded-box"
                                                     src="https://img.daisyui.com/images/profile/demo/1@94.webp"/>
                                            </div>
                                            <div class="w-full flex flex-col gap-3 items-start justify-start">
                                                <p class="block !line-clamp-1 h5_title">
                                                    مانیتور گیمینگ خمیده 34 اینچ شیائومی مدل G34WQi، رزولوشن QHD -
                                                    2K، نرخ بروزرسانی 180 هرتز، پنل VA، نسبت تصویر 21:9 - Ultra
                                                    Wide، قابلیت HDR10، قابلیت تنظیم ارتفاع، حالت گیمینگ FreeSync
                                                    Premium
                                                </p>
                                                <div class="flex w-full text-xs font-semibold opacity-60">
                                                    رنگ: مشکی
                                                </div>
                                                <div class="flex flex-col space-y-1 w-full items-end">
                                                    <span class="text-lg font-semibold text-default">52,599,000</span>
                                                    <div class="flex gap-3 items-center grow">
                                                        <span class="badge badge-lg badge-primary">6%</span>
                                                        <span class="line-through text-primary">51,520,000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="flex justify-between items-start gap-3 p-4">
                                            <div class="text-4xl font-thin opacity-50 tabular-nums">01</div>
                                            <div class="max-w-fit w-fit">
                                                <img width="100" height="auto" class="rounded-box"
                                                     src="https://img.daisyui.com/images/profile/demo/1@94.webp"/>
                                            </div>
                                            <div class="w-full flex flex-col gap-3 items-start justify-start">
                                                <p class="block !line-clamp-1 h5_title">
                                                    مانیتور گیمینگ خمیده 34 اینچ شیائومی مدل G34WQi، رزولوشن QHD -
                                                    2K، نرخ بروزرسانی 180 هرتز، پنل VA، نسبت تصویر 21:9 - Ultra
                                                    Wide، قابلیت HDR10، قابلیت تنظیم ارتفاع، حالت گیمینگ FreeSync
                                                    Premium
                                                </p>
                                                <div class="flex w-full text-xs font-semibold opacity-60">
                                                    رنگ: مشکی
                                                </div>
                                                <div class="flex flex-col space-y-1 w-full items-end">
                                                    <span class="text-lg font-semibold text-default">52,599,000</span>
                                                    <div class="flex gap-3 items-center grow">
                                                        <span class="badge badge-lg badge-primary">6%</span>
                                                        <span class="line-through text-primary">51,520,000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="flex justify-between items-start gap-3 p-4">
                                            <div class="text-4xl font-thin opacity-50 tabular-nums">01</div>
                                            <div class="max-w-fit w-fit">
                                                <img width="100" height="auto" class="rounded-box"
                                                     src="https://img.daisyui.com/images/profile/demo/1@94.webp"/>
                                            </div>
                                            <div class="w-full flex flex-col gap-3 items-start justify-start">
                                                <p class="block !line-clamp-1 h5_title">
                                                    مانیتور گیمینگ خمیده 34 اینچ شیائومی مدل G34WQi، رزولوشن QHD -
                                                    2K، نرخ بروزرسانی 180 هرتز، پنل VA، نسبت تصویر 21:9 - Ultra
                                                    Wide، قابلیت HDR10، قابلیت تنظیم ارتفاع، حالت گیمینگ FreeSync
                                                    Premium
                                                </p>
                                                <div class="flex w-full text-xs font-semibold opacity-60">
                                                    رنگ: مشکی
                                                </div>
                                                <div class="flex flex-col space-y-1 w-full items-end">
                                                    <span class="text-lg font-semibold text-default">52,599,000</span>
                                                    <div class="flex gap-3 items-center grow">
                                                        <span class="badge badge-lg badge-primary">6%</span>
                                                        <span class="line-through text-primary">51,520,000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="flex justify-between items-start gap-3 p-4">
                                            <div class="text-4xl font-thin opacity-50 tabular-nums">01</div>
                                            <div class="max-w-fit w-fit">
                                                <img width="100" height="auto" class="rounded-box"
                                                     src="https://img.daisyui.com/images/profile/demo/1@94.webp"/>
                                            </div>
                                            <div class="w-full flex flex-col gap-3 items-start justify-start">
                                                <p class="block !line-clamp-1 h5_title">
                                                    مانیتور گیمینگ خمیده 34 اینچ شیائومی مدل G34WQi، رزولوشن QHD -
                                                    2K، نرخ بروزرسانی 180 هرتز، پنل VA، نسبت تصویر 21:9 - Ultra
                                                    Wide، قابلیت HDR10، قابلیت تنظیم ارتفاع، حالت گیمینگ FreeSync
                                                    Premium
                                                </p>
                                                <div class="flex w-full text-xs font-semibold opacity-60">
                                                    رنگ: مشکی
                                                </div>
                                                <div class="flex flex-col space-y-1 w-full items-end">
                                                    <span class="text-lg font-semibold text-default">52,599,000</span>
                                                    <div class="flex gap-3 items-center grow">
                                                        <span class="badge badge-lg badge-primary">6%</span>
                                                        <span class="line-through text-primary">51,520,000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="flex justify-between items-start gap-3 p-4">
                                            <div class="text-4xl font-thin opacity-50 tabular-nums">01</div>
                                            <div class="max-w-fit w-fit">
                                                <img width="100" height="auto" class="rounded-box"
                                                     src="https://img.daisyui.com/images/profile/demo/1@94.webp"/>
                                            </div>
                                            <div class="w-full flex flex-col gap-3 items-start justify-start">
                                                <p class="block !line-clamp-1 h5_title">
                                                    مانیتور گیمینگ خمیده 34 اینچ شیائومی مدل G34WQi، رزولوشن QHD -
                                                    2K، نرخ بروزرسانی 180 هرتز، پنل VA، نسبت تصویر 21:9 - Ultra
                                                    Wide، قابلیت HDR10، قابلیت تنظیم ارتفاع، حالت گیمینگ FreeSync
                                                    Premium
                                                </p>
                                                <div class="flex w-full text-xs font-semibold opacity-60">
                                                    رنگ: مشکی
                                                </div>
                                                <div class="flex flex-col space-y-1 w-full items-end">
                                                    <span class="text-lg font-semibold text-default">52,599,000</span>
                                                    <div class="flex gap-3 items-center grow">
                                                        <span class="badge badge-lg badge-primary">6%</span>
                                                        <span class="line-through text-primary">51,520,000</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="block w-full p-4 border-t border-base-200 mt-2">
                                        <div class="flex-sbc">
                                            <button class="btn btn-xl px-10 py-4 text-base">
                                                <span> مشاهده سبد خرید </span>
                                            </button>
                                            <button class="btn btn-xl btn-primary px-10 py-4 text-base">
                                                <span> پرداخت </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-------------------------------->
                    </div>
                </div>
            </div>
        </div>
        <!-- ::Navbar:: -->
        <nav class="container-4xl-w max-lg:hidden md:px-4 base-header-navigation flex mx-auto justify-between items-center">
            <div class="navbar-main max-sm:px-4 relative">
                <ul class="flex flex-row gap-6 text-[0.95em] py-2 leading-[1]">
                    <li class="relative py-3">
                        <a href="/#" class="flex-cc gap-2 leading-0">
                            <div class="size-auto">
                                <i class="fa-solid fa-grid-round-2"></i>
                            </div>
                            <span class="text-nowrap"> همه دسته بندی ها </span>
                            <span>|</span>
                        </a>
                        <!-- :::SUB-MENU::: -->
                        <div class="submenu-body hidden max-lg:hidden min-xl:w-7xl min-lg:w-5xl absolute right-0 bg-base-100 border-b-2 border-base-200 rounded-b-box z-40 w-auto overflow-hidden">
                            <div class="grid max-h-[60vh] h-[60vh] overflow-hidden"
                                 style="max-height: 60vh;grid-template-columns: 1.5fr 7fr;min-height: 28vh;">
                                <!-- Right Categories Column -->
                                <div class="border-r border-base-200 h-[inherit]">
                                    <div class="space-y-1 overflow-y-auto h-full" style="direction: ltr">
                                        <!-- MEGA-MENU-RIGHT---PARENTS | LEVEL-1-->
                                        <?php
                                        if (has_nav_menu('mega-menu')) {
                                            wp_nav_menu(array(
                                                    'theme_location' => 'mega-menu',
                                                    'container' => false,            // بدون div اضافی
                                                    'items_wrap' => '%3$s',           // حذف <ul> دور منو
                                                    'depth' => 1,
                                                    'walker' => new MegaMenu_Walker(), // استفاده از Walker سفارشی
                                            ));
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- Left Content Columns -->
                                <div class="flex-1 grow w-auto px-6 py-2 h-full">
                                    <!-- MEGA-MENU-RIGHT---CHILD`S | LEVEL-2&3-->
                                    <?php
                                    if (has_nav_menu('mega-menu')) {

                                        $locations = get_nav_menu_locations();
                                        $menu_id = $locations['mega-menu']; // مکان منو در قالب (مثلاً 'primary')
                                        $menu_items = wp_get_nav_menu_items($menu_id);

                                        // مرتب‌سازی آیتم‌ها
                                        $parents = [];
                                        $children = [];

                                        foreach ($menu_items as $item) {
                                            if ($item->menu_item_parent == 0) {
                                                $parents[$item->ID] = $item;
                                            } else {
                                                $children[$item->menu_item_parent][] = $item;
                                            }
                                        }

                                        foreach ($parents as $parent) {
                                            $child_items = isset($children[$parent->ID]) ? $children[$parent->ID] : [];
                                            //*::Title--->>
                                            echo '<div data-parent-id="' . esc_attr($parent->ID) . '" class="megaMenu-left__item w-full h-full block text-[1em]">';
                                            echo '<div class="w-full block py-4 my-2">';
                                            echo '<a class="font-bold text-primary" href="' . esc_url($parent->url) . '">مشاهده همه محصولات ' . esc_html($parent->title) . '</a>';
                                            echo '</div>';

                                            //*::FOREACH--->>MEGA-MENU-LEVEL-2-&-3-->>
                                            if (!empty($child_items)) {
                                                echo '<div class="megaMenu-childs-content">';
                                                echo '<ul class="space-y-2 megaMenu-child-columnList">';

                                                foreach ($child_items as $child) {
                                                    $grand_children = isset($children[$child->ID]) ? $children[$child->ID] : [];

                                                    if (!empty($grand_children)) {
                                                        echo '<li class="megaMenu__perent_childs"><a href="' . esc_url($child->url) . '">' . esc_html($child->title) . '</a></li>';

                                                        foreach ($grand_children as $grand) {
                                                            echo '<li><a href="' . esc_url($grand->url) . '">' . esc_html($grand->title) . '</a></li>';
                                                        }
                                                    } else {
                                                        echo '<li class="megaMenu__perent_childs"><a href="' . esc_url($child->url) . '">' . esc_html($child->title) . '</a></li>';
                                                    }
                                                }

                                                echo '</ul>';
                                                echo '</div>';
                                            }

                                            echo '</div>';
                                        }

                                    } else {
                                        ?>
                                        <div class="absolute flex-cc flex-col gap-4 top-0 right-0 size-full">
                                            <div class="absolute top-0 right-0 size-full z-0"></div>
                                            <p class="text-sm text-base-500 z-10">مگا منو را اضافه کنید!</p>
                                            <a href="#help__abanTheme"
                                               class="text-lg text-teal-600 z-10 hover:scale-110 transition-all flex-cc gap-2 font-bold">
                                                راهنمای ایجاد مگا منو
                                                <i class="fa-duotone fa-solid fa-circle-question animate-pulse text-amber-800"></i>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- -------- -->
                            </div>
                        </div>
                    </li>

                    <!-- #MAIN-MENU...-->

                    <?php
                    if (has_nav_menu('main-menu')) {
                        wp_nav_menu([
                                'theme_location' => 'main-menu',
                                'menu' => '',
                                'menu_class' => false,
                                'container' => false,
                                'container_class' => '',
                                'items_wrap' => '%3$s',
                                'fallback_cb' => '',
                                'depth' => 1,
                        ]);
                    } else { ?>
                        <li class="relative py-3">
                            <a href="/#" class="flex-cc gap-2 leading-0">
                                <div class="size-auto">
                                    <i class="fa-duotone fa-solid fa-circle-info"></i>
                                </div>
                                <span class="text-nowrap"> منوی اصلی را اضافه کنید. </span>
                            </a>
                        </li>
                        <li class="relative py-3">
                            <a href="/#" class="flex-cc gap-2 leading-0">
                                <div class="size-auto">
                                    <i class="fa-duotone fa-solid fa-circle-question animate-pulse text-amber-500"></i>
                                </div>
                                <span class="text-nowrap">  راهنما </span>
                            </a>
                        </li>
                        <?php
                    }
                    ?>

                </ul>
                <div id="dvBorder" class="dvBorder absolute left-0 w-0 h-[2px] bottom-0">
                    <span></span>
                </div>
            </div>
            <div>
                <ul class="md:hidden">
                    <li class="text-neutral-400 text-xs">
                        <span class="text-nowrap"> پشتیبانی 24 ساعته </span>
                        <span>
                                    <i class="fa-regular fa-phone-waveform"></i>
                                </span>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <!--if home page...-->
</header>
<!-- END-HEADER... -->

<!--RESPONSIVE...-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ========== تنظیمات ریسپانسیو ==========
        const breakpoints = {
            mobile: 768,    // زیر 768px - موبایل
            tablet: 1024,   // 768 تا 1024 - تبلت
            desktop: 1141   // بالای 1141 - دسکتاپ
        };

        // ========== سلکتورها (قابل تنظیم) ==========
        const selectors = {
            header: '.header-container',
            galleryMobile: '.gallery-mobile',
            productContainer: '.product-page > .product',
            mobileHeader: '.header_layout_mobile',
            // addToCartBtn: '.add-to-card-wrapper button[name="add-to-cart"]'
            addToCartBtn: '.add-to-card-wrapper button.single_add_to_cart_button'
        };

        // ========== المان‌ها ==========
        const elements = {
            header: document.querySelector(selectors.header),
            galleryMobile: document.querySelector(selectors.galleryMobile),
            productContainer: document.querySelector(selectors.productContainer),
            mobileHeader: document.querySelector(selectors.mobileHeader),
            addToCartBtn: document.querySelector(selectors.addToCartBtn)
        };

        let currentBreakpoint = 'desktop';

        // دریافت ارتفاع نوار ادمین
        function getWpAdminBarHeight() {
            const wpAdminBar = document.getElementById('wpadminbar');
            return wpAdminBar ? wpAdminBar.getBoundingClientRect().height : 0;
        }

        // بازنشانی استایل‌ها برای دسکتاپ
        function resetStyles() {
            const headerMarginTop = getWpAdminBarHeight();

            if (elements.header) {
                elements.header.style.top = `${headerMarginTop}px`;
            }
            if (elements.mobileHeader) {
                elements.mobileHeader.style.top = '';
                elements.mobileHeader.style.position = '';
                elements.mobileHeader.style.zIndex = '';
            }
            if (elements.galleryMobile) {
                elements.galleryMobile.style.top = '';
            }
            if (elements.productContainer) {
                elements.productContainer.style.paddingTop = '';
            }
            if (elements.addToCartBtn) {
                elements.addToCartBtn.classList.remove('xs-cart-btn');
            }
        }

        // اعمال استایل‌های موبایل
        function applyMobileStyles() {
            const headerMarginTop = getWpAdminBarHeight();

            if (!elements.galleryMobile || !elements.productContainer || !elements.mobileHeader) return;

            // تنظیم هدر موبایل
            elements.mobileHeader.style.top = `${headerMarginTop}px`;
            elements.mobileHeader.style.zIndex = '1000';

            // اسکرول
            if (window.scrollY >= headerMarginTop) {
                elements.mobileHeader.style.top = '0';
                // #TABS-MENU...
            } else {
                elements.mobileHeader.style.top = `${headerMarginTop}px`;
            }

            // محاسبه موقعیت گالری
            const mobileHeaderRect = elements.mobileHeader.getBoundingClientRect().bottom;
            const galleryHeight = elements.galleryMobile.getBoundingClientRect().height;
            const totalHeight = galleryHeight + mobileHeaderRect - headerMarginTop;

            elements.galleryMobile.style.top = `${mobileHeaderRect}px`;
            elements.productContainer.style.paddingTop = `${totalHeight}px`;

            // add-to-cart-button...
            if (elements.addToCartBtn) {
                elements.addToCartBtn.classList.add('xs-cart-btn');
            }
        }

        // اعمال استایل‌های تبلت
        function applyTabletStyles() {
            if (elements.addToCartBtn) {
                elements.addToCartBtn.classList.remove('xs-cart-btn');
            }
        }

        // تشخیص بریک‌پوینت فعلی
        function getCurrentBreakpoint() {
            const width = window.innerWidth;
            if (width < breakpoints.mobile) return 'mobile';
            if (width < breakpoints.tablet) return 'tablet';
            return 'desktop';
        }

        // مدیریت اصلی بر اساس سایز صفحه
        function handleResponsive() {
            const newBreakpoint = getCurrentBreakpoint();
            const isMobile = newBreakpoint !== 'desktop';
            if (newBreakpoint === 'desktop') {
                resetStyles();
            } else if (newBreakpoint === 'tablet') {
                resetStyles(); // یا reset مخصوص تبلت
                applyTabletStyles();
            } else if (newBreakpoint === 'mobile') {
                applyMobileStyles();
            }

            currentBreakpoint = newBreakpoint;
        }

        // هندلر اسکرول با throttle
        let isScrolling = false;

        function handleScroll() {
            if (window.innerWidth < breakpoints.desktop && !isScrolling) {
                requestAnimationFrame(() => {
                    applyMobileStyles();
                    isScrolling = false;
                });
                isScrolling = true;
            }
        }

        // هندلر رایز با debounce
        let resizeTimeout;

        function handleResize() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                handleResponsive();
            }, 50);
        }

        // ========== ثبت رویدادها ==========
        window.addEventListener('resize', handleResize);
        window.addEventListener('scroll', handleScroll);

        // اجرای اولیه
        handleResponsive();

        // ========== تابع کمکی برای تغییر تنظیمات (اختیاری) ==========
        window.responsiveConfig = function (config) {
            Object.assign(breakpoints, config);
            handleResponsive();
        };
    });
</script>
<!--RESPONSIVE-2...-->
<script>
    //RESPONSIVE-PRODUCT-PAGE...
    // document.addEventListener('DOMContentLoaded', function () {
    //     // انتخاب المان‌ها
    //     const header = document.querySelector('.header-container');
    //     const galleryMobileHeight = document.querySelector('.gallery-mobile');
    //     const productContainer = document.querySelector('.product-page > .product');
    //     const mobileHeader_Responsive = document.querySelector('.header_layout_mobile');
    //     const btnAddToCard_Responsive = document.querySelector('.add-to-card-wrapper button[name=add-to-cart]');
    //     // متغیر برای کنترل وضعیت
    //     let isMobileLayout = false;
    //     function getWpAdminBarHeight() {
    //         const wpAdminBar = document.getElementById('wpadminbar');
    //         return wpAdminBar ? wpAdminBar.getBoundingClientRect().height : 0;
    //     }
    //     const SCROLL_THRESHOLD = getWpAdminBarHeight();
    //     function resetStyles() {
    //         const headerMarginTop = getWpAdminBarHeight();
    //         console.log(headerMarginTop, 'headerMarginTop_2')
    //         if (header) {
    //             header.style.top = `${headerMarginTop}px`;
    //         }
    //         if (mobileHeader_Responsive) {
    //             mobileHeader_Responsive.style.top = '';
    //             mobileHeader_Responsive.style.position = '';
    //         }
    //         if (galleryMobileHeight) {
    //             galleryMobileHeight.style.top = '';
    //         }
    //         if (productContainer) {
    //             productContainer.style.paddingTop = '';
    //         }
    //     }
    //     function applyMobileStyles() {
    //         const headerMarginTop = getWpAdminBarHeight();
    //         if (!galleryMobileHeight || !productContainer || !mobileHeader_Responsive) return;
    //         // تنظیم هدر موبایل
    //         mobileHeader_Responsive.style.top = `${headerMarginTop}px`;
    //         // -------------------------------
    //         if (scrollY >= SCROLL_THRESHOLD) {
    //             mobileHeader_Responsive.style.top = '0';
    //         } else {
    //             mobileHeader_Responsive.style.top = `${headerMarginTop}px`;
    //         }
    //         // -------------------------------
    //         mobileHeader_Responsive.style.zIndex = '1000';
    //         // محاسبه موقعیت گالری
    //         const mhr = mobileHeader_Responsive.getBoundingClientRect().bottom;
    //         const galleryHeight = galleryMobileHeight.getBoundingClientRect().height;
    //         const gmh = galleryHeight + mhr - headerMarginTop;
    //
    //         galleryMobileHeight.style.top = `${mhr}px`;
    //         productContainer.style.paddingTop = `${gmh}px`;
    //     }
    //     function handleGalleryMobile() {
    //         const isDesktop = window.innerWidth >= 1141;
    //         if (isDesktop) {
    //             resetStyles();
    //             if (isMobileLayout) {
    //                 // resetStyles();
    //                 isMobileLayout = false;
    //             }
    //             return;
    //         }
    //         // حالت موبایل
    //         if (!isMobileLayout) {
    //             isMobileLayout = true;
    //         }
    //         applyMobileStyles();
    //     }
    //     // Debounced resize handler
    //     let resizeTimeout;
    //     function handleResize() {
    //         clearTimeout(resizeTimeout);
    //         resizeTimeout = setTimeout(() => {
    //             handleGalleryMobile();
    //         }, 100);
    //     }
    //     // Scroll handler با throttle
    //     let isScrolling = false;
    //     function handleScroll() {
    //         if (!isScrolling) {
    //             requestAnimationFrame(() => {
    //                 if (window.innerWidth <= 1140) {
    //                     applyMobileStyles();
    //                 }
    //                 isScrolling = false;
    //             });
    //             isScrolling = true;
    //         }
    //     }
    //     // ثبت رویدادها
    //     window.addEventListener('resize', handleResize);
    //     window.addEventListener('scroll', handleScroll);
    //     // اجرای اولیه
    //     handleGalleryMobile();
    // });
</script>
<!--MEGA-MENU-SELECTORS...-->
<script>
    const wrapper = document.querySelector('.submenu-body');
    const parentItems = wrapper.querySelectorAll('[data-index]');
    const megaColumns = wrapper.querySelectorAll('[data-parent-id]');

    function clearActive() {
        parentItems.forEach(parent => parent.classList.remove('active'));
        megaColumns.forEach(col => col.classList.remove('active'));
    }

    // حالت اولیه
    if (parentItems.length && megaColumns.length) {
        const firstParentId = parentItems[0].dataset.index;
        parentItems[0].classList.add('active');
        megaColumns.forEach(col => {
            if (col.dataset.parentId === firstParentId) col.classList.add('active');
        });
    }
    // hover روی والدها
    parentItems.forEach(parent => {
        const parentId = parent.dataset.index;

        parent.addEventListener('mouseenter', () => {
            clearActive();
            parent.classList.add('active');
            megaColumns.forEach(col => {
                if (col.dataset.parentId === parentId) col.classList.add('active');
            });
        });
    });
    // وقتی موس از کل مگا منو خارج شد، حالت اولیه برگرده
    wrapper.addEventListener('mouseleave', () => {
        clearActive();
        const firstParentId = parentItems[0]?.dataset.index;
        parentItems[0]?.classList.add('active');
        megaColumns.forEach(col => {
            if (col.dataset.parentId === firstParentId) col.classList.add('active');
        });
    });
</script>
<!--BRAKE-LINE-SCROLL...-->
<script>
    // نوار پیشرفت اسکرول بالای سایت
    const progressBar = document.createElement('div');
    const progressFill = document.createElement('div');

    Object.assign(progressBar.style, {
        position: 'fixed',
        top: 0,
        left: 0,
        width: '100%',
        height: '2px',
        backgroundColor: 'rgb(43,42,51)',
        zIndex: '999999'
    });

    Object.assign(progressFill.style, {
        width: '0%',
        height: '100%',
        backgroundColor: 'rgb(220,16,64)',
        transition: 'width 0.8s linear'
    });

    progressBar.appendChild(progressFill);
    document.body.appendChild(progressBar);

    window.addEventListener('scroll', () => {
        const winScroll = document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - window.innerHeight;
        const scrolled = (winScroll / height) * 100;
        progressFill.style.width = scrolled + '%';
    });
</script>