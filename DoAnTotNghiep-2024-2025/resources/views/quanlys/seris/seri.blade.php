@extends('layouts.layoutquanly')

@section('content')
<div class="container">
    <h2>Danh Sách Sản Phẩm</h2>

    <!-- Thông báo thành công -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
<div  class="container px-4 px-lg-5">
    <form action="{{ route('seri.search') }}" method="GET" class="d-flex">
        <input type="text" name="q" class="form-control me-2" placeholder="Nhập mã seri để tìm kiếm..." value="{{ request('q') }}">
        <button type="submit" class="btn btn-outline-success">Tìm kiếm</button>
    </form><br>
</div>



    <!-- Bảng Hiển Thị Sản Phẩm -->
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã seri</th>
                <th>Tên sản phẩm</th>
                <th>Mã đơn hàng </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($seris as $key => $seri)

                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $seri->maSeri }}</td>
                    <td>
                        @foreach ( $seri->chiTietPhieuXuat->chiTietDonHangs->sanPhams as $sanpham)
                            {{ $sanpham->tenSanPham }}
                        @endforeach
                    </td>
                    <td>{{ $seri->chiTietPhieuXuat->chiTietDonHangs->donHangs->id }}
                        {{-- <td><a href="{{ route('quanlys.donhang.show', $seri->chiTietPhieuXuat->chiTietDonHangs->donHangs->id) }}"> Xem chi tiết</a></td> --}}

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
