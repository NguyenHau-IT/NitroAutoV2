<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 text-primary d-flex align-items-center">
        <i class="bi bi-gear-fill me-2"></i> Quản lý phụ kiện
    </h2>
    <a href="admin/accessory/add" class="btn btn-success d-flex align-items-center shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Thêm phụ kiện
    </a>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Tên phụ kiện</th>
                <th>Giá</th>
                <th>Kho</th>
                <th>Mô tả</th>
               <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody class="text-dark">
            <?php foreach ($accessories as $accessory): ?>
                <tr>
                    <td class="text-center"><?= $accessory['id'] ?></td>
                    <td><?= htmlspecialchars($accessory['name']) ?></td>
                    <td><?= number_format($accessory['price'], 0, ',', '.') ?> VND</td>
                    <td><?= isset($accessory['stock']) ? $accessory['stock'] : 'Không có dữ liệu' ?></td>
                    <td>
                        <div class="bg-light rounded p-2 overflow-auto" style="max-height: 120px; white-space: pre-wrap;">
                            <?= nl2br(htmlspecialchars($accessory['description'])) ?>
                        </div>
                    </td>
                        <td class="text-center">
                            <div class="form-check form-switch d-flex justify-content-center">
                                <input class="form-check-input services" type="checkbox"
                                    data-id="<?= $accessory['id'] ?>"
                                    <?= $accessory['status'] ? 'checked' : '' ?>>
                            </div>
                        </td>
                    <td class="text-center">
                        <a href="admin/accessory/edit/<?= $accessory['id'] ?>" class="btn btn-sm btn-outline-primary me-1 d-inline-flex align-items-center">
                            <i class="bi bi-pencil-square me-1"></i> Sửa
                        </a>
                        <a href="admin/accessory/delete/<?= $accessory['id'] ?>"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa phụ kiện này?');"
                            class="btn btn-sm btn-outline-danger d-inline-flex align-items-center">
                            <i class="bi bi-trash me-1"></i> Xóa
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    document.querySelectorAll('.services').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const accessory_id = this.getAttribute('data-id');
            const status = this.checked ? 1 : 0;

            fetch('/updateAccessoryStatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `accessory_id=${accessory_id}&status=${status}`
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