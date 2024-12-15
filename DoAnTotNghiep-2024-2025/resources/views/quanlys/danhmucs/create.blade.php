@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h2>Thêm Danh Mục</h2>
    <form action="{{ route('quanlys.danhmuc.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tenDanhMuc">Tên Danh Mục</label>
            <input type="text" name="tenDanhMuc" id="tenDanhMuc" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="moTa">Mô Tả</label>
            <textarea name="moTa" id="moTa" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="trangThai">Trạng Thái</label>
            <select name="trangThai" id="trangThai" class="form-control">
                <option value="1">Hoạt động</option>
                <option value="0">Không hoạt động</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
    </form>
</div>
@endsection
