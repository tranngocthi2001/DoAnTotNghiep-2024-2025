<?php
namespace App\Http\Controllers\TrangChu;

use App\Http\Controllers\Controller;

use App\Models\Danhmuc;
use App\Models\Khachhang;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $khachhang=Khachhang::where('id',auth()->user()->id)->first();

        // Lấy tất cả danh mục và sản phẩm liên quan

        $danhmucs = DanhMuc::where('trangThai', 1) // Lọc danh mục có trạng thái 1
        ->with(['sanphams' => function ($query) {
            $query->where('trangThai', 1); // Lọc sản phẩm có trạng thái 1
        }])
    ->get();

        //dd($danhmucs);
        return view('home', compact('danhmucs'));
    }
     // Trang dành cho guest
     public function guest()
     {
         // Lấy dữ liệu dành cho guest

         $danhmucs = DanhMuc::where('trangThai', 1) // Lọc danh mục có trạng thái 1
        ->with(['sanphams' => function ($query) {
            $query->where('trangThai', 1); // Lọc sản phẩm có trạng thái 1
        }])
    ->get(); // Ví dụ lấy danh mục và sản phẩm
         return view('homeguest', compact('danhmucs'));
     }
}
