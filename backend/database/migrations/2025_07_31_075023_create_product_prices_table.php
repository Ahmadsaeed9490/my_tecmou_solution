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
        // Pehle table create karo
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id(); // Default primary key
            $table->unsignedBigInteger('product_id')->index(); // allow duplicates
            $table->decimal('min_price', 10, 2);
            $table->decimal('max_price', 10, 2);
            $table->decimal('discount_percent', 5, 2);
            $table->decimal('final_price', 10, 2);
            $table->string('currency', 10);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
        });

        // Fir index drop karo (agar pehle se unique constraint hoga)
        if (Schema::hasTable('product_prices')) {
            Schema::table('product_prices', function (Blueprint $table) {
                try {
                    $table->dropUnique('product_prices_product_id_unique');
                } catch (\Exception $e) {
                    // Agar index nahi mila to error ignore karega
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_prices');
    }
};
