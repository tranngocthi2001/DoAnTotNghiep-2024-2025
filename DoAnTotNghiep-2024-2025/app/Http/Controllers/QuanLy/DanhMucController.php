<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Danhmuc;
use Illuminate\Support\Facades\Auth;

class DanhMucController extends Controller
{
    // Hiển thị danh sách danh mục
    public function index()
    {
        $danhmucs = Danhmuc::all(); // Lấy tất cả danh mục
        return view('quanlys.danhmucs.danhmuc', compact('danhmucs'));
    }

    // Hiển thị form tạo mới danh mục
    public function create()
    {
        if (Auth::user()->vaiTro !== 'admin'&&Auth::user()->vaiTro !=='quanly') {
            return redirect()->route('unauthorized');
       }
        return view('quanlys.danhmucs.create');
    }

    // Lưu danh mục mới vào database
    public function store(Request $request)
    {
        $request->validate([
            'tenDanhMuc' => 'required|string|max:100',
            'moTa' => 'nullable|string',
            'trangThai' => 'required|boolean',
        ]);

        Danhmuc::create($request->all());

        return redirect()->route('quanlys.danhmuc.index')->with('success', 'Thêm danh mục thành công!');
    }

    // Hiển thị form chỉnh sửa danh mục
    public function edit($id)
    {
        $danhmuc = Danhmuc::findOrFail($id);
        return view('quanlys.danhmucs.edit', compact('danhmuc'));
    }

    // Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenDanhMuc' => 'required|string|max:100',
            'moTa' => 'nullable|string',
            'trangThai' => 'required|boolean',
        ]);

        $danhmuc = Danhmuc::findOrFail($id);
        $danhmuc->update($request->all());

        return redirect()->route('quanlys.danhmuc.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    // Xóa danh mục
    public function destroy($id)
    {
        $danhmuc = Danhmuc::findOrFail($id);
        $danhmuc->delete();

        return redirect()->route('quanlys.danhmuc.index')->with('success', 'Xóa danh mục thành công!');
    }
}
