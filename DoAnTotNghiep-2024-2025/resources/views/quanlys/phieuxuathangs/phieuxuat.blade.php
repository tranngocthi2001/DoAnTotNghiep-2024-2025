@extends('layouts.layoutquanly')

@section('content')
<form action="{{ route('phieuxuathangs.store') }}" method="POST">
    @csrf

    <h3>Nhân viên xuất hàng</h3>
    <h3>{{  $donHang->nhanViens->hoTen }}</h3>
    <input type="hidden" name="donhang_id" value="{{ $donHang->id }}">

    <div>
        <label for="ngayXuat">Ngày Xuất:</label>
        <input type="datetime-local" name="ngayXuat" required>
    </div>

    <div>
        <label for="trangThai">Trạng Thái:</label>
        <input type="text" name="trangThai" required>
    </div>

    <div>
        <h3>Chi tiết đơn hàng</h3>
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Bảo hành</th>
                    <th>Ghi chú</th>
                    <th>Số Seri</th> <!-- Cột cho số seri -->
                </tr>
            </thead>
            <tbody>
                @foreach ($donHang->chiTietDonHangs as $index => $chiTiet)
                    @foreach ($chiTiet->sanPhams as $sanPham)
                        @for ($i = 0; $i < $sanPham->pivot->soLuong; $i++) <!-- Lặp qua số lượng -->

                            <tr>
                                <td>
                                    <input type="hidden" name="chiTietDonHangs[{{ $index }}][sanpham_id]" value="{{ $sanPham->id }}">
                                    {{ $sanPham->tenSanPham }}
                                </td>
                                <td>
                                    <input type="number" name="chiTietDonHangs[{{ $index }}][soLuong]" value="1"readonly required> <!-- Mỗi dòng chỉ có 1 sản phẩm -->
                                </td>
                                <td>
                                    <input type="datetime-local" name="chiTietDonHangs[{{ $index }}][baoHanh]" >

                                </td>
                                <td>
                                    <input type="text" name="chiTietDonHangs[{{ $index }}][ghiChu]" placeholder="Nhập ghi chú">
                                </td>
                                <td>
                                    <input type="text" name="chiTietDonHangs[{{ $index }}][seri][{{ $i }}]" placeholder="Nhập số seri {{ $i+1 }}">
                                </td>
                                <input type="hidden" name="chiTietDonHangs[{{ $index }}][chitietdonhang_id]" value="{{ $chiTiet->id }}">
                            </tr>
                        @endfor
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <button type="submit">Lưu Phiếu Xuất</button><br>
    </div>
</form>
@endsection
