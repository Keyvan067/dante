<?php
namespace App\Modules\Helpers\Walkers;

/**
 * واکر سفارشی برای مگامنو
 * نمایش سطح اول منو به صورت div با آیکون
 */
class MegaMenuWalker extends \Walker_Nav_Menu {

    /**
     * حذف شروع سطح (هیچ <ul> باز نکن)
     */
    function start_lvl( &$output, $depth = 0, $args = null ) {}

    /**
     * حذف پایان سطح (هیچ </ul> نبند)
     */
    function end_lvl( &$output, $depth = 0, $args = null ) {}

    /**
     * شروع هر آیتم
     */
    function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {

        // فقط سطح ۱ رو می‌خوایم
        if ( $depth === 0 ) {

            $url       = esc_url( $item->url );
            $text      = esc_html( $item->title );
            $parent_id = esc_attr( $item->ID );

            // اینجا می‌تونیم بعداً آیکون رو از فیلد سفارشی ACF بخونیم
            $icon = $this->getMenuItemIcon($item->ID);

            // کلاس‌های اضافی برای آیتم فعال
            $classes = ['megaMenu-right__item'];
            if ($item->current) {
                $classes[] = 'active';
            }

            $class_string = implode(' ', $classes);

            // HTML خروجی
            $output .= sprintf(
                '<div data-index="%s" class="%s flex items-center space-x-3 px-2 pr-4 py-3 cursor-pointer transition-colors text-gray-700 hover:bg-gray-50" style="direction: rtl">
                    %s
                    <a href="%s" class="text-sm line-clamp-1 text-nowrap">%s</a>
                    <span class="ml-auto text-gray-500">›</span>
                </div>',
                $parent_id,
                $class_string,
                $icon,
                $url,
                $text
            );
        }
    }

    /**
     * حذف پایان آیتم
     */
    function end_el( &$output, $item, $depth = 0, $args = null ) {}

    /**
     * گرفتن آیکون آیتم منو
     * اینجا می‌تونیم بعداً از ACF فیلد آیکون رو بخونیم
     */
    private function getMenuItemIcon($item_id) {
        // فعلاً آیکون ثابت
        $icon = '<i class="fa-solid fa-chart-simple"></i>';

        // اگه بعداً خواستی از ACF بخونی:
        // if (function_exists('get_field')) {
        //     $custom_icon = get_field('menu_icon', 'nav_menu_item_' . $item_id);
        //     if ($custom_icon) {
        //         $icon = '<i class="' . esc_attr($custom_icon) . '"></i>';
        //     }
        // }

        return $icon;
    }
}