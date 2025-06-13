<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($accessory) ? 'Chỉnh sửa phụ kiện' : 'Thêm phụ kiện mới' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4"><?= isset($accessory) ? 'Chỉnh sửa phụ kiện' : 'Thêm phụ kiện mới' ?></h2>

    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Tên phụ kiện</label>
            <input type="text" id="name" name="name" class="form-control" 
                   value="<?= htmlspecialchars($accessory['name'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Giá</label>
            <input type="number" id="price" name="price" class="form-control" 
                   value="<?= htmlspecialchars($accessory['price'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Số lượng</label>
            <input type="number" id="stock" name="stock" class="form-control" 
                   value="<?= htmlspecialchars($accessory['stock'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea id="description" name="description" rows="4" class="form-control"><?= htmlspecialchars($accessory['description'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="/admindashbroad" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
