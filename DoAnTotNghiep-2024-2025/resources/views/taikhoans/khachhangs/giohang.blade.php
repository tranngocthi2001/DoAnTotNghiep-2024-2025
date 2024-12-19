

@extends('layouts.layoutkhachhang')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Giỏ Hàng</h1>

        <div class="container mt-5">
            @if ($giohang && $giohang->chiTietGioHangs->count() > 0)
                <h2>Giỏ hàng của bạn</h2>
                @foreach ($giohang->chiTietGioHangs as $item)
                    @if ($item->sanPhams->count() > 0)
                        @foreach ($item->sanPhams as $sanpham)
                            <div>
                                <p>Sản phẩm: {{ $sanpham->tenSanPham }}</p>
                                <p>Số lượng: {{ $sanpham->pivot->soLuong }}</p>
                                <p>Giá: {{ number_format($sanpham->gia * $sanpham->pivot->soLuong,  0, ',', '.') }} VND</p>
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
                <p>Tổng tiền: {{ number_format($giohang->tongTien,  0, ',', '.') }} VND</p>
            @else
                <p>Giỏ hàng trống!</p>
            @endif

            <a href="{{route('khachhang.giohang.dondathang')}}">Đặt hàng</a>


        </div>
    </div>

    @endsection
