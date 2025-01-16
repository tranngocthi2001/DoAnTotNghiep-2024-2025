<?php

use Illuminate\Support\Facades\Route;



use App\Http\Controllers\TaiKhoan\NhanVien\DangKyController;
use App\Http\Controllers\TaiKhoan\NhanVien\DangNhapController;

// Đăng ký nhân viên
Route::get('/register', [DangKyController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [DangKyController::class, 'register'])->name('register.submit');

// Đăng nhập nhân viên
Route::get('/login', [DangNhapController::class, 'showLoginForm'])->name('login');
Route::post('/login', [DangNhapController::class, 'login'])->name('login.submit');

Route::post('/logout', [DangNhapController::class, 'logout'])->name('nhanvien.logout');

// Trang quản lý cho admin, quản lý, và nhân viên
Route::middleware('auth:nhanvien')->group(function () {
    Route::get('/quanly', function () {
        return view('quanlys.quanlydashboard');
    })->name('quanly.dashboard');

    Route::get('/admin', function () {
        return view('quanlys.admindashboard');
    })->name('admin.dashboard');

    Route::get('/nhanvien', function () {
        return view('quanlys.nhanviendashboard');
    })->name('nhanvien.dashboard');
});

use App\Http\Controllers\QuanLy\NhanVienController;

Route::middleware(['auth:nhanvien', 'role:admin,quanly'])->group(function () {
    // Group cho các route liên quan đến nhân viên

        // Resource route cho Nhân Viên Controller
        Route::resource('nhanvien', NhanVienController::class)->names([
            'index' => 'quanlys.nhanvien.index',
            'create' => 'quanlys.nhanvien.create',
            'store' => 'quanlys.nhanvien.store',
            'show' => 'quanlys.nhanvien.show',
            // 'edit' => 'quanlys.nhanvien.edit',
            // 'update' => 'quanlys.nhanvien.update',
            'destroy' => 'quanlys.nhanvien.destroy',
            // Tên cho route xóa
        ]);
        // Route riêng cho edit
        Route::get('nhanvien/{id}/edit', [NhanVienController::class, 'edit'])->name('quanlys.nhanvien.edit');

        // Route riêng cho update
        Route::post('nhanvien/{id}/update', [NhanVienController::class, 'update'])->name('quanlys.nhanvien.update');
        // Chỉnh sửa trạng thái tài khoản nhân viên
        Route::post('/{id}/update-status', [NhanVienController::class, 'updateStatus'])->name('quanlys.nhanvien.updateStatus');
});

use App\Http\Controllers\QuanLy\KhachHangController;
Route::middleware(['auth:nhanvien', 'role:admin,quanly'])->group(function () {

    Route::prefix('quanlys')->middleware(['checkNhanVienStatus'])->group(function () {
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
//Khach hàng chỉnh sửa thông tin
Route::get('/khachhang/{id}/edit', [KhachHangController::class, 'edit'])->name('khachhang.edit');
Route::PATCH('/khachhang/{id}/update', [KhachHangController::class, 'update'])->name('khachhang.update');


Route::get('/unauthorized', function () {
    return "Bạn không có quyền truy cập vào trang này.";
})->name('unauthorized');

use App\Http\Controllers\TaiKhoan\KhachHang\DangNhapKHController;
use App\Http\Controllers\TrangChu\HomeController;

// Route dành cho đăng nhập, đăng xuất khách hàng
Route::prefix('khachhang')->group(function () {
    Route::get('login', [DangNhapKHController::class, 'showLoginForm'])->name('khachhang.showLoginForm');
    Route::post('login', [DangNhapKHController::class, 'login'])->name('khachhang.login'); // Xử lý đăng nhập
    Route::post('logout', [DangNhapKHController::class, 'logout'])->name('khachhang.logout'); // Xử lý đăng xuất
});

// Route dành cho dashboard khách hàng (được bảo vệ bởi middleware)
Route::middleware('khachhang.dangnhap')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('khachhang.dashboard'); // Trang chủ sau khi đăng nhập
});

//Route dành cho user guest
Route::get('/homeguest', [HomeController::class, 'guest'])->name('homeguest');

// dang kys khach hang
use App\Http\Controllers\TaiKhoan\KhachHang\DangKyKHController;

Route::get('/khachhang/register', [DangKyKHController::class, 'showRegistrationForm'])->name('dangky.khachhang');
Route::post('/khachhang/register', [DangKyKHController::class, 'handleRegistration'])->name('dangky.khachhang.submit');
//quan lys danh  muc
use App\Http\Controllers\QuanLy\DanhmucController;
Route::middleware(['auth:nhanvien', 'role:admin,quanly'])->group(function () {

    Route::prefix('/')->middleware(['checkNhanVienStatus'])->group(function () {
        Route::resource('danhmuc', DanhMucController::class)->names([
            'index' => 'quanlys.danhmuc.index',
            'create' => 'quanlys.danhmuc.create',
            'store' => 'quanlys.danhmuc.store',
            'edit' => 'quanlys.danhmuc.edit',
            'update' => 'quanlys.danhmuc.update',
            'destroy' => 'quanlys.danhmuc.destroy',
        ]);
    });
});

//quan ly san pham
use App\Http\Controllers\QuanLy\SanPhamController;

Route::middleware(['auth:nhanvien', 'role:admin,quanly'])->group(function () {

    Route::prefix('/')->middleware(['checkNhanVienStatus'])->group(function () {
        Route::resource('sanpham', SanPhamController::class)->names([
            'index' => 'quanlys.sanpham.index',
            'create' => 'quanlys.sanpham.create',
            'store' => 'quanlys.sanpham.store',
             'show' => 'quanlys.sanpham.show',
            'edit' => 'quanlys.sanpham.edit',
            'update' => 'quanlys.sanpham.update',
            'destroy' => 'quanlys.sanpham.destroy',
        ]);

        //dành cho admin
        Route::get('/tim-kiemAdmin', [SanPhamController::class, 'searchAdmin'])->name('sanpham.searchadmin');
        //lấy sản phẩm của danh mục


    });
});
Route::get('sanpham/{id}', [SanPhamController::class, 'show'])->name('quanlys.sanpham.show');

Route::get('danh-muc/{id}', [SanPhamController::class, 'showByCategory'])->name('danhmuc.show');

//gio hang cua khach hang
use App\Http\Controllers\TaiKhoan\KhachHang\GioHangController;
Route::middleware('khachhang.dangnhap')->group(function () {
    Route::get('/giohang', [GioHangController::class, 'index'])->name('giohang.index');
});

use App\Http\Controllers\TaiKhoan\KhachHang\SanPhamKHController;
Route::get('/khachhang/chitietsanpham/{id}',[SanPhamKHController::class,'show'])->name('sanpham.showchitiet');
//tìm kiếm sản phẩm
Route::get('/tim-kiem', [SanPhamController::class, 'search'])->name('sanpham.search');


use App\Http\Controllers\TaiKhoan\KhachHang\ChitietGioHangController;
Route::middleware('khachhang.dangnhap')->group(function () {
    // Route thêm sản phẩm vào giỏ hàng
    Route::post('/giohang/chitiet', [ChitietGioHangController::class, 'store'])->name('giohang.chitiet.store');
    // Route xóa sản phẩm khỏi giỏ hàng
    Route::delete('/giohang/chitiet/{id}', [ChitietGioHangController::class, 'destroy'])->name('giohang.chitiet.destroy');

    Route::post('/giohang/chitiet/update/{id}', [ChiTietGioHangController::class, 'updateQuantity'])->name('giohang.chitiet.update');
     //Route::post('/giohang/update', [ChiTietGioHangController::class, 'update'])->name('giohang.update');

});

//Dơn hàng
use App\Http\Controllers\QuanLy\DonHangController;
Route::middleware(['auth:nhanvien', 'role:admin,quanly'])->group(function () {


    Route::get('/donhang/timkiem', [DonHangController::class, 'timKiemDonHang'])->name('quanlys.donhang.timkiem');

    Route::get('/donhang', [DonHangController::class, 'indexAdmin'])->name('quanlys.donhang.indexAdmin');
    Route::get('/donhang/yeucaudoihang', [DonHangController::class, 'showYeuCauDoiHang'])->name('quanlys.donhang.showYeuCauDoiHang');

    Route::put('/donhang/{id}', [DonHangController::class, 'update'])->name('quanlys.donhang.update');
    Route::get('/donhang/{id}', [DonHangController::class, 'show'])->name('quanlys.donhang.show');
    Route::post('/donhang/xacnhan/{id}', [DonHangController::class, 'xacNhanDonHang'])->name('quanlys.donhang.xacnhan');


    Route::get('quanlys/donhang/create', [DonHangController::class, 'formcreate'])->name('donhang.create.form');
    Route::post('quanlys/donhang/create', [DonHangController::class, 'create'])->name('quanlys.donhang.create');
    Route::get('quanlys/donhang/addchitiet{donHang_id}',[DonHangController::class, 'formAddChiTietDonHang'])->name('donhang.addchitiet.form');
    Route::post('quanlys/donhang/addchitiet{id}',[DonHangController::class, 'xuLyThemChiTiet'])->name('donhang.xuLyThemChiTiet');



});
Route::delete('/donhang/xoa-chitiet/{id}', [DonHangController::class, 'xoaChiTiet'])->name('donhang.xoaChiTiet');
Route::put('/donhang/capnhat-soluong/{id}', [DonHangController::class, 'capNhatSoLuong'])->name('donhang.capNhatSoLuong');

use App\Http\Controllers\QuanLy\PhieuXuatHangController;

Route::middleware(['auth:nhanvien', 'role:admin,quanly'])->group(function () {
    Route::controller(PhieuXuatHangController::class)->group(function () {
        Route::get('/phieuxuathang/create/{donHangId}', 'create')->name('quanlys.phieuxuathang.create'); // Tạo phiếu xuất
        Route::post('/phieuxuathang/store', 'store')->name('phieuxuathangs.store'); // Lưu phiếu xuất
        Route::get('/phieuxuathang/donhang/{donhang_id}', 'show')->name('phieuxuathangs.show');
        Route::get('/phieuxuathang/{id}/print', 'print')->name('phieuxuathangs.print'); // In phiếu xuất

    });
});

use App\Http\Controllers\TaiKhoan\KhachHang\DonHangKHController;

Route::prefix('khachhang')->middleware(['auth:khachhang'])->group(function () {

    // Route cho trang giỏ hàng của khách hàng để đi đến đơn đặt hàng
    Route::get('/dondathang', [DonHangKHController::class, 'dondathang'])->name('khachhang.giohang.dondathang');
    Route::post('/donhang/create', [DonHangKHController::class, 'donHangCreate'])->name('khachhang.donhang.create');
    Route::get('/donhangKH', [DonHangKHController::class, 'index'])->name('khachhang.donhang.index');
    Route::get('/khachhang/donhang/{id}', [DonHangKHController::class, 'show'])->name('khachhang.donhang.show');
    Route::put('/donhang/{id}/huy', [DonHangKHController::class, 'huyDonHang'])->name('donhang.huy');
    Route::post('/donhang/{id}', [DonHangKHController::class, 'update'])->name('donhang.update');


});


use App\Http\Controllers\TaiKhoan\KhachHang\ThanhToanController;
// Route::prefix('khachhang')->middleware(['auth:khachhang'])->group(function () {

//     // Route tạo mới thanh toán
//     Route::post('don-hang/{donhangId}/thanh-toan', [ThanhToanController::class, 'store'])->name('thanh-toan.store');

//     // Route xem chi tiết thanh toán của đơn hàng
//     Route::get('don-hang/{donhangId}/thanh-toan', [ThanhToanController::class, 'show'])->name('thanh-toan.show');

//     // Route cập nhật thanh toán
//     Route::put('thanh-toan/{id}', [ThanhToanController::class, 'update'])->name('thanh-toan.update');

//     // Route xóa thanh toán
//     Route::delete('thanh-toan/{id}', [ThanhToanController::class, 'destroy'])->name('thanh-toan.destroy');

// });

use App\Http\Controllers\TaiKhoan\KhachHang\YeuCauDoiHangController;
// Hiển thị danh sách đơn hàng hoàn thành (khách hàng)
// Chỉ cho phép phương thức POST
Route::prefix('khachhang')->middleware(['auth:khachhang'])->group(function () {

        Route::get('khachhang/yeucaudoihang/{donhang_id}', [YeuCauDoiHangController::class, 'showForm'])->name('taikhoans.khachhangs.yeucaudoihang');

        Route::post('khachhang/yeucaudoihang', [YeuCauDoiHangController::class, 'create'])->name('taikhoans.khachhangs.yeucaudoihang');
        Route::post('/khachhang/yeucaudoihang', [YeuCauDoiHangController::class, 'store'])->name('taikhoans.khachhangs.yeucaudoihang.store');
        //dd("a");
        Route::get('/taikhoans/khachhangs/yeucaudoihang/{id}', [YeuCauDoiHangController::class, 'show'])
            ->name('taikhoans.khachhangs.yeucaudoihang.show');

});

Route::middleware(['auth:nhanvien', 'role:admin,quanly'])->group(function () {
    Route::get('quanlys/yeucaudoihang/{id}', [YeuCauDoiHangController::class, 'showAdmin'])
    ->name('taikhoans.khachhangs.yeucaudoihang.showAdmin');
    Route::post('/yeu-cau-doi-hang/{id}/update-status', [YeuCauDoiHangController::class, 'updateStatus'])
            ->name('taikhoans.khachhangs.yeucaudoihang.updateStatus');
});
    //vnpay
use App\Http\Controllers\TaiKhoan\KhachHang\VnpayController;
Route::prefix('khachhang')->middleware(['auth:khachhang'])->group(function () {

    //Route::get('vnpay/create/{donhang_id}', [VnpayController::class, 'createPayment'])->name('vnpay.create');
    Route::match(['get', 'post'], 'vnpay/create/{donhang_id}', [VnpayController::class, 'createPayment'])->name('vnpay.create');

    Route::get('/vnpay/return', [VnpayController::class, 'return'])->name('vnpay.return');
    Route::post('vnpay/ipn', [VnpayController::class, 'ipn'])->name('vnpay.ipn');
});

use App\Http\Controllers\QuanLy\SeriController;
Route::middleware(['auth:nhanvien', 'role:admin,quanly'])->group(function () {

    Route::get('/seri',[SeriController::class, 'index'])->name('seri');
    Route::get('/timkiemSeri', [SeriController::class, 'searchAdmin'])->name('seri.search');
});
