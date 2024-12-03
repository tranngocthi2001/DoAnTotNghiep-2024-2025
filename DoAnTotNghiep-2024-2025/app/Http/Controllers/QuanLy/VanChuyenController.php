<?php
namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\DonHang;
use App\Models\VanChuyen;
use Illuminate\Http\Request;

class VanChuyenController extends Controller
{
    public function index($donhang_id)
    {
        // $donhang=DonHang::all();
        // dd($donhang);
        // Lấy đơn hàng theo donhang_id (sử dụng phương thức with để lấy quan hệ 'vanChuyen')
        $donhang = DonHang::with('vanChuyen')->findOrFail($donhang_id);
        $vanchuyen = VanChuyen::where('donhang_id', $donhang_id)->first();
//dd($donhang);
        // Lấy tất cả các vận chuyển (VanChuyen) liên quan đến donhang_id
        //$vanchuyens = $donhang->vanChuyen;  // Đây sẽ là một collection
//dd($vanchuyen);
        // Kiểm tra nếu không có dữ liệu vận chuyển
        if ($vanchuyen===null) {
            $message = 'Không có thông tin vận chuyển cho đơn hàng này.';
        } else {
            $message = null;
        }


        // Trả về view với dữ liệu vanchuyens và thông điệp nếu có
        return view('quanlys.vanchuyens.index', compact('vanchuyen', 'donhang', 'message'));
    }




    public function show($id)
    {
        // Lấy dữ liệu theo id
        $vanchuyen = VanChuyen::findOrFail($id);
        return view('vanchuyens.show', compact('vanchuyen'));
    }

    public function create(Request $request)
    {
        // Lấy tham số donhang_id từ query string
        $donhang_id = $request->query('donhang_id');
//dd($donhang_id);
        // Kiểm tra và lấy thông tin đơn hàng
        $donhang = DonHang::findOrFail($donhang_id);
       //dd($donhang);
        // Trả về view với thông tin đơn hàng
        return view('quanlys.vanchuyens.create', compact('donhang'));
    }

    // public function create($donhang_id)
    // {
    //     // Lấy đơn hàng theo donhang_id
    //     $donhang = DonHang::findOrFail($donhang_id);
    //     dd($donhang);

    //     // Trả về view với thông tin đơn hàng
    //     return view('quanlys.vanchuyens.create', compact('donhang'));
    // }



    public function store(Request $request)
    {
        //dd('1');
        // Xác thực dữ liệu
        $request->validate([
            'tenVanChuyen' => 'required|string|max:255',
            'donhang_id' => 'required|exists:donhang,id',
            'ngayGiaoDuKien' => 'required|date',  // Ngày giao dự kiến (bắt buộc và phải là ngày hợp lệ)
            'ngayThucTe' => 'nullable|date',  // Ngày thực tế (không bắt buộc, nếu có phải là ngày hợp lệ)
            'trangThaiVanChuyen'=>'required|string|max:50',
            'maVanChuyen'=>'required|string|max:255'
        ]);

        //dd('1');
        dd($request->all());
        try {
            VanChuyen::create([
                'tenVanChuyen' => $request->tenVanChuyen,
                'donhang_id' => $request->donhang_id,
                'ngayGiaoDuKien' => $request->ngayGiaoDuKien,
                'ngayThucTe' => $request->ngayThucTe,
                'trangThaiVanChuyen' => $request->trangThaiVanChuyen,
                'maVanChuyen' => $request->maVanChuyen,
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return redirect()->route('vanchuyens.index')->with('success', 'Vận chuyển đã được tạo thành công!');
    }

    public function edit($id)
    {
        // Lấy dữ liệu để chỉnh sửa
        $vanchuyen = VanChuyen::findOrFail($id);
        return view('vanchuyens.edit', compact('vanchuyen'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        $request->validate([
            'ten_van_chuyen' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
        ]);

        // Cập nhật dữ liệu
        $vanchuyen = VanChuyen::findOrFail($id);
        $vanchuyen->update($request->all());
        return redirect()->route('vanchuyens.index');
    }

    public function destroy($id)
    {
        // Xóa dữ liệu
        $vanchuyen = VanChuyen::findOrFail($id);
        $vanchuyen->delete();
        return redirect()->route('vanchuyens.index');
    }
}
