<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cập nhật vai trò người dùng</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="bg-light py-5">
    <div class="container w-75">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-gear me-2"></i> Cập nhật vai trò người dùng</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" class="p-4 bg-white rounded shadow-sm">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select name="gender" id="gender" class="form-select" disabled>
                            <option value="1" <?= $user['gender'] === 1 ? 'selected' : '' ?>>Nam</option>
                            <option value="0" <?= $user['gender'] === 0 ? 'selected' : '' ?>>Nữ</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($user['address'] ?? '---') ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ngày tạo</label>
                        <input type="text" class="form-control" value="<?= date('d/m/Y H:i', strtotime($user['created_at'])) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò</label>
                        <select name="role" id="role" class="form-select">
                            <option value="customer" <?= $user['role'] === 'customer' ? 'selected' : '' ?>>Customer</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/admindashbroad#users" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Lưu thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>