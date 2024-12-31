@extends('layouts.layoutquanly')

@section('content')
<div class="container">
<h3>Kết quả tìm kiếm cho từ khóa: "{{ $keyword }}"</h3>

    @if ($seris->isEmpty())
        <p>Không tìm thấy seri nào.</p>
    @else

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


                </tr>
            @endforeach
        </tbody>
    </table>


    @endif
</div>
@endsection
