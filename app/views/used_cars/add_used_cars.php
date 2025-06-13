<?php require_once __DIR__ . '/../../../includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-5 mb-5 bg-light p-5 rounded-4 shadow-lg">
        <h2 class="text-center text-primary mb-4">
            <i class="bi bi-car-front-fill me-2"></i>Thêm bài đăng
        </h2>

        <form action="" method="POST" enctype="multipart/form-data" class="row g-4">
            <!-- Thông tin cơ bản -->
            <div class="col-md-6">
                <label for="name" class="form-label fw-semibold">Tên xe</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="col-md-6">
                <label for="price" class="form-label fw-semibold">Giá (VNĐ)</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <!-- Hãng và danh mục -->
            <div class="col-md-6">
                <label for="brand_id" class="form-label fw-semibold">Hãng xe</label>
                <select class="form-select" id="brand_id" name="brand_id" required>
                    <option value="" disabled selected>Chọn hãng xe</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?= $brand['id'] ?>"><?= htmlspecialchars($brand['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label for="category_id" class="form-label fw-semibold">Danh mục</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="" disabled selected>Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Năm và số km -->
            <div class="col-md-6">
                <label for="year" class="form-label fw-semibold">Năm sản xuất</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>

            <div class="col-md-6">
                <label for="mileage" class="form-label fw-semibold">Số km đã đi</label>
                <input type="number" class="form-control" id="mileage" name="mileage" required>
            </div>

            <!-- Nhiên liệu & truyền động -->
            <div class="col-md-6">
                <label for="fuel_type" class="form-label fw-semibold">Loại nhiên liệu</label>
                <select class="form-select" id="fuel_type" name="fuel_type">
                    <option value="Gasoline">Xăng</option>
                    <option value="Diesel">Dầu</option>
                    <option value="Hybrid">Hybrid</option>
                    <option value="Electric">Điện</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="transmission" class="form-label fw-semibold">Hộp số</label>
                <select class="form-select" id="transmission" name="transmission">
                    <option value="Automatic">Tự động</option>
                    <option value="Manual">Số sàn</option>
                </select>
            </div>

            <!-- Màu sắc và mô tả -->
            <div class="col-md-6">
                <label for="color" class="form-label fw-semibold">Màu xe</label>
                <input type="text" class="form-control" id="color" name="color">
            </div>

            <div class="col-md-12">
                <label for="description" class="form-label fw-semibold">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>

            <!-- Hình ảnh -->
            <div class="col-md-12">
                <label for="image_url" class="form-label fw-semibold">Ảnh đại diện</label>
                <input type="file" name="image_urls[]" multiple accept="image/*" class="form-control" required>
            </div>

            <!-- Nút hành động -->
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-plus-circle me-1"></i> Thêm bài
                </button>
                <a href="/home" class="btn btn-secondary ms-2">
                    <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>