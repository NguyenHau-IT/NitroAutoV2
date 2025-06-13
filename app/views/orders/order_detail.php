<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4">
        <h2 class="text-center text-primary mb-4">
            <i class="bi bi-receipt-cutoff me-2"></i>Chi tiết đơn hàng #<?= $order['order_id'] ?>
        </h2>

        <div class="row g-4 mt-3">
            <!-- Thông tin khách hàng -->
            <div class="col-md-6">
                <div class="bg-white p-4 shadow-sm rounded-3 border">
                    <h4 class="text-secondary mb-3">
                        <i class="bi bi-person-lines-fill me-2"></i>Thông tin khách hàng
                    </h4>
                    <div class="mb-2"><strong>Họ tên:</strong> <?= htmlspecialchars($order['user_name']) ?></div>
                    <div class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></div>
                    <div class="mb-2"><strong>Điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></div>
                    <div class="mb-2"><strong>Địa chỉ nhận xe:</strong> <?= htmlspecialchars($order['address']) ?></div>
                </div>
            </div>

            <!-- Thông tin đơn hàng -->
            <div class="col-md-6">
                <div class="bg-white p-4 shadow-sm rounded-3 border">
                    <h4 class="text-secondary mb-3">
                        <i class="bi bi-truck me-2"></i>Thông tin đơn hàng
                    </h4>
                    <div class="mb-2"><strong>Tên xe:</strong> <?= !empty($order['car_name']) ? htmlspecialchars($order['car_name']) : '-' ?></div>
                    <div class="mb-2"><strong>Số lượng xe:</strong> <?= isset($order['quantity']) ? htmlspecialchars($order['quantity']) : '-' ?></div>
                    <div class="mb-2"><strong>Giá xe:</strong> <?= isset($order['subtotal']) ? number_format($order['subtotal'], 0, ',', '.') . ' VNĐ' : '-' ?></div>
                    <div class="mb-2"><strong>Phụ kiện:</strong> <?= !empty($order['accessory_name']) ? htmlspecialchars($order['accessory_name']) : '-' ?></div>
                    <div class="mb-2"><strong>Số lượng phụ kiện:</strong> <?= isset($order['accessory_quantity']) ? htmlspecialchars($order['accessory_quantity']) : '-' ?></div>
                    <div class="mb-2"><strong>Giá phụ kiện:</strong> <?= isset($order['accessory_price']) ? number_format($order['accessory_price'], 0, ',', '.') . ' VNĐ' : '-' ?></div>
                    <div class="mb-2"><strong>Tổng giá:</strong> <span class="text-danger fw-bold"><?= isset($order['total_amount']) ? number_format($order['total_amount'], 0, ',', '.') . ' VNĐ' : '-' ?></span></div>
                    <div class="mb-2"><strong>Ngày đặt:</strong> <?= !empty($order['order_date']) ? date('d/m/Y - H:i:s', strtotime($order['order_date'])) : '-' ?></div>
                    <div><strong>Trạng thái:</strong>
                        <?php
                        if (empty($order['status'])) {
                            echo '-';
                        } else {
                            switch (strtolower($order['status'])) {
                                case 'pending':
                                    echo '<span class="badge bg-warning text-dark">Đang chờ xử lý</span>';
                                    break;
                                case 'confirmed':
                                    echo '<span class="badge bg-info text-dark">Đã xác nhận</span>';
                                    break;
                                case 'shipped':
                                    echo '<span class="badge bg-primary">Đang giao</span>';
                                    break;
                                case 'completed':
                                    echo '<span class="badge bg-success">Đã hoàn thành</span>';
                                    break;
                                case 'canceled':
                                    echo '<span class="badge bg-danger">Đã hủy</span>';
                                    break;
                                default:
                                    echo 'Không xác định';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="/user_orders" class="btn btn-primary">
                <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>
