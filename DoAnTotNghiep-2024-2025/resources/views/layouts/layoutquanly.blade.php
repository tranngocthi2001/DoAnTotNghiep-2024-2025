
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>T-Smart </title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
<link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="{{url('/admin')}}">T-Smart</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{url('/admin')}}">Trang chủ</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="#!">Thông tin về chúng tôi</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Danh mục</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">Tất cả sản phẩm</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                    <div class="d-flex justify-content-between align-items-center my-3">
                        @if (auth('nhanvien')->check())

                            <a class="navbar-brand text-decoration-none text-primary"> {{ auth('nhanvien')->user()->hoTen }} </a>
                            <form action="{{ route('nhanvien.logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Đăng xuất</button>
                            </form>
                        @else
                            <a href="{{url('/register')}}" class="btn btn-primary btn-sm">Đăng ký</a>
                            <a href="{{ url ('/login') }}" class="btn btn-primary btn-sm">Đăng nhập</a>
                        @endif

                </div>
                </div>

            </div>
        </nav>

        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">T-Smart</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Trang web từ cửa hàng T-Smart</p>
                </div>
            </div>
        </header>
        <!-- Section-->
        @if (session('message'))
            <div class="alert alert-warning">
                {{ session('message') }}
            </div>
        @endif
        <h1>&nbsp;&nbsp;&nbsp; </h1>

        <main>
            @yield('content')
        </main>
        <h1>&nbsp;&nbsp;&nbsp; </h1>
        <h1>&nbsp;&nbsp;&nbsp; </h1>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container">
                <!-- Contact Information -->
                <div class="mt-4 text-center text-white">
                    <p><strong>Liên hệ: </strong>Email: dh51901412@student.stu.edu.vn.com | Hotline: <a href="tel:0348888144" class="text-white">034 8888 144</a></p>
                </div>

                <!-- Social Media Links -->
                <div class="mt-3 text-center">
                    <h1>&nbsp;&nbsp;&nbsp; </h1>
                    <p class="text-white"><strong>Kết nối với chúng tôi:</strong>
                        <a href="https://facebook.com" target="_blank" class="text-white me-3">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="https://zalo.me/yourzalo" target="_blank" class="text-white me-3">
                            <i class="fas fa-phone"></i> Zalo
                        </a>
                        <a href="https://instagram.com/" target="_blank" class="text-white">
                            <i class="fab fa-instagram"></i> instagram
                        </a>
                    </p>

                </div>

                <!-- Additional Information -->
                <div class="mt-4 text-center text-white">
                    <p><strong>Thông tin khác:</strong>
                        <p>Địa chỉ: 180 Đường Cao Lỗ, Phường 4, Quận 8, Thành phố Hồ Chí Minh</p>
                        <p>Giờ làm việc: 08:00 - 17:00 (Thứ Hai - Thứ Bảy)</p>
                    </p>

                </div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
