@extends('layouts.layoutquanly')

@section('content')
<div class="container">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head>
<body>
    <h1>Đăng ký tài khoản</h1>

    <!-- Hiển thị thông báo lỗi nếu có -->
    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form đăng ký -->
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tenTaiKhoan">Tên tài khoản</label>
            <input type="text" name="tenTaiKhoan" id="tenTaiKhoan" class="form-control" required>
            @error('tenTaiKhoan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="matKhau">Mật khẩu</label>
            <input type="password" name="matKhau" id="matKhau" class="form-control" required>
            @error('matKhau')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="matKhau_confirmation">Nhập lại mật khẩu</label>
            <input type="password" name="matKhau_confirmation" id="matKhau_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="sdt">Số điện thoại</label>
            <input type="text" name="sdt" id="sdt" class="form-control" required>
            @error('sdt')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="diaChi">Địa chỉ</label>
            <input type="text" name="diaChi" id="diaChi" class="form-control">
        </div>
        <div class="form-group">
            <label for="hoTen">Họ tên</label>
            <input type="text" name="hoTen" id="hoTen" class="form-control" required>
            @error('hoTen')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Đăng Ký</button>
    </form>
</body>
</html>
</div>
@endsection
