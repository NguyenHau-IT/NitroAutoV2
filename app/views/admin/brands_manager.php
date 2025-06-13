<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-building-gear me-2 text-primary fs-4"></i> Quản lý Hãng Xe
    </h2>
    <a href="/admin/brand/add" class="btn btn-success shadow-sm d-flex align-items-center gap-1">
        <i class="bi bi-plus-circle"></i> Thêm Hãng Mới
    </a>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Tên Hãng</th>
                <th>Quốc Gia</th>
                <th>Logo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($brands as $brand): ?>
                <tr>
                    <td><?= htmlspecialchars($brand['id']) ?></td>
                    <td class="text-start"><?= htmlspecialchars($brand['name']) ?></td>
                    <td><?= htmlspecialchars($brand['country']) ?></td>
                    <td>
                        <?php if (!empty($brand['logo'])): ?>
                            <img src="<?= htmlspecialchars($brand['logo']) ?>"
                                alt="<?= htmlspecialchars($brand['name']) ?>"
                                class="img-thumbnail"
                                style="max-width: 100px; max-height: 80px;">
                        <?php else: ?>
                            <span class="text-muted">Không có</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/admin/brand/edit/<?= $brand['id'] ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a href="/admin/brand/delete/<?= $brand['id'] ?>"
                                onclick="return confirm('Bạn có chắc muốn xóa hãng này?');"
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