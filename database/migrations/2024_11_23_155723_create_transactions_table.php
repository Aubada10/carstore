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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->decimal('value', 10, 2);
            $table->dateTime('date')->default(now());
            $table->string('description');
            $table->unsignedBigInteger('car_id')->nullable();
            $table->foreign('car_id')->references('car_id')->on('cars')->onDelete('cascade');
            $table->unsignedBigInteger('deal_id')->nullable();
            $table->foreign('deal_id')->references('deal_id')->on('deals')->onDelete('cascade');
            $table->unsignedBigInteger('box_id');
            $table->foreign('box_id')->references('box_id')->on('boxes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
