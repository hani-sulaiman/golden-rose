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
        Schema::create('travels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('restaurant_id')->nullable();
            $table->unsignedBigInteger('hotel_id')->nullable();
            $table->float('cost');
            $table->boolean('is_group');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travels');
    }
};
