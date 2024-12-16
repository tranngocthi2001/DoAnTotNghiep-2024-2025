@extends('layouts.layoutquanly')

@section('content')

<h3>Kết quả tìm kiếm cho từ khóa: "{{ $keyword }}"</h3>

    @if ($sanphams->isEmpty())
        <p>Không tìm thấy sản phẩm nào.</p>
    @else

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


    @endif

@endsection
