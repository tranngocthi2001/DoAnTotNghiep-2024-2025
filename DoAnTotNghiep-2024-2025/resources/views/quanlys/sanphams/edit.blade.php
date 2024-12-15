@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h2>Chỉnh Sửa Sản Phẩm</h2>

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

    <!-- Form chỉnh sửa sản phẩm -->
    <form action="{{ route('quanlys.sanpham.update', $sanpham->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="tenSanPham">Tên Sản Phẩm</label>
            <input type="text" name="tenSanPham" id="tenSanPham" class="form-control" value="{{ $sanpham->tenSanPham }}" required>
        </div>

        <div class="form-group">
            <label for="moTa">Mô Tả</label>
            <textarea name="moTa" id="moTa" class="form-control">{{ $sanpham->moTa }}</textarea>
        </div>

        <div class="form-group">
            <label for="gia">Giá</label>
            <input type="number" name="gia" id="gia" class="form-control" value="{{ $sanpham->gia }}" required min="0" step="0.01">
        </div>

        <div class="form-group">
            <label for="soLuong">Số Lượng</label>
            <input type="number" name="soLuong" id="soLuong" class="form-control" value="{{ $sanpham->soLuong }}" required min="0">
        </div>

        <div class="form-group">
            <label for="trangThai">Trạng Thái</label>
            <select name="trangThai" id="trangThai" class="form-control">
                <option value="1" {{ $sanpham->trangThai == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ $sanpham->trangThai == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div>

        <div class="form-group">
            <label for="danhmuc_id">Danh Mục</label>
            <select name="danhmuc_id" id="danhmuc_id" class="form-control">
                @foreach ($danhmucs as $danhmuc)
                    <option value="{{ $danhmuc->id }}" {{ $sanpham->danhmuc_id == $danhmuc->id ? 'selected' : '' }}>
                        {{ $danhmuc->tenDanhMuc }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Hiển thị các hình ảnh hiện tại -->
        <div class="form-group">
            <label>Hình Ảnh Hiện Tại</label>
            <div class="row">
                @php
                    $imagePaths = json_decode($sanpham->hinhAnh, true) ?? []; // Giải mã JSON để lấy danh sách ảnh
                @endphp

                @if (count($imagePaths) > 0)
                    @foreach ($imagePaths as $path)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <!-- Hiển thị ảnh -->
                                <img src="{{ asset('uploads/sanpham/' . $path) }}" class="card-img-top" alt="Hình Ảnh">
                                <div class="card-body text-center">
                                    <!-- Checkbox để chọn ảnh cần xóa -->
                                    <label>
                                        <input type="checkbox" name="delete_images[]" value="{{ $path }}">
                                        Xóa
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Không có hình ảnh nào được tải lên.</p>
                @endif
            </div>
        </div>
        <!-- Thêm hình ảnh mới -->
        <div class="form-group">
            <label for="hinhAnh">Thêm Hình Ảnh Mới</label>
            <input type="file" name="hinhAnh[]" id="hinhAnh" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Cập Nhật</button>
        <a href="{{ route('quanlys.sanpham.index') }}" class="btn btn-secondary mt-3">Quay Lại</a>
    </form>
</div>
@endsection
