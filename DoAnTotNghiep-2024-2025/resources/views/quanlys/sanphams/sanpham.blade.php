@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Danh Sách Sản Phẩm</h2>

    <!-- Thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Nút Thêm Sản Phẩm -->
    <div class="mb-3">
        <a href="{{ route('quanlys.sanpham.create') }}" class="btn btn-primary">Thêm Sản Phẩm</a>
    </div>

    <!-- Bảng Hiển Thị Sản Phẩm -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên Sản Phẩm</th>
                <th>Mô Tả</th>
                <th>Giá</th>
                <th>Số Lượng</th>
                <th>Trạng Thái</th>
                <th>Danh Mục</th>
                <th>Hình Ảnh</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sanphams as $key => $sanpham)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $sanpham->tenSanPham }}</td>
                    <td>{{ Str::limit($sanpham->moTa, 50) }}</td>
                    <td>{{ number_format($sanpham->gia, 0, ',', '.') }} VND</td>
                    <td>{{ $sanpham->soLuong }}</td>
                    <td>
                        @if ($sanpham->trangThai)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Không hoạt động</span>
                        @endif
                    </td>
                    <td>{{ $sanpham->danhmuc->tenDanhMuc ?? 'Chưa phân loại' }}</td>
                    <td>
                        @if ($sanpham->hinhAnh)
                            <img src="{{ asset('uploads/sanpham/' . $sanpham->hinhAnh) }}" alt="Hình Ảnh" width="80">
                        @else
                            <span>Không có</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('quanlys.sanpham.show', $sanpham->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('quanlys.sanpham.edit', $sanpham->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('quanlys.sanpham.destroy', $sanpham->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection