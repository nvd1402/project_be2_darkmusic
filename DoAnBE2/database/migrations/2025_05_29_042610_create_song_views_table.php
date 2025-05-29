<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('song_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('song_id')->unique(); // Mỗi bài 1 dòng duy nhất
            $table->unsignedBigInteger('views')->default(0); // Tổng lượt xem
            $table->timestamps();

            $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('song_views');
    }
};

