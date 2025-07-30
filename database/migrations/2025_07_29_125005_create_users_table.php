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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // BIGINT (Primary Key)
            $table->string('name'); // VARCHAR(255)
            $table->string('email')->unique(); // VARCHAR(255)
            $table->string('phone', 20)->nullable(); // VARCHAR(20)
            $table->string('username', 100)->unique()->nullable(); // VARCHAR(100)
            $table->string('password'); // VARCHAR(255)
            $table->string('profile_photo')->nullable(); // VARCHAR(255)
            $table->unsignedBigInteger('role_id')->nullable(); // INT
            $table->tinyInteger('status')->default(1); // TINYINT(1)
            $table->timestamp('email_verified_at')->nullable(); // DATETIME
            $table->timestamp('last_login_at')->nullable(); // DATETIME
            $table->string('last_login_ip', 45)->nullable(); // VARCHAR(45)
            $table->timestamps(); // created_at, updated_at
            $table->softDeletes(); // deleted_at
            $table->rememberToken(); // remember_token (VARCHAR 100)
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};