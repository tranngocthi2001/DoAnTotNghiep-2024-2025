@extends('layouts.app') <!-- Nếu bạn có layout chung -->

@section('content')
<div class="container">
    <h2>Tạo mới thông tin vận chuyển</h2>

    <!-- Form tạo mới vận chuyển -->
    <br><form action="{{ route('vanchuyens.store') }}" method="POST">
        @csrf <!-- CSRF token bảo vệ -->
        <input type="hidden" name="donhang_id" value="{{ $donhang->id }}">

        <div class="form-group">
            <label for="tenVanChuyen">Tên vận chuyển</label>
            <input type="text" class="form-control" id="tenVanChuyen" name="tenVanChuyen" required>
        </div>

        <div class="form-group">
            <label for="trangThaiVanChuyen">Trạng thái vận chuyển</label>
            <input type="text" class="form-control" id="trangThaiVanChuyen" name="trangThaiVanChuyen" required>
        </div>

        <div class="form-group">
            <label for="ngayGiaoDuKien">Ngày giao dự kiến</label>
            <input type="date" class="form-control" id="ngayGiaoDuKien" name="ngayGiaoDuKien" required>
        </div>

        <div class="form-group">
            <label for="ngayThucTe">Ngày thực tế</label>
            <input type="date" class="form-control" id="ngayThucTe" name="ngayThucTe">
        </div>

        <div class="form-group">
            <label for="maVanChuyen">Mã vận chuyển</label>
            <input type="text" class="form-control" id="maVanChuyen" name="maVanChuyen" required>
        </div>


        <button type="submit" class="btn btn-primary">Lưu thông tin vận chuyển</button>
    </form>
</div>
@endsection
