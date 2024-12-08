@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết đơn hàng #{{ $donHang->id }}</h1>

    <p><strong>Ngày đặt hàng:</strong> {{ $donHang->ngayDatHang }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($donHang->tongTien, 3) }} VND</p>
    <p><strong>Trạng thái:</strong> {{ $donHang->trangThai }}</p>
    <p><strong>Tên khách hàng:</strong> {{ $khachHang->hoTen }}</p>
    <p><strong>Địa chỉ giao hàng:</strong> {{ $donHang->diaChiGiaoHang }}</p>
    <p><strong>Số điện thoại:</strong> {{ $donHang->sdt }}</p>
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
            @foreach($donHang->chiTietDonHangs as $chitiet)
                @foreach($chitiet->sanphams as $sanpham)
                    <tr>
                        <td>{{ $sanpham->tenSanPham }}</td>
                        <td>{{ $chitiet->soLuong }}</td>
                        <td>{{ number_format($sanpham->gia, 3) }} VND</td>
                        <td>{{ number_format($chitiet->gia, 3) }} VND</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <h2>Cập nhật trạng thái đơn hàng</h2>
    <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="trangThai">Trạng thái:</label>
        <select name="trangThai" id="trangThai" required>
            <option value="Chưa xác nhận" @if($donHang->trangThai == 'Chưa xác nhận') selected @endif>Chưa xác nhận</option>
            <option value="Đang xử lý" @if($donHang->trangThai == 'Đang xử lý') selected @endif>Đang xử lý</option>

            <option value="Đã giao cho đơn vị vận chuyển" @if($donHang->trangThai == 'Đã giao cho đơn vị vận chuyển') selected @endif>Đã giao cho đơn vị vận chuyển</option>
            <option value="Đã hoàn thành" @if($donHang->trangThai == 'Đã hoàn thành') selected @endif>Đã hoàn thành</option>
            <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
        </select>
        <!-- Input mã vận chuyển -->
        @if (!$donHang->maVanChuyen)
            <label for="maVanChuyen_{{ $donHang->id }}">Mã vận chuyển:</label>
            <input type="text" name="maVanChuyen" id="maVanChuyen{{ $donHang->id }}" placeholder="Nhập mã vận chuyển">
        @else
            <p>
                Mã vận chuyển: {{ $donHang->maVanChuyen }}
                <!-- Thêm đường dẫn theo dõi -->
                <a href="https://donhang.ghn.vn/?order_code={{ $donHang->maVanChuyen }}" target="_blank" style="color: blue; text-decoration: underline;">
                    Theo dõi đơn hàng
                </a>

            </p>

        @endif

        <button type="submit">Cập nhật</button>
    </form>
    <p>
        <!-- Kiểm tra xem có yêu cầu đổi hàng không -->
        @if ($yeuCauDoiHang)
            <a href="{{ route('taikhoans.khachhangs.yeucaudoihang.showAdmin', ['id' => $yeuCauDoiHang->id]) }}" class="btn btn-primary">
                1Xem chi tiết yêu cầu đổi hàng1
            </a>
        @endif

    </p>
</div>
@endsection
