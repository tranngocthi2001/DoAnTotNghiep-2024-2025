<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $nhanVien = auth()->guard('nhanvien')->user();

        if ($nhanVien->vaiTro !== 'admin' && $nhanVien->vaiTro !== 'quanly') {
            return redirect()->route('unauthorized');
        }
        $sanphams = SanPham::with('danhMucs')->get(); // Lấy tất cả sản phẩm cùng danh mục
        return view('quanlys.sanphams.sanpham', compact('sanphams'));
    }

    // Hiển thị form thêm mới sản phẩm
    public function create()
    {
        $danhmucs = DanhMuc::all(); // Lấy danh sách danh mục để chọn
        return view('quanlys.sanphams.create', compact('danhmucs'));
    }

    // Lưu sản phẩm mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        $request->validate([
            'tenSanPham' => 'required|max:100',
            'gia' => 'required|numeric|min:0',
            'soLuong' => 'required|integer|min:0',
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'hinhAnh.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate từng file
        ]);

        $imagePaths = [];
        if ($request->hasFile('hinhAnh')) {
            foreach ($request->file('hinhAnh') as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('uploads/sanpham'), $filename);
                $imagePaths[] = $filename; // Lưu đường dẫn ảnh vào mảng
            }
        }

        $sanpham = new SanPham();
        $sanpham->tenSanPham = $request->tenSanPham;
        $sanpham->moTa = $request->moTa;
        $sanpham->gia = $request->gia;
        $sanpham->soLuong = $request->soLuong;
        $sanpham->trangThai = $request->trangThai;
        $sanpham->danhmuc_id = $request->danhmuc_id;
        $sanpham->ngayTao = now();
        $sanpham->ngayCapNhat = now();
        $sanpham->hinhAnh = json_encode($imagePaths, JSON_UNESCAPED_SLASHES); // Lưu JSON ảnh
        $sanpham->save();

        return redirect()->route('quanlys.sanpham.index')->with('success', 'Thêm sản phẩm thành công.');
    }


    // Hiển thị chi tiết một sản phẩm
    public function show($id)
    {
        $sanpham = SanPham::with('danhMucs')->findOrFail($id);
        return view('quanlys.sanphams.chitietsanpham', compact('sanpham'));
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit($id)
    {
        $sanpham = SanPham::findOrFail($id);
        $danhmucs = DanhMuc::all();
        return view('quanlys.sanphams.edit', compact('sanpham', 'danhmucs'));
    }

    // Cập nhật sản phẩm trong cơ sở dữ liệu
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenSanPham' => 'required|max:100',
            'gia' => 'required|numeric|min:0',
            'soLuong' => 'required|integer|min:0',
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'hinhAnh.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate ảnh mới
        ]);

        $sanpham = SanPham::findOrFail($id);

        // Giải mã JSON để lấy danh sách ảnh cũ
        $imagePaths = json_decode($sanpham->hinhAnh, true) ?? [];

        // Xử lý xóa ảnh
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $image) {
                $filePath = public_path('uploads/sanpham/' . $image);
                if (file_exists($filePath)) {
                    unlink($filePath); // Xóa file trên server
                }

                // Xóa ảnh khỏi mảng
                $imagePaths = array_filter($imagePaths, fn($path) => $path !== $image);
            }
        }

        // Xử lý thêm ảnh mới
        if ($request->hasFile('hinhAnh')) {
            foreach ($request->file('hinhAnh') as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('uploads/sanpham'), $filename);
                $imagePaths[] = $filename; // Thêm đường dẫn ảnh mới
            }
        }

        // Cập nhật sản phẩm
        $sanpham->update([
            'tenSanPham' => $request->tenSanPham,
            'moTa' => $request->moTa,
            'gia' => $request->gia,
            'soLuong' => $request->soLuong,
            'trangThai' => $request->trangThai,
            'danhmuc_id' => $request->danhmuc_id,
            'hinhAnh' => json_encode(array_values($imagePaths), JSON_UNESCAPED_SLASHES), // Lưu JSON mới
            'ngayCapNhat' => now(),
        ]);

        return redirect()->route('quanlys.sanpham.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }


    // Xóa một sản phẩm khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        $sanpham = SanPham::findOrFail($id);

        // Xóa các file ảnh liên quan
        $imagePaths = json_decode($sanpham->hinhAnh, true);
        if ($imagePaths) {
            foreach ($imagePaths as $path) {
                $file = public_path('uploads/sanpham/' . $path);
                if (file_exists($file)) {
                    unlink($file); // Xóa file ảnh
                }
            }
        }

        $sanpham->delete();
        return redirect()->route('quanlys.sanpham.index')->with('success', 'Xóa sản phẩm thành công.');
    }

    //tim kiem

    public function search(Request $request)
    {
        $danhmucs= DanhMuc::all();
        $keyword = $request->input('q'); // Lấy từ khóa tìm kiếm
        $sanphams = SanPham::where('tenSanPham', 'like', '%' . $keyword . '%')->get();

        return view('taikhoans.khachhangs.timkiem', compact('sanphams', 'keyword','danhmucs'));
    }
    //dành cho admin
    public function searchAdmin(Request $request)
    {
        $danhmucs= Danhmuc::all();
        $keyword = $request->input('q'); // Lấy từ khóa tìm kiếm
        $sanphams = SanPham::where('tenSanPham', 'like', '%' . $keyword . '%')->get();

        return view('quanlys.sanphams.timkiems', compact('sanphams', 'keyword','danhmucs'));
    }
//hiển thị sản phẩm riêng danh mục
    public function showByCategory($id)
    {
        $danhmucs= DanhMuc::all();

        // Lấy danh mục theo ID
        $danhmucs1 = DanhMuc::find($id);
//dd($danhmucs1);
        // Lấy các sản phẩm của danh mục đó
        $sanphams = $danhmucs1 ? $danhmucs1->sanphams()->where('trangThai', 1)->get() : collect([]);

        return view('taikhoans.khachhangs.danhmuc', compact('sanphams', 'danhmucs1','danhmucs'));
    }

}
