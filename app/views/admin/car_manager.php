<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 text-primary d-flex align-items-center">
        <i class="bi bi-car-front-fill me-2 fs-3"></i> Quản lý xe
    </h2>
    <a href="/admin/car/add" class="btn btn-success shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Thêm xe mới
    </a>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Tên xe</th>
                <th>Hãng</th>
                <th>Danh mục</th>
                <th>Năm</th>
                <th>Giá</th>
                <th>Màu</th>
                <th>Hộp số</th>
                <th>Kho</th>
                <th>Ảnh</th>
                <th>3D</th>
                <th style="min-width: 150px;">Mô tả</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?= htmlspecialchars($car['id']) ?></td>
                    <td class="text-start"><?= htmlspecialchars($car['name']) ?></td>
                    <td><?= htmlspecialchars($car['brand_name']) ?></td>
                    <td><?= htmlspecialchars($car['category_name']) ?></td>
                    <td><?= htmlspecialchars($car['year']) ?></td>
                    <td class="text-end text-nowrap"><?= number_format($car['price']) ?> đ</td>
                    <td><?= htmlspecialchars($car['color']) ?></td>
                    <td><?= htmlspecialchars($car['transmission']) ?></td>
                    <td><?= htmlspecialchars($car['stock']) ?></td>

                    <!-- Ảnh xe -->
                    <td>
                        <?php if (!empty($car['normal_image_url'])): ?>
                            <img src="<?= htmlspecialchars($car['normal_image_url']) ?>" alt="Ảnh xe" class="img-thumbnail border" style="width: 80px; height: auto;">
                        <?php else: ?>
                            <span class="text-muted">Không có</span>
                        <?php endif; ?>
                    </td>

                    <!-- Ảnh 3D -->
                    <td>
                        <?php if (!empty($car['three_d_images'])): ?>
                            <a href="<?= htmlspecialchars($car['three_d_images']) ?>" target="_blank" class="btn btn-outline-dark btn-sm" data-bs-toggle="tooltip" title="Xem ảnh 3D">
                                <i class="bi bi-box me-1"></i> 3D
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Không có</span>
                        <?php endif; ?>
                    </td>

                    <!-- Mô tả -->
                    <td class="text-start">
                        <span data-bs-toggle="tooltip" title="<?= htmlspecialchars($car['description']) ?>">
                            <?= strlen($car['description']) > 50 ? htmlspecialchars(mb_substr($car['description'], 0, 50)) . '...' : htmlspecialchars($car['description']) ?>
                        </span>
                    </td>

                    <!-- Hành động -->
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/admin/car/edit/<?= $car['id'] ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center">
                                <i class="bi bi-pencil-square me-1"></i> Sửa
                            </a>
                            <a href="/admin/car/delete/<?= $car['id'] ?>"
                                onclick="return confirm('Bạn có chắc muốn xóa xe này?');"
                                class="btn btn-sm btn-outline-danger d-flex align-items-center">
                                <i class="bi bi-trash3 me-1"></i> Xóa
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Kích hoạt tooltip Bootstrap -->
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
</script>