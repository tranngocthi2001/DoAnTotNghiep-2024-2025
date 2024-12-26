@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h1>Chi tiết phiếu xuất #{{ $phieuXuat->id }}</h1>

    <p><strong>Ngày xuất hàng:</strong> {{ $phieuXuat->ngayXuat }}</p>
    <p><strong>Người tạo phiếu:</strong> {{ $phieuXuat->nhanViens->hoTen }}</p>
    <p><strong>Trạng thái phiếu:</strong> {{ $phieuXuat->trangThai }}</p>

    <h2>Thông tin đơn hàng</h2>
    <p><strong>Mã đơn hàng:</strong> {{ $phieuXuat->donHangs->id }}</p>
    <p><strong>Ngày đặt hàng:</strong> {{ $phieuXuat->donHangs->ngayDatHang }}</p>
    <p><strong>Tên khách hàng:</strong> {{ $phieuXuat->donHangs->khachHangs->hoTen }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $phieuXuat->donHangs->diaChiGiaoHang }}</p>
    <p><strong>Số điện thoại:</strong> {{ $phieuXuat->donHangs->sdt }}</p>

    <h2>Sản phẩm trong phiếu xuất</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Seri</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($phieuXuat->donHangs->chiTietDonHangs as $chiTietDonHang)
                @foreach($chiTietDonHang->sanPhams as $sanPham)
                    {{-- Kiểm tra chi tiết phiếu xuất có tồn tại không --}}
                    @php
                        $chiTietPhieuXuat = $chiTietPhieuXuat->firstWhere('chitietdonhang_id', $chiTietDonHang->id);
                        $seris = $seri->where('chitietphieuxuat_id', $chiTietPhieuXuat ? $chiTietPhieuXuat->id : null);
                    @endphp
                    {{-- Hiển thị sản phẩm và seri nếu có --}}
                    <tr>
                        <td>{{ $sanPham->tenSanPham }}</td>
                        <td>{{ $chiTietDonHang->soLuong }}</td>
                        <td>
                            <ul>
                                @foreach($seris as $seri)
                                    <li>{{ $seri->maSeri }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ number_format($sanPham->gia, 0, ',', '.') }} VND</td>
                        <td>{{ number_format($chiTietDonHang->soLuong * $sanPham->gia, 0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <h4><a href="#">In phiếu xuất PDF</a></h4>
</div>
@endsection
