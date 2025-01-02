@extends('layouts.layoutquanly')

@section('content')

<div class="container">
    @if (session('error'))
        {{ session('error') }}
    @endif
    @if (session('success'))
        {{ session('success') }}
    @endif
    <h1>Tạo Đơn Hàng</h1>
    <form action="{{ route('quanlys.donhang.create') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="khachhang_id">Khách Hàng</label>
            <select name="khachhang_id" id="khachhang_id" class="form-control" required>
                <option value="">Chọn khách hàng</option>
                @foreach ($khachHangs as $khachHang)
                    <option value="{{ $khachHang->id }}">{{ $khachHang->hoTen }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="diaChiGiaoHang">Địa Chỉ Giao Hàng</label>
            <input type="text" name="diaChiGiaoHang" id="diaChiGiaoHang" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="sdt">Số Điện Thoại</label>
            <input type="text" name="sdt" id="sdt" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="tenKhachHang">Tên Khách Hàng</label>
            <input type="text" name="tenKhachHang" id="tenKhachHang" class="form-control" required>
        </div>


        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Tạo Đơn Hàng</button>
        </div>
    </form>
</div>



@endsection
