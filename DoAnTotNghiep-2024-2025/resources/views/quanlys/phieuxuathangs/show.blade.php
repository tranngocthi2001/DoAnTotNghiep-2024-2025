@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h1>Phiếu xuất #{{ $phieuXuatHang->id }}</h1>

    <p><strong>Ngày xuất hàng:</strong> {{ $phieuXuatHang->ngayXuat }}</p>
    <p><strong>Người tạo phiếu:</strong> {{ $phieuXuatHang->nhanViens->hoTen }}</p>
    <p><strong>Trạng thái phiếu:</strong> {{ $phieuXuatHang->trangThai }}</p>

    <h2>Thông tin đơn hàng</h2>
    <p><strong>Mã đơn hàng:</strong> {{ $phieuXuatHang->donHangs->id }}</p>
    <p><strong>Ngày đặt hàng:</strong> {{ $phieuXuatHang->donHangs->ngayDatHang }}</p>
    <p><strong>Tên khách hàng:</strong> {{ $phieuXuatHang->donHangs->khachHangs->hoTen }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $phieuXuatHang->donHangs->diaChiGiaoHang }}</p>
    <p><strong>Số điện thoại:</strong> {{ $phieuXuatHang->donHangs->sdt }}</p>

    <h2>Sản phẩm trong phiếu xuất</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
                <th>Seri</th>
            </tr>

        </thead>
        <tbody>

            @foreach ($phieuXuatHang->donHangs->chiTietDonHangs as $chiTietDonHang)
                @foreach ($chiTietDonHang->sanPhams as $sanpham)
                    <tr>
                        <td>{{ $sanpham->tenSanPham }}</td>
                        <td>{{ $chiTietDonHang->soLuong }}</td>
                        <td>{{ number_format($sanpham->gia, 0, ',', '.') }} VND </td>
                        <td>{{ number_format($chiTietDonHang->soLuong *$sanpham->gia, 0, ',', '.') }}VND</td>
                @endforeach
                        <td>
                            @foreach ($chiTietDonHang->chiTietPhieuXuats as $chiTietPhieuXuat)
                                @foreach ($chiTietPhieuXuat->seris as $seri)
                                    {{ $seri->maSeri }}<br>

                                @endforeach
                            @endforeach
                        </td>
                    </tr>
            @endforeach

        </tbody>
    </table>
    <h4><a href="{{route('phieuxuathangs.print',['id'=>$phieuXuatHang->id])}}">In phiếu xuất PDF</a></h4>
</div>
@endsection
