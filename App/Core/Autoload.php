<?php
namespace App\Core;
class Autoload {

    public static function register(): void
    {
        spl_autoload_register(static function ($class) {
            // فقط کلاس‌های App رو لود کن
            if (strpos($class, 'App\\') !== 0) {
                return;
            }

            // مطمئن شو فایل توی پوشه تم هست
            $class_path = str_replace('\\', '/', $class);
            $file = get_theme_file_path($class_path . '.php');

            // چک کن فایل توی پوشه App هست
            if (strpos(realpath($file), realpath(get_template_directory() . '/App')) === 0) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        });
    }
}
