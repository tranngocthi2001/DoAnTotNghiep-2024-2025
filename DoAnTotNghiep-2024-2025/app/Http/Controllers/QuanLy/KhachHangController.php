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
        $khachhangs = Khachhang::all(); // Lấy tất cả khách hàng
        return view('quanlys.khachhangs.khachhang', compact('khachhangs'));
    }
    //khởi tạo khách hàng mới
    public function create()
    {
        // Chỉ admin mới có quyền truy cập
        if (Auth::user()->vaiTro !== 'admin'&&Auth::user()->vaiTro !=='quanly') {
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
    //chỉnh sửa
    public function edit($id)
    {
        $khachhang = Khachhang::findOrFail($id);
        return view('khachhang.edit', compact('khachhang'));
    }
    //lưu chỉnh sửa
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenTaiKhoan' => 'required|max:100|unique:khachhang,tenTaiKhoan,' . $id,
            'email'       => 'required|email|max:100|unique:khachhang,email,' . $id,
            'sdt'         => 'required|digits:10',
            'hoTen'       => 'required|max:100',
        ]);

        $khachhang = Khachhang::findOrFail($id);
        $khachhang->update($request->all());

        return redirect()->route('khachhang.index')->with('success', 'Cập nhật khách hàng thành công!');
    }

        public function destroy($id)
    {
        $khachhang = Khachhang::findOrFail($id);
        $khachhang->delete();

        return redirect()->route('khachhang.index')->with('success', 'Xóa khách hàng thành công!');
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
