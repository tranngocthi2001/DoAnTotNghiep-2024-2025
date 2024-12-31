@extends('layouts.layoutkhachhang')

@section('content')
<div class="container">
    <h1>Chi tiết đơn hàng #{{ $donhang->id }}</h1>
    <p><strong>Tên khách hàng:</strong> {{ $donhang->tenKhachHang }}</p>

    <p><strong>Ngày đặt hàng:</strong> {{ $donhang->ngayDatHang }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($donhang->tongTien,  0, ',', '.') }} VND</p>
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
                            <td>{{ number_format($sanpham->gia, 0, ',', '.') }} VND</td>
                            <td>{{ number_format( $chitiet->gia,  0, ',', '.') }} VND</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        @if ($donhang->maVanChuyen)
            <a href="https://donhang.ghn.vn/?order_code={{ $donhang->maVanChuyen }}" target="_blank" style="color: blue; text-decoration: underline;">
                Theo dõi đơn hàng
            </a><br><br>
        @else
            <a >Đơn hàng chưa giao cho đơn vị vận chuyển</a><br><br>
        @endif
            <a href="{{ route('khachhang.donhang.index') }}" class="btn btn-primary">Quay lại danh sách đơn hàng</a><br><br>
        @if ($donhang->trangThai === 'COD'||$donhang->trangThai === 'Đã thanh toán')
            <form action="{{ route('donhang.huy', $donhang->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-danger">Hủy đơn hàng</button>
            </form>
        @endif

        @if ($donhang->trangThai ==='Chờ thanh toán' )
        <form action="{{ route('donhang.update', $donhang->id) }}" method="POST" style="max-width: 500px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; background-color: #f9f9f9;">
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
            <input type="hidden" name="tongTien" value="{{ $donhang->tongTien }}">
            <br><br>
            <!-- Nút Đặt hàng -->
            <button type="submit" class="btn btn-danger btn-sm">Đặt hàng</button>

        </form>
        @endif

        @if ($donhang->trangThai === 'Đã hoàn thành')
            <a href="{{ route('taikhoans.khachhangs.yeucaudoihang', ['donhang_id' => $donhang->id]) }}" class="btn btn-primary">Đổi hàng</a>
        @endif
        <!-- Kiểm tra xem có yêu cầu đổi hàng không -->
        @if ($donhang->trangThai === 'Đổi hàng')
            <a href="{{ route('taikhoans.khachhangs.yeucaudoihang.show', ['id' => $yeuCauDoiHangID]) }}" class="btn btn-primary">
                Xem chi tiết yêu cầu đổi hàng
            </a>
        @endif





</div>
@endsection
