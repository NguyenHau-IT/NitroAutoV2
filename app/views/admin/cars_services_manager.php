<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary mb-0">🛠️ Quản lý Dịch vụ</h2>
    <a href="/admin/service/add" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i> Thêm dịch vụ
    </a>
</div>

<div class="card shadow border-0">
    <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0">
            <thead class="table-light text-center">
                <tr>
                    <th>ID</th>
                    <th>Tên dịch vụ</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td class="text-center"><?= $service['ServiceID'] ?></td>
                        <td><?= htmlspecialchars($service['ServiceName']) ?></td>
                        <td style="max-width: 250px;">
                            <span class="d-inline-block text-truncate" style="max-width: 240px;" title="<?= htmlspecialchars($service['Description']) ?>">
                                <?= htmlspecialchars($service['Description']) ?>
                            </span>
                        </td>
                        <td class="text-end"><?= number_format($service['Price'], 0, ',', '.') ?>₫</td>
                        <td class="text-center"><?= $service['EstimatedTime'] ?> phút</td>
                        <td class="text-center">
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input class="form-check-input services" type="checkbox"
                                    data-id="<?= $service['ServiceID'] ?>"
                                    <?= $service['Status'] ? 'checked' : '' ?>>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="/admin/service/edit/<?= $service['ServiceID'] ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i> Sửa
                                </a>
                                <a href="/admin/service/delete/<?= $service['ServiceID'] ?>" class="btn btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                    <i class="bi bi-trash"></i> Xoá
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    document.querySelectorAll('.services').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const ServicesId = this.getAttribute('data-id');
            const isActive = this.checked ? 1 : 0;

            fetch('/updateServicesStatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `Services_id=${ServicesId}&is_active=${isActive}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Cập nhật trạng thái thành công');
                    } else {
                        alert('Cập nhật thất bại');
                        this.checked = !this.checked;
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    this.checked = !this.checked;
                });
        });
    });
</script>