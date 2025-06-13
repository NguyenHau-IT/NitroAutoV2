<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-receipt-cutoff me-2 text-primary fs-4"></i> Quản lý lịch hẹn
    </h2>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Dịch vụ</th>
                <th>Thời gian hẹn</th>
                <th>Trạng thái</th>
                <th>Ghi chú</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($serviceOrders as $order): ?>
                <tr>
                    <td><?= $order['ServiceOrderID'] ?></td>
                    <td><?= htmlspecialchars($order['UserFullName']) ?></td>
                    <td><?= htmlspecialchars($order['ServiceName']) ?></td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($order['OrderDate'])) ?></td>
                    <td style="min-width: 160px;">
                        <?php
                        $status = $order['Status']; // Updated to use $order instead of $test_drive
                        $options = [
                            'Completed' => 'Đã hoàn thành',
                            'Pending' => 'Đang xử lý',
                            'Cancelled' => 'Đã huỷ',
                            'Approved' => 'Đã xác nhận',
                        ];
                        ?>
                        <select name="status" class="form-select form-select-lg serviceorder" data-id="<?= $order['ServiceOrderID'] ?>">
                            <?php foreach ($options as $value => $label): ?>
                                <option value="<?= $value ?>" <?= $status === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><?= htmlspecialchars($order['Note']) ?: '-' ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/admin/service-order/edit/<?= $order['ServiceOrderID'] ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a href="/admin/service-order/delete/<?= $order['ServiceOrderID'] ?>"
                                onclick="return confirm('Bạn có chắc muốn xóa lịch hẹn này?');"
                                class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                <i class="bi bi-trash3"></i> Xóa
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    document.querySelectorAll('.serviceorder').forEach(function(select) {
        select.addEventListener('change', function() {
            const serviceOrderId = this.getAttribute('data-id');
            const newStatus = this.value;

            fetch('/update_service_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `service_order_id=${serviceOrderId}&status=${newStatus}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Trạng thái đã được cập nhật thành công');
                    } else {
                        alert('Cập nhật trạng thái thất bại');
                        // Nếu thất bại, reload lại trang để đảm bảo trạng thái chính xác
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert('Đã xảy ra lỗi. Vui lòng thử lại.');
                    location.reload();
                });
        });
    });
</script>