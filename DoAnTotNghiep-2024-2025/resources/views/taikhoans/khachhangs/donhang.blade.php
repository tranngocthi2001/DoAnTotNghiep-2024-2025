@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Đơn hàng của bạn</h1>

    @if($donhangs->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Số điện thoại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donhangs as $donhang)
                    <tr>

                        <td>{{ $donhang->id }}</td>
                        <td>{{ $donhang->tenKhachHang }}</td>
                        <td>{{ $donhang->ngayDatHang }}</td>
                        <td>{{ number_format($donhang->tongTien, 3) }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
                        <td>{{ $donhang->diaChiGiaoHang }}</td>
                        <td>{{ $donhang->sdt }}</td>
                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h1>Đơn hàng đã giao</h1>

    @if($donhangsHoanThanh->isEmpty())
        <p>Bạn chưa có đơn hàng hoàn thành nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Số điện thoại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donhangsHoanThanh as $donhang)
                    <tr>

                        <td>{{ $donhang->id }}</td>
                        <td>{{ $donhang->tenKhachHang }}</td>
                        <td>{{ $donhang->ngayDatHang }}</td>
                        <td>{{ number_format($donhang->tongTien, 3) }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
                        <td>{{ $donhang->diaChiGiaoHang }}</td>
                        <td>{{ $donhang->sdt }}</td>
                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h1>Đơn hàng đã hủy</h1>

    @if($donhangsHuy->isEmpty())
        <p>Bạn chưa có đơn hàng hủy nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Số điện thoại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donhangsHuy as $donhang)
                    <tr>

                        <td>{{ $donhang->id }}</td>
                        <td>{{ $donhang->tenKhachHang }}</td>
                        <td>{{ $donhang->ngayDatHang }}</td>
                        <td>{{ number_format($donhang->tongTien, 3) }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
                        <td>{{ $donhang->diaChiGiaoHang }}</td>
                        <td>{{ $donhang->sdt }}</td>
                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif


    <h1>Đổi hàng eregterwg</h1>

    @if($donhangsDoi->isEmpty())
        <p>Bạn chưa có yêu cầu đổi nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Số điện thoại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donhangsDoi as $donhang)
                    <tr>

                        <td>{{ $donhang->id }}</td>
                        <td>{{ $donhang->tenKhachHang }}</td>
                        <td>{{ $donhang->ngayDatHang }}</td>
                        <td>{{ number_format($donhang->tongTien, 3) }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
                        <td>{{ $donhang->diaChiGiaoHang }}</td>
                        <td>{{ $donhang->sdt }}</td>
                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
