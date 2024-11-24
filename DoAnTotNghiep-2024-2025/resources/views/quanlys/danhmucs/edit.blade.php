@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Chỉnh Sửa Danh Mục</h2>
    <form action="{{ route('quanlys.danhmuc.update', $danhmuc->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Sử dụng phương thức PUT cho cập nhật -->
        <div class="form-group">
            <label for="tenDanhMuc">Tên Danh Mục</label>
            <input
                type="text"
                name="tenDanhMuc"
                id="tenDanhMuc"
                class="form-control"
                value="{{ $danhmuc->tenDanhMuc }}"
                required
            >
        </div>
        <div class="form-group">
            <label for="moTa">Mô Tả</label>
            <textarea
                name="moTa"
                id="moTa"
                class="form-control"
            >{{ $danhmuc->moTa }}</textarea>
        </div>
        <div class="form-group">
            <label for="trangThai">Trạng Thái</label>
            <select name="trangThai" id="trangThai" class="form-control">
                <option value="1" {{ $danhmuc->trangThai == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ $danhmuc->trangThai == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
    </form>
</div>
@endsection
