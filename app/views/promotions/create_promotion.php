<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thêm khuyến mãi</title>

    <!-- Bootstrap CSS + Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
</head>

<body class="bg-light py-5">
    <div class="container mt-4 w-75">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Thêm khuyến mãi mới</h5>
            </div>
            <div class="card-body">
                <form action" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên khuyến mãi</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-3">
                            <label for="discount_percent" class="form-label">Giảm (%)</label>
                            <input type="number" class="form-control" id="discount_percent" name="discount_percent" min="0" max="100">
                        </div>
                        <div class="col-md-3">
                            <label for="discount_amount" class="form-label">Giảm (VNĐ)</label>
                            <input type="number" class="form-control" id="discount_amount" name="discount_amount" min="0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label">Mã Code</label>
                            <input type="text" class="form-control" id="code" name="code" required>
                        </div>
                        <div class="col-md-6">
                            <label for="is_active" class="form-label">Trạng thái</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1">Kích hoạt</option>
                                <option value="0">Vô hiệu hóa</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="/admindashbroad#promotions" class="btn btn-secondary me-2">Hủy</a>
                        <button type="submit" class="btn btn-success">Thêm mới</button>
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