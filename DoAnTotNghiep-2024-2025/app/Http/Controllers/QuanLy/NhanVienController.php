<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use Illuminate\Support\Facades\Auth;

class NhanVienController extends Controller
{
    /**
     * Hiển thị danh sách nhân viên.
     */
    public function index()
    {

        $nhanviens = NhanVien::all(); // Lấy danh sách tất cả nhân viên
        return view('quanlys.nhanviens.nhanvien', compact('nhanviens'));
    }

    /**
     * Hiển thị form tạo nhân viên mới.
     */
    public function create()
    {
        // Chỉ admin mới có quyền truy cập
        if (Auth::user()->vaiTro !== 'admin') {
            return redirect()->route('unauthorized');
        }

        return view('quanlys.nhanviens.create');
    }

    /**
     * Lưu thông tin nhân viên mới.
     */
    public function store(Request $request)
    {
        // Kiểm tra quyền truy cập
        if (Auth::user()->vaiTro !== 'admin') {
            return redirect()->route('unauthorized');
        }

        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'tenTaiKhoan' => 'required|unique:nhanvien,tenTaiKhoan|max:100',
            'matKhau' => 'required|min:6',
            'hoTen' => 'required',
            'email' => 'nullable|email|max:100',
            'vaiTro' => 'required|in:admin,quanly,nhanvien',
        ]);

        // Lưu dữ liệu
        NhanVien::create([
            'tenTaiKhoan' => $request->tenTaiKhoan,
            'matKhau' => bcrypt($request->matKhau),
            'hoTen' => $request->hoTen,
            'email' => $request->email,
            'vaiTro' => $request->vaiTro,
            'trangThai' => $request->trangThai ?? 1,
        ]);

        // Chuyển hướng về danh sách nhân viên
        return redirect()->route('quanlys.nhanvien.index')->with('success', 'Tạo nhân viên thành công!');
    }


    /**
     * Hiển thị chi tiết một nhân viên.
     */
    public function show($id)
    {
        $nhanVien = NhanVien::findOrFail($id);

        return view('quanlys.nhanviens.show', compact('nhanVien'));
    }

    /**
     * Hiển thị form chỉnh sửa thông tin nhân viên.
     */
    public function edit($id)
    {
        // Chỉ admin mới có quyền chỉnh sửa nhân viên
        if (Auth::user()->vaiTro !== 'admin') {
            return redirect()->route('unauthorized');
        }

        $nhanVien = NhanVien::findOrFail($id);
        return view('quanlys.nhanviens.edit', compact('nhanVien'));
    }

    /**
     * Cập nhật thông tin nhân viên.
     */
    public function update(Request $request, $id)
    {
        // Chỉ admin mới có quyền cập nhật nhân viên
        if (Auth::user()->vaiTro !== 'admin') {
            return redirect()->route('unauthorized');
        }

        $nhanVien = NhanVien::findOrFail($id);

        $request->validate([
            'hoTen' => 'required',
            'email' => 'nullable|email|max:100',
            'vaiTro' => 'required|in:admin,quanly,nhanvien',
            'trangThai' => 'required|boolean',
        ]);

        $nhanVien->update([
            'hoTen' => $request->hoTen,
            'email' => $request->email,
            'vaiTro' => $request->vaiTro,
            'trangThai' => $request->trangThai,
        ]);

        return redirect()->route('quanlys.nhanvien.index')->with('success', 'Cập nhật nhân viên thành công!');
    }

    /**
     * Xóa một nhân viên.
     */
    public function destroy($id)
    {
        // Chỉ admin mới có quyền xóa nhân viên
        if (Auth::user()->vaiTro !== 'admin') {
            return redirect()->route('unauthorized');
        }

        $nhanVien = NhanVien::findOrFail($id);
        $nhanVien->delete();

        return redirect()->route('quanlys.nhanvien.index')->with('success', 'Xóa nhân viên thành công!');
    }
}
