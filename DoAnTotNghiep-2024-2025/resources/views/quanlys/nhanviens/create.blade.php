@extends('layouts.app')

@section('content')
    <h2>Tạo nhân viên mới</h2>
    <form action="{{ route('quanlys.nhanvien.store') }}" method="POST">
        @csrf
        <label for="tenTaiKhoan">Tên tài khoản:</label>
        <input type="text" id="tenTaiKhoan" name="tenTaiKhoan" required>
        <br>
        <label for="matKhau">Mật khẩu:</label>
        <input type="password" id="matKhau" name="matKhau" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <br>
        <label for="vaiTro">Vai trò:</label>
        <select id="vaiTro" name="vaiTro" required>
            <option value="nhanvien">Nhân viên</option>
            <option value="quanly">Quản lý</option>
            <option value="admin">Admin</option>
        </select>
        <br>
        <label for="trangThai">Trạng thái:</label>
        <select id="trangThai" name="trangThai">
            <option value="1">Kích hoạt</option>
            <option value="0">Vô hiệu</option>
        </select>
        <br>
        <button type="submit">Tạo mới</button>
    </form>

@endsection
