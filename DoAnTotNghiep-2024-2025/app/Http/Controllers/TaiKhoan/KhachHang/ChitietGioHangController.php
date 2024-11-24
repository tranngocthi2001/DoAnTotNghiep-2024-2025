<?php

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use Illuminate\Http\Request;
use App\Models\Giohang;
use App\Models\ChitietGiohang;
use App\Models\Sanpham;
use App\Http\Controllers\Controller;

class ChiTietGioHangController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'sanpham_id' => 'required|exists:sanpham,id',
            'soLuong' => 'required|integer|min:1',
        ]);

        $khachhangId = auth()->id();
        $sanpham = Sanpham::findOrFail($request->sanpham_id);

        // Lấy giỏ hàng của khách hàng hoặc tạo mới
        $giohang = Giohang::where('khachhang_id', auth()->user()->id)->first();
        if (!$giohang) {
            $giohang = Giohang::create([
                'khachhang_id' => $khachhangId,
                'tongTien' => 0,
                'tongSoLuong' => 0,
            ]);
        }

        // Kiểm tra sản phẩm đã tồn tại trong bảng liên kết chưa
        $chitiet = $giohang->chitietgiohang()->first();
        $sanphamLienKet = $chitiet ? $chitiet->sanphams()->where('sanpham_id', $sanpham->id)->first() : null;

        if ($sanphamLienKet) {
            // Nếu đã tồn tại, cập nhật số lượng trong bảng liên kết
            $chitiet->sanphams()->updateExistingPivot($sanpham->id, [
                'soLuong' => $sanphamLienKet->pivot->soLuong + $request->soLuong,
            ]);
        } else {
            // Nếu chưa tồn tại, thêm mới vào bảng liên kết
            $chitiet = $giohang->chitietgiohang()->firstOrCreate([]);
            $chitiet->sanphams()->attach($sanpham->id, [
                'soLuong' => $request->soLuong,
            ]);
        }

        // Cập nhật tổng số lượng và tổng tiền giỏ hàng
        $giohang->tongSoLuong += $request->soLuong;
        $giohang->tongTien += $sanpham->gia * $request->soLuong;
        $giohang->save();

        return redirect()->route('giohang.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function destroy(Request $request)
    {
        $request->validate([
            'sanpham_id' => 'required|exists:sanpham,id',
        ]);

        $sanpham = Sanpham::findOrFail($request->sanpham_id);
        $giohang = Giohang::where('khachhang_id', auth()->id())->first();

        if ($giohang) {
            $chitiet = $giohang->chitietgiohang()->first();
            if ($chitiet) {
                $sanphamLienKet = $chitiet->sanphams()->where('sanpham_id', $sanpham->id)->first();

                if ($sanphamLienKet) {
                    // Cập nhật tổng số lượng và tổng tiền giỏ hàng
                    $giohang->tongSoLuong -= $sanphamLienKet->pivot->soLuong;
                    $giohang->tongTien -= $sanphamLienKet->pivot->soLuong * $sanpham->gia;
                    $giohang->save();

                    // Xóa sản phẩm khỏi bảng liên kết
                    $chitiet->sanphams()->detach($sanpham->id);
                }
            }
        }

        return redirect()->route('giohang.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }
}
