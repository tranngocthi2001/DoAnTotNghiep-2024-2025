@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h2>Chi Tiết Sản Phẩm</h2>

    <!-- Thông tin chi tiết sản phẩm -->
    <div class="card">
        <div class="card-header">
            <h3>{{ $sanpham->tenSanPham }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Mô Tả:</strong> {{ $sanpham->moTa }}</p>
            <p><strong>Giá:</strong> {{ number_format($sanpham->gia, 0, ',', '.') }} VND</p>
            <p><strong>Số Lượng:</strong> {{ $sanpham->soLuong }}</p>
            <p><strong>Trạng Thái:</strong>
                @if ($sanpham->trangThai)
                    <span class="badge bg-success">Hoạt động</span>
                @else
                    <span class="badge bg-danger">Không hoạt động</span>
                @endif
            </p>
            <p><strong>Danh Mục:</strong> {{ $sanpham->danhmuc->tenDanhMuc ?? 'Không có' }}</p>
            <p><strong>Ngày Tạo:</strong> {{ $sanpham->ngayTao }}</p>
            <p><strong>Ngày Cập Nhật:</strong> {{ $sanpham->ngayCapNhat }}</p>
        </div>
    </div>

    <!-- Hiển thị tất cả hình ảnh -->
    <div class="mt-4">
        <h4>Hình Ảnh</h4>
        <div class="row">
            @php
                $imagePaths = json_decode($sanpham->hinhAnh, true) ?? []; // Giải mã JSON
            @endphp

            @if (count($imagePaths) > 0)
                @foreach ($imagePaths as $path)
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <img src="{{ asset('uploads/sanpham/' . $path) }}" class="card-img-top" alt="Hình Ảnh">
                        </div>
                    </div>
                @endforeach
            @else
                <p>Không có hình ảnh nào được tải lên.</p>
            @endif
        </div>
    </div>

    <!-- Nút quay lại -->
    <div class="mt-3">
        <a href="{{ route('quanlys.sanpham.index') }}" class="btn btn-secondary">Quay Lại</a>
    </div>
</div>
@endsection
