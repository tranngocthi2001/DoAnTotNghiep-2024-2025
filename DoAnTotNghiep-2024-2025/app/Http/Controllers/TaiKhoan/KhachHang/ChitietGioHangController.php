<?php

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use Illuminate\Http\Request;
use App\Models\GioHang;
use App\Models\ChitietGiohang;
use App\Models\SanPham;
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
        $sanpham = SanPham::findOrFail($request->sanpham_id);

        // Lấy giỏ hàng của khách hàng hoặc tạo mới
        $giohang = Giohang::where('khachhang_id', auth()->user()->id)->first();

         // Kiểm tra số lượng sản phẩm trong kho và số lượng khách hàng muốn thêm
        $soLuongYeuCau = $request->input('soLuong');

        if ($sanpham->soLuong < $soLuongYeuCau) {
            // Nếu số lượng trong kho không đủ, trả về thông báo lỗi
            return redirect()->route('khachhang.dashboard')->withErrors('Sản phẩm "' . $sanpham->tenSanPham  . '" không đủ số lượng, trong kho chỉ còn:'. $sanpham->soLuong);
        }

        // Kiểm tra sản phẩm đã tồn tại trong bảng liên kết chưa
        $chitietgiohang = $giohang->chiTietGioHangs()->whereHas('sanPhams', function ($query) use ($sanpham) {
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
            $chitietgiohang = $giohang->chiTietGioHangs()->create([
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

        return back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function destroy($sanpham_id)
    {
        // Tìm sản phẩm cần xóa
        $sanpham = Sanpham::findOrFail($sanpham_id);

        // Lấy giỏ hàng hiện tại
        $giohang = Giohang::firstOrCreate(
            ['khachhang_id' => auth()->user()->id],
            ['tongTien' => 0, 'tongSoLuong' => 0]
        );

        if ($giohang) {
            foreach ($giohang->chiTietGioHangs as $chitiet) {
                // Tìm sản phẩm trong bảng pivot
                $sanphamLienKet = $chitiet->sanphams()->where('sanpham_id', $sanpham->id)->first();

                if ($sanphamLienKet) {
                    // Cập nhật tổng số lượng và tổng tiền giỏ hàng
                    $giohang->tongSoLuong -= $sanphamLienKet->pivot->soLuong;
                    $giohang->tongTien -= $sanphamLienKet->pivot->soLuong * $sanpham->gia;
                    $giohang->save();

                    // Xóa sản phẩm khỏi bảng liên kết
                    $chitiet->sanphams()->detach($sanpham->id);

                    // Kiểm tra nếu chi tiết giỏ hàng không còn sản phẩm liên kết
                    if ($chitiet->sanphams()->count() === 0) {
                        // Xóa bản ghi chi tiết giỏ hàng
                        $chitiet->delete();
                    }
                }
            }
        }

        return redirect()->route('giohang.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }


    public function updateQuantity(Request $request, $sanpham_id)
    {
        $request->validate([
            'soLuong' => 'required|integer|min:1',
        ]);

        $sanpham = Sanpham::findOrFail($sanpham_id);
//dd($sanpham);
        $giohang = Giohang::firstOrCreate(
            ['khachhang_id' => auth()->user()->id],
            ['tongTien' => 0, 'tongSoLuong' => 0]
        );
        //KIỂM TRA SỐ LƯỢNG TRONG KHO
        $soLuongMoi = $request->input('soLuong');

        if ($sanpham->soLuong < $soLuongMoi) {
            return redirect()->route('giohang.index')->withErrors('Sản phẩm "' . $sanpham->tenSanPham  . '" không đủ số lượng, trong kho chỉ còn:'. $sanpham->soLuong);
        }
//dd($giohang);
        if ($giohang) {
            // Lấy tất cả chi tiết giỏ hàng
            $chiTietGioHangs = $giohang->chiTietGioHangs()->get(); // Trả về danh sách tất cả chi tiết giỏ hàng

            foreach ($chiTietGioHangs as $chitiet) {
                // Tìm sản phẩm trong chi tiết giỏ hàng
                $sanphamLienKet = $chitiet->sanPhams()->where('sanpham_id', $sanpham->id)->first();

                if ($sanphamLienKet) {
                    // Cập nhật số lượng sản phẩm trong bảng pivot
                    $chitiet->sanPhams()->updateExistingPivot($sanpham->id, [
                        'soLuong' => $request->soLuong,
                    ]);
                    // Cập nhật soLuong trực tiếp trên bảng chitietgiohang
                    $chitiet->update([
                        'soLuong' => $request->soLuong,
                    ]);

                    // Tính toán lại tổng số lượng và tổng tiền
                    $tongSoLuong = $giohang->chiTietGioHangs->sum(function ($chitiet) {
                        return $chitiet->sanPhams->sum('pivot.soLuong');
                    });

                    $tongTien = $giohang->chiTietGioHangs->sum(function ($chitiet) {
                        return $chitiet->sanPhams->sum(function ($sanpham) {
                            return $sanpham->pivot->soLuong * $sanpham->gia;
                        });
                    });

                    // Cập nhật giỏ hàng
                    $giohang->tongSoLuong = $tongSoLuong;
                    $giohang->tongTien = $tongTien;
                    $giohang->save();

                    // Kết thúc xử lý sau khi tìm thấy sản phẩm
                    break;
                }
            }
        }
        return redirect()->route('giohang.index')->with('success', 'Số lượng sản phẩm đã được cập nhật!');
    }

}
