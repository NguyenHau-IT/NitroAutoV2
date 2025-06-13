<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NitroAuto - Đăng nhập / Đăng ký</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-dark text-white d-flex align-items-center justify-content-center vh-100">

  <!-- Nền động -->
  <div id="bg" class="position-fixed top-0 start-0 w-100 h-100 z-n1"></div>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-6">
        <div class="card shadow-lg border-0 rounded-4" style="
    background-color: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);">
          <div class="card-body p-4">

            <!-- Tabs -->
            <ul class="nav nav-tabs nav-justified mb-4" id="authTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#loginTab" type="button" role="tab">Đăng nhập</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#registerTab" type="button" role="tab">Đăng ký</button>
              </li>
            </ul>

            <!-- Tab content -->
            <div class="tab-content" id="authTabsContent">
              <!-- Đăng nhập -->
              <div class="tab-pane fade show active text-light" id="loginTab" role="tabpanel">
                <h4 class="text-primary mb-3 text-center">Chào mừng trở lại!</h4>
                <form action="/login" method="POST">
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                  </div>
                  <div class="mb-3 text-end">
                    <a href="/forgot-password" class="text-primary small">Quên mật khẩu?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                  <div class="text-center my-3">hoặc</div>
                  <a href="/auth/google" class="btn btn-outline-danger w-100">
                    <i class="bi bi-google me-2"></i> Đăng nhập bằng Google
                  </a>
                </form>
              </div>

              <!-- Đăng ký -->
              <div class="tab-pane fade text-light" id="registerTab" role="tabpanel">
                <h4 class="text-success mb-3 text-center">Tạo tài khoản mới</h4>
                <form action="/register" method="POST" id="registerForm">
                  <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="full_name" class="form-control" placeholder="Nhập họ và tên" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control"
                      placeholder="Ít nhất 8 ký tự, gồm chữ hoa/thường, số, ký tự đặc biệt"
                      required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" placeholder="Ví dụ: 0912345678" required pattern="^0\d{9}$">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ" required>
                  </div>
                  <button type="submit" class="btn btn-success w-100">Đăng ký</button>
                </form>
              </div>
            </div>

            <div class="text-center mt-4">
              <a href="/home" class="text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i> Quay lại trang chủ
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap + Vanta.js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r121/three.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vanta/dist/vanta.net.min.js"></script>

  <script>
    // Nền động bằng Vanta.js
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

    // Kiểm tra mật khẩu
    document.getElementById("registerForm").addEventListener("submit", function(e) {
      const pw = document.getElementById("reg_password").value;
      const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
      if (!regex.test(pw)) {
        alert("Mật khẩu chưa đúng định dạng yêu cầu.");
        e.preventDefault();
      }
    });
  </script>

</body>

</html>