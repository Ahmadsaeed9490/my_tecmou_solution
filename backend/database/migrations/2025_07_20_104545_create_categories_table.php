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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // BIGINT (Primary Key)
            $table->string('name'); // VARCHAR(255)
            $table->string('slug')->unique(); // VARCHAR(255)
            $table->text('description')->nullable(); // TEXT
            $table->unsignedBigInteger('parent_id')->default(0);
            $table->string('image')->nullable(); // VARCHAR(255)
            $table->tinyInteger('status')->default(0); // default to 0 instead of 1
            $table->unsignedBigInteger('created_by')->nullable(); // INT
            $table->unsignedBigInteger('updated_by')->nullable(); // INT
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // Add this line
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
