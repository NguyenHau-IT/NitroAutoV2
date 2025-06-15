<?php require_once 'includes/header.php'; ?>

<div class="container py-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white d-flex align-items-center gap-2">
                    <i class="bi bi-person-circle fs-3"></i>
                    <div>
                        <h4 class="mb-0">Thông tin cá nhân</h4>
                        <small>Xem và chỉnh sửa hồ sơ của bạn</small>
                    </div>
                </div>
                <div class="card-body fs-5">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="bi bi-person-fill me-2 text-primary"></i>
                            <strong>Họ tên:</strong> <?= htmlspecialchars($user['full_name'] ?? '-') ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-gender-ambiguous me-2 text-primary"></i>
                            <strong>Giới tính:</strong> <?= $user['gender'] == 1 ? 'Nam' : 'Nữ' ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-envelope-fill me-2 text-primary"></i>
                            <strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '-') ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-phone-fill me-2 text-primary"></i>
                            <strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone'] ?? '-') ?>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-house-door-fill me-2 text-primary"></i>
                            <strong>Địa chỉ:</strong> <?= htmlspecialchars($user['address'] ?? '-') ?>
                        </li>
                    </ul>

                    <div class="row mt-4 g-3">
                        <div class="col-md-6">
                            <a href="/edit_profile" class="btn btn-outline-primary w-100">
                                <i class="bi bi-gear me-1"></i> Cập nhật thông tin
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/reset_password" class="btn btn-warning w-100">
                                <i class="bi bi-key me-1"></i> Đổi mật khẩu
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/home" class="btn btn-secondary w-100">
                                <i class="bi bi-house-door-fill me-1"></i> Trang chủ
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" id="logoutBtn" class="btn btn-danger w-100">
                                <i class="bi bi-box-arrow-right me-1"></i> Đăng xuất
                            </a>
                        </div>
                        <div class="col-12 text-center">
                            <a href="/forgot-password" class="text-decoration-none small text-primary">
                                <i class="bi bi-question-circle me-1"></i> Quên mật khẩu?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
