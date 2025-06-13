<?php require_once 'includes/header.php'; ?>

<div class="overlay">
    <div class="container d-flex justify-content-center align-items-center mt-2">
        <div class="bg-white text-dark shadow-lg rounded-4 p-4 w-100" style="max-width: 700px;">
            <div class="mb-4 border-bottom pb-2">
                <h2 class="mb-0"><i class="bi bi-person-circle me-2 text-primary"></i>Thông tin cá nhân</h2>
            </div>

            <div class="mb-4 fs-5">
                <!-- Họ và tên -->
                <p><i class="bi bi-person-fill me-2 text-primary"></i><strong> Họ tên:</strong> <?= htmlspecialchars($user['full_name'] ?? '-') ?></p>

                <!-- Giới tính -->
                <p><i class="bi bi-gender-ambiguous me-2 text-primary"></i><strong> Giới tính:</strong> <?= ($user['gender'] == 1 ? 'Nam' : 'Nữ') ?>
                </p>

                <!-- Email -->
                <p><i class="bi bi-envelope-fill me-2 text-primary"></i><strong> Email:</strong> <?= htmlspecialchars($user['email'] ?? '-') ?></p>

                <!-- Số điện thoại -->
                <p><i class="bi bi-phone-fill me-2 text-primary"></i><strong> Số điện thoại:</strong> <?= htmlspecialchars($user['phone'] ?? '-') ?></p>

                <!-- Địa chỉ -->
                <p><i class="bi bi-house-door-fill me-2 text-primary"></i><strong> Địa chỉ:</strong> <?= htmlspecialchars($user['address'] ?? '-') ?></p>
            </div>

            <div class="d-flex flex-wrap gap-3 justify-content-between">
                <a href="/edit_profile" class="btn btn-outline-primary flex-fill d-flex align-items-center justify-content-center mt-2">
                    <i class="bi bi-gear me-2"></i> Cập nhật
                </a>

                <a href="/reset_password" class="btn btn-warning flex-fill d-flex align-items-center justify-content-center mt-2">
                    <i class="bi bi-key me-2"></i> Đổi mật khẩu
                </a>

                <a href="/home" class="btn btn-secondary flex-fill d-flex align-items-center justify-content-center mt-2">
                    <i class="bi bi-house-door-fill me-2"></i> Trang chủ
                </a>

                <a href="#" id="logoutBtn" class="btn btn-danger flex-fill d-flex align-items-center justify-content-center mt-2">
                    <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>