<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa Banner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Chỉnh sửa Banner</h2>
        <form action="" method="post" enctype="multipart/form-data" class="card p-4 shadow-sm">
            <!-- Loại banner -->
            <div class="mb-3">
                <label class="form-label">Loại banner</label>
                <select name="type" class="form-select">
                    <option value="slice" <?= ($banner['type'] ?? '') === 'slice' ? 'selected' : '' ?>>Hiển thị chia lớp (slice)</option>
                    <option value="left" <?= ($banner['type'] ?? '') === 'left' ? 'selected' : '' ?>>Hiển thị bên trái (left)</option>
                    <option value="top" <?= ($banner['type'] ?? '') === 'top' ? 'selected' : '' ?>>Hiển thị đầu trang (top)</option>
                    <option value="right" <?= ($banner['type'] ?? '') === 'right' ? 'selected' : '' ?>>Hiển thị bên phải (right)</option>
                </select>
            </div>

            <!-- Trạng thái -->
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" id="activeCheckbox"
                    <?= ($banner['is_active'] ?? 0) ? 'checked' : '' ?>>
                <label class="form-check-label" for="activeCheckbox">Kích hoạt</label>
            </div>

            <!-- Ảnh hiện tại -->
            <div class="mb-3">
                <label class="form-label">Ảnh hiện tại</label><br>
                <img src="<?= $banner['image_url'] ?>" class="img-fluid rounded shadow" style="max-height: 200px;">
            </div>

            <!-- Ảnh mới -->
            <div class="mb-3">
                <label class="form-label">Ảnh mới (nếu muốn thay đổi)</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            <a href="/admindashbroad#banners" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>

</html>