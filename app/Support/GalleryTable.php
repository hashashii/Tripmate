<?php

namespace App\Support;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Makes sure the gallery table exists, even if "php artisan migrate"
 * was never run on this database (SQLite or MySQL).
 */
class GalleryTable
{
    private static bool $checked = false;

    public static function ensure(): void
    {
        if (self::$checked) {
            return;
        }

        self::$checked = true;

        try {
            if (! Schema::hasTable('place_images')) {
                Schema::create('place_images', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('place_id')->constrained()->onDelete('cascade');
                    $table->string('path');
                    $table->timestamps();
                });
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
