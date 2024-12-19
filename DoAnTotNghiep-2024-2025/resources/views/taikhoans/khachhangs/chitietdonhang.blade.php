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
        <form action="{{ route('donhang.update', $donhang->id) }}" method="POST">
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
            <a href="{{ route('taikhoans.khachhangs.yeucaudoihang.show', ['id' => $yeuCauDoiHang->id]) }}" class="btn btn-primary">
                Xem chi tiết yêu cầu đổi hàng
            </a>
        @endif





</div>
@endsection
