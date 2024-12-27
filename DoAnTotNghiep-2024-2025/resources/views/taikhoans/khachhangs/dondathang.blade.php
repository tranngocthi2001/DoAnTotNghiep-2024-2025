@extends('layouts.layoutkhachhang')

@section('content')
<div class="container">
<H1>Xác nhận thanh toán</H1>
<table class="table">
    <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($giohang->chiTietGioHangs as $item)
            @if ($item->sanPhams->count() > 0)
                @foreach ($item->sanPhams as $sanpham)
                    <tr>
                        <td>
                            {{ $sanpham->tenSanPham }}
                            <input type="hidden" name="sanpham[{{ $sanpham->id }}][tenSanPham]" value="{{ $sanpham->tenSanPham }}">
                        </td>
                        <td>
                            {{ $sanpham->pivot->soLuong }}
                            <input type="hidden" name="sanpham[{{ $sanpham->id }}][soLuong]" value="{{ $sanpham->pivot->soLuong }}">
                        </td>
                        <td>
                            {{ number_format($sanpham->gia * $sanpham->pivot->soLuong, 0, ',', '.') }} VND
                            <input type="hidden" name="sanpham[{{ $sanpham->id }}][gia]" value="{{ $sanpham->gia }}">
                        </td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" style="text-align: "><strong>Tổng số lượng:</strong></td>
            <td>{{ $giohang->tongSoLuong }}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:"><strong>Tổng tiền:</strong></td>
            <td>{{ number_format($giohang->tongTien, 0, ',', '.') }} VND</td>
        </tr>
    </tfoot>
</table>

<h4 >Vui lòng nhập đầy đủ thông tin giao hàng</h4>

<form action="{{ route('khachhang.donhang.create') }}" method="POST" style="max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9;">
    @csrf
    <h2 style="text-align: center; margin-bottom: 20px;">Thông tin đặt hàng</h2>

    <!-- Tên khách hàng -->
    <div style="margin-bottom: 15px;">
        <label for="hoTen" style="display: block; font-weight: bold;">Tên khách hàng:</label>
        <input type="text" name="hoTen" id="hoTen" value="{{ auth()->user()->hoTen ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Địa chỉ giao hàng -->
    <div style="margin-bottom: 15px;">
        <label for="diaChi" style="display: block; font-weight: bold;">Địa chỉ giao hàng:</label>
        <input type="text" name="diaChi" id="diaChi" value="{{ auth()->user()->diaChi ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Số điện thoại -->
    <div style="margin-bottom: 15px;">
        <label for="sdt" style="display: block; font-weight: bold;">Số điện thoại:</label>
        <input type="number" name="sdt" id="sdt" value="{{ auth()->user()->sdt ?? '' }}" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    <!-- Phương thức thanh toán -->
    <div style="margin-bottom: 15px;">
        <label for="phuongThucThanhToan" style="display: block; font-weight: bold;">Chọn phương thức thanh toán:</label>
        <select name="phuongThucThanhToan" id="phuongThucThanhToan" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="Thanh toán khi nhận hàng (COD)">Thanh toán khi nhận hàng (COD)</option>
            <option value="Thanh toán qua cổng thanh toán VnPay">Thanh toán qua cổng thanh toán VnPay</option>
        </select>
    </div>

    <!-- Gửi tổng số tiền -->
    <input type="hidden" name="tongTien" value="{{ $giohang->tongTien }}">
    <input type="hidden" name="tongSoLuong" value="{{ $giohang->tongSoLuong }}">

    <!-- Nút Đặt hàng -->
    <div style="text-align: center;">
        <button type="submit" class="btn btn-danger btn-sm" style="padding: 10px 20px; background-color: #dc3545; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
            Đặt hàng
        </button>
    </div>
</form>

</div>
@endsection
