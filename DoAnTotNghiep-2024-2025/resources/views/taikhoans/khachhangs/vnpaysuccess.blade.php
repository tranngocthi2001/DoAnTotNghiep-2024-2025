@extends('layouts.layoutkhachhang')

@section('content')

<div class="container">
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>VNPAY RESPONSE</title>
        <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
        <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">
        <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
    </head>
    <body>
        @if (session('dathangthanhcong'))
        <div class="alert alert-warning">
            {{ session('dathangthanhcong') }}
        </div>
    @endif
        @php

        // Nhận các tham số trả về từ VNPAY
        $vnp_SecureHash = request()->input('vnp_SecureHash'); // Chữ ký bảo mật gửi từ VNPAY
        $vnp_HashSecret = "GR4ZMC29DNNMPMXDHH2IFNLOVHW6NIKL"; // Secret key

        $inputData = [];
        // Lọc các tham số bắt đầu bằng "vnp_"
        foreach (request()->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        // Loại bỏ "vnp_SecureHash" khỏi tham số cần xác thực
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);

        // Xây dựng chuỗi hash từ các tham số trả về
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= (empty($hashData) ? '' : '&') . urlencode($key) . "=" . urlencode($value);
        }

        // Tạo lại chữ ký hash từ chuỗi tham số và secret key
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        @endphp

        <!-- Begin display -->
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY RESPONSE</h3>
            </div>
            <div class="table-responsive">
                <div class="form-group">
                    <label>Mã đơn hàng:</label>
                    <label>{{ request()->input('vnp_TxnRef') }}</label>
                </div>
                <div class="form-group">
                    <label>Số tiền:</label>
                    <label>{{ request()->input('vnp_Amount') / 100 }} VND</label>
                </div>
                <div class="form-group">
                    <label>Nội dung thanh toán:</label>
                    <label>{{ request()->input('vnp_OrderInfo') }}</label>
                </div>
                <div class="form-group">
                    <label>Mã phản hồi (vnp_ResponseCode):</label>
                    <label>{{ request()->input('vnp_ResponseCode') }}</label>
                </div>
                <div class="form-group">
                    <label>Mã GD Tại VNPAY:</label>
                    <label>{{ request()->input('vnp_TransactionNo') }}</label>
                </div>
                <div class="form-group">
                    <label>Mã Ngân hàng:</label>
                    <label>{{ request()->input('vnp_BankCode') }}</label>
                </div>
                <div class="form-group">
                    <label>Thời gian thanh toán:</label>
                    <label>{{ request()->input('vnp_PayDate') }}</label>
                </div>
                <div class="form-group">
                    <label>Kết quả:</label>
                    <label>
                        {{-- @if ($secureHash == $vnp_SecureHash)  <!-- Kiểm tra chữ ký hợp lệ --> --}}
                            @if (request()->input('vnp_ResponseCode') == '00')
                                <span style='color:blue'>Giao dịch thành công</span>
                            @else
                                <span style='color:red'>Giao dịch không thành công</span>
                            @endif
                        {{-- @else
                            <span style='color:red'>Chữ ký không hợp lệ</span>
                        @endif --}}
                    </label>
                </div>
            </div>
            <footer class="footer">
                <p>&copy; VNPAY {{ date('Y') }}</p>
            </footer>
        </div>
    </body>
</html>
</div>
@endsection
