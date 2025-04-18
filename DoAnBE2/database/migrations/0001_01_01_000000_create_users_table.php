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
            $table->text('password'); // Mật khẩu
            $table->string('email', 100)->unique(); // Email (không cho phép null, phải là duy nhất)
            $table->enum('role', ['User', 'Admin', 'Vip'])->default('User'); // Vai trò (mặc định là User)
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái (mặc định là active)
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động (mặc định là 1)
            $table->string('avatar', 255)->nullable(); // Cột để lưu ảnh đại diện
            $table->timestamps(); // created_at, updated_at
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade'); // Khóa ngoại
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();  // Đảm bảo email là duy nhất
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
