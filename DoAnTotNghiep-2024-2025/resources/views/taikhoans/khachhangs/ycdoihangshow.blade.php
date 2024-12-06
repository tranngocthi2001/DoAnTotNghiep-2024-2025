@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết yêu cầu đổi hàng #{{ $yeuCauDoiHang->id }}</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Thông tin yêu cầu đổi hàng</h5>
            <p><strong>Ngày yêu cầu:</strong> {{ $yeuCauDoiHang->ngayYeuCau }}</p>
            <p><strong>Lý do:</strong> {{ $yeuCauDoiHang->lyDo }}</p>
            <p><strong>Trạng thái:</strong>
                @if ($yeuCauDoiHang->trangThai === 0)
                    Chờ xử lý
                @elseif ($yeuCauDoiHang->trangThai === 1)
                    Đã duyệt
                @elseif ($yeuCauDoiHang->trangThai === 2)
                    Đã từ chối
                @else
                    Không xác định
                @endif
            </p>
        </div>
    </div>

    <h3>Chi tiết sản phẩm đổi</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>stt</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Hình ảnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($yeuCauDoiHang->chitietdoihangs as $index => $chiTiet)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @foreach ($sanPhams as $sanPham)
                                @if ($chiTiet->sanPhamDoiID==$sanPham->id)
                                    <p>{{$sanPham->tenSanPham}}</p>
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $chiTiet->soLuong }}</td>
                        <td>
                            @if ($chiTiet->hinhAnh)
                                <img src="{{ asset('storage/' . $chiTiet->hinhAnh) }}" alt="Hình ảnh sản phẩm" style="width: 100px; height: auto;">
                            @else
                                Không có
                            @endif
                        </td>
                    </tr>

            @endforeach
        </tbody>
    </table>

    {{-- <a href="{{ route('taikhoans.khachhangs.yeucaudoihang.index') }}" class="btn btn-secondary">Quay lại</a> --}}
</div>

@endsection
