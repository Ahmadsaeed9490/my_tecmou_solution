<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id(); // <== yeh default primary key hai
$table->unsignedBigInteger('product_id')->index(); // allow duplicates

            $table->decimal('min_price', 10, 2);
            $table->decimal('max_price', 10, 2);
            $table->decimal('discount_percent', 5, 2);
            $table->decimal('final_price', 10, 2);
            $table->string('currency', 10);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            Schema::table('product_prices', function (Blueprint $table) {
            $table->dropUnique('product_prices_product_id_unique');
        });
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down(): void
    {
        Schema::table('product_prices', function (Blueprint $table) {
            $table->unique('product_id');
        });
    }
};
