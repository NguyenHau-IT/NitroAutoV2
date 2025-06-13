<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 shadow-lg p-4 bg-white rounded">
                <h2 class="text-center mb-4">Đăng nhập</h2>
                <form action="" method="POST">
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-1 input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control" id="password" name="password"
                        placeholder="Mật khẩu" required
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                        title="Mật khẩu phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt">
                    </div>
                    <div class="mb-3 text-end">
                        <a href="show_forgot_password" class="text-decoration-none text-primary">Quên mật khẩu?</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>

                <hr class="my-4">

                <div class="text-center mb-3">
                    <span class="text-muted">hoặc đăng nhập bằng</span>
                </div>

                <div class="d-grid mb-3">
                    <?php $googleUrl = '/auth/google'; ?>
                    <a href="<?= $googleUrl ?>" class="btn btn-outline-danger">
                        <i class="bi bi-google me-2"></i> Đăng nhập với Google
                    </a>
                </div>

                <div class="text-center">
                    <a href="register" class="text-decoration-none text-primary d-block">Chưa có tài khoản? Đăng ký ngay</a>
                    <a href="home" class="text-decoration-none text-secondary d-block mt-2">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- ✅ thêm dòng này -->
    <script src="/script.js" defer></script>

</body>

</html>