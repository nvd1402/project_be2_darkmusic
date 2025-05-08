<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\UserController;
use App\Models\Artist;



use App\Http\Controllers\NewsController;

//admin
Route::get('/admin/dashboard', [AdminController::class, 'adminindex'])->name('admin.dashboard');;

//song
Route::get('/admin/songs/create', [AdminController::class, 'createsong'])->name('admin.songs.create');
Route::post('/admin/songs/store', [AdminController::class, 'storesong'])->name('admin.songs.store');
Route::get('/admin/songs/index', [AdminController::class, 'indexsong'])->name('admin.songs.index');
// Route GET cho việc chỉnh sửa bài hát
Route::get('/admin/songs/edit/{id}', [AdminController::class, 'editsong'])->name('admin.songs.edit');
Route::get('/admin/songs/search', [AdminController::class, 'search'])->name('admin.songs.search');


// Route PUT cho việc cập nhật bài hát
Route::put('/admin/songs/edit/{id}', [AdminController::class, 'updatesong'])->name('admin.songs.update');


// Song Routes
Route::delete('/admin/songs/{id}', [AdminController::class, 'deletesong'])->name('admin.songs.destroy');


//user
// Route cho việc hiển thị danh sách người dùng
Route::get('/admin/users/index', [UserController::class, 'index'])->name('admin.users.index');

// Route cho việc hiển thị form tạo người dùng
Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');

// Route cho việc lưu người dùng mới
Route::post('admin/users', [UserController::class, 'store'])->name('admin.users.store');

Route::get('admin/users/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');

Route::put('admin/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');

// web.php
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
Route::get('/admin/users/search', [UserController::class, 'search'])->name('admin.users.search');


//doanh thu
Route::get('/admin/revenue/index', [AdminController::class, 'revenue'])->name('admin.revenue.index');


// artist-crud
Route::get('admin/artist/index', [ArtistController::class, 'indexArtist'])->name('admin.artist.index');

Route::get('admin/artist/create', [ArtistController::class, 'createArtist'])->name('admin.artist.create');
Route::post('admin/artist/create', [ArtistController::class, 'postArtist'])->name('admin.artist.post.create');

Route::get('admin/artist/update', [ArtistController::class, 'updateArtist'])->name('admin.artist.update');
Route::post('admin/artist/update', [ArtistController::class, 'postUpdateArtist'])->name('admin.artist.post.update');

Route::get('admin/artist/delete', [ArtistController::class, 'deleteArtist'])->name('admin.artist.delete');

Route::get('/admin/categories/index', [CategoryController::class, 'index'])->name('admin.categories.index');


Route::resource('categories', CategoryController::class);


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('news', NewsController::class);
});
Route::get('admin/news/create', [NewsController::class, 'create'])->name('admin.news.create');



//PHẦN GIAO DIỆN NGƯỜI DÙNG

Route::group(['prefix'=> '' , 'as' => 'frontend.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Route cho trang thể loại (/category/{slug}) trỏ đến phương thức category của HomeController và đặt tên là 'frontend.category'
    Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category');

    // Route cho trang chi tiết bài hát (/song/{slug}) trỏ đến phương thức song của HomeController và đặt tên là 'frontend.song'
    Route::get('/song/{slug}', [HomeController::class, 'song'])->name('song');

    // Route cho trang xếp hạng (/rankings) trỏ đến phương thức rankings của HomeController và đặt tên là 'frontend.rankings'
    Route::get('/rankings', [HomeController::class, 'rankings'])->name('rankings');

    // Thêm các routes khác cho giao diện người dùng của bạn trong group này
});

// Các routes cho trang admin (vẫn giữ nguyên tiền tố /admin)
//Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
//    // Các routes admin của bạn
//    Route::get('/dashboard', [AdminController::class, 'adminindex'])->name('admin.dashboard');
//    Route::get('/songs', [AdminController::class, 'indexsong'])->name('admin.songs.index');
//    // ... các routes admin khác
//});





















