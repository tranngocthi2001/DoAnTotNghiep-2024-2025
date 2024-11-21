@extends('layouts.app')

@section('content')
    <h2>Chỉnh sửa trạng thái nhân viên</h2>
    <form action="{{ route('quanlys.nhanvien.update', $nhanVien->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="trangThai">Trạng thái:</label>
        <select name="trangThai" id="trangThai">
            <option value="1" {{ $nhanVien->trangThai == 1 ? 'selected' : '' }}>Kích hoạt</option>
            <option value="0" {{ $nhanVien->trangThai == 0 ? 'selected' : '' }}>Khóa</option>
        </select>
        <br>
        <button type="submit">Cập nhật</button>
    </form>
@endsection
