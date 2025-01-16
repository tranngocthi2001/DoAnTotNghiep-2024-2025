@extends('layouts.layoutkhachhang')

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
            <p><strong>Danh Mục:</strong> {{ $sanpham->danhmucs->tenDanhMuc ?? 'Không có' }}</p>
            <form action="{{ route('giohang.chitiet.store') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="sanpham_id" value="{{ $sanpham->id }}">
                <div class="form-group d-flex align-items-center">
                    <label for="soLuong" class="mr-2">Số lượng:</label>
                    <input type="number" name="soLuong" value="1" min="1" class="form-control form-control-sm" style="width: 70px;">
                </div>
                <button type="submit" class="btn btn-success btn-sm mt-2">Thêm vào giỏ hàng</button>
            </form>
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
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay Lại</a>
    </div>
</div>
@endsection
