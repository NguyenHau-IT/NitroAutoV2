<div class="bg-light rounded-4 shadow border my-4 p-3 position-relative z-3">
    <form action="" method="POST" id="filter-form">
        <div class="d-grid gap-2 mb-3">
            <!-- Nút Mới -->
            <button type="button" class="btn btn-dark w-100" id="filter-from-current-year">
                <i class="fas fa-calendar-alt me-1"></i> Mới
            </button>
        </div>

        <!-- Thương hiệu -->
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-car-side me-1 text-secondary"></i> Thương hiệu</label>
            <select class="form-select" name="brand">
                <option value="">Tất cả</option>
                <?php foreach ($brands ?? [] as $brandItem): ?>
                    <option value="<?= htmlspecialchars($brandItem['id']) ?>" <?= ($_POST['brand'] ?? '') == $brandItem['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($brandItem['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Sắp xếp giá -->
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-sort-amount-up-alt me-1 text-secondary"></i> Sắp xếp theo giá</label>
            <select class="form-select" name="sortCar">
                <option value="">Chọn</option>
                <option value="asc" <?= ($_POST['sortCar'] ?? '') == 'asc' ? 'selected' : '' ?>>Giá thấp → cao</option>
                <option value="desc" <?= ($_POST['sortCar'] ?? '') == 'desc' ? 'selected' : '' ?>>Giá cao → thấp</option>
            </select>
        </div>

        <!-- Mức giá -->
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-dollar-sign me-1 text-secondary"></i> Mức giá</label>
            <select class="form-select" name="price_range">
                <option value="">Tất cả</option>
                <option value="0-500000000" <?= ($_POST['price_range'] ?? '') == '0-500000000' ? 'selected' : '' ?>>Dưới 500 triệu</option>
                <option value="500000000-1000000000" <?= ($_POST['price_range'] ?? '') == '500000000-1000000000' ? 'selected' : '' ?>>500 triệu - 1 tỷ</option>
                <option value="1000000000-2000000000" <?= ($_POST['price_range'] ?? '') == '1000000000-2000000000' ? 'selected' : '' ?>>1 tỷ - 2 tỷ</option>
                <option value="2000000000-3000000000" <?= ($_POST['price_range'] ?? '') == '2000000000-3000000000' ? 'selected' : '' ?>>2 tỷ - 3 tỷ</option>
                <option value="3000000000+" <?= ($_POST['price_range'] ?? '') == '3000000000+' ? 'selected' : '' ?>>Trên 3 tỷ</option>
            </select>
        </div>

        <!-- Nhiên liệu -->
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-gas-pump me-1 text-secondary"></i> Loại nhiên liệu</label>
            <select class="form-select" name="fuel_type">
                <option value="">Tất cả</option>
                <option value="Gasoline" <?= ($_POST['fuel_type'] ?? '') == 'Gasoline' ? 'selected' : '' ?>>Xăng</option>
                <option value="Diesel" <?= ($_POST['fuel_type'] ?? '') == 'Diesel' ? 'selected' : '' ?>>Dầu</option>
                <option value="Electric" <?= ($_POST['fuel_type'] ?? '') == 'Electric' ? 'selected' : '' ?>>Điện</option>
                <option value="Hybrid" <?= ($_POST['fuel_type'] ?? '') == 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
            </select>
        </div>

        <!-- Loại xe -->
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-car me-1 text-secondary"></i> Loại xe</label>
            <select class="form-select" name="car_type">
                <option value="">Tất cả</option>
                <?php foreach ($categories ?? [] as $category): ?>
                    <option value="<?= htmlspecialchars($category['id']) ?>" <?= ($_POST['car_type'] ?? '') == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Năm sản xuất -->
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-calendar me-1 text-secondary"></i> Năm sản xuất</label>
            <select class="form-select" name="year_manufacture" id="year-manufacture-select">
                <option value="">Tất cả</option>
                <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                    <option value="<?= $i ?>" <?= ($_POST['year_manufacture'] ?? '') == $i ? 'selected' : '' ?>>
                        <?= $i ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <!-- Nút -->
        <div class="d-flex justify-content-between gap-2 mt-4">
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-check-circle me-1"></i> Áp dụng
            </button>
            <button type="reset" class="btn btn-outline-secondary w-100" id="reset-filters">
                <i class="fas fa-redo me-1"></i> Đặt lại
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterForm = document.getElementById("filter-form");
        const resetBtn = document.getElementById("reset-filters");
        const yearSelect = document.getElementById("year-manufacture-select");
        const filterFromCurrentYearBtn = document.getElementById("filter-from-current-year");

        // Gửi form lọc bằng AJAX
        filterForm?.addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(filterForm);

            fetch("/filter-cars", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    const carList = document.getElementById("car-list-container");
                    if (carList) carList.innerHTML = data;
                    if (filterDropdown) filterDropdown.classList.remove("show");
                })
                .catch(error => console.error("Lỗi khi tải dữ liệu:", error));
        });

        // Reset filter bằng nút → gọi API /reset-filter
        resetBtn?.addEventListener("click", function(e) {
            e.preventDefault();

            const carList = document.getElementById("car-list-container");
            if (carList) carList.innerHTML = "<div class='text-center py-5'>Đang tải...</div>";

            fetch("/reset-filter", {
                    method: "POST"
                })
                .then(response => response.text())
                .then(data => {
                    const carList = document.getElementById("car-list-container");
                    if (carList) carList.innerHTML = data;
                    if (filterDropdown) filterDropdown.classList.remove("show");
                })
                .catch(error => console.error("Lỗi khi tải dữ liệu:", error));
        });

        // Nút chọn "Mới" (năm hiện tại)
        filterFromCurrentYearBtn?.addEventListener("click", () => {
            const currentYear = new Date().getFullYear();
            if (yearSelect) {
                yearSelect.value = currentYear.toString();
                filterForm.dispatchEvent(new Event("submit", {
                    bubbles: true,
                    cancelable: true
                }));
            }
        });
    });
</script>