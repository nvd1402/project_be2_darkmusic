<?php
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
//admin
Route::get('/admin/dashboard', [AdminController::class, 'adminindex']) -> name('admin.dashboard');;

//song
Route::get('/admin/songs/create', [AdminController::class, 'createsong']) -> name('admin.songs.create');
Route::post('/admin/songs/store', [AdminController::class, 'storesong']) -> name('admin.songs.store');
Route::get('/admin/songs/index', [AdminController::class, 'indexsong']) -> name('admin.songs.index');
// Route GET cho việc chỉnh sửa bài hát
Route::get('/admin/songs/edit/{id}', [AdminController::class, 'editsong'])->name('admin.songs.edit');

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
Route::get('/admin/revenue/index', [AdminController::class, 'revenue']) -> name('admin.revenue.index');
Route::get('/admin/categories/index', [CategoryController::class, 'index']) -> name('admin.categories.index');


Route::resource('categories', CategoryController::class);

Route::get('/admin/categories/search', [CategoryController::class, 'search'])->name('admin.categories.search');





