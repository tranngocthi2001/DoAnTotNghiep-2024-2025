@extends('layouts.layoutkhachhang')

@section('content')
<div class="container">
    <div class="container">
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

        {{-- <a href="{{ route('giohang.index') }}">Giỏ hàng của bạn</a></br> --}}
        {{-- <a href="{{ route('khachhang.donhang.index') }}">Đơn hàng của bạn</a> --}}

        @if (session('themsanphamgiohang'))
            <div class="alert alert-warning">
                {{ session('themsanphamgiohang') }}
            </div>
        @endif
    </div>
    <h3>Kết quả tìm kiếm cho từ khóa: "{{ $keyword }}"</h3>

    @if ($sanphams->isEmpty())
        <p>Không tìm thấy sản phẩm nào.</p>
    @else
        <div class="row">
            @foreach ($sanphams as $sanpham)
                @if ($sanpham->trangThai!=0)
                    <div class="col-md-3">
                        <div class="card mb-3">
                            @php
                                $imagePaths = json_decode($sanpham->hinhAnh, true) ?? []; // Giải mã JSON
                                $firstImage = $imagePaths[0] ?? null; // Lấy ảnh đầu tiên, nếu có
                                @endphp

                                @if ($firstImage)
                                    <img src="{{ asset('uploads/sanpham/' . $firstImage) }}" class="card-img-top" alt="{{ $sanpham->tenSanPham }}">
                                @else
                                    <img src="{{ asset('uploads/sanpham/default-image.png') }}" class="card-img-top" alt="Hình ảnh sản phẩm mặc định">
                                @endif

                            <div class="card-body">
                                <h5 class="card-title">{{ $sanpham->tenSanPham }}</h5>
                                <p class="card-text"><strong>Giá:</strong> {{ number_format($sanpham->gia, 3) }} VND</p>

                                <!-- Nút xem chi tiết sản phẩm -->
                                <a href="{{ route('sanpham.showchitiet', $sanpham->id) }}" class="btn btn-primary btn-sm">Chi tiết</a>

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
                @endif

            @endforeach
        </div>
    @endif
</div>
@endsection
