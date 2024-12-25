<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
</head>
<body>
    <h1>Cảm ơn bạn đã đặt hàng tại website của chúng tôi!</h1>
    <p>Chúng tôi đã nhận được đơn hàng của bạn với mã đơn hàng: <strong>{{ $donhang->id }}</strong></p>
    <p>Chi tiết đơn hàng:</p>
    <ul>
        <li><strong>Ngày đặt hàng:</strong> {{ $donhang->ngayDatHang }}</li>
        <li><strong>Tình trạng:</strong> {{ $donhang->trangThai }}</li>
        <li><strong>Tổng giá trị đơn hàng:</strong> {{ number_format($donhang->tongTien,0, ',', '.')}} VND </li>
    </ul>
    <p>Chúng tôi sẽ xử lý đơn hàng của bạn trong thời gian sớm nhất. Cảm ơn bạn đã tin tưởng sử dụng dịch vụ của chúng tôi!</p>
</body>
</html>
