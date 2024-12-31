<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\ChiTietPhieuXuat;
use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\PhieuXuatHang;
use App\Models\Sanpham;
use App\Models\YeuCauDoiHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DonHangController extends Controller
{
    // Hiển thị danh sách đơn hàng dành cho nhân viên/admin
    public function indexAdmin()
    {

        $donHangCount=DonHang::all()->count();

        // Kiểm tra quyền truy cập
        $nhanVien = auth()->guard('nhanvien')->user();

        if ($nhanVien->vaiTro !== 'admin' && $nhanVien->vaiTro !== 'quanly') {
            return redirect()->route('unauthorized');
       }

        // Lấy danh sách đơn hàng kèm thông tin nhân viên xử lý
        $donHangsMoi = DonHang::with('nhanViens')
            ->where('trangThai', 'COD')
            ->orwhere('trangThai', 'Đã thanh toán')
            ->orderBy('ngayDatHang', 'desc')
            ->get();
           // dd($donHangsMoi);
        $donHangsCu = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'Đang xử lý')
            ->orderBy('ngayDatHang', 'desc')
            ->get();
        $donHangsVanChuyen = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'Đã giao cho đơn vị vận chuyển')
            ->orderBy('ngayDatHang', 'desc')
            ->get();
            //dd($donHangsCu);
        $donHangsHoanThanh = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'đã hoàn thành')
            ->orderBy('ngayDatHang', 'desc')
            ->get();
        $donHangsHuy = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'đã hủy')
            ->orwhere('trangThai', '=', 'Chờ xác nhận hủy')
            ->orderBy('ngayDatHang', 'desc')
            ->get();
        $donHangsDoi = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'Đổi hàng')
            ->orderBy('ngayDatHang', 'desc')
            ->get();
        $donHangsChothanhtoan = DonHang::with('nhanViens')
        ->where('trangThai', '=', 'Chờ thanh toán')
        ->orderBy('ngayDatHang', 'desc')->get();
//dd($donHangsChothanhtoan);

        return view('quanlys.donhangs.donhang',
         compact('donHangsMoi', 'donHangsCu', 'donHangsHoanThanh',
         'donHangsHuy', 'donHangsDoi', 'donHangsVanChuyen','donHangsChothanhtoan','donHangCount'));
    }

    public function showYeuCauDoiHang()
    {
        // Lấy thông tin người dùng từ guard 'nhanvien'
        $user = auth()->guard('nhanvien')->user();
//dd($user);
        // Kiểm tra quyền truy cập
        $nhanVien = auth()->guard('nhanvien')->user();


        $donHangsDoi = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'Đổi hàng')
            ->orderBy('ngayDatHang', 'desc')
            ->get();


        return view('quanlys.yeucaudoihangs.yeucaudoihang', compact( 'donHangsDoi'));
    }


    // Cập nhật trạng thái đơn hàng
    public function update(Request $request, $id)
    {
        $request->validate([
            'trangThai' => 'nullable',
            'maVanChuyen' => 'nullable|string|max:50',

        ]);

       // Tìm đơn hàng theo ID
        $donhang = DonHang::findOrFail($id);

        // Lấy ID nhân viên hiện tại từ guard `nhanvien`
        $nhanvienId = Auth::guard('nhanvien')->id();
//dd($nhanvienId);
        // Cập nhật trạng thái đơn hàng và lưu nhân viên thực hiện
        $donhang->update([
            'trangThai' => $request->input('trangThai')?: $donhang->trangThai,

            'nhanvien_id' => $nhanvienId,
            'maVanChuyen' => $request->input('maVanChuyen') ?: $donhang->maVanChuyen, // Không ghi đè mã vận chuyển nếu không có giá trị mới

        ]);

        return redirect()->route('quanlys.donhang.show',[$donhang->id])->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        // Tìm đơn hàng với id
        $donHang = DonHang::with('chiTietDonHangs')->findOrFail($id);
        //dd($donHang->chiTietDonHangs);
        // Lấy thông tin khách hàng qua quan hệ khachhang_id
        $khachHang = $donHang->khachHangs;
// Kiểm tra xem yêu cầu đổi hàng có tồn tại trong các chi tiết đơn hàng hay không
        $yeuCauDoiHang = null;
        foreach ($donHang->chiTietDonHangs as $chiTietDonHang) {
            //dd($donHang);
            foreach ($chiTietDonHang->chiTietPhieuXuats as $chiTietPhieuXuat) {
                //dd($chiTietDonHang);
                if ($chiTietPhieuXuat->yeucaudoihang_id) {
                    //dd($chiTietPhieuXuat);
                    $yeuCauDoiHang = $chiTietPhieuXuat->yeucaudoihang;  // Lấy yêu cầu đổi hàng từ mối quan hệ
                    //break 2;  // Dừng vòng lặp khi đã tìm thấy yêu cầu đổi hàng
                }
            }//dd($yeuCauDoiHang);
        }
        $phieuXuatHang=PhieuXuatHang::where('donhang_id', $donHang->id)->first();
       // dd($phieuXuatHang);

        // Trả về view với thông tin đơn hàng và tên khách hàng
        return view('quanlys.donhangs.show', compact('donHang', 'khachHang', 'yeuCauDoiHang','phieuXuatHang'));
    }

    // Xác nhận đơn hàng
    public function xacNhanDonHang($id)
    {
        $donHang = DonHang::findOrFail($id);
        $donHang->update([
            'nhanvien_id' => auth()->id(),
            'trangThai' => 'Đã xác nhận',
        ]);

        return redirect()->route('nhanvien.donhang.indexAdmin')->with('success', 'Đơn hàng đã được xác nhận.');
    }

    public function timKiemDonHang(Request $request){

        $danhmucs=DanhMuc::all();
        $keyword= $request->input('q');
        $donHangs=DonHang::where('id', '=', $keyword)->get();
        //dd($donHangs);
        if($request->input('q')=='')
            return back()->with('loikhongtimthay','Vui lòng nhập từ khóa để tìm kiếm');
        if($donHangs->isEmpty())
            return back()->with('loikhongtimthay','Không tim thấy đơn hàng');

        return view('quanlys.donhangs.timkiem', compact('danhmucs','keyword','donHangs'));
    }

}
