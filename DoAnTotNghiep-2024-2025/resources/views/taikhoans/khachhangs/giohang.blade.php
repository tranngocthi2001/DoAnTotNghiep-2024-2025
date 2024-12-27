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


    <div class="container mt-5">
        @if ($giohang && $giohang->chiTietGioHangs->count() > 0)
            <h2>Giỏ hàng của bạn</h2>

            <table class="table table-bordered" style="width: 100%; text-align: ">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($giohang->chiTietGioHangs as $item)
                        @if ($item->sanPhams->count() > 0)
                            @foreach ($item->sanPhams as $sanpham)
                                <tr>
                                    <td>{{ $sanpham->tenSanPham }}</td>
                                    <td>
                                        <form action="{{ route('giohang.chitiet.update', ['id' => $sanpham->id]) }}" method="POST">
                                            @csrf
                                            <input type="number" name="soLuong" id="soLuong" value="{{ $sanpham->pivot->soLuong }}" min="1" style="width: 60px; text-align: center;">
                                            <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                                        </form>
                                    </td>
                                    <td>{{ number_format($sanpham->gia * $sanpham->pivot->soLuong, 0, ',', '.') }} VND</td>
                                    <td>
                                        <form action="{{ route('giohang.chitiet.destroy', ['id' => $sanpham->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Tổng số lượng:</strong></td>
                        <td colspan="2">{{ $giohang->tongSoLuong }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Tổng tiền:</strong></td>
                        <td colspan="2">{{ number_format($giohang->tongTien, 0, ',', '.') }} VND</td>
                    </tr>
                </tfoot>
            </table>

            <div class="text-end mt-3">
                <a href="{{ route('khachhang.giohang.dondathang') }}" class="btn btn-success">Đặt hàng</a>
            </div>
        @else
            <p>Giỏ hàng trống!</p>
        @endif
    </div>
</div>
@endsection
