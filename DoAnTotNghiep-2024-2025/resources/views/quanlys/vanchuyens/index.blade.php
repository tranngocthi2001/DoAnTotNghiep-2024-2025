<!-- resources/views/quanlys/vanchuyens/index.blade.php -->
@extends('layouts.app')

@section('content')
    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif

    @if($vanchuyens)
        <!-- Kiểm tra nếu danh sách vận chuyển không rỗng -->
        <p>Thông tin vận chuyển:</p>
        <table>
            <thead>
                <tr>
                    <th>Tên vận chuyển</th>
                    <th>Ngày giao dự kiến</th>
                    <th>Ngày thực tế</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vanchuyens as $vanchuyen)
                    <tr>
                        <td>{{ $vanchuyen->tenVanChuyen }}</td>
                        <td>{{ $vanchuyen->ngayGiaoDuKien }}</td>
                        <td>{{ $vanchuyen->ngayThucTe ?? 'Chưa có' }}</td>  <!-- Thêm kiểm tra cho ngày thực tế -->
                        <td>{{ $vanchuyen->trangThaiVanChuyen }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Không có thông tin vận chuyển cho đơn hàng này.</p>
    @endif

    <!-- Liên kết thêm thông tin vận chuyển -->
    <a href="{{ route('vanchuyens.create', ['donhang_id' => $donhang->id]) }}">Thêm thông tin vận chuyển</a>
@endsection
