<!-- resources/views/quanlys/vanchuyens/index.blade.php -->
@extends('layouts.app')

@section('content')
    @if($vanchuyen)
        <div class="container">
        <table class="table table-bordered" border="1">
            <thead>
                <tr>
                    <td>Tên vận chuyển</td>
                    <td>Trạng thái vận chuyển</td>
                    <td>Ngày giao dự kiến</td>
                    <td>Ngày giao thực tế</td>
                    <td>Mã vận chuyển</td>
                    <td>Mã đơn hàng</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $vanchuyen->tenVanChuyen }}</td>
                    <td>{{ $vanchuyen->trangThaiVanChuyen }}</td>
                    <td>{{ $vanchuyen->ngayGiaoDuKien }}</td>
                    <td>{{ $vanchuyen->ngayThucTe }}</td>
                    <td>{{ $vanchuyen->maVanChuyen }}</td>
                    <td>{{ $vanchuyen->donhang_id }}</td>
                </tr>
            </tbody>

        </table>
    @else
        <p>{{ $message }}</p>
    @endif

    <!-- Liên kết thêm thông tin vận chuyển -->
    <a href="{{ route('vanchuyens.create', ['donhang_id' => $donhang->id]) }}">Thêm thông tin vận chuyển</a>
</div>
    @endsection
