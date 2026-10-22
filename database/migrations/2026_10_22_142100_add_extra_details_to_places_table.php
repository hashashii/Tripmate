<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->string('opening_hours')->nullable();
            $table->string('entrance_fee')->nullable();
            $table->text('accessibility')->nullable();
            $table->text('travel_tips')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('places', function (Blueprint $table) {
            $table->dropColumn([
                'opening_hours',
                'entrance_fee',
                'accessibility',
                'travel_tips',
            ]);
        });
    }
};
