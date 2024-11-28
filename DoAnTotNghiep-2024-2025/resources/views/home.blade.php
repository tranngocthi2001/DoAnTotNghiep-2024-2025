@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

<div class="container">
    <!-- Hiển thị tài khoản hoặc nút đăng nhập -->
    <div class="d-flex justify-content-between align-items-center my-3">
        <h2>Danh Sách Danh Mục và Sản Phẩm</h2>
        @if (auth('khachhang')->check())
        <p>Chào, {{ auth('khachhang')->user()->tenTaiKhoan }}</p>
        <form action="{{ route('khachhang.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger btn-sm">Đăng xuất</button>
        </form>
    @else
        <a href="{{ route('khachhang.login') }}" class="btn btn-primary btn-sm">Đăng nhập</a>
    @endif

    </div>
<div>
    <a href="{{ route('giohang.index') }}">Giỏ hàng của bạn</a></br>
    <a href="{{ route('khachhang.donhang.index') }}">Đơn hàng của bạn</a>


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
                                        <p class="card-text"><strong>Giá:</strong> {{ number_format($sanpham->gia, 2) }} VND</p>

                                        <!-- Nút xem chi tiết sản phẩm -->
                                        <a href="{{ route('quanlys.sanpham.show', $sanpham->id) }}" class="btn btn-primary btn-sm">Chi tiết</a>

                                        <!-- Form thêm sản phẩm vào giỏ hàng -->
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
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    @endforeach
</div>
@endsection
