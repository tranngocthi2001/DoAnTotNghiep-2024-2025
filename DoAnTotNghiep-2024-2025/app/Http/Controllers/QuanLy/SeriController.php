<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\SanPham;
use App\Models\Seri;
use Illuminate\Http\Request;

class SeriController extends Controller
{
    public function index(){
        $seris = Seri::all();
        return view('quanlys.seris.seri', compact('seris'));

    }
    //dành cho admin
    public function searchAdmin(Request $request)
    {

        $keyword = $request->input('q'); // Lấy từ khóa tìm kiếm
        $seris = Seri::where('maSeri', 'like', '%' . $keyword . '%')->get();

        return view('quanlys.seris.timkiem', compact('seris', 'keyword'));
    }
}
