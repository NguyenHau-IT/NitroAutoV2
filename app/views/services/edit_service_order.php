<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chỉnh sửa trạng thái lịch hẹn</title>

    <!-- Bootstrap CSS + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
</head>

<body class="bg-light py-5">
    <div class="container mt-4 w-75">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i> Chỉnh sửa trạng thái lịch hẹn</h5>
            </div>
            <div class="card-body">
                <form action="" method="post" class="p-4 border rounded bg-white shadow-sm">
                    <input type="hidden" name="ServiceOrderID" value="<?= $serviceOrder['ServiceOrderID'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Khách hàng</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($serviceOrder['UserFullName']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dịch vụ</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($serviceOrder['ServiceName']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái lịch hẹn</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Pending" <?= $serviceOrder['Status'] === 'Pending' ? 'selected' : '' ?>>Đang chờ xử lý</option>
                            <option value="Approved" <?= $serviceOrder['Status'] === 'Approved' ? 'selected' : '' ?>>Đã duyệt</option>
                            <option value="Completed" <?= $serviceOrder['Status'] === 'Completed' ? 'selected' : '' ?>>Đã hoàn thành</option>
                            <option value="Cancelled" <?= $serviceOrder['Status'] === 'Cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/admindashbroad#service_orders" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Cập nhật trạng thái
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>