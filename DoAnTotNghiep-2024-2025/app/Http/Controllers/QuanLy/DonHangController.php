<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\ChiTietDoiHang;
use App\Models\ChiTietDonHang;
use App\Models\ChiTietPhieuXuat;
use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\KhachHang;
use App\Models\PhieuXuatHang;
use App\Models\Sanpham;
use App\Models\YeuCauDoiHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelIgnition\Recorders\DumpRecorder\Dump;

class DonHangController extends Controller
{
    // Hiển thị danh sách đơn hàng dành cho nhân viên/admin
    public function indexAdmin()
    {

        $donHangCount=DonHang::all()->count();

        $donHang=DonHang::all();
        // $tongTien=DonHang::all()->sum('tongTien');
        // dump($tongTien);
        // $tong=0;
        // foreach($donHang as $dh)
        //     $tong+=$dh-> tongTien;
        //     dd($tongTien);

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
        $donHangsCuDaDoi = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'Đã chấp nhận đổi')
            ->orwhere('trangThai', '=', 'Từ chối đổi hàng')
            ->orderBy('id', 'desc')
            ->get();
        $donHangsDaDoi = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'Đang chờ nhận lại hàng')
            ->orderBy('id', 'desc')
            ->get();
        $donHangsChothanhtoan = DonHang::with('nhanViens')
        ->where('trangThai', '=', 'Chờ thanh toán')
        ->orderBy('ngayDatHang', 'desc')->get();
