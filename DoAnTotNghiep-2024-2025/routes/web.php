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
    return view('quanlys.quanlydashboard'); // Trỏ tới file resources/views/quanlys/quanly.blade.php
})->name('quanly.dashboard');
//Trang admin
Route::get('/admin', function () {
    return view('quanlys.admindashboard'); // Trỏ tới file resources/views/quanlys/quanly.blade.php
})->name('admin.dashboard');
//Trang nhan vien
Route::get('/nhanvien', function () {
    return view('quanlys.nhanviendashboard'); // Trỏ tới file resources/views/quanlys/quanly.blade.php
})->name('nhanvien.dashboard');

use App\Http\Controllers\QuanLy\NhanVienController;
use App\Models\Khachhang;

// Route::prefix('quanlys')->middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/nhanvien', [NhanVienController::class, 'index'])->name('nhanvien.index');

// });
Route::prefix('quanlys')->middleware(['auth', 'role:admin'])->group(function () {
    // Group cho các route liên quan đến nhân viên
    Route::prefix('/')->middleware(['checkNhanVienStatus'])->group(function () {
        // Resource route cho Nhân Viên Controller
        Route::resource('nhanvien', NhanVienController::class)->names([
            'index' => 'quanlys.nhanvien.index',
            'create' => 'quanlys.nhanvien.create',
            'store' => 'quanlys.nhanvien.store',
            'show' => 'quanlys.nhanvien.show',
            'edit' => 'quanlys.nhanvien.edit',
            'update' => 'quanlys.nhanvien.update',
            'destroy' => 'quanlys.nhanvien.destroy',
            // Tên cho route xóa
        ]);

        // Chỉnh sửa trạng thái tài khoản nhân viên
        Route::post('/{id}/update-status', [NhanVienController::class, 'updateStatus'])->name('quanlys.nhanvien.updateStatus');
    });
});

use App\Http\Controllers\QuanLy\KhachHangController;
Route::prefix('quanlys')->middleware(['auth', 'role:admin,quanly'])->group(function () {

    Route::prefix('khachhang')->middleware(['checkNhanVienStatus'])->group(function () {
        Route::resource('khachhang', KhachHangcontroller::class)->names([
            'index' => 'quanlys.khachhang.index',
            'create' => 'quanlys.khachhang.create',
            'store' => 'quanlys.khachhang.store',
            'show' => 'quanlys.khachhang.show',
        ]);
        //chinh sua trang thai tai khoan khach hang
        Route::post('/khachhang/{id}/update-status', [KhachHangController::class, 'updateStatus'])->name('khachhang.updateStatus');
    });
});


Route::get('/unauthorized', function () {
    return "Bạn không có quyền truy cập vào trang này.";
})->name('unauthorized');
//
use App\Http\Controllers\TaiKhoan\KhachHang\DangNhapKHController;
// Route đăng nhập khách hàng
Route::get('khachhang/login', [DangNhapKHController::class, 'showLoginForm'])->name('khachhang.loginForm');
Route::post('khachhang/login', [DangNhapKHController::class, 'login'])->name('khachhang.login');
Route::post('khachhang/logout', [DangNhapKHController::class, 'logout'])->name('khachhang.logout');

// Route dashboard cho khách hàng

Route::middleware('khachhang.dangnhap')->group(function () {
    Route::get('khachhang/dashboard', function () {
        return view('trangchus.welcome');
    })->name('khachhang.dashboard');
});
//
use App\Http\Controllers\TaiKhoan\KhachHang\DangKyKHController;

Route::get('/khachhang/register', [DangKyKHController::class, 'showRegistrationForm'])->name('dangky.khachhang');
Route::post('/khachhang/register', [DangKyKHController::class, 'handleRegistration'])->name('dangky.khachhang.submit');
//
use App\Http\Controllers\QuanLy\DanhmucController;
Route::prefix('quanlys')->middleware(['auth', 'role:admin,quanly'])->group(function () {

    Route::prefix('/')->middleware(['checkNhanVienStatus'])->group(function () {
        Route::resource('danhmuc', DanhMucController::class)->names([
            'index' => 'quanlys.danhmuc.index',
            'create' => 'quanlys.danhmuc.create',
            'store' => 'quanlys.danhmuc.store',
            'show' => 'quanlys.danhmuc.show',
            'edit' => 'quanlys.danhmuc.edit',
            'update' => 'quanlys.danhmuc.update',
            'destroy' => 'quanlys.danhmuc.destroy',
        ]);
    });
});


