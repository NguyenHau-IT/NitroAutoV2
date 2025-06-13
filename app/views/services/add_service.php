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

    <div class="container my-5">
        <h2 class="text-primary mb-4">📝 Thêm Dịch Vụ Mới</h2>

        <form action="" method="post">
            <div class="mb-3">
                <label for="service_name" class="form-label">Tên dịch vụ</label>
                <input type="text" class="form-control" id="service_name" name="service_name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Giá (VNĐ)</label>
                <input type="number" class="form-control" id="price" name="price" min="0" required>
            </div>

            <div class="mb-3">
                <label for="estimated_time" class="form-label">Thời gian dự kiến (phút)</label>
                <input type="number" class="form-control" id="estimated_time" name="estimated_time" min="0" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Trạng thái</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="1" selected>Hoạt động</option>
                    <option value="0">Không hoạt động</option>
                </select>
            </div>

            <div class="text-end">
                <a href="/admindashbroad#car_services" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Lưu dịch vụ
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>