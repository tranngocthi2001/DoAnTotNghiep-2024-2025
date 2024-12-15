@extends('layouts.layoutquanly')

@section('content')
<h2>Đơn hàng yêu cầu đổi</h2>
@if($donHangsDoi->count() > 0)
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ngày đặt hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Nhân viên xử lý</th>
                <th>Chi tiết đơn hàng</th>
                <th>Mã vận chuyển</th>

            </tr>
        </thead>
        <tbody>
            @foreach($donHangsDoi as $donHang)
            <tr>
                <td>{{ $donHang->id }}</td>
                <td>{{ $donHang->ngayDatHang }}</td>
                <td>{{ number_format($donHang->tongTien, 3) }} VND</td>
                <td>{{ $donHang->trangThai }}</td>


                <td>{{ $donHang->nhanVienS ? $donHang->nhanVienS->hoTen : 'Chưa cập nhật' }}</td>

                <td>
                    <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                </td>

                <td>
                    @if ($donHang->maVanChuyen!=null)
                        <a>{{$donHang->maVanChuyen }}</a>
                    @else
                        <a>chưa có</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Không có đơn hàng đổi.</p>
@endif
</div>
@endsection
