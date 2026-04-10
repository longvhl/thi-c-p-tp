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
        Schema::create('bikes', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // xe_thuong, xe_dien, etc.
            $table->string('bike_number')->unique(); // Biển số xe
            $table->string('status')->default('available'); // available, rented, maintenance
            $table->string('current_station')->nullable();
            $table->decimal('unit_price', 10, 2)->default(200.00); // Giá mỗi phút
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bikes');
    }
};
