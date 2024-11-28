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
        Schema::create('deals', function (Blueprint $table) {
            $table->id('deal_id');
            $table->date('date');
            $table->enum('type', ['cash', 'installments']);
            $table->decimal('total_cost', 10, 2);
            $table->boolean('is_done')->default('0');
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('car_id')->on('cars')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
