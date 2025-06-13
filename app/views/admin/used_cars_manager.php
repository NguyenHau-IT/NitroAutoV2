<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-primary m-0"><i class="bi bi-car-front-fill"></i> Quản lý Xe Đã Qua Sử Dụng</h3>
</div>

<!-- Table -->
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Người đăng</th>
                <th>Ảnh</th>
                <th>Tên xe</th>
                <th>Hãng</th>
                <th>Danh mục</th>
                <th>Năm</th>
                <th>Km đã đi</th>
                <th>Màu</th>
                <th>Hộp số</th>
                <th>Giá</th>
                <th>Nhiên liệu</th>
                <th>Ngày tạo</th>
                <th>Mô tả</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usedCars as $car): ?>
                <tr>
                    <td><?= htmlspecialchars($car['user_name']) ?></td>
                    <td>
                        <img src="<?= !empty($car['image_url']) ? $car['image_url'] : '/assets/images/no-image.png' ?>"
                            alt="Ảnh xe" width="100" height="60" class="img-thumbnail">
                    </td>
                    <td><?= htmlspecialchars($car['name']) ?></td>
                    <td><?= htmlspecialchars($car['brand']) ?></td>
                    <td><?= htmlspecialchars($car['category_name']) ?></td>
                    <td><?= $car['year'] ?></td>
                    <td><?= $car['mileage'] ?> km</td>
                    <td><?= htmlspecialchars($car['color']) ?></td>
                    <td><?= htmlspecialchars($car['transmission']) ?></td>
                    <td class="text-end"><?= number_format($car['price'], 0, ',', '.') ?> đ</td>
                    <td><?= htmlspecialchars($car['fuel_type']) ?></td>
                    <td><?= date('d/m/Y', strtotime($car['created_at'])) ?></td>
                    <td class="text-start align-top">
                        <div class="overflow-auto bg-light p-2 rounded text-start" style="max-height: 100px; min-width: 200px; max-width: 300px;">
                            <?= nl2br(htmlspecialchars($car['description'])) ?>
                        </div>
                    </td>
                    <td style="min-width: 160px;">
                        <?php
                        $status = $car['status'];
                        $options = [
                            'Approved' => 'Đã duyệt',
                            'Pending' => 'Đang xử lý',
                            'Rejected' => 'Đã từ chối',
                            'Sold' => 'Đã bán'
                        ];
                        ?>
                        <select name="status" class="form-select form-select-lg used_car" data-id="<?= $car['id'] ?>">
                            <?php foreach ($options as $value => $label): ?>
                                <option value="<?= $value ?>" <?= $status === $value ? 'selected' : '' ?>>
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-1">
                            <a href="/admin/used_car/edit/<?= $car['id'] ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a href="/admin/used_car/delete/<?= $car['id'] ?>"
                                onclick="return confirm('Xác nhận xoá bài đăng này?');"
                                class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Xoá
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Empty table notice -->
    <?php if (empty($usedCars)): ?>
        <div class="alert alert-warning text-center mt-4">
            Không có xe nào được tìm thấy.
        </div>
    <?php endif; ?>
</div>
<script>
    document.querySelectorAll('.used_car').forEach(function(select) {
        select.addEventListener('change', function() {
            const carId = this.getAttribute('data-id');
            const newStatus = this.value;

            fetch('/update_usedcar_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `used_car_id=${carId}&status=${newStatus}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Trạng thái đã được cập nhật thành công');
                    } else {
                        alert('Cập nhật trạng thái thất bại');
                        // Nếu thất bại, reload lại trang để đảm bảo trạng thái chính xác
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert('Đã xảy ra lỗi. Vui lòng thử lại.');
                    location.reload();
                });
        });
    });
</script>