@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách đơn hàng</h1>

    @if($donhangs->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
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
