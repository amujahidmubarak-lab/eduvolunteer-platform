<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('learning_homes', function (Blueprint $table) {
            $table->double('latitude', 10, 8)->nullable();
            $table->double('longitude', 11, 8)->nullable();
        });

        // Seed default coordinates for existing homes (Malang, Indonesia center fallback)
        \Illuminate\Support\Facades\DB::table('learning_homes')->update([
            'latitude' => -7.983908,
            'longitude' => 112.621391,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('learning_homes', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
