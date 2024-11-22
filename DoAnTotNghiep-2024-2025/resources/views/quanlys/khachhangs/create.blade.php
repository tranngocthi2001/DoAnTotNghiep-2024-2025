@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm Khách Hàng</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('quanlys.khachhang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tenTaiKhoan" class="form-label">Tên Tài Khoản</label>
            <input type="text" class="form-control" id="tenTaiKhoan" name="tenTaiKhoan" value="{{ old('tenTaiKhoan') }}" required>
        </div>
        <div class="mb-3">
            <label for="matKhau" class="form-label">Mật Khẩu</label>
            <input type="password" class="form-control" id="matKhau" name="matKhau" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="sdt" class="form-label">Số Điện Thoại</label>
            <input type="text" class="form-control" id="sdt" name="sdt" value="{{ old('sdt') }}" required>
        </div>
        <div class="mb-3">
            <label for="diaChi" class="form-label">Địa Chỉ</label>
            <input type="text" class="form-control" id="diaChi" name="diaChi" value="{{ old('diaChi') }}">
        </div>
        <div class="mb-3">
            <label for="hoTen" class="form-label">Họ Tên</label>
            <input type="text" class="form-control" id="hoTen" name="hoTen" value="{{ old('hoTen') }}" required>
        </div>
        <div class="mb-3">
            <label for="trangThai" class="form-label">Trạng Thái</label>
            <select class="form-control" id="trangThai" name="trangThai" required>
                <option value="1">Hoạt Động</option>
                <option value="0">Không Hoạt Động</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Khách Hàng</button>
    </form>
</div>
@endsection
