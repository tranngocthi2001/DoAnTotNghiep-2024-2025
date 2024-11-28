
@foreach ($giohang->chiTietGioHangs as $item)
                    @if ($item->sanPhams->count() > 0)
                        @foreach ($item->sanPhams as $sanpham)
                            <div>
                                <p>Sản phẩm: {{ $sanpham->tenSanPham }}</p>
                                <p>Số lượng: {{ $sanpham->pivot->soLuong }}</p>
                                <p>Giá: {{ number_format($sanpham->gia * $sanpham->pivot->soLuong, 3) }} VND</p>
                                <form action="{{ route('giohang.chitiet.update', ['id' => $sanpham->id]) }}" method="POST">
                                    @csrf
                                    <label for="soLuong">Số lượng:</label>
                                    <input type="number" name="soLuong" id="soLuong" value="{{ $sanpham->pivot->soLuong }}" min="1">
                                    <button type="submit">Cập nhật</button>
                                </form>

                                <form action="{{ route('giohang.chitiet.destroy', ['id' => $sanpham->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Xóa</button>
                                </form>
                            </div>
                        @endforeach
                    @endif
                @endforeach
                <p>Tổng số lượng: {{ $giohang->tongSoLuong }}</p>
                <p>Tổng tiền: {{ number_format($giohang->tongTien, 3) }} VND</p>
                <p>Vui lòng nhập địa chỉ giao hàng</p>
                <form action="{{ route('khachhang.donhang.create') }}" method="POST">
                    @csrf

                    <!-- Địa chỉ giao hàng -->
                    <label for="diaChi">Địa chỉ giao hàng:</label>
                    <input type="text" name="diaChi" id="diaChi" value="{{ auth()->user()->diaChi ?? '' }}" required>

                    <!-- Số điện thoại -->
                    <label for="sdt">Số điện thoại:</label>
                    <input type="text" name="sdt" id="sdt" value="{{ auth()->user()->sdt ?? '' }}" required></br>

                    <!-- Phương thức thanh toán -->
                    <label for="phuongThucThanhToan">Chọn phương thức thanh toán:</label>
                    <select name="phuongThucThanhToan" id="phuongThucThanhToan" required>
                        <option value="Thanh toán khi nhận hàng (COD)">Thanh toán khi nhận hàng (COD)</option>
                        <option value="Chuyển khoản ngân hàng">Chuyển khoản ngân hàng</option>
                        <option value="Thanh toán qua ví điện tử">Thanh toán qua ví điện tử Momo</option>
                    </select>

                    <!-- Nút Đặt hàng -->
                    <button type="submit">Đặt hàng</button>
                </form>
