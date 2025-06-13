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
                <h2 class="text-center mb-4">Nhập mã xác nhận đã gửi qua email</h2>
                <form method="POST" action="/verify-code">
                    <input type="text" name="code" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-success w-100">Xác nhận</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- ✅ thêm dòng này -->
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