@extends('layouts.layoutkhachhang')

@section('content')
<div class="container">
    <h2 class="mb-4">Chỉnh Sửa Thông Tin Cá Nhân</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <form action="{{ route('khachhang.update', $khachhang->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="hoTen" class="form-label">Họ Tên</label>
            <input type="text" class="form-control @error('hoTen') is-invalid @enderror" id="hoTen" name="hoTen" value="{{ old('hoTen', $khachhang->hoTen) }}">
            @error('hoTen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $khachhang->email) }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sdt" class="form-label">Số Điện Thoại</label>
            <input type="number" class="form-control @error('sdt') is-invalid @enderror" id="sdt" name="sdt" value="{{ old('sdt', $khachhang->sdt) }}">
            @error('sdt')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="diaChi" class="form-label">Địa Chỉ</label>
            <input type="text" class="form-control @error('diaChi') is-invalid @enderror" id="diaChi" name="diaChi" value="{{ old('diaChi', $khachhang->diaChi) }}">
            @error('diaChi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="matKhau" class="form-label">Mật Khẩu (Để trống nếu không muốn đổi)</label>
            <input type="password" class="form-control @error('matKhau') is-invalid @enderror" id="matKhau" name="matKhau">
            @error('matKhau')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="matKhau_confirmation" class="form-label">Xác Nhận Mật Khẩu</label>
            <input type="password" class="form-control" id="matKhau_confirmation" name="matKhau_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
    </form>
</div>
@endsection
