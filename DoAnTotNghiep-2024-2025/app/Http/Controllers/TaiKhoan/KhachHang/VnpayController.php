<?php

namespace App\Http\Controllers\TaiKhoan\KhachHang;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\ThanhToan;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlaced;

class VnpayController extends Controller
{
    // Hàm tạo URL thanh toán VNPAY
    public function createPayment(Request $request, $id)
    {
        $danhmucs=DanhMuc::all();

        $donHang = DonHang::findOrFail($id);
        $amount = $donHang->tongTien; // Lấy số tiền từ đơn hàng
        $order_id = $donHang->id; // Mã đơn hàng

        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán
        $vnp_TmnCode = "DD6QHVE6"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "GR4ZMC29DNNMPMXDHH2IFNLOVHW6NIKL"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');;
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+435 minutes',strtotime($startTime)));


        $vnp_Locale = $request->input('language');
        $vnp_BankCode = $request->input('bankCode'); // Lấy mã ngân hàng từ request
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $amount* 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" =>  $order_id,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $order_id,
            "vnp_ExpireDate"=>$expire
        );
        //dd($inputData);
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }


        $donHang = DonHang::where('id', $inputData['vnp_OrderInfo'])->first();
        $donHang->trangThai="Chờ thanh toán";
        $donHang->save();
//dd($donHang);

        // Lưu thông tin thanh toán vào database
        $payment = new ThanhToan();
        $payment->donhang_id = $order_id;
        $payment->phuongThuc = 'Thanh toán qua cổng thanh toán VnPay';
        $payment->soTien = $amount;
        $payment->trangThaiGiaoDich = 'Chờ thanh toán'; // Bạn có thể sử dụng trạng thái 'Chờ thanh toán' hoặc một trạng thái nào đó phù hợp
        $payment->ngayGiaoDich = now();
        $payment->maGiaoDichVnpay=$order_id;
        $payment->save(); // Lưu thông tin thanh toán vào bảng
//dd($payment);
        // Redirect đến VNPAY để thực hiện thanh toán
        return redirect()->to($vnp_Url);
    }

    // Hàm xử lý kết quả thanh toán trả về từ VNPAY
    public function return(Request $request)
    {
        $danhmucs=DanhMuc::all();

        //dd($request->query());

        $vnp_Params = $request->all();
        $secureHash = $vnp_Params['vnp_SecureHash'];
//dd($vnp_Params);
        // Xử lý kiểm tra chữ ký (checksum)
        unset($vnp_Params['vnp_SecureHash']);
        ksort($vnp_Params);
        $query = http_build_query($vnp_Params);
        //$expectedSecureHash = hash_hmac('sha512', $query, env('VNP_HASH_SECRET'));

       // if ($secureHash === $expectedSecureHash) {
            // Kiểm tra kết quả thanh toán
            if ($vnp_Params['vnp_ResponseCode'] === '00') {
                // Thanh toán thành công
                //dd($vnp_Params['vnp_ResponseCode']);
                //Log::info('Thanh toán thành công: ', $vnp_Params);

                // Cập nhật trạng thái giao dịch thanh toán
                $donHang = DonHang::where('id', $vnp_Params['vnp_OrderInfo'])->first();
                $donHang->trangThai="Đã thanh toán";
                $donHang->save();
                //dd(auth()->user()->email);
                Mail::to(auth()->user()->email)->send(new OrderPlaced($donHang));


                $payment = ThanhToan::where('donhang_id', $vnp_Params['vnp_OrderInfo'])->first();
                if ($payment) {
                    $payment->trangThaiGiaoDich = 'Thành công';
                    $payment->maGiaoDichNganHang = $vnp_Params['vnp_BankCode']; // Mã giao dịch ngân hàng
                    $payment->save(); // Lưu thông tin
                }
                $danhmucs=DanhMuc::all();
                return view('taikhoans/khachhangs.vnpaysuccess', compact('danhmucs')); // Hiển thị trang thành công
            } else {
                 // Trường hợp mã bảo mật không khớp
                // Thanh toán thất bại
                Log::info('Thanh toán thất bại: ', $vnp_Params);

                // Cập nhật trạng thái giao dịch thanh toán
                $payment = ThanhToan::where('donhang_id', $vnp_Params['vnp_OrderInfo'])->first();
                if ($payment) {
                    $payment->trangThaiGiaoDich = 'Thất bại';
                    $payment->save(); // Lưu thông tin
                }

                return view('#', compact('danhmucs')); // Hiển thị trang thất bại
            }
        //}
    }


}
