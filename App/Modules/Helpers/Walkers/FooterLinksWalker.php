<?php
namespace App\Modules\Helpers\Walkers;

/**
 * واکر سفارشی برای منوی فوتر
 * نمایش منو به صورت لینک‌های ساده بدون تگ ul/li
 */
class FooterLinksWalker extends \Walker_Nav_Menu {

    /**
     * شروع سطح جدید منو (ما اینجا نمی‌خوایم ul بسازیم)
     */
    public function start_lvl( &$output, $depth = 0, $args = [] ) {
        // خالی میذاریم تا ul ساخته نشه
    }

    /**
     * پایان سطح منو
     */
    public function end_lvl( &$output, $depth = 0, $args = [] ) {
        // خالی میذاریم
    }

    /**
     * شروع آیتم منو
     */
    public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {

        // کلاس‌های اضافی برای لینک
        $classes = ['footer-link'];
        if ($item->current) {
            $classes[] = 'active';
        }
        if ($depth > 0) {
            $classes[] = 'sub-menu-link';
        }

        $class_string = implode(' ', $classes);

        // ساختن لینک
        $output .= sprintf(
            '<a href="%s" class="%s">%s</a>',
            esc_url($item->url),
            esc_attr($class_string),
            esc_html($item->title)
        );
    }

    /**
     * پایان آیتم منو
     */
    public function end_el( &$output, $item, $depth = 0, $args = [] ) {
        // می‌تونیم اینجا یه جداکننده بذاریم بین لینک‌ها
        $output .= "\n";
    }
}