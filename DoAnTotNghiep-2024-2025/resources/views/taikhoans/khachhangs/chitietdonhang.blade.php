@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết đơn hàng #{{ $donhang->id }}</h1>

    <p><strong>Ngày đặt hàng:</strong> {{ $donhang->ngayDatHang }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($donhang->tongTien, 2) }} VND</p>
    <p><strong>Trạng thái:</strong> {{ $donhang->trangThai }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $donhang->diaChiGiaoHang }}</p>
    <p><strong>Số điện thoại:</strong> {{ $donhang->sdt }}</p>

    <h2>Sản phẩm trong đơn hàng</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donhang->chitietdonhang as $chitiet)
                @foreach($chitiet->sanphams as $sanpham)
                    <tr>
                        <td>{{ $sanpham->tenSanPham }}</td>
                        <td>{{ $chitiet->soLuong }}</td>
                        <td>{{ number_format($sanpham->gia, 3) }} VND</td>
                        <td>{{ number_format($chitiet->gia, 3) }} VND</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('khachhang.donhang.index') }}" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
</div>
@endsection
