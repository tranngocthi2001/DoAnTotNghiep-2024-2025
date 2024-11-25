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
//dd($khachhang);
        // Lấy tất cả danh mục và sản phẩm liên quan
        $danhmucs = Danhmuc::with('sanphams')->get();
        //dd($danhmucs);
        return view('home', compact('danhmucs'));
    }
     // Trang dành cho guest
     public function guest()
     {
         // Lấy dữ liệu dành cho guest
         $danhmucs = DanhMuc::with('sanphams')->get(); // Ví dụ lấy danh mục và sản phẩm
         return view('homeguest', compact('danhmucs'));
     }
}
