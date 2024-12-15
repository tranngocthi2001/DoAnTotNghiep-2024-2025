@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h1>Danh Sách Khách Hàng</h1>
    <a href="{{ route('quanlys.khachhang.create') }}" class="btn btn-primary">Thêm Khách Hàng</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Tài Khoản</th>
                <th>Họ Tên</th>
                <th>Email</th>
                <th>Số Điện Thoại</th>
                <th>Trạng thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($khachhangs as $khachhang)
                <tr>
                    <td>{{ $khachhang->id }}</td>
                    <td>{{ $khachhang->tenTaiKhoan }}</td>
                    <td>{{ $khachhang->hoTen }}</td>
                    <td>{{ $khachhang->email }}</td>
                    <td>{{ $khachhang->sdt }}</td>
                    <td>
                        @if ($khachhang->trangThai)
                            <span class="badge bg-success">Kích Hoạt</span>
                        @else
                            <span class="badge bg-danger">Khóa</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('khachhang.updateStatus', $khachhang->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $khachhang->trangThai ? 'btn-danger' : 'btn-success' }}">
                                {{ $khachhang->trangThai ? 'Khóa' : 'Kích Hoạt' }}
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
