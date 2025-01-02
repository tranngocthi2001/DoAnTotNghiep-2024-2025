@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h1>Chi tiết đơn hàng #{{ $donHang->id }}</h1>

    <p><strong>Ngày đặt hàng:</strong> {{ $donHang->ngayDatHang }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($donHang->tongTien, 3) }} VND</p>
    <p><strong>Trạng thái:</strong> {{ $donHang->trangThai }}</p>
    <p><strong>Tên khách hàng:</strong> {{ $donHang->tenKhachHang }}</p>
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
                        <td>{{ number_format($sanpham->gia,  0, ',', '.') }} VND</td>
                        <td>{{ number_format($sanpham->gia*$chitiet->soLuong,  0, ',', '.') }} VND</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

        <h4><a href="{{route('donhang.addchitiet.form',['donHang_id'=> $donHang->id])}}">Chỉnh sửa chi tiết đơn hàng</a></h4>

    <h4>
        @if ( $donHang->trangThai!='Đang chờ nhận lại hàng')
            @if (!$phieuXuatHang)
                <a href="{{ route('quanlys.phieuxuathang.create', ['donHangId' => $donHang->id]) }}">Tạo Phiếu xuất hàng</a>
            @endif
        @endif

        @if ($donHang->id)
            @if ($phieuXuatHang)
            <br>Xem phiếu xuất cho đơn hàng: <a href="{{ route('phieuxuathangs.show', ['donhang_id' => $donHang->id]) }}">
                     {{ $donHang->id }}
                </a><br><br>
            @endif
        @endif


    @if ($donHang->maVanChuyen)
        Mã vận chuyển: {{ $donHang->maVanChuyen }}
        <!-- Thêm đường dẫn theo dõi -->
        <a href="https://donhang.ghn.vn/?order_code={{ $donHang->maVanChuyen }}" target="_blank" style="color: blue; text-decoration: underline;">
            Theo dõi đơn hàng
        </a>
    @endif
    </h4>


        <h2>Cập nhật đơn hàng</h2>
        @if ($phieuXuatHang)
            @if ($donHang->trangThai=='Đang xử lý')
                @if ($donHang->maVanChuyen==null)
                    <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="maVanChuyen_{{ $donHang->id }}">Mã vận chuyển:</label>
                        <input type="text" name="maVanChuyen" id="maVanChuyen{{ $donHang->id }}" class="form-control" placeholder="Nhập mã vận chuyển">
                        <button type="submit">Cập nhật</button>

                    </form>
                @endif
            @endif
        @endif






        <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="trangThai">Trạng thái:</label>
            <select class="form-control"name="trangThai" id="trangThai" required>
                @if($donHang->trangThai=='Đã thanh toán'||$donHang->trangThai=='COD')
                    <option value="Đang xử lý" @if($donHang->trangThai == 'Đang xử lý') selected @endif>Đang xử lý</option>
                    <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>

                @endif

                @if($donHang->trangThai=='Đang xử lý')
                    @if($phieuXuatHang)
                        @if ($donHang->maVanChuyen)
                            <option value="Đã giao cho đơn vị vận chuyển" @if($donHang->trangThai == 'Đã giao cho đơn vị vận chuyển') selected @endif>Đã giao cho đơn vị vận chuyển</option>
                        @endif
                    @endif
                    <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>

                @endif

                @if($donHang->trangThai=='Đã giao cho đơn vị vận chuyển')
                    <option value="Đã hoàn thành" @if($donHang->trangThai == 'Đã hoàn thành') selected @endif>Đã hoàn thành</option>
                    <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
                @endif
            </select>
            <!-- Input mã vận chuyển -->


            <button type="submit">Cập nhật</button>
        </form>



        <!-- Kiểm tra xem có yêu cầu đổi hàng không -->
        @if ($yeuCauDoiHang)
            <br><br><a href="{{ route('taikhoans.khachhangs.yeucaudoihang.showAdmin', ['id' => $yeuCauDoiHang->id]) }}" class="btn btn-primary">
                Xem chi tiết yêu cầu đổi hàng
            </a>
        @endif


</div>
@endsection
