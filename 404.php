
<?php
get_header();
?>

<main class="container mx-auto">
    <section class="relative size-full flex flex-col justify-start items-center bg-background">



        <div class="flex-cc w-auto my-10">
            <h1> متاسفانه صفحه مورد نظر یافت نشد! </h1>
        </div>

        <div class="w-auto bg-background flex-cc flex-col">
            <div class="my-4">
                <span> لطفا دسته بندی مورد نظر خود را انتخاب کنید </span>
            </div>
            <div class="swiper category_swiper_404 w-auto">
                <div class="swiper-wrapper p-8">
                    <div class="swiper-slide">
                        <div>
                            <img width="80px" height="auto" src="<?php echo get_template_directory_uri() . '/assets/images/products/category/1.jpg '?>" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            <img width="80px" height="auto" src="<?php echo get_template_directory_uri() . '/assets/images/products/category/2.jpg '?>" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            <img width="80px" height="auto" src="<?php echo get_template_directory_uri() . '/assets/images/products/category/3.jpg '?>" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            <img width="80px" height="auto" src="<?php echo get_template_directory_uri() . '/assets/images/products/category/4.jpg '?>" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            <img width="80px" height="auto" src="<?php echo get_template_directory_uri() . '/assets/images/products/category/5.jpg '?>" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            <img width="80px" height="auto" src="<?php echo get_template_directory_uri() . '/assets/images/products/category/6.jpg '?>" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            <img width="80px" height="auto" src="<?php echo get_template_directory_uri() . '/assets/images/products/category/7.jpg '?>" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div>
                            <img width="80px" height="auto" src="<?php echo get_template_directory_uri() . '/assets/images/products/category/8.jpg '?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="flex-cc relative flex-col">
            <img style="width: 400px;height: auto;object-fit: cover;" src="<?php echo get_template_directory_uri() . '/assets/images/404-3.png' ?>" alt="404_not_found_this_page">
            <div class="flex-cc w-auto my-10 flex-col">
                <span class="font-black text-md mb-2"> ...Oops, Page Not Found</span>
                <a href="" class="btn-primary" style="background: #6569ff;min-width: 3rem;width: 8rem;border-radius: 24px;">
                    <span href="<?php home_url(); ?>">Back Home</span>
                </a>
            </div>
        </div>
    </section>
</main>


<?php
get_footer();
?>


<script>
    var swiper2 = new Swiper(".category_swiper_404", {
        // direction: "vertical",
        slidesPerView: 'auto',
        spaceBetween: 30,
        mousewheel: true,
        // centeredSlides: true,
        // pagination: {
        //     el: ".swiper-pagination",
        //     clickable: true,
        // },
    });
</script>
