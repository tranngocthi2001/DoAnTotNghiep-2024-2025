<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cảnh báo sản phẩm</title>
</head>
<body>
    <h1>Cảnh báo: Sản phẩm còn ít</h1>
    <p>Chúng tôi nhận thấy rằng sản phẩm <strong>{{ $sanPham->tenSanPham }}</strong> hiện tại chỉ còn <strong>{{ $sanPham->soLuong }}</strong> sản phẩm trong kho.</p>
    <p>Vui lòng nhập thêm hàng để đảm bảo không thiếu sản phẩm khi khách hàng đặt hàng.</p>
</body>
</html>
