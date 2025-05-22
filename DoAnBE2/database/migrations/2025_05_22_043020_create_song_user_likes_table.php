<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('song_user_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');   // phải đúng tên và kiểu với khóa chính bảng users
            $table->unsignedBigInteger('song_id');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade'); // chú ý user_id
            $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('song_user_likes');
    }
};
