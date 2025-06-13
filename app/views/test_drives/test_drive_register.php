<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="container mt-5 text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4 border">
    <h2 class="mb-4 text-center text-primary">
        <i class="bi bi-steering-wheel me-2"></i>Đăng ký lái thử xe
    </h2>

    <!-- Thông tin người dùng -->
    <div class="mb-4">
        <h4 class="mb-3"><i class="bi bi-person-vcard me-2"></i>Thông tin người đăng kí</h4>
        <div class="row g-3">
            <div class="col-md-6"><strong>Họ tên:</strong> <?= htmlspecialchars($user['full_name']) ?></div>
            <div class="col-md-6"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></div>
            <div class="col-md-6"><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></div>
            <div class="col-md-6"><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['address'] ?? '-') ?></div>
        </div>
    </div>

    <!-- Form đăng ký -->
    <form action="/register_test_drive" method="POST" class="mt-4">
        <input type="hidden" name="user_id" value="<?= isset($user['id']) ? htmlspecialchars($user['id']) : '' ?>">

        <!-- Chọn xe -->
        <div class="mb-3">
            <label for="car_id" class="form-label fw-semibold">Chọn xe:</label>
            <select class="form-select form-select-lg" id="car_id" name="car_id" required>
                <option value="">-- Vui lòng chọn xe --</option>
                <?php foreach ($cars as $car): ?>
                    <option value="<?= htmlspecialchars($car['id']) ?>"
                            data-price="<?= htmlspecialchars($car['price']) ?>"
                            <?= (isset($_POST['car_id']) && $_POST['car_id'] == $car['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($car['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Ngày lái thử -->
        <div class="mb-3">
            <label for="preferred_date" class="form-label fw-semibold">Ngày lái thử:</label>
            <input type="date" class="form-control form-control-lg" id="preferred_date" name="preferred_date" required>
        </div>

        <!-- Giờ lái thử (08:00 - 17:00) -->
        <div class="mb-3">
            <label for="preferred_time" class="form-label fw-semibold">Giờ lái thử:</label>
            <input type="time" class="form-control form-control-lg" id="preferred_time" name="preferred_time"
                   min="08:00" max="17:00" required>
            <small class="text-muted">Giờ mở cửa: từ <strong>08:00</strong> đến <strong>17:00</strong></small>
        </div>

        <!-- Địa điểm -->
        <div class="mb-4">
            <label for="location" class="form-label fw-semibold">Địa điểm lái thử:</label>
            <input type="text" class="form-control form-control-lg" id="location" name="location" required>
        </div>

        <!-- Hành động -->
        <div class="d-flex justify-content-between">
            <a href="/home" class="btn btn-danger px-4">
                <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
            </a>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-car-front-fill me-1"></i> Đăng ký lái thử
            </button>
        </div>
    </form>
</div>

<!-- Script chặn ngày quá khứ -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dateInput = document.getElementById("preferred_date");
        const timeInput = document.getElementById("preferred_time");

        // Chặn ngày quá khứ
        if (dateInput) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            dateInput.min = `${yyyy}-${mm}-${dd}`;
        }

        // Cảnh báo nếu người dùng chọn giờ ngoài khung giờ hợp lệ
        if (timeInput) {
            timeInput.addEventListener("change", function () {
                const val = this.value;
                if (val < "08:00" || val > "17:00") {
                    alert("Giờ lái thử hợp lệ là từ 08:00 đến 17:00!");
                    this.value = "";
                }
            });
        }
    });
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
