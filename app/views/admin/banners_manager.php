<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-images me-2 text-primary fs-4"></i> Quản lý Banner
    </h2>
    <a href="/admin/banner/add" class="btn btn-success d-flex align-items-center gap-1 shadow-sm">
        <i class="bi bi-plus-circle"></i> Thêm banner
    </a>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>URL</th>
                <th>Hình ảnh</th>
                <th>Loại</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($banners as $banner): ?>
                <tr>
                    <td><?= $banner['id'] ?></td>
                    <td class="text-start text-break"><?= htmlspecialchars($banner['image_url']) ?></td>
                    <td>
                        <?php if (!empty($banner['image_url'])): ?>
                            <img src="<?= htmlspecialchars($banner['image_url']) ?>"
                                alt="Banner"
                                class="img-thumbnail"
                                style="max-height: 120px; max-width: 300px;">
                        <?php else: ?>
                            <span class="text-muted">Không có ảnh</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($banner['type']) ?></td>
                    <td>
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input toggle-active" type="checkbox"
                                data-id="<?= $banner['id'] ?>"
                                <?= $banner['is_active'] ? 'checked' : '' ?>>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/admin/banner/edit/<?= $banner['id'] ?>"
                                class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a href="/admin/banner/delete/<?= $banner['id'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa banner này?');"
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
    document.querySelectorAll('.toggle-active').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const bannerId = this.getAttribute('data-id');
            const isActive = this.checked ? 1 : 0;

            fetch('/updateBannerStatus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `banner_id=${bannerId}&is_active=${isActive}`
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