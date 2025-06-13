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

<body class="d-flex justify-content-center align-items-center vh-100">
<div id="bg" class="position-fixed top-0 start-0 w-100 h-100 z-n1"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 shadow-lg p-4 bg-white rounded">
                <h2 class="text-center mb-4">Nhập mặt khẩu mới</h2>
                <form method="POST" action="/reset-password">
                    <input type="password" class="form-control mb-3" id="password" name="password"
                        placeholder="Mật khẩu mới" required
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                        title="Mật khẩu mới phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt">
                    <button type="submit" class="btn btn-success w-100">Đặt lại mật khẩu</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta/dist/vanta.net.min.js"></script>
    <script src="/script.js" defer></script>

    <script>
     VANTA.NET({
      el: "#bg",
      mouseControls: true,
      touchControls: true,
      minHeight: 200,
      minWidth: 200,
      scale: 1.0,
      scaleMobile: 1.0,
      color: 0x00aaff,
      backgroundColor: 0x0d0d0d
    });
    </script>

</body>

</html>