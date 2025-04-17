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
            $table->id('user_id'); // Primary key (user_id)
            $table->string('username', 100); // Tên người dùng
            $table->string('password', 255); // Mật khẩu
            $table->string('email', 100)->nullable()->default(null); // Email (cho phép null, mặc định là null)
            $table->enum('role', ['User', 'Admin', 'Vip'])->default('User'); // Vai trò (mặc định là User)
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái (mặc định là active)
            $table->tinyInteger('is_active')->default(1)->notNull(); // Trạng thái hoạt động (mặc định là 1)
            $table->string('avatar')->nullable(); // Cột để lưu ảnh đại diện
            $table->timestamps(); // created_at, updated_at
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
