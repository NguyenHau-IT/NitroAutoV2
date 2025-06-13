<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cập nhật đăng ký lái thử</title>

    <!-- Bootstrap CSS + Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
</head>

<body class="bg-light py-5">

    <div class="container mt-5 text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4 border">
        <h2 class="mb-4 text-center text-primary">
            <i class="bi bi-steering-wheel me-2"></i>Cập nhật đăng ký lái thử xe
        </h2>

        <div class="mb-4">
            <h4 class="mb-3"><i class="bi bi-person-vcard me-2"></i>Thông tin người đăng kí</h4>
            <div class="row g-3">
                <div class="col-md-6"><strong>Họ tên:</strong> <?= htmlspecialchars($testDrive['full_name']) ?></div>
                <div class="col-md-6"><strong>Email:</strong> <?= htmlspecialchars($testDrive['email']) ?></div>
                <div class="col-md-6"><strong>Số điện thoại:</strong> <?= htmlspecialchars($testDrive['phone']) ?></div>
                <div class="col-md-6"><strong>Địa chỉ:</strong> <?= htmlspecialchars($testDrive['address'] ?? '-') ?></div>
            </div>
        </div>

        <form action="" method="POST" class="mt-4">
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($testDrive['user_id']) ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($testDrive['id']) ?>">

            <div class="mb-3">
                <label for="car_id" class="form-label fw-semibold">Chọn xe:</label>
                <select class="form-select form-select-lg" id="car_id" name="car_id" required>
                    <option value="">-- Vui lòng chọn xe --</option>
                    <?php foreach ($cars as $car): ?>
                        <option value="<?= htmlspecialchars($car['id']) ?>"
                            data-price="<?= htmlspecialchars($car['price']) ?>"
                            <?= ($testDrive['car_id'] == $car['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($car['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="preferred_date" class="form-label fw-semibold">Ngày lái thử:</label>
                <input type="date" class="form-control form-control-lg" id="preferred_date" name="preferred_date"
                    value="<?= htmlspecialchars($testDrive['preferred_date']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="preferred_time" class="form-label fw-semibold">Giờ lái thử:</label>
                <input type="time"
                    class="form-control form-control-lg"
                    id="preferred_time"
                    name="preferred_time"
                    min="08:00"
                    max="17:00"
                    value="<?= htmlspecialchars(date('H:i', strtotime($testDrive['preferred_time']))) ?>"
                    required>
                <small class="text-muted">Giờ mở cửa: từ <strong>08:00</strong> đến <strong>17:00</strong></small>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Trạng thái:</label>
                <select class="form-select form-select-lg" id="status" name="status" required>
                    <option value="Pending" <?= ($testDrive['status'] == 'Pending') ? 'selected' : '' ?>>Chờ xác nhận</option>
                    <option value="Confirmed" <?= ($testDrive['status'] == 'Confirmed') ? 'selected' : '' ?>>Đã xác nhận</option>
                    <option value="Completed" <?= ($testDrive['status'] == 'Completed') ? 'selected' : '' ?>>Hoàn tất</option>
                    <option value="Cancelled" <?= ($testDrive['status'] == 'Cancelled') ? 'selected' : '' ?>>Đã hủy</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="location" class="form-label fw-semibold">Địa điểm lái thử:</label>
                <input type="text" class="form-control form-control-lg" id="location" name="location"
                    value="<?= htmlspecialchars($testDrive['location']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Ngày đăng ký:</label>
                <div class="form-control form-control-lg bg-light">
                    <?= date('d/m/Y H:i', strtotime($testDrive['created_at'])) ?>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/admindashbroad#test_drives" class="btn btn-secondary px-4">
                    <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-circle-fill me-1"></i> Cập nhật thông tin
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS + SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>