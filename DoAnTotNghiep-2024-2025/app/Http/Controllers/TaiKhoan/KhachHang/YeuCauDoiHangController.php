<?php
namespace App\Models;

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Models\DonHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\YeuCauDoiHang;
use App\Models\ChiTietDoiHang;
use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Support\Facades\Validator;

class YeuCauDoiHangController extends Controller
{
    // Phương thức hiển thị form đổi hàng
    public function showForm($donhang_id)
    {
        $danhmucs = DanhMuc::all();

        // Lấy thông tin đơn hàng và các chi tiết sản phẩm trong đơn hàng
        $donhang = DonHang::with('chiTietDonHangs.sanphams')->findOrFail($donhang_id);

        // Trả về view để hiển thị form
        return view('taikhoans.khachhangs.yeucaudoihang', compact('donhang','danhmucs'));
    }
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'sanPhamDoiID'  => 'nullable|array', // Không bắt buộc chọn sản phẩm
            'sanPhamDoiID.*' => 'exists:sanpham,id', // kiểm tra từng phần tử trong mảng sanPhamDoiID
                                                    //để đảm bảo rằng giá trị của nó tồn tại trong cột id của bảng sanpham
            'lyDo' => 'required|string', // Lý do đổi
            'soLuong' => 'nullable|array', // Không bắt buộc chọn số lượng
            'soLuong.*' => 'nullable|integer|min:1', // Kiểm tra số lượng nếu có
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

            $imagePaths = [];
            if ($request->hasFile('hinhAnh')) {
                foreach ($request->file('hinhAnh') as $sanPhamDoiID => $file) {
                    // Tạo tên file duy nhất để tránh trùng lặp
                    $imageName = time() . '-' . $file->getClientOriginalName();
                    // Lưu file vào thư mục yêu cầu
                    $file->move(public_path('uploads/yeucau_doi_hang'), $imageName);
                    // Lưu đường dẫn file vào mảng imagePaths
                    $imagePaths[] = $imageName;
                }
            }

            // Gán giá trị mảng chứa tên các ảnh vào cột `hinhAnh` của ChiTietDoiHang
            $chiTietDoiHang->hinhAnh = json_encode($imagePaths);
            $chiTietDoiHang->save();

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
            // Kiểm tra nếu không tìm thấy yêu cầu đổi hàng
            if (!$yeuCauDoiHang) {
                return redirect()->route('taikhoans.khachhangs.yeucaudoihang.index')->with('error', 'Yêu cầu đổi hàng không tồn tại.');
            }
            $danhmucs=DanhMuc::all();

            return view('taikhoans.khachhangs.ycdoihangshow', compact('yeuCauDoiHang', 'sanPhams','danhmucs'));
        }

        public function showAdmin($id)
        {
            $yeuCauDoiHang = YeuCauDoiHang::with('chitietdoihangs')->findOrFail($id); // Lấy yêu cầu đổi hàng cùng các chi tiết

            $sanPhams= SanPham::all();

            if (!$yeuCauDoiHang) {
                return redirect()->back()->with('error', 'Yêu cầu đổi hàng không tồn tại!');
            }
            return view('quanlys.yeucaudoihangs.ycdoihangshow', compact('yeuCauDoiHang', 'sanPhams'));
        }

        public function updateStatus(Request $request, $id)
        {
            // Tìm yêu cầu đổi hàng theo id
            $yeuCauDoiHang = YeuCauDoiHang::find($id);

            if (!$yeuCauDoiHang) {
                return redirect()->back()->with('error', 'Yêu cầu đổi hàng không tồn tại!');
            }

            // Kiểm tra dữ liệu trạng thái
            $request->validate([
                'trangThai' => 'required|in:0,1,2', // Trạng thái có thể là 0, 1, hoặc 2 (ví dụ: 0: Chưa xử lý, 1: Đang xử lý, 2: Hoàn tất)
            ]);

            // Cập nhật trạng thái của yêu cầu đổi hàng
            $yeuCauDoiHang->trangThai = $request->input('trangThai');
            $yeuCauDoiHang->save();

            return redirect()->route('taikhoans.khachhangs.yeucaudoihang.showAdmin', $yeuCauDoiHang->id)
                             ->with('success', 'Cập nhật trạng thái thành công!');
        }

}
