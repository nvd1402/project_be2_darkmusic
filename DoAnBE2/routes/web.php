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
});

// === Frontend (public) routes ===
Route::group(['as' => 'frontend.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('category/{slug}', [HomeController::class, 'category'])->name('category');
    Route::get('song/{slug}', [HomeController::class, 'song'])->name('song');
    Route::get('rankings', [HomeController::class, 'rankings'])->name('rankings');
    Route::get('news', [HomeController::class, 'news'])->name('news');
    Route::get('news/{id}', [NewsController::class, 'show'])->name('news.show');

    Route::get('/song/{slug}', [HomeController::class, 'song'])->name('song');
    Route::get('/rankings', [HomeController::class, 'rankings'])->name('rankings');

    Route::get('/news', [HomeController::class, 'news'])->name('news');
    Route::get('/category', [HomeController::class, 'category'])->name('category');
    Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category_show');

    Route::get('/news/{id}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');


});

