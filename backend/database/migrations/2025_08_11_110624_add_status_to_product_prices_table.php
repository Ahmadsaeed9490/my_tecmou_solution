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
        Schema::table('product_prices', function (Blueprint $table) {
            // Add status column if it doesn't exist
            if (!Schema::hasColumn('product_prices', 'status')) {
                $table->boolean('status')
                      ->default(1) // 1 = active, 0 = inactive
                      ->after('currency')
                      ->comment('Product price status: 1=Active, 0=Inactive');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_prices', function (Blueprint $table) {
            // Drop the status column if it exists
            if (Schema::hasColumn('product_prices', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
