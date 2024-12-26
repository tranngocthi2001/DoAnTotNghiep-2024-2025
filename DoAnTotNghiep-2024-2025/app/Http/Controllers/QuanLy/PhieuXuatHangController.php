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
        //$nhanVien = Auth::guard('nhanvien')->user(); // Lấy thông tin nhân viên đang đăng nhập
        $nhanVien = auth()->guard('nhanvien')->user();
        //dd($nhanVien);

        $validated = $request->validate([
            'donhang_id' => 'required|exists:donhang,id',
            'ngayXuat' => 'required|date',
            'trangThai' => 'required|string',
            'chiTietDonHangs' => 'required|array',
            'chiTietDonHangs.*.chitietdonhang_id' => 'required|exists:chitietdonhang,id',
            'chiTietDonHangs.*.soLuong' => 'required|integer',
            'chiTietDonHangs.*.baoHanh' => 'nullable|string',
            'chiTietDonHangs.*.ghiChu' => 'nullable|string',
        ]);
        //$ngayXuat = \Carbon\Carbon::parse($request->ngayXuat)->format('Y-m-d H:i:s');
        //dd($request->ngayXuat);

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
        // Tìm phiếu xuất dựa trên donhang_id
        $phieuXuat = PhieuXuatHang::with('donHangs.khachHangs', 'nhanViens')
            ->where('donhang_id', $donhang_id)
            ->firstOrFail();

        // Tìm chi tiết phiếu xuất liên quan đến phiếu xuất
        $chiTietPhieuXuat = ChiTietPhieuXuat::where('phieuxuathang_id', $phieuXuat->id)->get();
//dd($chiTietPhieuXuat);
        // Tìm các mã seri liên quan đến từng chi tiết phiếu xuất
        $seri = Seri::whereIn('chitietphieuxuat_id', $chiTietPhieuXuat->pluck('id'))->get();
//dd($seri);
        // Hiển thị kết quả trong view
        return view('quanlys.phieuxuathangs.show', compact('phieuXuat', 'chiTietPhieuXuat', 'seri'));
    }


    public function print($id)
    {
        $phieuXuat = PhieuXuatHang::with('donHangs.khachHangs', 'nhanViens')->findOrFail($id);

        // Tùy chỉnh hiển thị giao diện in phiếu xuất
        return view('phieuxuathangs.print', compact('phieuXuat'));
    }
}
