<?php
namespace App\Contracts;

// این فقط یه قرارداد ساده است
interface ModuleInterface {
    public function register();  // هر ماژول باید این متد رو داشته باشه
    public function boot();      // هر ماژول باید این متد رو داشته باشه
}