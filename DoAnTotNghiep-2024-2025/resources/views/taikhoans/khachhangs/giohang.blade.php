@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Giỏ Hàng</h1>

    <div class="container mt-5">
        @if ($giohang && $giohang->chitietgiohang->count() > 0)
    <h2>Giỏ hàng của bạn</h2>
    @foreach ($giohang->chitietgiohang as $item)
        @if ($item->sanphams->count() > 0)
            @foreach ($item->sanphams as $sanpham)
                <div>
                    <p>Sản phẩm: {{ $sanpham->tenSanPham }}</p>
                    <p>Số lượng: {{ $sanpham->pivot->soLuong }}</p>
                    <p>Giá: {{ number_format($sanpham->gia * $sanpham->pivot->soLuong, 3) }} VND</p>
                    <form action="{{ route('giohang.chitiet.update', ['id' => $sanpham->id]) }}" method="POST">
                        @csrf
                        <label for="soLuong">Số lượng:</label>
                        <input type="number" name="soLuong" id="soLuong" value="{{ $sanpham->pivot->soLuong }}" min="1">
                        <button type="submit">Cập nhật</button>
                    </form>

                    <form action="{{ route('giohang.chitiet.destroy', ['id' => $sanpham->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Xóa</button>
                    </form>

                </div>
            @endforeach
        @endif
    @endforeach
    <p>Tổng số lượng: {{ $giohang->tongSoLuong }}</p>
    <p>Tổng tiền: {{ number_format($giohang->tongTien, 3) }} VND</p>
@else
    <p>Giỏ hàng trống!</p>
@endif
<form action="{{ route('khachhang.donhang.create') }}" method="POST">
    @csrf
    <label for="diaChi">Địa chỉ giao hàng:</label>
    <input type="text" name="diaChi" id="diaChi" value="{{ auth()->user()->diaChi ?? '' }}" required>

    <label for="sdt">Số điện thoại:</label>
    <input type="text" name="sdt" id="sdt" value="{{ auth()->user()->sdt ?? '' }}" required>

    <button type="submit">Đặt hàng</button>
</form>


    </div>
</div>
@endsection
