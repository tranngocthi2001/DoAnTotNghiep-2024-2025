@extends('layouts.layoutquanly')

@section('content')
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
        <label for="tenTaiKhoan">Tên tài khoản:</label>
        <input type="text" id="tenTaiKhoan" name="tenTaiKhoan" required><br>

        <label for="matKhau">Mật khẩu:</label>
        <input type="password" id="matKhau" name="matKhau" required><br>
        <div class="form-group">
            <label for="matKhau_confirmation">Nhập lại mật khẩu</label>
            <input type="password" name="matKhau_confirmation" id="matKhau_confirmation" class="form-control" required>
        </div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br>

        <label for="sdt">Số điện thoại:</label>
        <input type="text" id="sdt" name="sdt"><br>

        <label for="diaChi">Địa chỉ:</label>
        <input type="text" id="diaChi" name="diaChi"><br>

        <label for="hoTen">Họ và tên:</label>
        <input type="text" id="hoTen" name="hoTen"><br>

        <label for="vaiTro">Vai trò:</label>
        <select id="vaiTro" name="vaiTro" required>
            <option value="nhanvien">Nhân viên</option>
            <option value="quanly">Quản lý</option>
            <option value="admin">Admin</option>
        </select><br>

        <button type="submit">Đăng ký</button>
    </form>
</body>
</html>
@endsection
