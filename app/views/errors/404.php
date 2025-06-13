<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>404 - Không tìm thấy trang</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .error-container {
      text-align: center;
      animation: fadeIn 1s ease-in-out;
    }

    .error-code {
      font-size: 8rem;
      font-weight: bold;
      color: #ff4d4f;
    }

    .error-icon {
      font-size: 4rem;
      color: #dc3545;
    }

    .error-text {
      font-size: 1.5rem;
      color: #333;
    }

    .home-btn {
      margin-top: 30px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>

  <div class="error-container">
    <div class="error-icon mb-3">
      <i class="bi bi-exclamation-triangle-fill"></i>
    </div>
    <div class="error-code">404</div>
    <div class="error-text">Trang bạn tìm kiếm không tồn tại.</div>
    <p>Hãy kiểm tra lại đường dẫn hoặc quay về trang chủ.</p>
    <a href="/home" class="btn btn-danger home-btn">Quay lại trang chủ</a>
  </div>

</body>
</html>
