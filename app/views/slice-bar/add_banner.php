<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Banner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light py-5">
    <div class="container bg-white p-5 rounded-4 shadow w-75" style="max-width: 600px;">
        <h3 class="mb-4 text-primary">
            <i class="bi bi-image-fill me-2"></i> Thêm Banner Mới
        </h3>

        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Image URL -->
            <div class="mb-3">
                <label for="image_file" class="form-label">Chọn hình ảnh</label>
                <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*" required>
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label for="type" class="form-label">Loại banner</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="slide">Slide (trình chiếu chính)</option>
                    <option value="left">Left (trái)</option>
                    <option value="right">Right (phải)</option>
                    <option value="top">Top (trên cùng)</option>
                </select>
            </div>

            <!-- Created at -->
            <div class="mb-3">
                <label for="created_at" class="form-label">Ngày tạo</label>
                <input type="datetime-local" name="created_at" id="created_at" class="form-control" value="<?= date('Y-m-d\TH:i') ?>">
            </div>

            <!-- Is Active -->
            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                <label class="form-check-label" for="is_active">Kích hoạt banner</label>
            </div>

            <!-- Action -->
            <div class="d-flex justify-content-between">
                <a href="/admin#banners" class="btn btn-secondary d-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-success d-flex align-items-center gap-1">
                    <i class="bi bi-check-circle"></i> Lưu banner
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>