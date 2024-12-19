@extends('layouts.layoutkhachhang')

@section('content')
<div class="container">
<H1>Xác nhận thanh toán</H1>

@foreach ($giohang->chiTietGioHangs as $item)
    @if ($item->sanPhams->count() > 0)
        @foreach ($item->sanPhams as $sanpham)
            <div>
                <p>Sản phẩm: {{ $sanpham->tenSanPham }}</p>
                <p>Số lượng: {{ $sanpham->pivot->soLuong }}</p>
                <p>Giá: {{ number_format($sanpham->gia * $sanpham->pivot->soLuong,  0, ',', '.') }} VND</p>

                <!-- Gửi thông tin sản phẩm cùng với form -->
                <input type="hidden" name="sanpham[{{ $sanpham->id }}][tenSanPham]" value="{{ $sanpham->tenSanPham }}">
                <input type="hidden" name="sanpham[{{ $sanpham->id }}][soLuong]" value="{{ $sanpham->pivot->soLuong }}">
                <input type="hidden" name="sanpham[{{ $sanpham->id }}][gia]" value="{{ $sanpham->gia }}">
            </div>
        @endforeach
    @endif
@endforeach

<p>Tổng số lượng: {{ $giohang->tongSoLuong }}</p>
<p>Tổng tiền: {{ number_format($giohang->tongTien, 0, ',', '.') }} VND</p>

<p>Vui lòng nhập đầy đủ thông tin giao hàng</p>

<form action="{{ route('khachhang.donhang.create') }}" method="POST">
    @csrf
    <!-- Tên khách hàng -->
    <label for="hoTen">Tên khách hàng:</label>
    <input type="text" name="hoTen" id="hoTen" value="{{ auth()->user()->hoTen ?? '' }}" required>
    <br><br>
    <!-- Địa chỉ giao hàng -->
    <label for="diaChi">Địa chỉ giao hàng:</label>
    <input type="text" name="diaChi" id="diaChi" value="{{ auth()->user()->diaChi ?? '' }}" required>
    <br><br>

    <!-- Số điện thoại -->
    <label for="sdt">Số điện thoại:</label>
    <input type="text" name="sdt" id="sdt" value="{{ auth()->user()->sdt ?? '' }}" required></br>
    <br>

    <!-- Phương thức thanh toán -->
    <label for="phuongThucThanhToan">Chọn phương thức thanh toán:</label>
    <select name="phuongThucThanhToan" id="phuongThucThanhToan" required>
        <option value="Thanh toán khi nhận hàng (COD)">Thanh toán khi nhận hàng (COD)</option>
        <option value="Thanh toán qua cổng thanh toán VnPay">Thanh toán qua cổng thanh toán VnPay</option>
    </select>

    <!-- Gửi tổng số tiền -->
    <input type="hidden" name="tongTien" value="{{ $giohang->tongTien }}">
    <input type="hidden" name="tongSoLuong" value="{{ $giohang->tongSoLuong }}">
    <br><br>

    <!-- Nút Đặt hàng -->
    <button type="submit" class="btn btn-danger btn-sm">Đặt hàng</button>

</form>
</div>
@endsection
