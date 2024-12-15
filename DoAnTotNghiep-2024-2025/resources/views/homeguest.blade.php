@extends('layouts.layoutkhachhang')

@section('content')
<div class="container">
    <!-- Hiển thị tài khoản hoặc nút đăng nhập -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <a href="{{ route('khachhang.login') }}" class="btn btn-primary btn-sm">Đăng nhập</a>

    </div>

    @foreach ($danhmucs as $danhmuc)
        <div class="card mb-4">
            <div class="card-header">
                <h4>{{ $danhmuc->tenDanhMuc }}</h4>
                <p>{{ $danhmuc->moTa }}</p>
            </div>
            <div class="card-body">
                @if ($danhmuc->sanphams->isEmpty())
                    <p>Không có sản phẩm nào trong danh mục này.</p>
                @else
                    <div class="row">
                        @foreach ($danhmuc->sanphams as $sanpham)
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <img src="{{ asset('uploads/sanpham/' . $sanpham->hinhAnh) }}" class="card-img-top" alt="{{ $sanpham->tenSanPham }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $sanpham->tenSanPham }}</h5>
                                        <p class="card-text">{{ $sanpham->moTa }}</p>
                                        <p class="card-text"><strong>Giá:</strong> {{ number_format($sanpham->gia, 3) }} VND</p>
                                        <a href="{{ route('quanlys.sanpham.show', $sanpham->id) }}" class="btn btn-primary btn-sm">Chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
