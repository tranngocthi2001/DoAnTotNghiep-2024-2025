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


        // Kiểm tra sản phẩm đã tồn tại trong bảng liên kết chưa
        // Kiểm tra chi tiết giỏ hàng đã tồn tại chưa
        $chitietgiohang = $giohang->chitietgiohang()->whereHas('sanphams', function ($query) use ($sanpham) {
            $query->where('sanpham_id', $sanpham->id);
        })->first();

        if ($chitietgiohang) {
            // Nếu đã tồn tại, cập nhật số lượng và giá
            $chitietgiohang->soLuong += $request->soLuong;
            $chitietgiohang->gia = $sanpham->gia * $chitietgiohang->soLuong;
            $chitietgiohang->save();

            // Cập nhật bảng liên kết
            $chitietgiohang->sanphams()->updateExistingPivot($sanpham->id, [
                'soLuong' => $chitietgiohang->soLuong,
            ]);
        } else {
            // Nếu chưa tồn tại, thêm chi tiết giỏ hàng mới
            $chitietgiohang = $giohang->chitietgiohang()->create([
                'soLuong' => $request->soLuong,
                'gia' => $sanpham->gia * $request->soLuong,
            ]);

            // Thêm vào bảng liên kết
            $chitietgiohang->sanphams()->attach($sanpham->id, [
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
    public function destroy($sanpham_id)
{
    // Tìm sản phẩm cần xóa
    $sanpham = Sanpham::findOrFail($sanpham_id);
    //dd($sanpham); // Debug kiểm tra sản phẩm

    // Lấy giỏ hàng hiện tại
    //$giohang = Giohang::where('khachhang_id', auth()->user()->id)->first();
    $giohang = Giohang::firstOrCreate(
        ['khachhang_id' => auth()->user()->id],
        ['tongTien' => 0, 'tongSoLuong' => 0]
    );
    //dd($giohang); // Debug kiểm tra giỏ hàng

    if ($giohang) {
        foreach ($giohang->chitietgiohang as $chitiet) {
            //dd($chitiet); // Debug kiểm tra chi tiết giỏ hàng

            $sanphamLienKet = $chitiet->sanphams()->where('sanpham_id', $sanpham->id)->first();
            //dd($sanphamLienKet); // Debug kiểm tra sản phẩm liên kết

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

    return redirect()->route('giohang.index')->with('success', 'Tất cả sản phẩm liên quan đã được xóa khỏi giỏ hàng!');
}


    public function updateQuantity(Request $request, $sanpham_id)
    {
        $request->validate([
            'soLuong' => 'required|integer|min:1',
        ]);

        $sanpham = Sanpham::findOrFail($sanpham_id);

        $giohang = Giohang::firstOrCreate(
            ['khachhang_id' => auth()->user()->id],
            ['tongTien' => 0, 'tongSoLuong' => 0]
        );
        if ($giohang) {
            $chitiet = $giohang->chitietgiohang()->first();
            if ($chitiet) {
                $sanphamLienKet = $chitiet->sanphams()->where('sanpham_id', $sanpham->id)->first();

                if ($sanphamLienKet) {
                    // Cập nhật số lượng và tổng tiền
                    $chitiet->sanphams()->updateExistingPivot($sanpham->id, [
                        'soLuong' => $request->soLuong,
                    ]);

                    // Cập nhật tổng tiền và số lượng trong giỏ hàng
                    $giohang->tongSoLuong = $giohang->chitietgiohang->sum(function ($chitiet) {
                        return $chitiet->sanphams->sum('pivot.soLuong');
                    });

                    $giohang->tongTien = $giohang->chitietgiohang->sum(function ($chitiet) {
                        return $chitiet->sanphams->sum(function ($sanpham) {
                            return $sanpham->pivot->soLuong * $sanpham->gia;
                        });
                    });

                    $giohang->save();
                }
            }
        }

        return redirect()->route('giohang.index')->with('success', 'Số lượng sản phẩm đã được cập nhật!');
    }

}
