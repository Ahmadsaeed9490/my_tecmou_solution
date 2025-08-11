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
            $table->id(); // Primary key
            $table->unsignedBigInteger('product_id')->index();
            $table->decimal('min_price', 10, 2);
            $table->decimal('max_price', 10, 2);
            $table->decimal('discount_percent', 5, 2);
            $table->decimal('final_price', 10, 2);
            $table->string('currency', 10);
            $table->timestamps();
            $table->softDeletes();

    {
        // Add the 'status' column only if it does not exist
        if (!Schema::hasColumn('product_prices', 'status')) {
            Schema::table('product_prices', function (Blueprint $table) {
                $table->boolean('status')
                      ->default(1) // 1 = active, 0 = inactive
                      ->after('currency');
            });
        }
    }
        });

        // Optional: drop unique constraint if it exists from old versions
        if (Schema::hasTable('product_prices')) {
            Schema::table('product_prices', function (Blueprint $table) {
                try {
                    $table->dropUnique('product_prices_product_id_unique');
                } catch (\Exception $e) {
                    // Ignore if index not found
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
      public function down(): void
    {
        // Remove the column if it exists
        if (Schema::hasColumn('product_prices', 'status')) {
            Schema::table('product_prices', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};

