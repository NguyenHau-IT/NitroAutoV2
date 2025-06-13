<div class="bg-light rounded-4 shadow border my-4 p-3">
    <!-- Hàng 1: bộ lọc, nút "Mới", tìm kiếm -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <!-- Dropdown bộ lọc -->
        <div class="dropdown">
            <button class="btn btn-outline-info" type="button" id="filter-toggle-btn">
                <i class="fas fa-filter"></i> Bộ lọc
            </button>
            <div class="dropdown-menu p-3" aria-labelledby="filter-toggle-btn" style="min-width: 600px;" id="filter-dropdown">
                <form action="" method="POST" id="filter-form">
                    <div class="d-flex flex-wrap">
                        <!-- Thương hiệu -->
                        <div class="form-group flex-fill pr-2">
                            <label>Thương hiệu</label>
                            <select class="form-control" name="brand">
                                <option value="">Tất cả</option>
                                <?php if (isset($brands) && is_array($brands)): foreach ($brands as $brandItem): ?>
                                        <option value="<?= htmlspecialchars($brandItem['id']) ?>"
                                            <?= isset($_POST['brand']) && $_POST['brand'] == $brandItem['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($brandItem['name']) ?>
                                        </option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                        </div>

                        <!-- Sắp xếp theo giá -->
                        <div class="form-group flex-fill pr-2">
                            <label>Sắp xếp theo giá</label>
                            <select class="form-control" name="sortCar">
                                <option value="">Chọn</option>
                                <option value="asc" <?= isset($_POST['sortCar']) && $_POST['sortCar'] == 'asc' ? 'selected' : '' ?>>Giá thấp đến cao</option>
                                <option value="desc" <?= isset($_POST['sortCar']) && $_POST['sortCar'] == 'desc' ? 'selected' : '' ?>>Giá cao đến thấp</option>
                            </select>
                        </div>

                        <!-- Mức giá -->
                        <div class="form-group flex-fill pr-2">
                            <label>Mức giá</label>
                            <select class="form-control" name="price_range">
                                <option value="">Chọn mức giá...</option>
                                <option value="0-500000000" <?= @$_POST['price_range'] == '0-500000000' ? 'selected' : '' ?>>Dưới 500 triệu</option>
                                <option value="500000000-1000000000" <?= @$_POST['price_range'] == '500000000-1000000000' ? 'selected' : '' ?>>Từ 500 triệu đến 1 tỷ</option>
                                <option value="1000000000-2000000000" <?= @$_POST['price_range'] == '1000000000-2000000000' ? 'selected' : '' ?>>Từ 1 tỷ đến 2 tỷ</option>
                                <option value="2000000000-3000000000" <?= @$_POST['price_range'] == '2000000000-3000000000' ? 'selected' : '' ?>>Từ 2 tỷ đến 3 tỷ</option>
                                <option value="3000000000+" <?= @$_POST['price_range'] == '3000000000+' ? 'selected' : '' ?>>Trên 3 tỷ</option>
                            </select>
                        </div>

                        <!-- Nhiên liệu -->
                        <div class="form-group flex-fill pr-2">
                            <label>Loại nhiên liệu</label>
                            <select class="form-control" name="fuel_type">
                                <option value="">Chọn loại nhiên liệu...</option>
                                <option value="Gasoline" <?= @$_POST['fuel_type'] == 'Gasoline' ? 'selected' : '' ?>>Xăng</option>
                                <option value="Diesel" <?= @$_POST['fuel_type'] == 'Diesel' ? 'selected' : '' ?>>Dầu</option>
                                <option value="Electric" <?= @$_POST['fuel_type'] == 'Electric' ? 'selected' : '' ?>>Điện</option>
                                <option value="Hybrid" <?= @$_POST['fuel_type'] == 'Hybrid' ? 'selected' : '' ?>>Hybrid</option>
                            </select>
                        </div>

                        <!-- Loại xe -->
                        <div class="form-group flex-fill pr-2">
                            <label>Loại xe</label>
                            <select class="form-control" name="car_type">
                                <option value="">Chọn loại xe...</option>
                                <?php if (!empty($categories)): foreach ($categories as $category): ?>
                                        <option value="<?= htmlspecialchars($category['id']) ?>" <?= @$_POST['car_type'] == $category['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                <?php endforeach;
                                endif; ?>
                            </select>
                        </div>

                        <!-- Năm sản xuất -->
                        <div class="form-group flex-fill">
                            <label>Năm sản xuất</label>
                            <select class="form-control" name="year_manufacture" id="year-manufacture-select">
                                <option value="">Chọn năm sản xuất...</option>
                                <?php for ($i = date('Y'); $i >= 1800; $i--): ?>
                                    <option value="<?= $i ?>" <?= @$_POST['year_manufacture'] == $i ? 'selected' : '' ?>>
                                        <?= $i ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Nút áp dụng và reset -->
                    <div class="d-flex mt-3 justify-content-center">
                        <button type="submit" class="btn btn-primary me-2"><i class="fas fa-check-circle"></i> Áp dụng</button>
                        <button type="reset" class="btn btn-secondary" id="reset-filters"><i class="fas fa-redo"></i> Đặt lại</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Nút lọc theo năm hiện tại -->
        <button type="button" class="btn btn-dark" id="filter-from-current-year">
            <i class="fas fa-calendar-alt"></i> Mới
        </button>

        <!-- Ô tìm kiếm -->
        <form action="" method="POST" class="flex-grow-1" id="search-form">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Tìm kiếm xe..." value="<?= @htmlspecialchars($_POST['search'] ?? '') ?>">
                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>

    <!-- Hàng 2: danh sách hãng -->
    <div class="d-flex gap-2 mt-3 overflow-auto flex-nowrap">
        <?php 
// Giới hạn chỉ lấy 5 hãng đầu tiên
$brandsToDisplay = array_slice($brands, 0, 5);

foreach ($brandsToDisplay as $brand): ?>
    <?php if (isset($brand['id'], $brand['name'])): ?>
        <a href="/cars_brand/<?= urlencode($brand['id']) ?>?brand=<?= urlencode($brand['name']) ?>"
            class="btn btn-outline-primary <?= (isset($_GET['brand']) && $_GET['brand'] == $brand['name']) ? 'active' : '' ?>">
            <i class="bi bi-ev-front me-1"></i> <?= htmlspecialchars($brand['name']) ?>
        </a>
    <?php endif; ?>
<?php endforeach; ?>
    </div>
</div>

<script>
    let filterToggleBtn = document.getElementById("filter-toggle-btn");
    let filterDropdown = document.getElementById("filter-dropdown");

    if (filterToggleBtn && filterDropdown) {
        filterToggleBtn.addEventListener("click", function(e) {
            e.stopPropagation();
            filterDropdown.classList.toggle("show");
        });

        document.addEventListener("click", function(e) {
            if (!filterToggleBtn.contains(e.target) && !filterDropdown.contains(e.target)) {
                filterDropdown.classList.remove("show");
            }
        });

        const resetBtn = document.getElementById("reset-filters");
        const filterForm = document.getElementById("filter-form");
        if (resetBtn && filterForm) {
            resetBtn.addEventListener("click", function() {
                filterForm.reset();
                filterDropdown.classList.remove("show");
            });
        }
    }

    document.addEventListener("DOMContentLoaded", function() {

        const filterForm = document.getElementById("filter-form");
        const searchForm = document.getElementById("search-form");
        const filterDropdown = document.getElementById("filter-dropdown");
        const filterFromCurrentYearBtn = document.getElementById("filter-from-current-year");

        if (filterForm) {
            filterForm.addEventListener("submit", function(event) {
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

            filterForm.addEventListener("reset", function() {
                setTimeout(() => {
                    filterForm.dispatchEvent(new Event("submit", {
                        bubbles: true,
                        cancelable: true
                    }));
                }, 0);
            });
        }

        if (searchForm) {
            searchForm.addEventListener("submit", function(event) {
                event.preventDefault();
                const formData = new FormData(searchForm);
                fetch("/filter-cars", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        const carList = document.getElementById("car-list-container");
                        if (carList) carList.innerHTML = data;
                    })
                    .catch(error => console.error("Lỗi khi tải dữ liệu:", error));
            });
        }

        if (filterFromCurrentYearBtn) {
            filterFromCurrentYearBtn.addEventListener("click", function() {
                const yearSelect = document.getElementById("year-manufacture-select");
                if (yearSelect) yearSelect.value = new Date().getFullYear();
                if (filterForm) {
                    filterForm.dispatchEvent(new Event("submit", {
                        bubbles: true,
                        cancelable: true
                    }));
                }
            });
        }
    });
</script>