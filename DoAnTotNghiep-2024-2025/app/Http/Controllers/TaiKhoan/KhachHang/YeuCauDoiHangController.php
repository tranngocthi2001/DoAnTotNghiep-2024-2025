<?php
namespace App\Models;

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Models\DonHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\YeuCauDoiHang;
use App\Models\ChiTietDoiHang;
use App\Models\SanPham;
use Illuminate\Support\Facades\Validator;

class YeuCauDoiHangController extends Controller
{
    // Phương thức hiển thị form đổi hàng
    public function showForm($donhang_id)
    {
        // Lấy thông tin đơn hàng và các chi tiết sản phẩm trong đơn hàng
        $donhang = DonHang::with('chiTietDonHangs.sanphams')->findOrFail($donhang_id);

        // Trả về view để hiển thị form
        return view('taikhoans.khachhangs.yeucaudoihang', compact('donhang'));
    }
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'sanPhamDoiID' => 'required|array', // Kiểm tra nếu khách hàng đã chọn sản phẩm
            'sanPhamDoiID.*' => 'exists:sanpham,id', // Kiểm tra từng ID sản phẩm có hợp lệ trong bảng sanpham
            'lyDo' => 'required|string', // Lý do đổi
            'soLuong' => 'required|array',
            'soLuong.*' => 'integer|min:1',
            'hinhAnh.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        //dd($request);
            $yeuCauDoiHang=YeuCauDoiHang::create([
                'ngayYeuCau' => now(),
                'lyDo' => $request->input('lyDo'),
                'trangThai' => 0,
            ]);
//dd($yeuCauDoiHang);
        // Lặp qua từng sản phẩm được chọn và tạo chi tiết đổi hàng
        foreach ($request->sanPhamDoiID as $sanPhamDoiID) {
            $chiTietDoiHang = new ChiTietDoiHang();
            //dd( $chiTietDoiHang = new ChiTietDoiHang());
            $chiTietDoiHang->yeucaudoihang_id = $yeuCauDoiHang->id;
//dd($chiTietDoiHang->yeucaudoihang_id);
            $chiTietDoiHang->sanPhamDoiID = $sanPhamDoiID;
            //dd($chiTietDoiHang->sanPhamDoiID);
            $chiTietDoiHang->soLuong = $request->soLuong[$sanPhamDoiID]; // Lấy số lượng từ input
            //$chiTietDoiHang->hinhAnh = $request->hinhAnh ? $request->file('hinhAnh')->store('images') : null; // Nếu có ảnh, lưu ảnh
            if (isset($request->hinhAnh[$sanPhamDoiID])) {
                $file = $request->file('hinhAnh')[$sanPhamDoiID];
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('upload/yeucau_doi_hang', $imageName);
                $chiTietDoiHang->hinhAnh = $imageName;
            }

//dd($chiTietDoiHang);
            $chiTietDoiHang->save();
        }
        // Cập nhật trạng thái đơn hàng thành "Đổi hàng"
        $donHang = DonHang::find($request->donhang_id); // Lấy đơn hàng liên quan
        if ($donHang) {
            $donHang->trangThai = 'Đổi hàng'; // Cập nhật trạng thái
            $donHang->save(); // Lưu thay đổi trạng thái
        }

        // Cập nhật yeucaudoihang_id trong bảng ChiTietPhieuXuat
        foreach ($donHang->chiTietDonHangs as $chiTietDonHang) {
            foreach ($chiTietDonHang->chiTietPhieuXuats as $chiTietPhieuXuat) {
                // Cập nhật yeucaudoihang_id cho từng ChiTietPhieuXuat
                $chiTietPhieuXuat->yeucaudoihang_id = $yeuCauDoiHang->id;
                $chiTietPhieuXuat->save(); // Lưu thay đổi
            }
        }

        // Chuyển hướng đến trang chi tiết yêu cầu đổi hàng hoặc trang khác
        return redirect()->route('taikhoans.khachhangs.yeucaudoihang.show', $yeuCauDoiHang->id);
    }

    public function show($id)
        {
            $yeuCauDoiHang = YeuCauDoiHang::with('chitietdoihangs')->findOrFail($id); // Lấy yêu cầu đổi hàng cùng các chi tiết

            $sanPhams= SanPham::all();
           //dd($sanPham);
            //dd($yeuCauDoiHang);
            // Lấy yêu cầu đổi hàng và các chi tiết liên quan đến đơn hàng
             // Lấy yêu cầu đổi hàng cùng các chi tiết liên quan đến đơn hàng
            // $yeuCauDoiHang = YeuCauDoiHang::with('chitietphieuxuat.chitietdonhang.sanPham') // Eager load chi tiết phieu xuất và chi tiết đơn hàng
            // ->findOrFail($id);
            //dd($yeuCauDoiHang);
            // Kiểm tra nếu không tìm thấy yêu cầu đổi hàng
            if (!$yeuCauDoiHang) {
                return redirect()->route('taikhoans.khachhangs.yeucaudoihang.index')->with('error', 'Yêu cầu đổi hàng không tồn tại.');
            }
            return view('taikhoans.khachhangs.ycdoihangshow', compact('yeuCauDoiHang', 'sanPhams'));
        }


}
