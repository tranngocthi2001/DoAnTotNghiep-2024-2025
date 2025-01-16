@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h1 class="container">Danh sách nhân viên</h1>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    <a class="btn btn-primary" href="{{ route('quanlys.nhanvien.create') }}">Tạo nhân viên mới</a>
    <table class="container">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên tài khoản</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nhanviens as $nhanvien)
                <tr>
                    <td>{{ $nhanvien->id }}</td>
                    <td>{{ $nhanvien->tenTaiKhoan }}</td>
                    <td>{{ $nhanvien->hoTen }}</td>
                    <td>{{ $nhanvien->email }}</td>
                    <td>{{ $nhanvien->vaiTro }}</td>
                    <td>
                        @if ($nhanvien->trangThai)
                            <span class="badge bg-success">Kích Hoạt</span>
                        @else
                            <span class="badge bg-danger">Khóa</span>
                        @endif
                    </td>
                    <td>
                        @if ($nhanvien->vaiTro!='admin')
                            <form action="{{ route('quanlys.nhanvien.updateStatus', $nhanvien->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $nhanvien->trangThai ? 'btn-danger' : 'btn-success' }}">
                                    {{ $nhanvien->trangThai ? 'Khóa' : 'Kích Hoạt' }}
                                </button>
                            </form>
                        @endif

                    </td>
                    <td>
                        @if ($nhanvien->vaiTro!='admin')
                            <form action="{{ route('quanlys.nhanvien.destroy', $nhanvien->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                            </form>
                        @endif
                        <a href="{{ route('quanlys.nhanvien.edit', $nhanvien->id) }}">Sửa</a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
