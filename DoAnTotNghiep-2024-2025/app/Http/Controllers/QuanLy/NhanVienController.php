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
        //$nhanvien = session('nhanvien');
        //dd($nhanvien);
        $nhanviens = NhanVien::all();
         //dd($nhanviens); // Lấy danh sách tất cả nhân viên
        return view('quanlys.nhanviens.nhanvien', compact('nhanviens'));
    }

    /**
     * Hiển thị form tạo nhân viên mới.
     */
    public function create()
    {
        $nhanVien = auth()->guard('nhanvien')->user();

        // Chỉ admin mới có quyền truy cập
        if ($nhanVien->vaiTro !== 'admin') {
            //dd($nhanVien);
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
        $request->validate([
            'tenTaiKhoan' => 'required|unique:nhanvien,tenTaiKhoan|max:255',
            'matKhau'     => 'required|min:6',
            'email'       => 'required|email|unique:nhanvien,email',
            'sdt'         => 'required|digits:10',
            'diaChi'      => 'nullable|string',
            'hoTen'       => 'required|string|max:255',
            'vaiTro'      => 'required|string',
            'trangThai'   => 'required|boolean',
        ]);

        // Lưu dữ liệu
        Nhanvien::create([
            'tenTaiKhoan' => $request->tenTaiKhoan,
            'matKhau'     => $request->matKhau, // Mã hóa mật khẩu tự động trong model
            'email'       => $request->email,
            'sdt'         => $request->sdt,
            'diaChi'      => $request->diaChi,
            'hoTen'       => $request->hoTen,
            'vaiTro'      => $request->vaiTro,
            'trangThai'   => $request->trangThai,
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
        $nhanVien = Auth::guard('nhanvien')->user();
        //dd($nhanVien);
         // Lấy thông tin nhân viên đang đăng nhập
        //$nhanVien = auth()->guard('nhanvien')->user()
        // Chỉ admin mới có quyền chỉnh sửa nhân viên
        if ($nhanVien->vaiTro !== 'admin') {
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
        $nhanVien = auth()->guard('nhanvien')->user();
        //dd($nhanVien);
        // Chỉ admin mới có quyền chỉnh sửa nhân viên
        if ($nhanVien->vaiTro !== 'admin') {
            //dd($nhanVien);
            return redirect()->route('unauthorized');
        }
        // Kiểm tra số điện thoại có quá lớn không (vượt quá giới hạn của kiểu INT)
        $sdt = $request->sdt;
        //dd(strlen($sdt));
        if (strlen($sdt) >10  ||strlen($sdt) <9 ){
            return back()->with('error', 'Số điện thoại không hợp lệ hoặc quá dài!');
        }
        $nhanVien = NhanVien::findOrFail($id);

        $nhanVien->update([
            'tenTaiKhoan' => $request->tenTaiKhoan,
            'email'       => $request->email,
            'sdt'         => $sdt,
            'diaChi'      => $request->diaChi,
            'hoTen'       => $request->hoTen,
            'vaiTro'      => $request->vaiTro,
        ]);
        return redirect()->route('quanlys.nhanvien.index')->with('success', 'Cập nhật nhân viên thành công!');
    }

    /**
     * Xóa một nhân viên.
     */
    public function destroy($id)
    {
        $nhanVien = auth()->guard('nhanvien')->user();
        //dd($nhanVien);
        // Chỉ admin mới có quyền chỉnh xóa nhân viên
        if ($nhanVien->vaiTro !== 'admin') {
            return redirect()->route('unauthorized');
        }

        $nhanVien = NhanVien::findOrFail($id);
        $nhanVien->delete();

        return redirect()->route('quanlys.nhanvien.index')->with('success', 'Xóa nhân viên thành công!');
    }
    //cập nhật trạng thái khóa, hoạt động.
    public function updateStatus($id)
    {
        // Tìm nhân viên theo ID
        $nhanvien = Nhanvien::findOrFail($id);

        // Đổi trạng thái
        $nhanvien->trangThai = !$nhanvien->trangThai; // Đảo ngược trạng thái (1 -> 0 hoặc 0 -> 1)
        $nhanvien->save(); // Lưu thay đổi vào cơ sở dữ liệu

        // Chuyển hướng kèm thông báo thành công
        return redirect()->route('quanlys.nhanvien.index')->with('success', 'Cập nhật trạng thái thành công!');
    }
}
