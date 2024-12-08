@extends('layouts.app')

@section('content')
<h1>Quản lý Đơn Hàng</h1>
<div class="container">


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
                    <th>Nhân viên xử lý</th>
                    <th>Chi tiết</th>
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
                                <option value="Đã giao cho đơn vị vận chuyển" @if($donHang->trangThai == 'Đã giao cho đơn vị vận chuyển') selected @endif>Đã giao cho đơn vị vận chuyển</option>
                                <option value="Đã hoàn thành" @if($donHang->trangThai == 'Đã hoàn thành') selected @endif>Đã hoàn thành</option>
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
                    <th>Nhân viên xử lý</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Phiếu xuất hàng</th>
                    <th>Mã vận chuyển</th>

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
                                <option value="Đang xử lý" @if($donHang->trangThai == 'Đang xử lý') selected @endif>Đang xử lý</option>
                                <option value="Đã giao cho đơn vị vận chuyển" @if($donHang->trangThai == 'Đã giao cho đơn vị vận chuyển') selected @endif>Đã giao cho đơn vị vận chuyển</option>
                                <option value="Đã hoàn thành" @if($donHang->trangThai == 'Đã hoàn thành') selected @endif>Đã hoàn thành</option>
                                <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
                            </select>
                            <button type="submit">Cập nhật</button>
                        </form>

                    </td>
                    <td>{{ $donHang->nhanVienS ? $donHang->nhanVienS->hoTen : 'Chưa cập nhật' }}</td>

                    <td>
                        <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                    </td>
                    <td>
                        <a href="{{ route('quanlys.phieuxuathang.create', ['donHangId' => $donHang->id]) }}">Tạo Phiếu xuất hàng</a>

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
        <p>Không có đơn hàng cũ.</p>
    @endif

    <h2>Đơn hàng đã hoàn thành</h2>
    @if($donHangsHoanThanh->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                    <th>Nhân viên xử lý</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Phiếu xuất hàng</th>
                    <th>Mã vận chuyển</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsHoanThanh as $donHang)
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
                                <option value="Đã hoàn thành" @if($donHang->trangThai == 'Đã hoàn thành') selected @endif>Đã hoàn thành</option>
                                <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
                            </select>
                            <button type="submit">Cập nhật</button>
                        </form>

                    </td>
                    <td>{{ $donHang->nhanVienS ? $donHang->nhanVienS->hoTen : 'Chưa cập nhật' }}</td>

                    <td>
                        <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                    </td>
                    <td>
                        <a href="{{ route('quanlys.phieuxuathang.create', ['donHangId' => $donHang->id]) }}">Tạo Phiếu xuất hàng</a>

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
        <p>Không có đơn hàng đã hoàn thành.</p>
    @endif

    <h2>Đơn hàng đã hủy</h2>
    @if($donHangsHuy->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày đặt hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                    <th>Nhân viên xử lý</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Phiếu xuất hàng</th>
                    <th>Mã vận chuyển</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsHuy as $donHang)
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
                                <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
                            </select>
                            <button type="submit">Cập nhật</button>
                        </form>

                    </td>
                    <td>{{ $donHang->nhanVienS ? $donHang->nhanVienS->hoTen : 'Chưa cập nhật' }}</td>

                    <td>
                        <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                    </td>
                    <td>
                        <a href="{{ route('quanlys.phieuxuathang.create', ['donHangId' => $donHang->id]) }}">Tạo Phiếu xuất hàng</a>

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
        <p>Không có đơn hàng hủy.</p>
    @endif


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
