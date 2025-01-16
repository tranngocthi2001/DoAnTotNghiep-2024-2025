@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    @if(isset($nhanVien))
        <form action="{{ route('quanlys.nhanvien.update', $nhanVien->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="tenTaiKhoan" class="form-label">Tên Tài Khoản</label>
                <input type="text" class="form-control" id="tenTaiKhoan" name="tenTaiKhoan" value="{{ $nhanVien->tenTaiKhoan }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $nhanVien->email }}" required>
            </div>
            <div class="form-group">
                <label for="sdt">Số Điện Thoại</label>
                <input type="number" name="sdt" id="sdt" class="form-control" required pattern="[0-9]{10}"
                title="Số điện thoại phải có đúng 10 chữ số">
                        @error('sdt')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
            </div>
            <div class="mb-3">
                <label for="diaChi" class="form-label">Địa Chỉ</label>
                <input type="text" class="form-control" id="diaChi" name="diaChi" value="{{ $nhanVien->diaChi }}">
            </div>
            <div class="mb-3">
                <label for="hoTen" class="form-label">Họ Tên</label>
                <input type="text" class="form-control" id="hoTen" name="hoTen" value="{{ $nhanVien->hoTen }}" required>
            </div>
            @if ($nhanVien->vaiTro!='admin')
                <div class="mb-3">
                    <label for="vaiTro" class="form-label">Vai Trò</label>
                    <select class="form-control" id="vaiTro" name="vaiTro" required>
                        <option value="quanly" {{ $nhanVien->vaiTro == 'quanly' ? 'selected' : '' }}>Quản lý</option>
                        <option value="nhanvien" {{ $nhanVien->vaiTro == 'nhanvien' ? 'selected' : '' }}>Nhân viên</option>
                    </select>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
    @else
        <p>Không tìm thấy thông tin nhân viên.</p>
    @endif
</div>
@endsection
