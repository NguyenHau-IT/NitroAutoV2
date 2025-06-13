<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Hãng Xe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Thêm Hãng Xe Mới</h2>

        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-<?= $_GET['status'] === 'success' ? 'success' : 'danger' ?>">
                <?= urldecode($_GET['message']) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Tên Hãng Xe</label>
                <input type="text" name="name" id="name" class="form-control" required placeholder="VD: Toyota, BMW...">
            </div>

            <div class="mb-3">
                <label for="country" class="form-label">Quốc Gia</label>
                <input type="text" name="country" id="country" class="form-control" required placeholder="VD: Nhật Bản, Đức...">
            </div>

            <div class="mb-3">
                <label for="logo" class="form-label">Logo (jpg, png, webp)</label>
                <input type="file" name="logo" id="logo" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
            </div>

            <button type="submit" class="btn btn-primary">Thêm Hãng</button>
            <a href="/admindashbroad#brands" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>

</html>