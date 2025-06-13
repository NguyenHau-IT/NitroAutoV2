<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa Hãng Xe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Chỉnh sửa Hãng Xe</h2>

    <?php if (isset($_GET['status'])): ?>
        <div class="alert alert-<?= $_GET['status'] === 'success' ? 'success' : 'danger' ?>">
            <?= urldecode($_GET['message']) ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $brand['id'] ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Tên Hãng</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($brand['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">Quốc Gia</label>
            <input type="text" name="country" id="country" class="form-control" value="<?= htmlspecialchars($brand['country']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Logo mới (tuỳ chọn)</label>
            <input type="file" name="logo" id="logo" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        </div>

        <?php if (!empty($brand['logo_url'])): ?>
            <div class="mb-3">
                <label class="form-label">Logo hiện tại:</label><br>
                <img src="<?= $brand['logo_url'] ?>" alt="Logo hãng xe" style="max-width: 150px;">
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="/admindashbroad#brands" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>