//dd($donHangsChothanhtoan);

        return view('quanlys.donhangs.donhang',
         compact('donHangsMoi', 'donHangsCu', 'donHangsHoanThanh',
         'donHangsHuy', 'donHangsDoi', 'donHangsVanChuyen',
         'donHangsChothanhtoan','donHangCount','donHangsDaDoi','donHangsCuDaDoi'));
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
        $donHangsDaDoi = DonHang::with('nhanViens')
            ->where('trangThai', '=', 'Đang chờ nhận lại hàng')
            ->orderBy('id', 'desc')
            ->get();

        return view('quanlys.yeucaudoihangs.yeucaudoihang', compact( 'donHangsDoi','donHangsDaDoi'));
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

    public function formcreate()
    {
        $khachHangs = KhachHang::all(); // Lấy danh sách khách hàng
        $sanPhams = SanPham::all(); // Lấy danh sách sản phẩm
        $danhmucs= DanhMuc::all();
        return view('quanlys.donhangs.create', compact('khachHangs', 'sanPhams','danhmucs'));
    }

    public function create(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'khachhang_id' => 'required|exists:khachhang,id',
            'diaChiGiaoHang' => 'required|string|max:255',
            'sdt' => ['required', 'digits:10'],
            'tenKhachHang' => 'required|string|max:255',
        ]);

        try {
            // Tạo đơn hàng mới
            $donHang = DonHang::create([
                'khachhang_id' => $validatedData['khachhang_id'],
                'nhanvien_id' => auth()->user()->id,
                'trangThai' => 'Đang xử lý',
                'diaChiGiaoHang' => $validatedData['diaChiGiaoHang'],
                'sdt' => $validatedData['sdt'],
                'ngayDatHang' => $validatedData['ngayDatHang'] ?? now(),
                'updated_by' => $validatedData['updated_by'] ?? now(),
                'phuongThucThanhToan' => 'Chưa có' ,
                'tenKhachHang' => $validatedData['tenKhachHang'],

                'tongTien'=>0
            ]);



            return redirect()->route('quanlys.donhang.show',[$donHang->id])
                            ->with('success', 'Đơn hàng được tạo thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function formAddChiTietDonHang($donHang_id)
    {
        $donHang=DonHang::where('id', $donHang_id)->first();
        //dd($donHang);
        $sanPhams = SanPham::all(); // Lấy danh sách sản phẩm
        $danhmucs= DanhMuc::all();
        return view('quanlys.donhangs.addchitiet', compact('sanPhams','danhmucs','donHang'));
    }

    public function xuLyThemChiTiet(Request $request, $id)
    {
        //dd($request);
        $sanPham = SanPham::findOrFail($request->sanpham_id);
        $donHang=DonHang::where('id', $id)->first();
        // Kiểm tra xem sản phẩm đã tồn tại trong chi tiết đơn hàng chưa
        $chiTietDonHang = ChiTietDonHang::where('donhang_id', $donHang->id)->first();
        if(!$chiTietDonHang){
            $chiTietDonHang = new ChiTietDonHang();
            $chiTietDonHang->donhang_id = $donHang->id;
            $chiTietDonHang->soLuong = $request->so_luong;
            $chiTietDonHang->gia = $chiTietDonHang->soLuong * $sanPham->gia;
            $chiTietDonHang->save();

            // Ghi vào bảng trung gian nếu có
            $sanPham->chiTietDonHangs()->attach($chiTietDonHang->id, [
                'soLuong' => $request->so_luong,
            ]);
            $donHang->tongTien += $chiTietDonHang->soLuong *$sanPham->gia;
            $donHang->save();
        }else{
            foreach($chiTietDonHang->sanPhams as $sanphams_has_Chitiet){
                //dump($sanphams_has_Chitiet);
                if ($sanphams_has_Chitiet->id==$sanPham->id) {
                    // Nếu đã tồn tại, tăng số lượng
                    $chiTietDonHang->soLuong += $request->so_luong;
                    $chiTietDonHang->gia = $chiTietDonHang->soLuong * $sanPham->gia;
                    $chiTietDonHang->save();
                    $donHang->tongTien = $chiTietDonHang->soLuong *$sanPham->gia;
                    $donHang->save();
                } else {
                    // Nếu chưa tồn tại, thêm mới
                    $chiTietDonHang = new ChiTietDonHang();
                    $chiTietDonHang->donhang_id = $donHang->id;
                    $chiTietDonHang->soLuong = $request->so_luong;
                    $chiTietDonHang->gia = $chiTietDonHang->soLuong * $sanPham->gia;
                    $chiTietDonHang->save();

                    // Ghi vào bảng trung gian nếu có
                    $sanPham->chiTietDonHangs()->attach($chiTietDonHang->id, [
                        'soLuong' => $request->so_luong,
                    ]);
                    $donHang->tongTien += $chiTietDonHang->soLuong *$sanPham->gia;
                    $donHang->save();
                    //dd($chiTietDonHang);
                }
            }
        }



        // $donHang->tongTien+=($chiTietDonHang->soLuong)*$sanPham->gia;
        // $donHang->save();
        return back()->with('success', 'Sản phẩm được thêm thành công!');
    }
    public function xoaChiTiet($id)
    {
        $chiTietDonHang = ChiTietDonHang::findOrFail($id);


        // Cập nhật tổng tiền trong đơn hàng
        $donHang = DonHang::findOrFail($chiTietDonHang->donhang_id);
        //dump($donHang);
        foreach($chiTietDonHang->sanPhams as $sanPham){
            $donHang->tongTien -= $chiTietDonHang->soLuong * $sanPham->gia;
            $donHang->save();

        }
        //$sanPham = SanPham::findOrFail($chiTietDonHang->sanPhams()->sanpham_id);
        //dd($donHang);
        //xóa sanpham trong sanpham_has_chitiet donhang
        $chiTietDonHang->sanPhams()->detach();

        // Xóa chi tiết đơn hàng
        $chiTietDonHang->delete();

        return back()->with('success', 'Chi tiết đơn hàng đã được xóa!');
    }
    public function capNhatSoLuong(Request $request, $id)
    {

        $request->validate([
            'so_luong' => 'required|integer|min:1',
        ]);

        $chiTietDonHang = ChiTietDonHang::findOrFail($id);
        // Tìm đơn hàng và sản phẩm
        $donHang = DonHang::findOrFail($chiTietDonHang->donhang_id);
        //dump($chiTietDonHang);

        foreach($chiTietDonHang->sanPhams as $sanPham){
            $donHang->tongTien -= $chiTietDonHang->soLuong * $sanPham->gia;
            $chiTietDonHang->soLuong = $request->so_luong;
            $chiTietDonHang->gia= $chiTietDonHang->soLuong * $sanPham->gia;
            $chiTietDonHang->save();

        }
        // Cập nhật tổng tiền
        foreach($chiTietDonHang->sanPhams as $sanPham){
            $donHang->tongTien+= $chiTietDonHang->soLuong*$sanPham->gia;
            $donHang->save();
        }
        return back()->with('success', 'Số lượng sản phẩm đã được cập nhật!');
    }



}
