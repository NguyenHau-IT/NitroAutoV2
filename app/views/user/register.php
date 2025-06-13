<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="card-title text-center">Đăng ký tài khoản</h2>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="name">Tên</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Tên" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Mật khẩu" required
                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                                    title="Mật khẩu phải có ít nhất 8 ký tự, gồm chữ hoa, chữ thường, số và ký tự đặc biệt">
                            </div>
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Số điện thoại" required pattern="^0\d{9}$"
                                    title="Số điện thoại phải bắt đầu bằng 0 và có 10 chữ số">
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ" required>
                            </div>
                            <!-- Thêm trường Giới tính -->
                            <div class="form-group">
                                <label for="gender">Giới tính</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="" disabled selected>Chọn giới tính</option>
                                    <option value="male">Nam</option>
                                    <option value="female">Nữ</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">Đăng ký</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.querySelector("form").addEventListener("submit", function(e) {
            const phone = document.getElementById("phone").value;
            const phoneRegex = /^0\d{9,10}$/;
            if (!phoneRegex.test(phone)) {
                alert("Số điện thoại không hợp lệ. Phải bắt đầu bằng 0 và có 10-11 chữ số.");
                e.preventDefault(); // Ngăn không cho submit form
            }

            const password = document.getElementById("password").value;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!passwordRegex.test(password)) {
                alert("Mật khẩu phải có ít nhất 8 ký tự, gồm: chữ hoa, chữ thường, số và ký tự đặc biệt.");
                e.preventDefault(); // Chặn form submit
            }
        });
    </script>

</body>

</html>
