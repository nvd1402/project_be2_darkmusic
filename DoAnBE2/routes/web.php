<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

//admin
Route::get('/admin/dashboard', [AdminController::class, 'adminindex']) -> name('admin.dashboard');;

//song
Route::get('/admin/songs/create', [AdminController::class, 'createsong']) -> name('admin.songs.create');
Route::get('/admin/songs/index', [AdminController::class, 'indexsong']) -> name('admin.songs.index');
Route::get('/admin/songs/edit', [AdminController::class, 'editsong']) -> name('admin.songs.edit');

//user
Route::get('/admin/users/index', [AdminController::class, 'indexuser']) -> name('admin.users.index');
Route::get('/admin/users/create', [AdminController::class, 'createuser']) -> name('admin.users.create');
Route::get('/admin/users/edit', [AdminController::class, 'edituser']) -> name('admin.users.edit');


//doanh thu
Route::get('/admin/revenue/index', [AdminController::class, 'revenue']) -> name('admin.revenue.index');
