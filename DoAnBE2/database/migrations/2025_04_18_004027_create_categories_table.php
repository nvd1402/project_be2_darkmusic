<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();                           // ID tự tăng
            $table->string('tentheloai');           // Tên thể loại
            $table->string('nhom')->nullable();     // Nhóm thể loại (có thể null)
            $table->string('image')->nullable();    // Ảnh thể loại (có thể null, lưu đường dẫn)
            $table->timestamps();                   // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
