@extends('layouts.layoutkhachhang')

@section('content')
<div class="container">
    @if (session('huythanhcong'))
        <div class="alert alert-warning">
            {{ session('huythanhcong') }}
        </div>
    @endif
    @if (session('dathangthanhcong'))
        <div class="alert alert-warning">
            {{ session('dathangthanhcong') }}
        </div>
    @endif
    <h1>Đơn hàng của bạn</h1>

    @if($donhangs->isEmpty())
        <p>Bạn chưa có đơn hàng nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donhangs as $donhang)
                    <tr>

                        <td>{{ $donhang->id }}</td>
                        <td>{{ number_format($donhang->tongTien, 0, ',', '.') }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h1>Chờ thanh toán</h1>

    @if($donhangsChothanhtoan->isEmpty())
        <p>Bạn chưa có đơn hàng chờ thanh toán.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donhangsChothanhtoan as $donhang)
                    <tr>

                        <td>{{ $donhang->id }}</td>
                        <td>{{ number_format($donhang->tongTien,  0, ',', '.') }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
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
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donhangsHoanThanh as $donhang)
                    <tr>

                        <td>{{ $donhang->id }}</td>

                        <td>{{ number_format($donhang->tongTien, 0, ',', '.') }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>

                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif




    <h1>Yêu cầu đổi hàng</h1>

    @if($donhangsDoi->isEmpty())
        <p>Bạn chưa có yêu cầu đổi nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donhangsDoi as $donhang)
                    <tr>
                        <td>{{ $donhang->id }}</td>

                        <td>{{ number_format($donhang->tongTien,  0, ',', '.') }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

<h1>Kết quả đổi hàng</h1>

    @if($donHangsCuDaDoi->isEmpty())
        <p>Bạn chưa có yêu cầu đổi nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donHangsCuDaDoi as $donhang)
                    <tr>
                        <td>{{ $donhang->id }}</td>

                        <td>{{ number_format($donhang->tongTien,  0, ',', '.') }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h1>Đơn hàng mới đổi hàng</h1>

    @if($donHangsDaDoi->isEmpty())
        <p>Bạn chưa có yêu cầu đổi nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donHangsDaDoi as $donhang)
                    <tr>
                        <td>{{ $donhang->id }}</td>

                        <td>{{ number_format($donhang->tongTien,  0, ',', '.') }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

<h1>Hủy đơn hàng</h1>

    @if($donhangsHuy->isEmpty())
        <p>Bạn chưa có đơn hàng hủy nào.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết đơn hàng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donhangsHuy as $donhang)
                    <tr>
                        <td>{{ $donhang->id }}</td>
                        <td>{{ number_format($donhang->tongTien,  0, ',', '.') }} VND</td>
                        <td>{{ $donhang->trangThai }}</td>
                        <td>
                            <a href="{{ route('khachhang.donhang.show', $donhang->id) }}">Xem chi tiết</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</div>
@endsection
