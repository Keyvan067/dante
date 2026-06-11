<?php
namespace App\Woo\Helpers;

use WC_Product;

defined('ABSPATH') || exit;

class ProductInfoHelper {

    private static $instance = null;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * دریافت لیست آیکون‌های Font Awesome
     */
    public function getIconList() {
        return [
            'fa-regular fa-truck' => '🚚 حمل و نقل',
            'fa-regular fa-shield' => '🛡️ گارانتی',
            'fa-regular fa-credit-card' => '💳 پرداخت امن',
            'fa-regular fa-undo' => '↩️ بازگشت کالا',
            'fa-regular fa-clock' => '⏰ زمان تحویل',
            'fa-regular fa-gem' => '💎 کیفیت بالا',
            'fa-regular fa-heart' => '❤️ محبوب',
            'fa-regular fa-star' => '⭐ ویژه',
            'fa-regular fa-gift' => '🎁 هدیه',
            'fa-regular fa-tag' => '🏷️ تخفیف ویژه',
            'fa-regular fa-store' => '🏪 فروشگاه',
            'fa-regular fa-box' => '📦 بسته‌بندی',
            'fa-regular fa-medal' => '🏅 مدال',
            'fa-regular fa-warranty' => '🔒 ضمانت',
            'fa-regular fa-headset' => '🎧 پشتیبانی',
            'fa-regular fa-flask' => '🔬 اصل بودن',
            'fa-regular fa-bolt' => '⚡ ارسال سریع',
            'fa-regular fa-crown' => '👑 ویژه',
        ];
    }

    /**
     * دریافت اطلاعات اضافی محصول از Repeater داخل Group
     *
     * @param int $product_id
     * @return array
     */
    public function getProductExtraInfo($product_id): array
    {
        if (!function_exists('have_rows')) {
            return [];
        }

        $info_items = [];

        // اگه Repeater مستقیما روی محصول باشه
        if (have_rows('product_extra_info', $product_id)) {
            while (have_rows('product_extra_info', $product_id)) {
                the_row();

                $text = get_sub_field('info_text');
               // $icon = get_sub_field('info_icon');
                $icon_class = get_sub_field('info_icon'); // این مقدار کلاس Font Awesome هست

                if (!empty($text)) {
                    $info_items[] = [
                        'text' => $text,
                      //'icon' => $icon ?: 'fa-regular fa-circle-info',
                        'icon' => $icon_class ?: 'fa-regular fa-circle-info'
                    ];
                }
            }
        }
        // اگه Repeater داخل یک Group فیلد باشه
        elseif (have_rows('product_details', $product_id)) {
            while (have_rows('product_details', $product_id)) {
                the_row();

                // حالا داخل گروه، Repeater رو چک کن
                if (have_rows('product_extra_info')) {
                    while (have_rows('product_extra_info')) {
                        the_row();

                        $text = get_sub_field('info_text');
                        $icon = get_sub_field('info_icon');

                        if (!empty($text)) {
                            $info_items[] = [
                                'text' => $text,
                                'icon' => $icon ?: 'fa-regular fa-circle-info'
                            ];
                        }
                    }
                }
            }
        }

        return $info_items;
    }

    /**
     * بررسی وجود اطلاعات اضافی
     */
    public function hasExtraInfo($product_id) {
        return !empty($this->getProductExtraInfo($product_id));
    }
}