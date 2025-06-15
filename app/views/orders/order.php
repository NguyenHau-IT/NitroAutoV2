<?php require_once 'includes/header.php'; ?>

<div class="overlay">
    <div class="container mt-2 text-dark fs-5 mb-4 bg-light shadow-lg rounded-4 p-4">
        <h2 class="mb-4 text-center"><i class="fas fa-car me-2 text-primary"></i>Đặt Mua Xe</h2>

        <!-- Thông tin người mua -->
        <div class="mb-4">
            <h4 class="mb-3">Thông tin người mua</h4>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Tên:</strong> <?= htmlspecialchars($user['full_name']) ?></div>
                <div class="col-md-6"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone']) ?></div>
                <div class="col-md-6"><strong>Địa chỉ:</strong> <?= htmlspecialchars($user['address'] ?? '-') ?></div>
            </div>
        </div>

        <!-- Form đặt hàng -->
        <form action="/Order" method="POST" id="orderForm">
            <div class="mb-3">
                <label for="address">Địa chỉ nhận xe:</label>
                <input type="text" class="form-control fs-5" id="address" name="address"
                    placeholder="Nhập địa chỉ nhận xe" required
                    oninvalid="this.setCustomValidity('Vui lòng nhập địa chỉ nhận xe')"
                    oninput="this.setCustomValidity('')">
            </div>

            <div class="mb-3">
                <label for="phone">Số điện thoại người nhận:</label>
                <input type="text" class="form-control fs-5" id="phone" name="phone"
                    placeholder="Nhập số điện thoại người nhận" required
                    oninvalid="this.setCustomValidity('Vui lòng nhập số điện thoại người nhận')"
                    oninput="this.setCustomValidity('')">
            </div>

            <div class="mb-3">
                <label for="car_id">Chọn xe:</label>
                <select class="form-select fs-5" id="car_id" name="car_id" onchange="updatePrice()">
                    <option value="">-- Chọn xe --</option>
                    <?php foreach ($cars as $car): ?>
                        <option
                            value="<?= $car['id'] ?>"
                            data-price="<?= $car['price'] ?>"
                            data-name="<?= $car['name'] ?>"
                            <?= (isset($_POST['car_id']) && $_POST['car_id'] == $car['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($car['name']) ?> - <?= number_format($car['price']) ?> VNĐ
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity">Số lượng xe:</label>
                <input type="number" class="form-control fs-5" id="quantity" name="quantity"
                    min="0" value="0" onchange="updatePrice()">
            </div>

            <div class="mb-3">
                <label for="accessory_id">Chọn phụ kiện:</label>
                <select class="form-select fs-5" id="accessory_id" name="accessory_id" onchange="updatePrice()">
                    <option value="">-- Chọn phụ kiện --</option>
                    <?php foreach ($accessories as $accessory): ?>
                        <option value="<?= $accessory['id'] ?>"
                            data-accessosy-price="<?= $accessory['price'] ?>"
                            data-accessosy-name="<?= $accessory['name'] ?>">
                            <?= htmlspecialchars($accessory['name']) ?> - <?= number_format($accessory['price']) ?> VNĐ
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="accessory_quantity">Số lượng phụ kiện:</label>
                <input type="number" class="form-control fs-5" id="accessory_quantity"
                    name="accessory_quantity" min="0" value="0" onchange="updatePrice()">
            </div>

            <div class="mb-3">
                <label for="promotions">Mã khuyến mãi:</label>
                <input type="text" onchange="updatePrice()" class="form-control fs-5" id="promotions" name="promotions">
            </div>

            <!-- Giá trị tính toán -->
            <input type="hidden" id="total_price" name="total_price">
            <input type="hidden" id="car_name" name="car_name">

            <div class="mb-3 fs-5" id="total_price_display"></div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-shopping-cart me-1"></i> Đặt hàng
                </button>
                <a href="/home" class="btn btn-danger">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function updatePrice() {
        const carSelect = document.getElementById('car_id');
        const carQuantity = document.getElementById('quantity');
        const accessorySelect = document.getElementById('accessory_id');
        const accessoryQuantity = document.getElementById('accessory_quantity');
        const totalPriceDisplay = document.getElementById('total_price_display');
        const totalPriceInput = document.getElementById('total_price');
        const carNameInput = document.getElementById('car_name');
        const promoCodeInput = document.getElementById('promotions');
        const promoCode = promoCodeInput?.value.trim() || '';

        if (!carSelect || !carQuantity || !accessorySelect || !accessoryQuantity ||
            !totalPriceDisplay || !totalPriceInput || !carNameInput) return;

        let subtotal = 0;

        const selectedCar = carSelect.options[carSelect.selectedIndex];
        const carPrice = parseFloat(selectedCar.getAttribute('data-price') || 0);
        if (carSelect.value) {
            if (!carQuantity.value || carQuantity.value <= 0) carQuantity.value = 1;
            subtotal += carPrice * parseInt(carQuantity.value);
            carNameInput.value = selectedCar.getAttribute('data-name') || '';
        }

        if (accessorySelect.value) {
            const selectedAccessory = accessorySelect.options[accessorySelect.selectedIndex];
            const accessoryPrice = parseFloat(selectedAccessory?.getAttribute('data-accessosy-price') || 0);
            if (!accessoryQuantity.value || accessoryQuantity.value <= 0) accessoryQuantity.value = 1;
            subtotal += accessoryPrice * parseInt(accessoryQuantity.value);
        }

        if (promoCode !== '') {
            totalPriceDisplay.innerHTML = `<div class="text-muted">Đang kiểm tra khuyến mãi...</div>`;
            fetch('/applyPromotion', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        code: promoCode,
                        total: subtotal
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const discount = data.success ? data.discount : 0;
                    if (!data.success && data.message) alert(data.message);

                    const discounted = subtotal - discount;
                    const vat = discounted * 0.08;
                    const total = discounted + vat;
                    totalPriceInput.value = total;

                    totalPriceDisplay.innerHTML = `
                <div><strong>Tạm tính:</strong> ${subtotal.toLocaleString('vi-VN')} VNĐ</div>
                ${discount > 0 ? `<div><strong>Khuyến mãi:</strong> -${discount.toLocaleString('vi-VN')} VNĐ</div>` : ''}
                <div><strong>VAT (8%):</strong> ${vat.toLocaleString('vi-VN')} VNĐ</div>
                <div><strong>Tổng thanh toán:</strong> <span class="text-danger fw-bold">${total.toLocaleString('vi-VN')} VNĐ</span></div>
            `;
                });
        } else {
            const vat = subtotal * 0.08;
            const total = subtotal + vat;
            totalPriceInput.value = total;

            totalPriceDisplay.innerHTML = `
            <div><strong>Tạm tính:</strong> ${subtotal.toLocaleString('vi-VN')} VNĐ</div>
            <div><strong>VAT (8%):</strong> ${vat.toLocaleString('vi-VN')} VNĐ</div>
            <div><strong>Tổng thanh toán:</strong> <span class="text-danger fw-bold">${total.toLocaleString('vi-VN')} VNĐ</span></div>
        `;
        }
    }

    window.addEventListener('DOMContentLoaded', () => {
        updatePrice();
        document.getElementById('promotions').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                updatePrice();
            }
        })
    });
</script>

<?php require_once 'includes/footer.php'; ?>