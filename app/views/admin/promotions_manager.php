<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-ticket-perforated-fill me-2 text-primary fs-4"></i> Quản lý Khuyến mãi
    </h2>
    <a href="/admin/promotions/create" class="btn btn-success">
        <i class="bi bi-plus-circle me-1"></i> Thêm mới
    </a>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Tên khuyến mãi</th>
                <th>Giảm (%)</th>
                <th>Giảm (VNĐ)</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Mã Code</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($promotions as $promo): ?>
                <tr>
                    <td><?= $promo['id'] ?></td>
                    <td><?= htmlspecialchars($promo['name']) ?></td>
                    <td><?= number_format($promo['discount_percent'] ?? 0, 0, ',', '.') ?>%</td>
                    <td><?= number_format($promo['discount_amount'] ?? 0, 0, ',', '.') ?>đ</td>
                    <td><?= date('d/m/Y', strtotime($promo['start_date'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($promo['end_date'])) ?></td>
                    <td><span class="badge bg-info text-dark"><?= htmlspecialchars($promo['code']) ?></span></td>
                    <td>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input promo" type="checkbox"
                                data-id="<?= $promo['id'] ?>"
                                <?= $promo['is_active'] ? 'checked' : '' ?>>
                        </div>
                    </td>
                    <td>
                        <a href="/admin/promotions/edit/<?= $promo['id'] ?>" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-pencil-fill"></i> Sửa
                        </a>
                        <a href="/admin/promotions/delete/<?= $promo['id'] ?>" class="btn btn-sm btn-outline-danger me-1" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                            <i class="bi bi-trash-fill"></i> Xoá
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    document.querySelectorAll('.promo').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const promoId = this.getAttribute('data-id');
            const isActive = this.checked ? 1 : 0;

            fetch('/updatePromotionStatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `promo_id=${promoId}&is_active=${isActive}`
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