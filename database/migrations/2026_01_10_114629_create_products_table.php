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
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->string('product_code')->unique();

            $table->string('diameter');
            $table->enum('type', ['men', 'women']);

            $table->enum('material', ['steel', 'plastic']);
            $table->enum('strap', ['leather', 'steel']);

            $table->string('water_resistance');
            $table->string('caliber');

            $table->decimal('price', 10, 2);
            $table->integer('quantity');

            $table->string('image'); // image path

            
            $table->timestamps();
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
