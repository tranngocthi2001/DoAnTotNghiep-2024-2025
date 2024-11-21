<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>
<body>
    <h1>Đăng nhập</h1>

    <!-- Hiển thị thông báo lỗi nếu có -->
    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form đăng nhập -->
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <label for="tenTaiKhoan">Tên tài khoản:</label>
        <input type="text" id="tenTaiKhoan" name="tenTaiKhoan" required><br>

        <label for="matKhau">Mật khẩu:</label>
        <input type="password" id="matKhau" name="matKhau" required><br>

        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>
