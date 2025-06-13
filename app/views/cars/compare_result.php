<?php
$min_price = min(array_column($cars, 'price'));
$max_hp = max(array_column($cars, 'horsepower'));
$min_mileage = min(array_column($cars, 'mileage'));
$max_year = max(array_column($cars, 'year'));
$colWidth = floor(100 / (count($cars) + 1)); // +1 cho cột tiêu đề
?>

<table class="table table-bordered text-center table-compare align-middle">
    <thead class="table-dark">
        <tr>
            <th style="width: <?= $colWidth ?>%;">Thông số</th>
            <?php foreach ($cars as $car): ?>
                <th style="width: <?= $colWidth ?>%;">
                    <a href="/car_detail/<?= htmlspecialchars($car['id']) ?>" class="text-light text-decoration-none">
                        <?= htmlspecialchars($car['name']) ?>
                    </a>
                </th>
            <?php endforeach; ?>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>Hình ảnh</td>
            <?php foreach ($cars as $car): ?>
                <td>
                    <img src="<?= htmlspecialchars($car['normal_image_url'] ?? '/uploads/cars/default.jpg') ?>"
                        class="img-fluid rounded"
                        style="max-width: 200px; height: auto;" loading="lazy">
                </td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Hãng</td>
            <?php foreach ($cars as $car): ?>
                <td><?= htmlspecialchars($car['brand_name'] ?? 'Chưa có') ?></td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Loại xe</td>
            <?php foreach ($cars as $car): ?>
                <td><?= htmlspecialchars($car['category_name'] ?? 'Chưa có') ?></td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Giá</td>
            <?php foreach ($cars as $car): ?>
                <td class="<?= $car['price'] == $min_price ? 'fw-bold text-success' : '' ?>">
                    <?= number_format($car['price'], 0, ',', '.') ?> đ
                </td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Năm sản xuất</td>
            <?php foreach ($cars as $car): ?>
                <td class="<?= $car['year'] == $max_year ? 'fw-bold text-primary' : '' ?>">
                    <?= $car['year'] ?>
                </td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Số km đã đi</td>
            <?php foreach ($cars as $car): ?>
                <td class="<?= $car['mileage'] == $min_mileage ? 'fw-bold text-success' : '' ?>">
                    <?= number_format($car['mileage']) ?> km
                </td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Mã lực</td>
            <?php foreach ($cars as $car): ?>
                <td class="<?= $car['horsepower'] == $max_hp ? 'fw-bold text-danger' : '' ?>">
                    <?= $car['horsepower'] ?> HP
                </td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Nhiên liệu</td>
            <?php foreach ($cars as $car): ?>
                <td><?= htmlspecialchars($car['fuel_type']) ?></td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Hộp số</td>
            <?php foreach ($cars as $car): ?>
                <td><?= htmlspecialchars($car['transmission']) ?></td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Màu sắc</td>
            <?php foreach ($cars as $car): ?>
                <td><?= htmlspecialchars($car['color']) ?></td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Tình trạng kho</td>
            <?php foreach ($cars as $car): ?>
                <td class="<?= $car['stock'] > 0 ? 'text-success fw-semibold' : 'text-danger fw-semibold' ?>">
                    <?= $car['stock'] > 0 ? 'Còn hàng' : 'Hết hàng' ?>
                </td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Mô tả</td>
            <?php foreach ($cars as $car): ?>
                <td class="text-start">
                    <?= mb_strimwidth(strip_tags($car['description']), 0, 100, "...") ?>
                </td>
            <?php endforeach; ?>
        </tr>

        <!-- Hàng chứa nút Đặt mua -->
        <tr>
            <td class="fw-bold"></td>
            <?php foreach ($cars as $car): ?>
                <?php if ($car['stock'] > 0): ?>
                <td>
                    <form action="/OrderForm" method="POST">
                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-cart-fill me-1"></i> Đặt mua
                        </button>
                    </form>
                </td>
                <?php else: ?>
                <td>
                    <span class="text-danger alert">Xe hiện đã hết hàng</span>
                </td>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </tbody>
</table>