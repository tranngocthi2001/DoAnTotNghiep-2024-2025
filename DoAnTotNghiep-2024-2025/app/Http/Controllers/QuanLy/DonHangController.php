<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\Sanpham;
use App\Models\YeuCauDoiHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\GHNService;

class DonHangController extends Controller
{
    // Hiển thị danh sách đơn hàng dành cho nhân viên/admin
    public function indexAdmin()
    {
        // Lấy thông tin người dùng từ guard 'nhanvien'
        $user = auth()->guard('nhanvien')->user();
//dd($user);
        // Kiểm tra quyền truy cập
        $nhanVien = auth()->guard('nhanvien')->user();

        if ($nhanVien->vaiTro !== 'admin' && $nhanVien->vaiTro !== 'quanly') {
            return redirect()->route('unauthorized');
       }

        // Lấy danh sách đơn hàng kèm thông tin nhân viên xử lý
        $donHangsMoi = DonHang::with('nhanViens')
            ->where('trangThai', 'Chưa xác nhận')
            ->orderBy('ngayDatHang', 'desc')
            ->get();

        $donHangsCu = DonHang::with('nhanViens')
            ->where('trangThai', '!=', 'Chưa xác nhận')
            ->orderBy('ngayDatHang', 'desc')
            ->get();
        $donHangsHoanThanh = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'đã hoàn thành')
            ->orderBy('ngayDatHang', 'desc')
            ->get();
        $donHangsHuy = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'đã hủy')
            ->orderBy('ngayDatHang', 'desc')
            ->get();
        $donHangsDoi = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'Đổi hàng')
            ->orderBy('ngayDatHang', 'desc')
            ->get();


        return view('quanlys.donhangs.donhang',
         compact('donHangsMoi', 'donHangsCu', 'donHangsHoanThanh','donHangsHuy', 'donHangsDoi'));
    }


    // Cập nhật trạng thái đơn hàng
    public function update(Request $request, $id)
    {
        $request->validate([
            'trangThai' => 'required',
            'maVanChuyen' => 'nullable|string|max:50',

        ]);

       // Tìm đơn hàng theo ID
        $donhang = DonHang::findOrFail($id);

        // Lấy ID nhân viên hiện tại từ guard `nhanvien`
        $nhanvienId = Auth::guard('nhanvien')->id();
//dd($nhanvienId);
        // Cập nhật trạng thái đơn hàng và lưu nhân viên thực hiện
        $donhang->update([
            'trangThai' => $request->input('trangThai'),
            'nhanvien_id' => $nhanvienId,
            'maVanChuyen' => $request->input('maVanChuyen') ?: $donhang->maVanChuyen, // Không ghi đè mã vận chuyển nếu không có giá trị mới

        ]);
//
// Nếu mã vận chuyển được cập nhật, gửi đến API GHN để đồng bộ trạng thái
        //if ($donhang->maVanChuyen) {
            //$ghnService = new GHNService(); // Service xử lý API GHN
            //$result = $ghnService->trackOrder($donhang->maVanChuyen);

            // Kiểm tra kết quả từ API
            // if ($result && isset($result['status'])) {
            //     // Cập nhật trạng thái đơn hàng từ GHN
            //     $donhang->trangThai = $result['status'];
            //     $donhang->save();
            // } else {
            //     return back()->withErrors(['msg' => 'Không thể lấy trạng thái từ GHN']);
            // }
        //}
        return redirect()->route('quanlys.donhang.indexAdmin')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }
    protected $ghnService;

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        // Tìm đơn hàng với id
        $donHang = DonHang::with('chiTietDonHangs')->findOrFail($id);
        //dd($donHang->chiTietDonHangs);

        // Lấy thông tin khách hàng qua quan hệ khachhang_id
        $khachHang = $donHang->khachHangs;
        //dd($donHang->khachHangs);
        //$orderCode = $donHang->maVanChuyen; // Giả sử bạn có trường mã vận chuyển
        // Kiểm tra xem yêu cầu đổi hàng có tồn tại không
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
}            // Trả về view với thông tin đơn hàng và tên khách hàng
        return view('quanlys.donhangs.show', compact('donHang', 'khachHang', 'yeuCauDoiHang'));
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
//---------

}
