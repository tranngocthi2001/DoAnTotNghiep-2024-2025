<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonHangController extends Controller
{
    // Hiển thị danh sách đơn hàng dành cho nhân viên/admin
    public function indexAdmin()
    {
        // Kiểm tra nếu người dùng đã đăng nhập với guard 'nhanvien'
        if (!auth()->guard('nhanvien')->check()) {
            return redirect()->route('login')->withErrors('Bạn cần đăng nhập để truy cập.');
        }

        // Lấy thông tin người dùng từ guard 'nhanvien'
        $user = auth()->guard('nhanvien')->user();
//dd($user);
        // Kiểm tra quyền truy cập
        if (!in_array($user->role, ['admin', 'quanly'])) {
            return redirect()->route('login')->withErrors('Bạn không có quyền truy cập.');
        }

        // Lấy danh sách đơn hàng kèm thông tin nhân viên xử lý
        $donHangsMoi = DonHang::with('nhanViens')
            ->where('trangThai', 'Chưa xác nhận')
            ->orderBy('ngayDatHang', 'desc')
            ->get();

        $donHangsCu = DonHang::with('nhanViens')
            ->where('trangThai', '!=', 'Chưa xác nhận')
            ->orderBy('ngayDatHang', 'desc')
            ->get();

        return view('quanlys.donhangs.donhang', compact('donHangsMoi', 'donHangsCu'));
    }


    // Cập nhật trạng thái đơn hàng
    public function update(Request $request, $id)
    {
        $request->validate([
            'trangThai' => 'required|in:Chưa xác nhận,Đang xử lý,Đã hoàn thành,Đã hủy',
        ]);

       // Tìm đơn hàng theo ID
        $donhang = DonHang::findOrFail($id);

        // Lấy ID nhân viên hiện tại từ guard `nhanvien`
        $nhanvienId = Auth::guard('nhanvien')->id();
//dd($nhanvienId);
        // Cập nhật trạng thái đơn hàng và lưu nhân viên thực hiện
        $donhang->update([
            'trangThai' => $request->input('trangThai'),
            'nhanvien_id' => $nhanvienId,
        ]);

        return redirect()->route('quanlys.donhang.indexAdmin')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        // Tìm đơn hàng với id
        $donHang = DonHang::with('chiTietDonHangs')->findOrFail($id);
        //dd($donHang->chiTietDonHangs);

        // Lấy thông tin khách hàng qua quan hệ khachhang_id
        $khachHang = $donHang->khachHangs;
        //dd($donHang->khachHangs);

        // Trả về view với thông tin đơn hàng và tên khách hàng
        return view('quanlys.donhangs.show', compact('donHang', 'khachHang'));
    }


    // Xác nhận đơn hàng
    public function xacNhanDonHang($id)
    {
        $donHang = DonHang::findOrFail($id);
        $donHang->update([
            'nhanvien_id' => auth()->id(),
            'trangThai' => 'Đã xác nhận',
        ]);

        return redirect()->route('nhanvien.donhang.indexAdmin')->with('success', 'Đơn hàng đã được xác nhận.');
    }
}
