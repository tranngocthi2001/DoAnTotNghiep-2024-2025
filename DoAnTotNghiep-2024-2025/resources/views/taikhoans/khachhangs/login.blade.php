@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Đăng Nhập Khách Hàng</h1>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('khachhang.login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tenTaiKhoan" class="form-label">Tên Tài Khoản</label>
            <input type="text" class="form-control" id="tenTaiKhoan" name="tenTaiKhoan" required>
        </div>
        <div class="mb-3">
            <label for="matKhau" class="form-label">Mật Khẩu</label>
            <input type="password" class="form-control" id="matKhau" name="matKhau" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
    </form>
</div>
@endsection
