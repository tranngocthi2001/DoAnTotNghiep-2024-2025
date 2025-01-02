
@extends('layouts.layoutquanly')

@section('content')
<div class="container">

    @if (session('success'))
<div class="alert alert-warning">
    {{ session('success') }}
</div>
@endif
    <h2>Sản phẩm trong đơn hàng</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($donHang->chiTietDonHangs as $chitiet)
                @foreach($chitiet->sanphams as $sanpham)
                    <tr>
                        <td>{{ $sanpham->tenSanPham }}</td>
                        <td>
                            <form action="{{ route('donhang.capNhatSoLuong', $chitiet->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <input type="number" name="so_luong" value="{{ $chitiet->soLuong }}" min="1" required>
                                <button type="submit" class="btn btn-primary btn-sm">Cập nhật</button>
                            </form>
                        </td>
                        <td>{{ number_format($sanpham->gia,  0, ',', '.') }} VND</td>
                        <td>{{ number_format($sanpham->gia * $chitiet->soLuong,  0, ',', '.') }} VND</td>
                        <td>
                            <form action="{{ route('donhang.xoaChiTiet', $chitiet->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>

    </table>
    <p><strong>Tổng tiền:</strong> {{ number_format($donHang->tongTien, 3) }} VND</p>

    <form action="{{ route('donhang.xuLyThemChiTiet', $donHang->id) }}" method="POST">
        @csrf
        <h3>Thêm chi tiết vào đơn hàng: {{ $donHang->id }}</h3>

        <label for="sanpham_id">Chọn sản phẩm:</label>
        <select name="sanpham_id" id="sanpham_id">
            @foreach($sanPhams as $sanPham)
                <option value="{{ $sanPham->id }}">{{ $sanPham->tenSanPham }}</option>
            @endforeach
        </select>

        <br><br><label for="so_luong">Số lượng:</label>
        <input type="number" name="so_luong" id="so_luong" min="1" required>

        <button type="submit">Thêm chi tiết</button>
    </form>
    <a href="{{route('quanlys.donhang.show',$donHang->id )}}"> Quay về chi tiết đơn hàng</a>

</div>
@endsection
