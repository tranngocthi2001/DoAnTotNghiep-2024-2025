<?php
namespace App\Http\Controllers\TaiKhoan\KhachHang;

use App\Models\DonHang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ThanhToan;
use Illuminate\Support\Facades\Validator;

class ThanhToanController extends Controller
{
    // Hàm tạo mới một thanh toán
    public function store(Request $request, $donhangId)
    {
        // Xác minh đơn hàng tồn tại
        $donhang = DonHang::findOrFail($donhangId);

        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'phuongThuc' => 'required|string',
            'maGiaoDichNganHang' => 'nullable|string',
            'maGiaoDichMomo' => 'nullable|string',
        ]);

        // Nếu dữ liệu không hợp lệ, trả về redirect với thông báo lỗi
        if ($validator->fails()) {
            return redirect()->back() // Trở lại trang trước đó
                ->withErrors($validator) // Đưa lỗi vào session
                ->withInput(); // Giữ lại dữ liệu đầu vào
        }

        // Tạo thanh toán mới và lưu vào cơ sở dữ liệu
        ThanhToan::create([
            'donhang_id' => $donhang->id,  // Liên kết với đơn hàng
            'phuongThuc' => $request->input('phuongThuc'),
            'soTien' => $donhang->tong_tien,  // Giả sử có cột 'tong_tien' trong DonHang
            'trangThaiGiaoDich' => 'Chưa thanh toán', // Mặc định
            'ngayGiaoDich' => now(),  // Thời gian hiện tại
            'maGiaoDichNganHang' => $request->input('maGiaoDichNganHang'),
            'maGiaoDichMomo' => $request->input('maGiaoDichMomo'),
        ]);

        // Trả về redirect đến trang thông tin thanh toán của đơn hàng mới
        return redirect()->route('thanh-toan.show', ['donhangId' => $donhang->id])
            ->with('message', 'Thanh toán đã được tạo thành công!');
    }

    // Hàm lấy thông tin thanh toán của đơn hàng
    public function show($donhangId)
    {
        // Tìm đơn hàng theo ID và lấy thanh toán liên kết
        $donhang = DonHang::findOrFail($donhangId);
        $payment = $donhang->thanhtoan;  // Quan hệ đã được định nghĩa ở DonHang

        // Trả về trang hiển thị thông tin thanh toán của đơn hàng
        return view('thanh-toan.show', compact('payment'));
    }

    // Hàm cập nhật thanh toán
    public function update(Request $request, $id)
    {
        // Tìm thanh toán theo ID
        $payment = ThanhToan::findOrFail($id);

        // Cập nhật thông tin thanh toán
        $payment->update([
            'phuongThuc' => $request->input('phuongThuc'),
            'soTien' => $request->input('soTien'),
            'trangThaiGiaoDich' => $request->input('trangThaiGiaoDich'),
            'maGiaoDichNganHang' => $request->input('maGiaoDichNganHang'),
            'maGiaoDichMomo' => $request->input('maGiaoDichMomo'),
        ]);

        // Trả về thông báo thành công và chuyển hướng đến trang thanh toán
        return redirect()->route('thanh-toan.show', ['donhangId' => $payment->donhang_id])
            ->with('message', 'Thanh toán đã được cập nhật thành công!');
    }

    // Hàm xóa thanh toán
    public function destroy($id)
    {
        // Tìm thanh toán theo ID và xóa
        $payment = ThanhToan::findOrFail($id);
        $payment->delete();

        // Trả về thông báo xóa thành công và chuyển hướng đến trang danh sách thanh toán
        return redirect()->route('donhang.index') // Hoặc điều hướng đến trang danh sách đơn hàng
            ->with('message', 'Thanh toán đã được xóa thành công!');
    }
}