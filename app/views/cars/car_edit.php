<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chỉnh sửa thông tin xe</title>

    <!-- Bootstrap CSS + Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
</head>

<body class="bg-light py-5">
    <div class="container w-75">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa thông tin xe</h4>
            </div>

            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($car['id']) ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label"><i class="bi bi-card-text me-1"></i> Tên xe</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($car['name']) ?>" required maxlength="100" />
                        </div>

                        <div class="col-md-6">
                            <label for="brand_id" class="form-label"><i class="bi bi-buildings me-1"></i> Hãng xe</label>
                            <select class="form-select" id="brand_id" name="brand_id" required>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand['id'] ?>" <?= $brand['id'] == $car['brand_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($brand['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label"><i class="bi bi-tags me-1"></i> Danh mục</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $car['category_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label"><i class="bi bi-cash-stack me-1"></i> Giá bán</label>
                            <input type="number" class="form-control" id="price" name="price" value="<?= htmlspecialchars($car['price']) ?>" required min="0" />
                        </div>

                        <div class="col-md-4">
                            <label for="year" class="form-label"><i class="bi bi-calendar3 me-1"></i> Năm sản xuất</label>
                            <input type="number" class="form-control" id="year" name="year" value="<?= htmlspecialchars($car['year']) ?>" required min="1886" max="<?= date('Y') ?>" />
                        </div>

                        <div class="col-md-4">
                            <label for="fuel_type" class="form-label"><i class="bi bi-fuel-pump me-1"></i> Nhiên liệu</label>
                            <select class="form-select" id="fuel_type" name="fuel_type" required>
                                <option value="Gasoline" <?= $car['fuel_type'] == 'Gasoline' ? 'selected' : '' ?>>Xăng</option>
                                <option value="Diesel" <?= $car['fuel_type'] == 'Diesel' ? 'selected' : '' ?>>Dầu</option>
                                <option value="Hybrid" <?= $car['fuel_type'] == 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                                <option value="Electric" <?= $car['fuel_type'] == 'Electric' ? 'selected' : '' ?>>Điện</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="transmission" class="form-label"><i class="bi bi-gear me-1"></i> Hộp số</label>
                            <select class="form-select" id="transmission" name="transmission" required>
                                <option value="Automatic" <?= $car['transmission'] == 'Automatic' ? 'selected' : '' ?>>Tự động</option>
                                <option value="Manual" <?= $car['transmission'] == 'Manual' ? 'selected' : '' ?>>Số sàn</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="stock" class="form-label"><i class="bi bi-box-seam me-1"></i> Tồn kho</label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?= htmlspecialchars($car['stock']) ?>" required min="0" />
                        </div>

                        <div class="col-md-4">
                            <label for="color" class="form-label"><i class="bi bi-droplet-half me-1"></i> Màu sắc</label>
                            <input type="text" class="form-control" id="color" name="color" value="<?= htmlspecialchars($car['color']) ?>" required maxlength="50" />
                        </div>

                        <div class="col-md-4">
                            <label for="mileage" class="form-label"><i class="bi bi-speedometer2 me-1"></i> Số km đã đi</label>
                            <input type="number" class="form-control" id="mileage" name="mileage" value="<?= htmlspecialchars($car['mileage']) ?>" required min="0" />
                        </div>

                        <div class="col-md-6">
                            <label for="horsepower" class="form-label"><i class="bi bi-lightning me-1"></i> Công suất (HP)</label>
                            <input type="number" class="form-control" id="horsepower" name="horsepower" value="<?= htmlspecialchars($car['horsepower']) ?>" required min="0" />
                        </div>

                        <div class="col-md-6">
                            <label for="created_at" class="form-label"><i class="bi bi-clock me-1"></i> Ngày tạo</label>
                            <input type="datetime-local" class="form-control" id="created_at" name="created_at" value="<?= htmlspecialchars($car['created_at'] ?? '') ?>" required />
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label"><i class="bi bi-card-text me-1"></i> Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3" maxlength="1000"><?= htmlspecialchars($car['description']) ?></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="image_url" class="form-label"><i class="bi bi-image me-1"></i> Ảnh xe</label><br />
                            <?php if (!empty($car['normal_image_url'])): ?>
                                <img src="<?= htmlspecialchars($car['normal_image_url']) ?>" alt="Current Image" class="img-thumbnail mb-2 d-block" style="max-width: 200px;" />
                            <?php endif; ?>
                            <input type="file" class="form-control" id="image_url" name="image_url" />
                        </div>

                        <div class="col-md-6">
                            <label for="image_3d_url" class="form-label"><i class="bi bi-cube me-1"></i> Link ảnh 3D</label>
                            <input type="text" class="form-control" id="image_3d_url" name="image_3d_url" value="<?= htmlspecialchars($car['three_d_images'] ?? '') ?>" />
                            <?php if (!empty($car['three_d_images'])): ?>
                                <a href="<?= htmlspecialchars($car['three_d_images']) ?>" target="_blank" class="mt-2 d-block">Xem ảnh 3D hiện tại</a>
                            <?php endif; ?>
                        </div>

                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary mt-3">
                                <i class="bi bi-save2 me-1"></i> Cập nhật
                            </button>
                            <a href="/admindashbroad#cars" class="btn btn-secondary mt-3">
                                <i class="bi bi-x-circle me-1"></i> Hủy
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS + SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>