<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // id
            $table->string('tentheloai'); // tên thể loại
            $table->string('nhom')->nullable(); // nhóm
            $table->string('image')->nullable(); // ảnh
            $table->text('description')->nullable(); // mô tả
            $table->boolean('status')->default(1); // 1 = active, 0 = inactive

            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
}
