<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chỉnh sửa đơn hàng</title>

    <!-- Bootstrap 5 + Icons + SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="container mt-5 bg-white p-4 rounded-4 shadow-lg">
        <div class="card-header bg-primary text-white mb-4 rounded-3">
            <h3 class="m-3 p-2">
                <i class="bi bi-pencil-square me-2"></i> Chỉnh sửa đơn hàng #<?= htmlspecialchars($order['order_id']) ?>
            </h3>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h5 class="text-primary"><i class="bi bi-car-front-fill me-1"></i> Thông tin xe</h5>
                <p><strong>Khách hàng:</strong> <?= htmlspecialchars($order['user_name']) ?: '-' ?></p>
                <p><strong>Tên xe:</strong> <?= htmlspecialchars($order['car_name'] ?? '-') ?></p>
                <p><strong>Số lượng:</strong><?= htmlspecialchars($order['quantity'] ?? '-') ?></p>
                <p><strong>Giá xe:</strong> <?= isset($order['car_price']) ? number_format($order['car_price'], 0, ',', '.') . ' VND' : '-' ?></p>
            </div>

            <div class="col-md-6">
                <h5 class="text-success"><i class="bi bi-puzzle-fill me-1"></i> Thông tin phụ kiện</h5>
                <p><strong>Tên phụ kiện:</strong> <?= !empty($order['accessory_name']) ? htmlspecialchars($order['accessory_name']) : '-' ?></p>
                <p><strong>Số lượng:</strong> <?= !empty($order['accessory_quantity']) ? htmlspecialchars($order['accessory_quantity']) : '-' ?></p>
                <p><strong>Giá phụ kiện:</strong> <?= !empty($order['accessory_price']) ? number_format($order['accessory_price'], 0, ',', '.') . ' VND' : '-' ?></p>
            </div>
        </div>

        <div class="mt-3">
            <p><strong>Tổng tiền:</strong> <span class="fw-bold text-success"><?= !empty($order['total_price']) ? number_format($order['total_price'], 0, ',', '.') . ' VND' : '-' ?></span></p>
            <p><strong>Trạng thái hiện tại:</strong>
                <span class="badge 
                <?php
                switch (strtolower($order['status'])) {
                    case 'pending':
                        echo 'bg-warning text-dark';
                        break;
                    case 'completed':
                        echo 'bg-success';
                        break;
                    case 'canceled':
                        echo 'bg-danger';
                        break;
                    case 'shipped':
                        echo 'bg-info text-dark';
                        break;
                    case 'confirmed':
                        echo 'bg-primary';
                        break;
                    default:
                        echo 'bg-secondary';
                }
                ?>">
                    <?= htmlspecialchars(ucfirst($order['status'])) ?>
                </span>
            </p>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">

            <div class="mb-3">
                <label for="status" class="form-label">Cập nhật trạng thái:</label>
                <select name="order_status" id="status" class="form-select">
                    <?php
                    $statuses = [
                        'pending' => 'Đang chờ xử lý',
                        'confirmed' => 'Đã xác nhận',
                        'shipped' => 'Đang giao',
                        'completed' => 'Đã hoàn thành',
                        'canceled' => 'Đã hủy'
                    ];
                    foreach ($statuses as $key => $label):
                    ?>
                        <option value="<?= $key ?>" <?= strtolower($order['status']) === $key ? 'selected' : '' ?>><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="/admindashbroad#orders" class="btn btn-secondary d-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                    <i class="bi bi-check-circle"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap & SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>