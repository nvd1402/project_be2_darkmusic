<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('news_id');
        $table->text('noidung');
        $table->timestamps();

        // Khóa ngoại
        $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
