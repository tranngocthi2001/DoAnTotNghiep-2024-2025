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
        // Lấy đơn hàng theo donhang_id (sử dụng phương thức with để lấy quan hệ 'vanChuyen')
        $donhang = DonHang::with('vanChuyen')->findOrFail($donhang_id);
//dd($donhang);
        // Lấy tất cả các vận chuyển (VanChuyen) liên quan đến donhang_id
        $vanchuyens = $donhang->vanChuyen;  // Đây sẽ là một collection
//dd($vanchuyens);
        // Kiểm tra nếu không có dữ liệu vận chuyển
        if ($vanchuyens==null) {
            $message = 'Không có thông tin vận chuyển cho đơn hàng này.';
        } else {
            $message = null;
        }

        // Trả về view với dữ liệu vanchuyens và thông điệp nếu có
        return view('quanlys.vanchuyens.index', compact('vanchuyens', 'donhang', 'message'));
}




    public function show($id)
    {
        // Lấy dữ liệu theo id
        $vanchuyen = VanChuyen::findOrFail($id);
        return view('vanchuyens.show', compact('vanchuyen'));
    }

    public function create(Request $request)
    {
        $donhang_id = $request->query('donhang_id');  // Lấy tham số donhang_id từ query string
        // Bạn có thể kiểm tra và xử lý tham số donhang_id ở đây

        return view('quanlys.vanchuyens.create', compact('donhang_id'));  // Truyền donhang_id vào view
    }


    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'tenVanChuyen' => 'required|string|max:255',
            'donhang_id' => 'required|exists:donhangs,id',
            'ngayGiaoDuKien' => 'required|date',  // Ngày giao dự kiến (bắt buộc và phải là ngày hợp lệ)
            'ngayThucTe' => 'nullable|date',  // Ngày thực tế (không bắt buộc, nếu có phải là ngày hợp lệ)
            'trangThaiVanChuyen'=>'required|string|max:50'
        ]);

        // Tạo mới vanchuyen
        VanChuyen::create([
            'tenVanChuyen' => $request->tenVanChuyen,
            'donhang_id' => $request->donhang_id,
            'ngayGiaoDuKien' => $request->ngayGiaoDuKien,
            'ngayThucTe' => $request->ngayThucTe,
            'trangThaiVanChuyen' => $request->trangThaiVanChuyen ?? 'chua_giao',  // Mặc định là 'chua_giao' nếu không có
        ]);
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
