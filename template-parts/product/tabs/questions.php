<?php
?>
<section id="questions" class="pdk-tabs h-auto w-full mx-auto">
    <div class="w-full flex flex-col justify-start items-start gap-4">
        <div>
            <h3 class="h2_title"> پرسش‌ ها </h3>
        </div>

        <div class="w-full block h-auto">
            <div class="w-full block">
                <!-- FILTERS-COMMENTS... -->
                <div class="flex flex-row gap-4 justify-start items-center border-b border-[var(--border-base)] py-8">
                    <div>
                        <span class="text-[var(--text-color)] font-bold"> مرتب سازی بر اساس </span>
                    </div>
                    <div class="flex flex-row gap-4 items-center mr-10">
                        <div
                            class="flex-cc text-xs cursor-pointer rounded-full px-4 py-2 bg-gray-800 text-white font-bold">
                            <span> جدیدترین </span>
                        </div>
                        <div class="flex-cc text-xs cursor-pointer rounded-full px-4 py-2 bg-gray-100">
                            <span> مفیدترین </span>
                        </div>
                        <div class="flex-cc text-xs cursor-pointer rounded-full px-4 py-2 bg-gray-100">
                            <span> دیدگاه خریداران </span>
                        </div>
                    </div>
                </div>

                <!-- پرسش و پاسخ کاربران -->
                <div class="w-full block *:border-b *:border-[var(--border-base)] *:last:border-none">
                    <!-- پرسش. -->
                    <article class="flex flex-col gap-4 py-10 px-4 justify-start items-start">
                        <!-- متن سوال کاربر -->
                        <div class="flex flex-row gap-4">
                        <span class="flex-cc text-amber-400">
                          <i class="fa-solid fa-circle-question"></i>
                        </span>
                            <span class="flex-cc">
                          <p class="text-body-1 !font-bold">
                            سلام من اگه سریال این گوشی تو سایت ایفون وارد کنم برام تاییده میده؟
                          </p>
                        </span>

                        </div>
                        <span class="bg-gray-100 px-2 py-1 flex-cc rounded-full text-[.7em]">
                        نام مشتری
                      </span>
                        <!-- پاسخ سوال -->
                        <div class="flex flex-row gap-4 px-4">
                            <span class="text-green-600 flex-cc"><i class="fa-solid fa-quote-left"></i></span>
                            <span class="flex-cc">
                          <p class="text-body-sm">
                            بله ولی بهتره از یه جای مطمئن این کارو انجام بدی خیالت راحت تر باشه
                          </p>
                        </span>
                        </div>
                        <span class="bg-gray-100 px-2 py-1 flex-cc rounded-full text-[.7em]">
                        نام فروشنده
                      </span>
                        <!-- نام کاربر + امتیاز کاربر + تاریخ و لایک و دیس لایک به کامنت -->
                        <div class="block w-full">
                            <div class="flex justify-end items-center gap-2">
                                <button class="btn-accent">
                                    <span> 128 </span>
                                    <i class="fa-regular fa-thumbs-up"></i>
                                </button>
                                <button class="btn-accent">
                                    <span> 15 </span>
                                    <i class="fa-regular fa-thumbs-down"></i>
                                </button>
                                <button class="btn-accent !w-12.5">
                                    <i class="fa-regular fa-ellipsis-vertical"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                    <!-- نمونه پرسش دوم -->
                    <article class="flex flex-col gap-4 py-8 px-4 justify-start items-start">
                        <!-- متن سوال کاربر -->
                        <div class="flex flex-row gap-4">
                        <span class="flex-cc text-amber-400">
                          <i class="fa-solid fa-circle-question"></i>
                        </span>
                            <span class="flex-cc">
                          <p class="text-body-1 !font-bold">
                            اگر مشکل رجیستر داشتید و مرجوع کردید، میشه مراحل رو بگید؟ چطور درخواست دادید و وجه رو
                            گرفتید؟
                          </p>
                        </span>

                        </div>
                        <span class="bg-gray-100 px-2 py-1 flex-cc rounded-full text-[.7em]">
                        نام مشتری
                      </span>
                        <!-- پاسخ سوال -->
                        <div class="flex flex-row gap-4 px-4">
                            <span class="text-green-600 flex-cc"><i class="fa-solid fa-quote-left"></i></span>
                            <span class="flex-cc">
                          <p class="text-body-sm">
                            مرجوع نمی کنند و متاسفانه پاسخگو هم نیستند ، واقعا پشیمونم از خریدم
                          </p>
                        </span>
                        </div>
                        <span class="bg-gray-100 px-2 py-1 flex-cc rounded-full text-[.7em]">
                        نام فروشنده
                      </span>
                        <!-- نام کاربر + امتیاز کاربر + تاریخ و لایک و دیس لایک به کامنت -->
                        <div class="block w-full">
                            <div class="flex justify-end items-center gap-2">
                                <button class="btn-accent">
                                    <span> 94 </span>
                                    <i class="fa-regular fa-thumbs-up"></i>
                                </button>
                                <button class="btn-accent">
                                    <span> 38 </span>
                                    <i class="fa-regular fa-thumbs-down"></i>
                                </button>
                                <button class="btn-accent !w-12.5">
                                    <i class="fa-regular fa-ellipsis-vertical"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                    <!-- نمونه پرسش سوم -->
                    <article class="flex flex-col gap-4 py-10 px-4 justify-start items-start">
                        <!-- متن سوال کاربر -->
                        <div class="flex flex-row gap-4">
                        <span class="flex-cc text-amber-400">
                          <i class="fa-solid fa-circle-question"></i>
                        </span>
                            <span class="flex-cc">
                          <p class="text-body-1 !font-bold">
                            واقعا چرا تا ما گوشی‌ها رو مرجوع کردیم کالا ناموجود شد که دیگه برامون ارسال نشه و بگن
                            ناموجوده؟!!!!!
                          </p>
                        </span>

                        </div>
                        <span class="bg-gray-100 px-2 py-1 flex-cc rounded-full text-[.7em]">
                        نام مشتری
                      </span>
                        <!-- پاسخ سوال -->
                        <div class="flex flex-row gap-4 px-4">
                            <span class="text-green-600 flex-cc"><i class="fa-solid fa-quote-left"></i></span>
                            <span class="flex-cc">
                          <p class="text-body-sm">
                            مرجوع کردم اما بعید میدونم بهمون گوشی بدن
                          </p>
                        </span>
                        </div>
                        <span class="bg-gray-100 px-2 py-1 flex-cc rounded-full text-[.7em]">
                        نام فروشنده
                      </span>
                        <!-- نام کاربر + امتیاز کاربر + تاریخ و لایک و دیس لایک به کامنت -->
                        <div class="block w-full">
                            <div class="flex justify-end items-center gap-2">
                                <button class="btn-accent">
                                    <span> 668 </span>
                                    <i class="fa-regular fa-thumbs-up"></i>
                                </button>
                                <button class="btn-accent">
                                    <span> 19 </span>
                                    <i class="fa-regular fa-thumbs-down"></i>
                                </button>
                                <button class="btn-accent !w-12.5">
                                    <i class="fa-regular fa-ellipsis-vertical"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                    <!-- نمونه پرسش چهارم -->
                    <article class="flex flex-col gap-4 py-10 px-4 justify-start items-start">
                        <!-- متن سوال کاربر -->
                        <div class="flex flex-row gap-4">
                        <span class="flex-cc text-amber-400">
                          <i class="fa-solid fa-circle-question"></i>
                        </span>
                            <span class="flex-cc">
                          <p class="text-body-1 !font-bold">
                            میگم این طبیعیه با روزی ۴-۵ ساعت استفاده معمولی از گوشی باتریش کلا ۲۲ ساعت دووم میاره؟
                          </p>
                        </span>

                        </div>
                        <span class="bg-gray-100 px-2 py-1 flex-cc rounded-full text-[.7em]">
                        نام مشتری
                      </span>
                        <!-- پاسخ سوال -->
                        <div class="flex flex-row gap-4 px-4">
                            <span class="text-green-600 flex-cc"><i class="fa-solid fa-quote-left"></i></span>
                            <span class="flex-cc">
                          <p class="text-body-sm">
                            ایفون کلا روی باتریش حساب نکن
                          </p>
                        </span>
                        </div>
                        <span class="bg-gray-100 px-2 py-1 flex-cc rounded-full text-[.7em]">
                        نام فروشنده
                      </span>
                        <!-- نام کاربر + امتیاز کاربر + تاریخ و لایک و دیس لایک به کامنت -->
                        <div class="block w-full">
                            <div class="flex justify-end items-center gap-2">
                                <button class="btn-accent">
                                    <span> 34 </span>
                                    <i class="fa-regular fa-thumbs-up"></i>
                                </button>
                                <button class="btn-accent">
                                    <span> 188 </span>
                                    <i class="fa-regular fa-thumbs-down"></i>
                                </button>
                                <button class="btn-accent !w-12.5">
                                    <i class="fa-regular fa-ellipsis-vertical"></i>
                                </button>
                            </div>
                        </div>
                    </article>
                </div>

            </div>
        </div>
</section>
