<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thêm Xe Mới</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

  <div class="container">
    <div class="card shadow-lg">
      <div class="card-header bg-success text-white">
        <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Thêm Xe Mới</h4>
      </div>
      <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Tên xe</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="col-md-6">
              <label for="brand_id" class="form-label">Hãng xe</label>
              <select class="form-select" id="brand_id" name="brand_id" required>
                <option value="" disabled selected>Chọn hãng</option>
                <?php foreach ($brands as $brand): ?>
                  <option value="<?= $brand['id'] ?>"><?= htmlspecialchars($brand['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="category_id" class="form-label">Danh mục</label>
              <select class="form-select" id="category_id" name="category_id" required>
                <option value="" disabled selected>Chọn danh mục</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="price" class="form-label">Giá bán</label>
              <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <div class="col-md-4">
              <label for="year" class="form-label">Năm sản xuất</label>
              <input type="number" class="form-control" id="year" name="year" required>
            </div>

            <div class="col-md-4">
              <label for="mileage" class="form-label">Số km đã đi</label>
              <input type="number" class="form-control" id="mileage" name="mileage" required>
            </div>

            <div class="col-md-4">
              <label for="stock" class="form-label">Tồn kho</label>
              <input type="number" class="form-control" id="stock" name="stock">
            </div>

            <div class="col-md-6">
              <label for="fuel_type" class="form-label">Nhiên liệu</label>
              <select class="form-select" id="fuel_type" name="fuel_type">
                <option value="Gasoline">Xăng</option>
                <option value="Diesel">Dầu</option>
                <option value="Hybrid">Hybrid</option>
                <option value="Electric">Điện</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="transmission" class="form-label">Hộp số</label>
              <select class="form-select" id="transmission" name="transmission">
                <option value="Automatic">Tự động</option>
                <option value="Manual">Số sàn</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="color" class="form-label">Màu sắc</label>
              <input type="text" class="form-control" id="color" name="color">
            </div>

            <div class="col-md-6">
              <label for="horsepower" class="form-label">Công suất (HP)</label>
              <input type="number" class="form-control" id="horsepower" name="horsepower">
            </div>

            <div class="col-md-6">
              <label for="image_url" class="form-label">Ảnh xe</label>
              <input type="file" class="form-control" id="image_url" name="image_url">
            </div>

            <div class="col-md-6">
              <label for="image_3d_url" class="form-label">Link ảnh 3D</label>
              <input type="text" class="form-control" id="image_3d_url" name="image_3d_url" placeholder="https://...">
            </div>

            <div class="col-12">
              <label for="description" class="form-label">Mô tả</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="col-12 text-end">
              <button type="submit" class="btn btn-success mt-3">
                <i class="bi bi-check-circle me-1"></i>Thêm xe
              </button>
              <a href="/admindashbroad#cars" class="btn btn-secondary mt-3 ms-2">
                <i class="bi bi-x-circle me-1"></i>Hủy
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
