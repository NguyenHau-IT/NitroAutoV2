<?php require_once 'includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-2 text-dark mb-4 bg-light shadow-lg rounded-4 p-4" style="max-width: 700px;">
        <div class="card border-0">
            <div class="card-header bg-transparent text-center">
                <h2><i class="bi bi-pencil-square me-2 text-primary"></i>Chỉnh sửa thông tin</h2>
            </div>
            <div class="card-body">
                <form action="/update_profile" method="POST" class="fs-5">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                    <!-- Họ và tên -->
                    <div class="mb-3">
                        <label for="full_name" class="form-label fw-semibold">
                            <i class="bi bi-person-fill me-1"></i> Họ và tên
                        </label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                    </div>

                    <!-- Giới tính -->
                    <div class="mb-3">
                        <!-- Hàng 1: Label -->
                        <label class="form-label fw-semibold d-block mb-2">
                            <i class="bi bi-gender-ambiguous me-1"></i> Giới tính
                        </label>

                        <!-- Hàng 2: Radio buttons -->
                        <div class="form-check form-check-inline">
                            <input type="radio" id="gender_male" name="gender" class="form-check-input" value="1" <?= $user['gender'] == 1 ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="gender_male">Nam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="gender_female" name="gender" class="form-check-input" value="0" <?= $user['gender'] == 0 ? 'checked' : '' ?> required>
                            <label class="form-check-label" for="gender_female">Nữ</label>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            <i class="bi bi-envelope-fill me-1"></i> Email
                        </label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <!-- Số điện thoại -->
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">
                            <i class="bi bi-telephone-fill me-1"></i> Số điện thoại
                        </label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                    </div>

                    <!-- Địa chỉ -->
                    <div class="mb-4">
                        <label for="address" class="form-label fw-semibold">
                            <i class="bi bi-geo-alt-fill me-1"></i> Địa chỉ
                        </label>
                        <input type="text" id="address" name="address" class="form-control" value="<?= htmlspecialchars($user['address']) ?>" required>
                    </div>

                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between">
                        <a href="/profile" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle-fill me-1"></i> Cập nhật
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>