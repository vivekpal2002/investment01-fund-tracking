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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');             // Stock name
            $table->string('ticker');           // Stock symbol
            $table->decimal('quantity', 12, 4)->default(0);
            $table->decimal('avg_price', 12, 2)->nullable();
            $table->decimal('invested_amount', 15, 2)->default(0);
            $table->decimal('current_price', 12, 2)->nullable();
            $table->decimal('change_percent', 6, 2)->nullable();
            $table->string('exchange')->nullable();
            $table->string('sector')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
