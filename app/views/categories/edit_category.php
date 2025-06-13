<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa Danh Mục</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <main class="container bg-white p-4 rounded shadow w-100" style="max-width: 600px;">
        <h4 class="mb-4 text-warning d-flex align-items-center">
            <i class="bi bi-pencil-square me-2"></i> Sửa Danh Mục
        </h4>

        <form action="" method="POST">
            <!-- ID ẩn -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">

            <!-- Tên danh mục -->
            <div class="mb-3">
                <label for="name" class="form-label">Tên danh mục</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="<?= htmlspecialchars($category['name']) ?>"
                       placeholder="Nhập tên danh mục" required>
            </div>

            <!-- Mô tả -->
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea name="description" id="description" rows="3" class="form-control" required
                    placeholder="Nhập mô tả danh mục"><?= htmlspecialchars($category['description']) ?></textarea>
            </div>

            <!-- Hành động -->
            <div class="d-flex justify-content-between">
                <a href="/admindashbroad#categories" class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-warning d-flex align-items-center">
                    <i class="bi bi-save me-1"></i> Cập nhật
                </button>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>