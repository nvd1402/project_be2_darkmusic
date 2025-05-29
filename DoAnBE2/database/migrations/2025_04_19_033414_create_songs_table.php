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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('tenbaihat');
            $table->unsignedBigInteger('nghesi')->nullable(); // Thay đổi kiểu dữ liệu của cột 'nghesi'
            $table->unsignedBigInteger('theloai');
            $table->string('file_amthanh');
            $table->string('anh_daidien')->nullable();
            $table->timestamps();

            $table->foreign('nghesi')->references('id')->on('artists')->onDelete('cascade'); // Thêm khóa ngoại
            $table->foreign('theloai')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
