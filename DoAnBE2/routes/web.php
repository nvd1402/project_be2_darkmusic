<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdController;
use App\Models\Artist;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AlbumController;

use App\Http\Controllers\VipController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CommentsController;

use App\Http\Controllers\ListeningHistoryController;

// === Public routes (guest only) ===
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);



//admin
    Route::get('/admin/dashboard', [AdminController::class, 'adminindex'])->name('admin.dashboard');;

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

// === Logout (auth only) ===
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// === Profile routes (auth only) ===
Route::middleware('auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');
});

// === Admin routes (auth + prefix admin + route name admin.) ===
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('news/search', [NewsController::class, 'search'])->name('news.search');
    Route::get('categories/search', [CategoryController::class, 'search'])->name('categories.search');
    Route::get('album/search', [AlbumController::class, 'search'])->name('album.search');
  Route::get('comments/search', [CommentsController::class, 'search'])->name('comments.search');


    // Dashboard
    Route::get('dashboard', [AdminController::class, 'adminindex'])->name('dashboard');

    // Songs CRUD (khai báo rõ hoặc dùng resource)
    Route::get('songs', [AdminController::class, 'indexsong'])->name('songs.index');
    Route::get('songs/create', [AdminController::class, 'createsong'])->name('songs.create');
    Route::post('songs', [AdminController::class, 'storesong'])->name('songs.store');
    Route::get('songs/search', [AdminController::class, 'search'])->name('songs.search');
    Route::get('songs/{id}/edit', [AdminController::class, 'editsong'])->name('songs.edit');
    Route::put('songs/{id}', [AdminController::class, 'updatesong'])->name('songs.update');
    Route::delete('songs/{id}', [AdminController::class, 'deletesong'])->name('songs.destroy');

    // Users CRUD (dùng resource, loại bỏ 'show' nếu không dùng)
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('users/search', [UserController::class, 'search'])->name('users.search');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('users/destroy', [UserController::class, 'destroy'])->name('users.destroy');



    // Artists CRUD (tùy bạn muốn khai báo riêng hay dùng resource)
    Route::get('artist/index', [ArtistController::class, 'indexArtist'])->name('artist.index');
    Route::get('artist/create', [ArtistController::class, 'createArtist'])->name('artist.create');
    Route::post('artist/post.create', [ArtistController::class, 'postArtist'])->name('artist.post.create');
    Route::get('artist/update', [ArtistController::class, 'updateArtist'])->name('artist.update');
    Route::post('artist/post.update', [ArtistController::class, 'postUpdateArtist'])->name('artist.post.update');
    Route::get('artist/delete', [ArtistController::class, 'deleteArtist'])->name('artist.delete');

    // Categories CRUD (dùng resource)
    Route::resource('categories', CategoryController::class);


       


    // Ads & News (resource)
    Route::resource('ad', AdController::class);
    Route::resource('news', NewsController::class);


    // Doanh thu
    Route::get('revenue', [AdminController::class, 'revenue'])->name('revenue.index');





    //album
Route::get('album/index', [AlbumController::class, 'index'])->name('album.index');
Route::get('album/create', [AlbumController::class, 'create'])->name('album.create');
Route::post('album/store', [AlbumController::class, 'store'])->name('album.store');
Route::get('album/edit/{id}', [AlbumController::class, 'edit'])->name('album.edit');
Route::put('album/update/{id}', [AlbumController::class, 'update'])->name('album.update');
Route::delete('album/{id}', [AlbumController::class, 'destroy'])->name('album.destroy');
});

// Hiển thị danh sách bình luận (admin)
Route::get('/admin/comments', [CommentsController::class, 'index'])->name('admin.comments.index');
Route::get('/admin/comments/create', [CommentsController::class, 'create'])->name('admin.comments.create');
Route::post('/admin/comments/store', [CommentsController::class, 'store'])->name('admin.comments.store');
Route::get('/admin/comments/edit/{id}', [CommentsController::class, 'edit'])->name('admin.comments.edit');
Route::put('/admin/comments/update/{id}', [CommentsController::class, 'update'])->name('admin.comments.update');
Route::delete('/admin/comments/{id}', [CommentsController::class, 'destroy'])->name('admin.comments.destroy');


// === Frontend (public) routes ===
Route::group(['as' => 'frontend.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('category', [HomeController::class, 'category'])->name('category'); // Danh sách nhóm thể loại
Route::get('category/{tentheloai}', [HomeController::class, 'categoryDetail'])->name('category.detail'); // Chi tiết thể loại

    Route::get('song/{slug}', [HomeController::class, 'song'])->name('song');
    Route::get('rankings', [HomeController::class, 'rankings'])->name('rankings');
    Route::get('news', [HomeController::class, 'news'])->name('news');

    Route::get('news/{id}', [NewsController::class, 'show'])->name('news.show');


    Route::get('/song/{slug}', [HomeController::class, 'song'])->name('song');
    Route::get('/rankings', [HomeController::class, 'rankings'])->name('rankings');

    Route::get('/news', [HomeController::class, 'news'])->name('news');
  
   // routes/web.php
Route::post('/news/{id}/comment', [CommentsController::class, 'store'])->name('comment.store');



    Route::get('/news/{id}', [App\Http\Controllers\NewsController::class, 'show'])->name('news_show');

Route::get('/category/{tentheloai}', [CategoryController::class, 'show'])->name('category_show');
    Route::get('/history', [ListeningHistoryController::class, 'index'])
        ->middleware('auth')
        ->name('listening.history');


    Route::get('/vip/register', [VipController::class, 'showRegistrationForm'])->name('vip.register');
    // Route để hiển thị trang thanh toán, nhận tham số gói VIP
    Route::get('/payment/checkout/{plan}', [PaymentController::class, 'showCheckout'])->name('payment.checkout');

    // Route để xử lý việc gửi form thanh toán (ví dụ: gửi đến cổng thanh toán VNPAY)
    Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');

    // Route này là cần thiết cho VNPAY gọi về sau khi thanh toán, bạn sẽ cần triển khai logic xử lý phản hồi ở đây
    Route::get('/payment/return', [PaymentController::class, 'paymentReturn'])->name('payment.return');
//    Route::get('/payment/checkout/{plan}', [PaymentController::class, 'showCheckout'])->name('payment.checkout');


});
//Route::post('/song/{id}/toggle-like', [AdminController::class, 'toggleLike'])
//    ->name('song.toggleLike')
//    ->middleware('auth');
Route::post('/song/{id}/like', [AdminController::class, 'toggleLike'])->name('song.like');




