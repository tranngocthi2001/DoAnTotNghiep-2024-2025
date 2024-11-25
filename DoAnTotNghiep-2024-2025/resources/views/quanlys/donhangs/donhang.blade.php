@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Quản lý Đơn Hàng</h1>

    <h2>Đơn hàng mới</h2>
    @if($donHangsMoi->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                    <th>Chi tiết</th>
                    <th>Nhân viên xử lý</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donHangsMoi as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ $donHang->ngayDatHang }}</td>
                    <td>{{ number_format($donHang->tongTien, 3) }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>
                    <td>
                        <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="trangThai" required>
                                <option value="Chưa xác nhận" @if($donHang->trangThai == 'Chưa xác nhận') selected @endif>Chưa xác nhận</option>
                                <option value="Đang xử lý" @if($donHang->trangThai == 'Đang xử lý') selected @endif>Đang xử lý</option>
                                <option value="Đã hoàn thành" @if($donHang->trangThai == 'Đã hoàn thành') selected @endif>Đã hoàn thành</option>
                                <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
                            </select>
                            <button type="submit">Cập nhật</button>
                        </form>
                        <td>{{ $donHang->nhanvien ? $donHang->nhanvien->tenNhanVien : 'Chưa cập nhật' }}</td>

                    </td>
                    <td>
                        <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Không có đơn hàng mới.</p>
    @endif

    <h2>Đơn hàng cũ</h2>
    @if($donHangsCu->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                    <th>Chi tiết</th>
                    <th>Nhân viên xử lý</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donHangsCu as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ $donHang->ngayDatHang }}</td>
                    <td>{{ number_format($donHang->tongTien, 3) }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>

                    <td>
                        <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="trangThai" required>
                                <option value="Chưa xác nhận" @if($donHang->trangThai == 'Chưa xác nhận') selected @endif>Chưa xác nhận</option>
                                <option value="Đang xử lý" @if($donHang->trangThai == 'Đang xử lý') selected @endif>Đang xử lý</option>
                                <option value="Đã hoàn thành" @if($donHang->trangThai == 'Đã hoàn thành') selected @endif>Đã hoàn thành</option>
                                <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
                            </select>
                            <button type="submit">Cập nhật</button>
                        </form>

                    </td>
                    <td>
                        <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                    </td>
                    <td>{{ $donHang->nhanvien ? $donHang->nhanvien->tenTaiKhoan : 'Chưa cập nhật' }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Không có đơn hàng cũ.</p>
    @endif
</div>
@endsection
