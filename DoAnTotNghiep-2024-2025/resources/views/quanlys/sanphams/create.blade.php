@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h2>Thêm Sản Phẩm Mới</h2>

    <!-- Hiển thị lỗi nếu có -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Thêm Sản Phẩm -->
    <form action="{{ route('quanlys.sanpham.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="tenSanPham">Tên Sản Phẩm</label>
            <input type="text" name="tenSanPham" id="tenSanPham" class="form-control" required value="{{ old('tenSanPham') }}">
        </div>

        <div class="form-group">
            <label for="moTa">Mô Tả</label>
            <textarea name="moTa" id="moTa" class="form-control">{{ old('moTa') }}</textarea>
        </div>

        <div class="form-group">
            <label for="gia">Giá</label>
            <input type="number" name="gia" id="gia" class="form-control" required min="0" step="0.01" value="{{ old('gia') }}">
        </div>

        <div class="form-group">
            <label for="soLuong">Số Lượng</label>
            <input type="number" name="soLuong" id="soLuong" class="form-control" required min="0" value="{{ old('soLuong') }}">
        </div>

        <div class="form-group">
            <label for="trangThai">Trạng Thái</label>
            <select name="trangThai" id="trangThai" class="form-control">
                <option value="1" {{ old('trangThai') == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ old('trangThai') == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <div class="form-group">
            <label for="danhmuc_id">Danh Mục</label>
            <select name="danhmuc_id" id="danhmuc_id" class="form-control">
                @foreach ($danhmucs as $danhmuc)
                    <option value="{{ $danhmuc->id }}" {{ old('danhmuc_id') == $danhmuc->id ? 'selected' : '' }}>
                        {{ $danhmuc->tenDanhMuc }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="hinhAnh">Hình Ảnh</label>
            <input type="file" name="hinhAnh[]" id="hinhAnh" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Thêm Sản Phẩm</button>
    </form>
</div>
@endsection
