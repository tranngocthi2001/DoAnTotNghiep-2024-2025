@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết đơn hàng #{{ $donhang->id }}</h1>
    <p><strong>Tên khách hàng:</strong> {{ $donhang->tenKhachHang }}</p>

    <p><strong>Ngày đặt hàng:</strong> {{ $donhang->ngayDatHang }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($donhang->tongTien, 3) }} VND</p>
    <p><strong>Trạng thái:</strong> {{ $donhang->trangThai }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $donhang->diaChiGiaoHang }}</p>
    <p><strong>Số điện thoại:</strong> {{ $donhang->sdt }}</p>
    <p><strong>Phương thức thanh toán:</strong> {{ $donhang->phuongThucThanhToan}}</p>
    <p><strong>Mã vận chuyển:</strong> {{ $donhang->maVanChuyen}}</p><br>



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
            @foreach($donhang->chiTietDonHangs as $chitiet)
                @foreach($chitiet->sanPhams as $sanpham)
                    <tr>
                        <td>{{ $sanpham->tenSanPham }}</td>
                        <td>{{ $chitiet->soLuong }}</td>
                        <td>{{ number_format($sanpham->gia, 3) }} VND</td>
                        <td>{{ number_format( $chitiet->gia, 3) }} VND</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @if ($donhang->maVanChuyen)
        <a href="https://donhang.ghn.vn/?order_code={{ $donhang->maVanChuyen }}" target="_blank" style="color: blue; text-decoration: underline;">
            Theo dõi đơn hàng
        </a>
    @else
        <a >Đơn hàng chưa giao cho đơn vị vận chuyển</a>
    @endif
    <a href="{{ route('khachhang.donhang.index') }}" class="btn btn-primary">Quay lại danh sách đơn hàng</a>
</div>
@endsection
