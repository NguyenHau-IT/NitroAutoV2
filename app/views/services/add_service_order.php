<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-5">
        <div class="bg-white shadow-lg rounded-4 p-5">
            <h2 class="text-center mb-4 fw-bold text-primary">
                <i class="bi bi-tools me-2"></i>Đặt dịch vụ ô tô
            </h2>

            <form action="ServicesOrder" method="POST">
                <!-- Chọn dịch vụ -->
                <div class="mb-4">
                    <label for="service_id" class="form-label fw-semibold text-dark">
                        <i class="bi bi-wrench-adjustable me-2"></i>Chọn dịch vụ
                    </label>
                    <select name="service_id" id="service_id" class="form-select form-select-lg rounded-3" required>
                        <option value="">-- Vui lòng chọn dịch vụ --</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?= $service['ServiceID'] ?>" <?= (isset($_POST['service_id']) && $_POST['service_id'] == $service['ServiceID']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($service['ServiceName']) ?> (<?= number_format($service['Price'], 0, ',', '.') ?> đ)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Chọn ngày -->
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <div class="mb-4">
                    <label for="service_date" class="form-label fw-semibold text-dark">
                        <i class="bi bi-calendar-event me-2"></i>Chọn ngày & giờ
                    </label>
                    <input type="datetime-local" name="service_date" id="service_date" class="form-control form-control-lg rounded-3" required>
                </div>

                <!-- Ghi chú -->
                <div class="mb-4">
                    <label for="note" class="form-label fw-semibold text-dark">
                        <i class="bi bi-chat-left-dots me-2"></i>Ghi chú
                    </label>
                    <textarea name="note" id="note" class="form-control rounded-3" rows="4" placeholder="Thời gian mong muốn, yêu cầu thêm,..."></textarea>
                </div>

                <!-- Nút hành động -->
                <div class="d-flex justify-content-between">
                    <a href="/services" class="btn btn-outline-secondary px-4 py-2 rounded-3">
                        <i class="bi bi-arrow-left-circle me-2"></i>Huỷ
                    </a>
                    <button type="submit" class="btn btn-success px-4 py-2 rounded-3">
                        <i class="bi bi-check-circle-fill me-2"></i>Đặt dịch vụ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script chặn chọn ngày quá khứ -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dateInput = document.getElementById("service_date");

        if (dateInput) {
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset()); // Để không bị lệch giờ

            // Format thành yyyy-MM-ddTHH:mm
            const localISOTime = now.toISOString().slice(0, 16);
            dateInput.min = localISOTime;
        }
    });
</script>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>