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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('description');
            $table->integer('mileageDistance');
            $table->string('mileageUnit');
            $table->integer('priceAmount');
            $table->string('priceCurrency');
            $table->uuid('model_id');
            $table->timestamps();

            $table->foreign('model_id')
                ->references('id')
                ->on('models')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
