@extends('layouts.layoutquanly')

@section('content')
<h1>&nbsp;&nbsp;&nbsp; </h1>

<div class="container">
<h3>Kết quả tìm kiếm cho đơn hàng #{{ $keyword }}</h3>
<table border="1">
    <thead>
        <tr>
            <th>Mã đơn hàng</th>
            <th>Ngày đặt hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
            <th>Nhân viên xử lý</th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donHangs as $donHang)
        <tr>
            <td>{{ $donHang->id }}</td>
            <td>{{ $donHang->ngayDatHang }}</td>
            <td>{{ number_format($donHang->tongTien,  0, ',', '.') }} VND</td>
            <td>{{ $donHang->trangThai }}</td>
            <td>
                <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="trangThai" required>
                        <option value="Đang xử lý" @if($donHang->trangThai == 'Đang xử lý') selected @endif>Đang xử lý</option>
                        <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>

                    </select>
                    <button type="submit">Cập nhật</button>
                </form>
                <td>{{ $donHang->nhanVienS ? $donHang->nhanVienS->hoTen : 'Chưa cập nhật' }}</td>

            </td>
            <td>
                <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
<h1>&nbsp;&nbsp;&nbsp; </h1>
<h1>&nbsp;&nbsp;&nbsp; </h1>
@endsection
