<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-signpost-split-fill me-2 text-primary fs-4"></i> Quản lý Lái thử
    </h2>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Xe</th>
                <th>Ngày</th>
                <th>Giờ</th>
                <th>Địa điểm</th>
                <th>Trạng thái</th>
                <th>Thời gian đặt</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($testDrives as $test_drive): ?>
                <tr>
                    <td><?= htmlspecialchars($test_drive['id']) ?></td>
                    <td><?= htmlspecialchars($test_drive['user_name']) ?></td>
                    <td><?= htmlspecialchars($test_drive['car_name']) ?></td>
                    <td><?= htmlspecialchars($test_drive['preferred_date']) ?></td>
                    <td><?= date('H:i:s', strtotime($test_drive['preferred_time'])) ?></td>
                    <td class="text-start"><?= htmlspecialchars($test_drive['location']) ?></td>
                    <td style="min-width: 160px;">
                        <?php
                        $status = $test_drive['status'];
                        $options = [
                            'Completed' => 'Đã hoàn thành',
                            'Pending' => 'Đang xử lý',
                            'Cancelled' => 'Đã huỷ',
                            'Confirmed' => 'Đã xác nhận',
                        ];
                        ?>
                        <select name="status" class="form-select form-select-lg testdrive" data-id="<?= $test_drive['id'] ?>">
                            <?php foreach ($options as $value => $label): ?>
                                <option value="<?= $value ?>" <?= $status === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($test_drive['created_at'])) ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/admin/test_drive/edit/<?= $test_drive['id'] ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a href="/admin/test_drive/delete/<?= $test_drive['id'] ?>"
                               onclick="return confirm('Bạn có chắc chắn muốn xóa lịch lái thử này?');"
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
    document.querySelectorAll('.testdrive').forEach(function(select) {
        select.addEventListener('change', function() {
            const test_driveId = this.getAttribute('data-id');
            const newStatus = this.value;

            fetch('/update_testdrive_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `test_drive_id=${test_driveId}&status=${newStatus}`
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