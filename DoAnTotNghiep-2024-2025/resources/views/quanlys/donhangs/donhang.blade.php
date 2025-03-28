@extends('layouts.layoutquanly')

@section('content')

<div class="container">
    <h1>Quản lý Đơn Hàng</h1>

    <div  class="container px-4 px-lg-5">
        <form action="{{ route ('quanlys.donhang.timkiem') }}" method="GET" class="d-flex">
            <input type="number" name="q" class="form-control me-2" placeholder="Nhập mã đơn hàng để tìm kiếm..." value="{{ request('q') }}">
            <button type="submit" class="btn btn-outline-success">Tìm kiếm</button>
        </form>
    </div>
@if (session('loikhongtimthay'))
<div class="alert alert-warning">
    {{ session('loikhongtimthay') }}
</div>
@endif

<h5><a href="{{route('donhang.create.form')}}"> Tạo đơn hàng mới</a></h5>
    <h5>Tổng số đơn hàng: {{ $donHangCount }}</h5>
    <h2>Đơn hàng mới</h2>
    @if($donHangsMoi->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Cập nhật</th>
                    <th>Chi tiết đơn hàng</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsMoi as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
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
        <table border="1"class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    {{-- <th>Hành động</th> --}}
                    <th>Chi tiết đơn hàng</th>
                    <th>Phiếu xuất hàng</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsCu as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ number_format($donHang->tongTien,  0, ',', '.') }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>

                    {{-- <td>
                        <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="trangThai" required> --}}

                                {{-- <option value="Đã giao cho đơn vị vận chuyển" @if($donHang->trangThai == 'Đã giao cho đơn vị vận chuyển') selected @endif>Đã giao cho đơn vị vận chuyển</option> --}}

                                {{-- <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>

                            </select>
                            <button type="submit">Cập nhật</button>
                        </form>

                    </td> --}}
                    {{-- <td>{{ $donHang->nhanVienS ? $donHang->nhanVienS->hoTen : 'Chưa cập nhật' }}</td> --}}

                    <td>
                        <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                    </td>
                    <td>
                        @foreach ($donHang->phieuXuatHangs as $phieuXuatHang)
                            @if ($phieuXuatHang!=null)
                                <p>Đã tạo PXH: {{ $phieuXuatHang->id }}</p>

                            @endif
                        @endforeach

                            @if ($donHang->phieuXuatHangs->isEmpty())
                                <a href="{{ route('quanlys.phieuxuathang.create', ['donHangId' => $donHang->id]) }}">Tạo Phiếu xuất hàng</a>
                            @endif

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Không có đơn hàng cũ.</p>
    @endif

    <h2>Đơn hàng đã giao cho đơn vị vận chuyển</h2>
    @if($donHangsVanChuyen->count() > 0)
        <table border="1"class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    {{-- <th>Hành động</th> --}}
                    <th>Chi tiết đơn hàng</th>
                    {{-- <th>Phiếu xuất hàng</th> --}}
                    <th>Mã vận chuyển</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsVanChuyen as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ number_format($donHang->tongTien,  0, ',', '.') }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>

                    {{-- <td>
                        <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="trangThai" required>
                                <option value="Đã hoàn thành" @if($donHang->trangThai == 'Đã hoàn thành') selected @endif>Đã hoàn thành</option>
                                <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
                            </select>
                            <button type="submit">Cập nhật</button>
                        </form>

                    </td> --}}

                    <td>
                        <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                    </td>
                    {{-- <td>
                        <a href="{{ route('quanlys.phieuxuathang.create', ['donHangId' => $donHang->id]) }}">Tạo Phiếu xuất hàng</a>

                    </td> --}}
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



    <h2>Đơn hàng yêu cầu đổi</h2>
    @if($donHangsDoi->count() > 0)
        <table border="1"class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Mã vận chuyển</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsDoi as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ number_format($donHang->tongTien,  0, ',', '.') }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>

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


    <h2>Đơn hàng mới của khách hàng đổi hàng</h2>
    @if($donHangsDaDoi->count() > 0)
        <table border="1"class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Mã vận chuyển</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsDaDoi as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ number_format($donHang->tongTien,  0, ',', '.') }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>

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

    <h2>Kết quả xác nhận đổi</h2>
    @if($donHangsCuDaDoi->count() > 0)
        <table border="1"class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Mã vận chuyển</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsCuDaDoi as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ number_format($donHang->tongTien,  0, ',', '.') }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>

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


    <h2>Đơn hàng đã hủy</h2>
    @if($donHangsHuy->count() > 0)
        <table border="1"class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    {{-- <th>Hành động</th> --}}
                    <th>Chi tiết đơn hàng</th>
                    {{-- <th>Phiếu xuất hàng</th> --}}
                    <th>Mã vận chuyển</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsHuy as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ number_format($donHang->tongTien,  0, ',', '.') }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>

                    {{-- <td>
                        <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="trangThai" required>
                                <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
                            </select>
                            <button type="submit">Cập nhật</button>
                        </form>

                    </td> --}}

                    <td>
                        <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                    </td>
                    {{-- <td>
                        <a href="{{ route('quanlys.phieuxuathang.create', ['donHangId' => $donHang->id]) }}">Tạo Phiếu xuất hàng</a>

                    </td> --}}
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



    <h2>Đơn hàng đã hoàn thành</h2>
    @if($donHangsHoanThanh->count() > 0)
        <table border="1"class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    {{-- <th>Hành động</th> --}}
                    <th>Chi tiết đơn hàng</th>
                    {{-- <th>Phiếu xuất hàng</th> --}}
                    <th>Mã vận chuyển</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsHoanThanh as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ number_format($donHang->tongTien,  0, ',', '.') }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>

                    {{-- <td>
                        <form action="{{ route('quanlys.donhang.update', $donHang->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="trangThai" required>
                                <option value="Đã hoàn thành" @if($donHang->trangThai == 'Đã hoàn thành') selected @endif>Đã hoàn thành</option>
                                <option value="Đã hủy" @if($donHang->trangThai == 'Đã hủy') selected @endif>Đã hủy</option>
                            </select>
                            <button type="submit">Cập nhật</button>
                        </form>

                    </td> --}}

                    <td>
                        <a href="{{ route('quanlys.donhang.show', $donHang->id) }}"> Xem chi tiết</a>
                    </td>
                    {{-- <td>
                        <a href="{{ route('quanlys.phieuxuathang.create', ['donHangId' => $donHang->id]) }}">Tạo Phiếu xuất hàng</a>

                    </td> --}}
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

<h2>Đơn hàng chờ thanh toán</h2>
    @if($donHangsChothanhtoan->count() > 0)
        <table border="1"class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                    <th>Mã vận chuyển</th>

                </tr>
            </thead>
            <tbody>
                @foreach($donHangsChothanhtoan as $donHang)
                <tr>
                    <td>{{ $donHang->id }}</td>
                    <td>{{ number_format($donHang->tongTien,  0, ',', '.') }} VND</td>
                    <td>{{ $donHang->trangThai }}</td>
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
        <p>Không có đơn hàng chờ thánh toán.</p>
    @endif
</div>
</div>
@endsection
