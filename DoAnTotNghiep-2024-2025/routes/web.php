<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\Http\Controllers\TaiKhoan\NhanVien\DangNhapController;
use App\Http\Controllers\TaiKhoan\NhanVien\DangKyController;

//goi trang dang ky
Route::get('/register', [DangKyController::class, 'showRegisterForm'])->name('register');
//xu ly dang ký
Route::post('/register', [DangKyController::class, 'register'])->name('register.submit');

//goi trang dang nhap
Route::get('/login', [DangNhapController::class, 'showLoginForm'])->name('login');
//xu ly dang nhap
Route::post('/login', [DangNhapController::class, 'login'])->name('login.submit');

//Trang quan ly
Route::get('/quanly', function () {
    return view('quanlys.quanly'); // Trỏ tới file resources/views/quanlys/quanly.blade.php
})->name('quanly.dashboard');
//
use App\Http\Controllers\QuanLy\NhanVienController;

// Route::prefix('quanlys')->middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/nhanvien', [NhanVienController::class, 'index'])->name('nhanvien.index');

// });
Route::prefix('quanlys')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('nhanvien', NhanVienController::class)->names([
        'index' => 'quanlys.nhanvien.index',
        'create' => 'quanlys.nhanvien.create',
        'store' => 'quanlys.nhanvien.store',
        'show' => 'quanlys.nhanvien.show',
        'edit' => 'quanlys.nhanvien.edit',
        'update' => 'quanlys.nhanvien.update',
        'destroy' => 'quanlys.nhanvien.destroy', // Tên cho route xoá
    ]);
});


Route::get('/unauthorized', function () {
    return "Bạn không có quyền truy cập vào trang này.";
})->name('unauthorized');
