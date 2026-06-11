<?php

namespace App\Modules\Helpers;

use App\Contracts\ModuleInterface;
use App\Modules\Helpers\Walkers\MegaMenuWalker;
use App\Woo\WooCommerce;

class Helpers implements ModuleInterface
{

    private static $instance = null;

    // برای توابع تاریخ
    private $dateHelper = null;
    /**
     * @var WooCommerce|null
     */
    private $woo;

    private function __construct()
    {
        // نمونه‌سازی از DateHelper در زمان ساخت کلاس
        $this->dateHelper = new DateHelper();
        //--> @WooCommerce.
        $this->woo = WooCommerce::getInstance();
    }

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function register()
    {
        // اینجا هوک‌ها رو ثبت میکنیم
    }

    public function boot()
    {
        // اینجا کار اصلی ماژول رو انجام میدیم
    }

    //--> #WooCommerce.
    public function woo() {
        return $this->woo;
    }

    /**
     * دسترسی به توابع تاریخ
     */
    public function date(): DateHelper
    {
        return $this->dateHelper;
    }

    // توابع کمکی شما
    public function formatPrice($price): string
    {
        return number_format($price) . ' تومان';
    }

    public function truncateText($text, $length = 50): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }

    /**
     *
     * HEADER MEGA MENUS...
     */

    /**
     * نمایش مگامنو
     */
    public function megaMenu() {
        return wp_nav_menu([
            'theme_location' => 'primary',
            'walker' => new Walkers\MegaMenuWalker(),
            'container' => false,
            'items_wrap' => '%3$s',
            'depth' => 1,
            'echo' => false,
        ]);
    }

    /**
     *
     * FOOTER MENUS...
     */
    public function footerMenuSupport()
    {
        return wp_nav_menu([
            'theme_location' => 'footer-support',
            'walker' => new Walkers\FooterLinksWalker(),
            'container' => false,
            'echo' => false,  // برگردونه، نه اینکه مستقیم چاپ کنه
        ]);
    }

    public function footerMenuGuide()
    {
        return wp_nav_menu([
            'theme_location' => 'footer-guide',
            'walker' => new Walkers\FooterLinksWalker(),
            'container' => false,
            'echo' => false
        ]);
    }
}