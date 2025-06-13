<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-ui-checks-grid me-2 text-primary fs-4"></i> Quản lý Danh mục
    </h2>
    <a href="/admin/category/add" class="btn btn-success d-flex align-items-center gap-1 shadow-sm">
        <i class="bi bi-plus-circle"></i> Thêm danh mục
    </a>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th >ID</th>
                <th >Tên danh mục</th>
                <th >Mô tả</th>
                <th >Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= htmlspecialchars($category['id'] ?? 0) ?></td>
                    <td><?= htmlspecialchars($category['name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($category['description'] ?? '') ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/admin/category/edit/<?= $category['id'] ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a href="/admin/category/delete/<?= $category['id'] ?>"
                               onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');"
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
