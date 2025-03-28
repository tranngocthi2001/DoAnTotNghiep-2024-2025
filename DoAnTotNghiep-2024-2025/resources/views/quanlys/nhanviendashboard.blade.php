
@extends('layouts.layoutquanly')

@section('content')<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
            justify-content: center;
        }
        .card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px;
            width: 200px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin: 0;
            padding: 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border-radius: 8px 8px 0 0;
        }
        .card a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .card a:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Hệ thống quản lý</h1>
    </div>
    <div class="container">
        <div class="card">
            <h3>Tra cứu khách hàng</h3>
            <a href="/quanlys/khachhang">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Tra cứu danh mục</h3>
            <a href="/quanlys/danhmuc">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Tra cứu sản phẩm</h3>
            <a href="/quanlys/sanpham">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Tra cứu Đơn hàng</h3>
            <a href="/quanlys/donhang">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Sửa chữa & bảo trì</h3>
            <a href="/quanlys/baotri">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Phiếu xuất hàng</h3>
            <a href="/quanlys/phieuxuathang">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Tra cứu thanh toán</h3>
            <a href="/quanlys/thanhtoan">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Tra cứu vận chuyển</h3>
            <a href="/quanlys/vanchuyen">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Thông báo</h3>
            <a href="/quanlys/thongbao">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Yêu cầu đổi hàng</h3>
            <a href="/quanlys/doihang">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Yêu cầu trả hàng</h3>
            <a href="/quanlys/trahang">Xem chi tiết</a>
        </div>
        <div class="card">
            <h3>Sự kiện</h3>
            <a href="/quanlys/sukien">Xem chi tiết</a>
        </div>
    </div>
</body>
</html>
@endsection
