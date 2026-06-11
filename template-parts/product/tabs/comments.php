<?php
///*/**
// *
// *
// */
//
//defined( 'ABSPATH' ) || exit;
//$product_id = get_the_ID();
//
////$user_state = theme_get_review_user_status( $product_id );
//
//$reviews = theme_get_review_context( $product_id );
//
//
//
//*/?><!--<!---->
<!--<!--SEND-REVIEWS-->-->
<!---->
<!--<!--USERS-REVIEWS-->-->
<!--<section id="reviews" class="pdk-tabs h-auto w-full mx-auto flex flex-row gap-4">-->
<!--    <aside class="flex h-auto basis-1/3">-->
<!--        <div class="block w-full py-8 sticky top-[var(--header-height)] px-16 h-fit">-->
<!--            <div class="pdkr-starts flex flex-col items-center gap-4">-->
<!--                <div class="flex-cc">-->
<!--                    <span class="text-default class=flex flex-col items-center text-3xl font-bold">4.5</span>-->
<!--                    <span class="text-amber-500"><i class="fa-solid fa-star fa-xl"></i></span>-->
<!--                </div>-->
<!--                <div class="block text-xs">-->
<!--                    <span>شما هم درباره این کالا دیدگاه ثبت کنید</span>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="block w-full my-4">-->
<!--                <button class="btn-secondary py-6 px-8 w-full open-review"-->
<!--                        data-modal-target="pdk-send-review-modal">-->
<!--                    <span> ثبت دیدگاه </span>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </aside>-->
<!--    <div class="w-fit grow flex flex-col justify-start items-start gap-4">-->
<!--        <div>-->
<!--            <h3 class="font-bold text-primary"> امتیاز و دیدگاه کاربران </h3>-->
<!--        </div>-->
<!--        --><?php ///*if ( $reviews ) : */?>
<!--            <div class="w-full block h-auto">-->
<!--                <div class="w-full block">-->
<!--                    <!-- FILTERS-COMMENTS... -->-->
<!--                    <!-- AI-SUMMARY-COMMENTS... -->-->
<!--                    <!-- ALL-COMMENTS... -->-->
<!--                    <div class="block w-full mt-20 h-auto *:border-b *:last:border-none *:border-accent">-->
<!--                        --><?php
///*                        //                    foreach ( $reviews as $review ) :
//                        //
//                        //                    $rating = get_comment_meta( $review->comment_ID, 'rating', true );
//                        //                    $author = $review->comment_author;
//                        //                    $date   = get_comment_date( 'Y/m/d', $review );
//                        //                    $text   = $review->comment_content;
//                        */?>
<!--                        <!-- نظر کاربر -->-->
<!--                        <article class="flex flex-col gap-3 justify-start items-start py-12 px-4">-->
<!--                            <!-- نام کاربر + امتیاز کاربر + تاریخ و لایک و دیس لایک به کامنت -->-->
<!--                            <div class="flex-sbc w-full">-->
<!--                                <div class="flex flex-col justify-start items-start gap-4">-->
<!--                                    <div class="leading-0">-->
<!--                                        <span class="font-bold text-default"> --><?php ///*//echo esc_html( $author ); */?><!-- </span>-->
<!--                                        <span class="mx-2 bg-rose-500 text-white px-2 py-1 rounded-full text-xs">خریدار</span>-->
<!--                                    </div>-->
<!--                                    <div class="flex-cc gap-4 *:text-xs font-bold">-->
<!--                                        --><?php ///*//if ( $rating ) : */?>
<!--                                        <div class="flex-cc *:text-amber-600">-->
<!--                                            <div class="review-stars" data-rating="--><?php ///*//echo esc_attr( $rating ); */?><!--">-->
<!--                                                --><?php ///*//echo str_repeat('★', (int)$rating); */?>
<!--                                                --><?php ///*//echo str_repeat('☆', 5 - (int)$rating); */?>
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                        --><?php ///*//endif; */?>
<!--                                        <div class="text-default tracking-wider">--><?php ///*//echo esc_html( $date ); */?><!--</div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                                <div class="flex-cc gap-2">-->
<!--                                    <button class="btn-accent">-->
<!--                                        <span> 204 </span>-->
<!--                                        <i class="fa-regular fa-thumbs-up"></i>-->
<!--                                    </button>-->
<!--                                    <button class="btn-accent">-->
<!--                                        <span> 18 </span>-->
<!--                                        <i class="fa-regular fa-thumbs-down"></i>-->
<!--                                    </button>-->
<!--                                    <button class="btn-accent !w-12.5">-->
<!--                                        <i class="fa-regular fa-ellipsis-vertical"></i>-->
<!--                                    </button>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <!-- عنوان کامنت کاربر -->-->
<!--                            <div class="w-full block mt-6">-->
<!--                                <span class="text-body-1 !font-bold !text-[1em]"> یکی از بهترین ها در رنج قیمت </span>-->
<!--                            </div>-->
<!--                            <!--  متن کامنت + نقاط ضعف و قوت محصول -->-->
<!--                            <div class="w-full flex flex-col gap-4">-->
<!--                                <!-- متن کامنت -->-->
<!--                                <div class="w-full block">-->
<!--                                    <p class="text-body-1 tracking-wide">--><?php ///*//echo esc_html( $text ); */?><!--</p>-->
<!--                                </div>-->
<!--                                <!-- نقاط ضعف و قوت محصول -->-->
<!--                                <div class="w-full block">-->
<!--                                    <ul class="flex flex-col gap-2">-->
<!--                                        <li>-->
<!--                                            <span class="text-emerald-600"><i class="fa-solid fa-circle-check"></i></span>-->
<!--                                            <span class="text-xs text-emerald-600 font-bold"> این لپ تاپ از نظر طراحی زیبایی و کیفیت-->
<!--                                    ساخت بسیار بالا است و بهترین قابلیت‌های-->
<!--                                    دوربین را-->
<!--                                    ارائه می‌دهد. </span>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <span class="text-emerald-600"><i class="fa-solid fa-circle-check"></i></span>-->
<!--                                            <span class="text-xs text-emerald-600 font-bold"> طراحی شیک و زیبا </span>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <span class="text-emerald-600"><i class="fa-solid fa-circle-check"></i></span>-->
<!--                                            <span class="text-xs text-emerald-600 font-bold"> صفحه نمایش بزرگ </span>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <span class="text-slate-600"><i class="fa-solid fa-circle-xmark"></i></span>-->
<!--                                            <span class="text-xs font-bold text-slate-600"> صفحه کلید کوچک </span>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <span class="text-slate-600"><i class="fa-solid fa-circle-xmark"></i></span>-->
<!--                                            <span class="text-xs font-bold text-slate-600">نامناسب برای کارهای سنگین</span>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <span class="text-slate-600"><i class="fa-solid fa-circle-xmark"></i></span>-->
<!--                                            <span class="text-xs font-bold text-slate-600">حجم و وزن نسبتا بالای گوشی</span>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <span class="text-slate-600"><i class="fa-solid fa-circle-xmark"></i></span>-->
<!--                                            <span class="text-xs font-bold text-slate-600">حافظه داخلی کم</span>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </div>-->
<!--                                <!-- تصاویر ارسالی از محصول توسط خریدار -->-->
<!--                                <div>-->
<!--                                    <!-- نمایش تصاویر مدل یک -->-->
<!--                                    <!-- <div class="flex flex-wrap p-3 gap-4">-->
<!--                                      <div-->
<!--                                        class="w-auto p-2 border border-gray-100 cursor-pointer hover:saturate-200 transition-all rounded-2xl">-->
<!--                                        <img style="object-fit: contain;" width="40" height="100%"-->
<!--                                          src="./assets/images/products/mobiles/9.jpg" alt="product-image">-->
<!--                                      </div>-->
<!--                                      <div-->
<!--                                        class="w-auto p-2 border border-gray-100 cursor-pointer hover:saturate-200 transition-all rounded-2xl">-->
<!--                                        <img style="object-fit: contain;" width="40" height="100%"-->
<!--                                          src="./assets/images/products/mobiles/7.jpg" alt="product-image">-->
<!--                                      </div>-->
<!--                                      <div-->
<!--                                        class="w-auto p-2 border border-gray-100 cursor-pointer hover:saturate-200 transition-all rounded-2xl">-->
<!--                                        <img style="object-fit: contain;" width="40" height="100%"-->
<!--                                          src="./assets/images/products/mobiles/1.png" alt="product-image">-->
<!--                                      </div>-->
<!--                                      <div-->
<!--                                        class="w-auto p-2 border border-gray-100 cursor-pointer hover:saturate-200 transition-all rounded-2xl">-->
<!--                                        <img style="object-fit: contain;" width="40" height="100%"-->
<!--                                          src="./assets/images/products/mobiles/8.jpg" alt="product-image">-->
<!--                                      </div>-->
<!--                                    </div> -->-->
<!--                                    <!-- نمایش تصاویر مدل دو -->-->
<!--                                    <div-->
<!--                                        class="mt-3 flex *:!w-10 *:!h-10 -space-x-1 *:!ring-offset-1 *:hover:!scale-110 *:!transition-all *:!cursor-pointer *:!ring-2 *:!ring-slate-300 *:!overflow-hidden *:!rounded-full">-->
<!--                                        <img class="inline-block" src="./assets/images/products/mobiles/8.jpg" alt="" />-->
<!--                                        <img class="inline-block" src="./assets/images/products/mobiles/9.jpg" alt="" />-->
<!--                                        <img class="inline-block" src="./assets/images/products/mobiles/8.jpg" alt="" />-->
<!--                                        <img class="inline-block" src="./assets/images/products/mobiles/9.jpg" alt="" />-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </article>-->
<!--                        --><?php ///*//endforeach; */?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        --><?php ///*else : */?>
<!--            <div class="empty-comments-message flex grow shrink-0 w-full">-->
<!--                هنوز دیدگاهی برای این محصول ثبت نشده.-->
<!--            </div>-->
<!--        --><?php ///*endif; */?>
<!--    </div>-->
<!--</section>-->
<!---->-->