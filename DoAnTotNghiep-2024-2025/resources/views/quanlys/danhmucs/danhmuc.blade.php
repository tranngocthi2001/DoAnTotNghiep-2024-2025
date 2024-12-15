@extends('layouts.layoutquanly')

@section('content')

<div class="container">
    <h2>Danh Sách Danh Mục</h2>
    <a href="{{ route('quanlys.danhmuc.create') }}" class="btn btn-primary mb-3">Thêm Danh Mục</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Danh Mục</th>
                <th>Mô Tả</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($danhmucs as $danhmuc)
            <tr>
                <td>{{ $danhmuc->id }}</td>
                <td>{{ $danhmuc->tenDanhMuc }}</td>
                <td>{{ $danhmuc->moTa }}</td>
                <td>{{ $danhmuc->trangThai ? 'Hoạt động' : 'Không hoạt động' }}</td>
                <td>
                    <a href="{{ route('quanlys.danhmuc.edit', $danhmuc->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('quanlys.danhmuc.destroy', $danhmuc->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Tất cả sản phẩm thuộc danh mục này sẽ bị xóa!!!. Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
