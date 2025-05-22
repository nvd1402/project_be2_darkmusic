<?php

// Trong file database/migrations/2025_05_22_061645_create_listening_history_table.php

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
        Schema::create('listening_history', function (Blueprint $table) {
            $table->id(); // Khóa chính (primary key) của bảng 'listening_history'

            // Dòng này cần thay đổi:
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Sửa thành: Chỉ định rõ khóa chính của bảng 'users' là 'user_id'
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');

            // Dòng này vẫn giữ nguyên vì bảng 'songs' thường dùng 'id' mặc định
            $table->foreignId('song_id')->constrained('songs')->onDelete('cascade');

            $table->timestamp('listened_at')->useCurrent(); // Thời điểm bài hát được nghe
            $table->timestamps(); // Thêm created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listening_history');
    }
};
