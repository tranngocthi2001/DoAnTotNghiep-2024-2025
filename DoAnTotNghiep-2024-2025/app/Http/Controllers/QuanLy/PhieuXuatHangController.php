<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PhieuXuatHang;
use App\Models\NhanVien;
use App\Models\ChiTietPhieuXuat;
use App\Models\ChiTietDonHang;
use App\Models\Seri;

class PhieuXuatHangController extends Controller
{
    public function create(Request $request, $donHangId)
    {
        $donHang = DonHang::with('chiTietDonHangs.sanPhams')->findOrFail($donHangId);
// Lấy thông tin người dùng từ guard 'nhanvien'
        $user = auth()->guard('nhanvien')->user();
//dd($donHang);
        return view('quanlys.phieuxuathangs.phieuxuat', compact('donHang'));
    }

    public function store(Request $request)
    {
        // Tạo phiếu xuất hàng
        $phieuXuat = PhieuXuatHang::create([
            'donhang_id' => $request->donhang_id,
            'ngayXuat' => $request->ngayXuat,
            'trangThai' => $request->trangThai,
            'nhanvien_id' => Auth::id(),
        ]);
        //dd($phieuXuat);
        // Tạo chi tiết phiếu xuất
        foreach ($request->chiTietDonHangs as $chiTiet) {
            // Lấy chi tiết đơn hàng
            $chiTietDonHang = ChiTietDonHang::with('sanPhams')->findOrFail($chiTiet['chitietdonhang_id']);
            $chiTietPhieuXuat = ChiTietPhieuXuat::create([
                'soLuong' => $chiTietDonHang->soLuong,
                'baoHanh' => $chiTiet['baoHanh'],
                'ghiChu' => $chiTiet['ghiChu'],
                'chitietdonhang_id' => $chiTiet['chitietdonhang_id'],
                'phieuxuathang_id' => $phieuXuat->id,
                'yeucautrahang_id' => null, // Đặt mặc định là NULL
                'yeucaudoihang_id' => null, // Đặt mặc định là NULL
            ]);

            // Lưu các mã seri cho từng chi tiết phiếu xuất
            if (isset($chiTiet['seri'])) {
                foreach ($chiTiet['seri'] as $seri) {
                    // Tạo seri cho chi tiết phiếu xuất
                    \App\Models\Seri::create([
                        'chitietphieuxuat_id' => $chiTietPhieuXuat->id,
                        'maSeri' => $seri,
                    ]);
                }
            }
            // dd($sanPham->sanPhams->tenSanPham);
        }
        //dd($phieuXuat);
        return redirect()->route('quanlys.donhang.show', $request->donhang_id)->with('success', 'Phiếu xuất hàng đã được tạo!');
    }

    public function show($donhang_id)
    {

        $phieuXuatHang=PhieuXuatHang::where('donhang_id',$donhang_id)->first();

        return view('quanlys.phieuxuathangs.show', compact('phieuXuatHang'));
    }


    public function print($id)
    {
        $phieuXuat = PhieuXuatHang::with('donHangs.khachHangs', 'nhanViens')->findOrFail($id);

        // Tùy chỉnh hiển thị giao diện in phiếu xuất
        return view('phieuxuathangs.print', compact('phieuXuat'));
    }
}
