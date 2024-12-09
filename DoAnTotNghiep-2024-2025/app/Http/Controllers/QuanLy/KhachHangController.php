<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Khachhang;
use Illuminate\Support\Facades\Auth;

class KhachHangController extends Controller
{
    //Hiển thị danh sách khách hang
    public function index()
    {
        $nhanVien = auth()->guard('nhanvien')->user();

        if ($nhanVien->vaiTro !== 'admin' && $nhanVien->vaiTro !== 'quanly') {
            return redirect()->route('unauthorized');
        }
        $khachhangs = Khachhang::all(); // Lấy tất cả khách hàng
        return view('quanlys.khachhangs.khachhang', compact('khachhangs'));
    }
    //khởi tạo khách hàng mới
    public function create()
    {
        $nhanVien = auth()->guard('nhanvien')->user();

        if ($nhanVien->vaiTro !== 'admin' && $nhanVien->vaiTro !== 'quanly') {
            return redirect()->route('unauthorized');
        }
        return view('quanlys.khachhangs.create');
    }
    //Lưu khách hàng mới
    public function store(Request $request)
    {
        $request->validate([
            'tenTaiKhoan' => 'required|unique:khachhang|max:100',
            'matKhau'     => 'required|min:6',
            'email'       => 'required|email|unique:khachhang|max:100',
            'sdt'         => 'required|digits:10',
            'hoTen'       => 'required|max:100',
        ]);

        Khachhang::create([
            'tenTaiKhoan' => $request->tenTaiKhoan,
            'matKhau'     => bcrypt($request->matKhau),
            'email'       => $request->email,
            'sdt'         => $request->sdt,
            'diaChi'      => $request->diaChi,
            'hoTen'       => $request->hoTen,
            'trangThai'   => 1,
        ]);

        return redirect()->route('quanlys.khachhang.index')->with('success', 'Thêm khách hàng thành công!');
    }

    //cập nhật trạng thái khóa, hoạt động.
    public function updateStatus($id)
    {
        // Tìm nhân viên theo ID
        $khachhang = Khachhang::findOrFail($id);

        // Đổi trạng thái
        $khachhang->trangThai = !$khachhang->trangThai; // Đảo ngược trạng thái (1 -> 0 hoặc 0 -> 1)
        $khachhang->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Chuyển hướng kèm thông báo thành công
        return redirect()->route('quanlys.khachhang.index')->with('success', 'Cập nhật trạng thái thành công!');
    }
}
