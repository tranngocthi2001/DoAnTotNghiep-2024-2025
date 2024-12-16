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
                            @if ($sanpham->trangThai==1)
                                <div class="col-md-3 mb-4">
                                    <div class="card d-flex flex-column h-100 shadow-sm">
                                        <img src="{{ asset('uploads/sanpham/' . $sanpham->hinhAnh) }}"
                                            class="card-img-top"
                                            style="object-fit: cover; height: 200px;"
                                            alt="{{ $sanpham->tenSanPham }}">
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title" style="min-height: 48px;">
                                                    {{ $sanpham->tenSanPham }}
                                                </h5>
                                                <p class="card-text flex-grow-1">{{ $sanpham->moTa }}</p>
                                                <p class="card-text">
                                                    <strong>Giá:</strong> {{ number_format($sanpham->gia, 3) }} VND
                                                </p>
                                                <a href="{{ route('quanlys.sanpham.show', $sanpham->id) }}"
                                                class="btn btn-primary btn-sm mt-auto">
                                                    Chi tiết
                                                </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endforeach

</div>
@endsection
