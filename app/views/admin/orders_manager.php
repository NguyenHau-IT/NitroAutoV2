<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-receipt-cutoff me-2 text-primary fs-4"></i> Quản lý đơn hàng
    </h2>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Xe</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Phụ kiện</th>
                <th>Số lượng</th>
                <th>Giá phụ kiện</th>
                <th>Tổng giá</th>
                <th>Địa chỉ</th>
                <th>Trạng thái</th>
                <th>Thời gian</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($orders as $order): ?>
                <?php
                $carCount = count($order['cars']);
                $accCount = count($order['accessories']);
                $rowspan = max($carCount, $accCount);
                for ($i = 0; $i < $rowspan; $i++):
                ?>
                    <tr>
                        <?php if ($i === 0): ?>
                            <td rowspan="<?= $rowspan ?>"><?= $order['id'] ?></td>
                            <td rowspan="<?= $rowspan ?>"><?= htmlspecialchars($order['user_name']) ?></td>
                        <?php endif; ?>

                        <td><?= $order['cars'][$i]['name'] ?? '-' ?></td>
                        <td><?= $order['cars'][$i]['quantity'] ?? '-' ?></td>
                        <td class="text-end"><?= isset($order['cars'][$i]['price']) ? number_format($order['cars'][$i]['price']) . ' đ' : '-' ?></td>

                        <td><?= $order['accessories'][$i]['name'] ?? '-' ?></td>
                        <td><?= $order['accessories'][$i]['quantity'] ?? '-' ?></td>
                        <td class="text-end"><?= isset($order['accessories'][$i]['price']) ? number_format($order['accessories'][$i]['price']) . ' đ' : '-' ?></td>

                        <?php if ($i === 0): ?>
                            <td rowspan="<?= $rowspan ?>" class="text-end text-success fw-bold"><?= number_format($order['total_price']) ?> đ</td>
                            <td rowspan="<?= $rowspan ?>" class="text-start"><?= htmlspecialchars($order['address']) ?></td>
                            <td rowspan="<?= $rowspan ?>" style="min-width: 160px;">
                                <?php
                                $status = $order['status'];
                                $options = [
                                    'Canceled' => 'Đã huỷ',
                                    'Completed' => 'Đã hoàn thành',
                                    'Shipped' => 'Đang giao xe',
                                    'Confirmed' => 'Đã xác nhận',
                                    'Pending' => 'Chờ xác nhận',
                                ];
                                ?>
                                <select name="status" class="form-select form-select-lg status" data-id="<?= $order['id'] ?>">
                                    <?php foreach ($options as $value => $label): ?>
                                        <option value="<?= $value ?>" <?= $status === $value ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td rowspan="<?= $rowspan ?>"><?= date('d/m/Y - H:i:s', strtotime($order['order_date'])) ?></td>
                            <td rowspan="<?= $rowspan ?>">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="/admin/order/edit/<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>
                                    <a href="/admin/order/delete/<?= $order['id'] ?>"
                                        onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này?');"
                                        class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                        <i class="bi bi-trash3"></i> Xóa
                                    </a>
                                </div>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endfor; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    document.querySelectorAll('.status').forEach(function(select) {
        select.addEventListener('change', function() {
            const orderId = this.getAttribute('data-id');
            const valueStatus = this.value;

            fetch('/update_order_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `order_id=${orderId}&status=${valueStatus}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('✅ Trạng thái đã được cập nhật thành công');
                    } else {
                        console.log('❌ Cập nhật trạng thái thất bại');
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    console.log('❌ Đã xảy ra lỗi. Vui lòng thử lại.');
                    location.reload();
                });
        });
    });
</script>