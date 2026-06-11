<?php

namespace App\Core;

use App\Contracts\ModuleInterface;

class Loader {

    // لیست ماژول‌های فعال - فقط این یکی کافیه
    private $modules = [
        \App\Modules\Helpers\Helpers::class,
        \App\Modules\Assets\Assets::class,
        \App\Modules\Admin\ACFPages::class,
        \App\Modules\Theme\Setup::class,
        \App\Woo\WooCommerce::class,
    ];

    // نمونه‌های ساخته شده از ماژول‌ها
    private $instances = [];

    private static $instance = null;

    private function __construct() {
        $this->loadModules();
    }

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadModules(): void
    {
        foreach ($this->modules as $moduleClass) {

            if (!class_exists($moduleClass)) {
                continue;
            }

            // اول try کن با getInstance (برای کلاس‌های Singleton)
            if (method_exists($moduleClass, 'getInstance')) {
                $module = $moduleClass::getInstance();
            } else {
                $module = new $moduleClass();
            }

            if (!$module instanceof ModuleInterface) {
                continue;
            }

//            $module->register();
            $this->instances[] = $module;
        }
    }

    public function boot(): void
    {
        foreach ($this->instances as $module) {
            $module->boot();
        }
    }

    public function registerModules(): void
    {
        foreach ($this->instances as $module) {
            $module->register();  // register رو بعداً صدا بزن
        }
    }

    // دسترسی به یک ماژول خاص
    public function getModule($name) {
        foreach ($this->instances as $module) {
            $class_name = (new \ReflectionClass($module))->getShortName();
            if ($class_name === $name) {
                return $module;
            }
        }
        return null;
    }
}