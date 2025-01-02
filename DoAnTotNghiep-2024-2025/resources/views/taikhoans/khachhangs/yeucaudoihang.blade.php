@extends('layouts.layoutkhachhang')

@section('content')
<div class="container">
    <h1>Chọn sản phẩm cần đổi hàng cho đơn hàng #{{ $donhang->id }}</h1>

    <form action="{{ url('khachhang/khachhang/yeucaudoihang') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="donhang_id" value="{{ $donhang->id }}">

        @foreach($donhang->chiTietDonHangs as $chiTiet)
            <div class="form-group">
                <label>
                    <input type="checkbox" name="sanPhamDoiID[]" value="{{ $chiTiet->sanPhams->first()->id }}">
                    {{ $chiTiet->sanPhams->first()->tenSanPham }}
                </label>
                <input type="number" name="soLuong[{{ $chiTiet->sanPhams->first()->id }}]"
                 placeholder="Số lượng muốn đổi" min="1" max="{{ $chiTiet->soLuong }}" class="form-control">
                 <input type="file" name="hinhAnh[]" id="hinhAnh" class="form-control" multiple>

            </div>
        @endforeach

        <div class="form-group">
            <label>Lý do đổi:</label>
            <textarea name="lyDo" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Gửi yêu cầu đổi hàng</button>
    </form>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
