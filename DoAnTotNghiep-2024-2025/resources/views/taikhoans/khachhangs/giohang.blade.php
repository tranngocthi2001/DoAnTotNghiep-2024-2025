@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Giỏ Hàng</h1>

    <div class="container mt-5">
        @if ($giohang && $giohang->chitietgiohang)
    <h2>Giỏ hàng của bạn</h2>
    @foreach ($giohang->chitietgiohang as $item)
        @foreach ($item->sanphams as $sanpham)
            <div>
                <p>Sản phẩm: {{ $sanpham->tenSanPham }}</p>
                <p>Số lượng: {{ $sanpham->pivot->soLuong }}</p>
                <p>Giá: {{ number_format($sanpham->gia * $sanpham->pivot->soLuong, 2) }} VND</p>
                <form action="{{ route('giohang.chitiet.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Xóa</button>
                </form>
            </div>
        @endforeach
    @endforeach
    <p>Tổng số lượng: {{ $giohang->tongSoLuong }}</p>
    <p>Tổng tiền: {{ number_format($giohang->tongTien, 2) }} VND</p>
@else
    <p>Giỏ hàng trống!</p>
@endif

    </div>
</div>
@endsection
