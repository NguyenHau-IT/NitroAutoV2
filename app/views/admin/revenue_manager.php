<h2 class="mb-4"><i class="bi bi-bar-chart-fill"></i> Thống kê tổng quan</h2>

<!-- Bộ lọc thời gian -->
<form method="get" class="mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="yearFilter" class="form-label">Năm</label>
            <select class="form-select" id="yearFilter" name="year">
                <?php for ($y = date('Y'); $y >= 2025; $y--): ?>
                    <option value="<?= $y ?>" <?= isset($_GET['year']) && $_GET['year'] == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-filter-circle me-1"></i>Lọc dữ liệu</button>
        </div>
    </div>
</form>

<!-- Tổng quan -->
<div class="container mt-4">
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-bg-primary shadow-sm h-100" style="min-height: 140px;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title"><i class="bi bi-people-fill me-2"></i>Người dùng</h5>
                    <p class="fs-3 fw-bold mb-0"><?= $totalUsers ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-info shadow-sm h-100" style="min-height: 140px;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title"><i class="bi bi-car-front-fill me-2"></i>Tổng xe</h5>
                    <p class="fs-3 fw-bold mb-0"><?= $totalCars ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-bg-success shadow-sm h-100" style="min-height: 140px;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title"><i class="bi bi-bag-check-fill me-2"></i>Đơn hàng</h5>
                    <p class="fs-3 fw-bold mb-0"><?= $totalOrders ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-bg-warning shadow-sm h-100" style="min-height: 140px;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title text-dark"><i class="bi bi-cash-coin me-2"></i>Doanh thu</h5>
                    <p class="fs-5 fw-bold text-dark mb-0"><?= number_format($totalRevenue, 0) ?> đ</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dòng thứ 2 -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-start border-4 border-danger h-100" style="min-height: 140px;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h6 class="card-title"><i class="bi bi-x-octagon-fill me-2 text-danger"></i>Tỷ lệ huỷ đơn</h6>
                    <p class="fs-3 fw-bold text-danger mb-0"><?=  $cancelRate ?>%</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-start border-4 border-primary h-100" style="min-height: 140px;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h6 class="card-title"><i class="bi bi-star-fill me-2 text-primary"></i>Đánh giá trung bình</h6>
<?php
                    $color = $avgRating >= 4 ? 'text-success'
        : ($avgRating >= 3 ? 'text-warning' : 'text-danger');
?>
<p class="fs-3 fw-bold <?= $color ?> mb-0">
    <?= number_format($avgRating, 1) ?> <i class="bi bi-star-fill"></i>
</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Biểu đồ -->
<div class="row g-4 mt-3">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-graph-up me-2"></i>Doanh thu theo tháng</h5>
                <canvas id="revenueChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-speedometer2 me-2"></i>Top xe bán chạy</h5>
                <canvas id="topSellingChart" height="250"></canvas>
                <ul class="mt-3">
                    <?php foreach ($topSellingCars as $car): ?>
                        <li><i class="bi bi-dot"></i> <?= $car['name'] ?> (<?= $car['sold'] ?> đơn)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-tools me-2"></i>Top phụ kiện bán chạy</h5>
                <canvas id="topAccessoriesChart" height="250"></canvas>
                <ul class="mt-3">
                    <?php foreach ($topSellingAccessories as $item): ?>
                        <li><i class="bi bi-dot"></i> <?= $item['name'] ?> (<?= $item['sold'] ?> đơn)</li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-pie-chart-fill me-2"></i>Tỷ lệ trạng thái đơn hàng</h5>
                <canvas id="orderStatusChart" height="250"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($revenueByMonth, 'month_name')) ?>,
            datasets: [{
                label: 'Doanh thu theo tháng',
                data: <?= json_encode(array_column($revenueByMonth, 'revenue')) ?>,
                tension: 0.3,
                fill: true,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Doanh thu theo từng tháng',
                    font: {
                        size: 16
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed.y;
                            return 'Doanh thu: ' + value.toLocaleString('vi-VN') + '₫';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return (value / 1_000_000) + ' triệu';
                        }
                    }
                }
            }
        }
    });

    const topSellingCtx = document.getElementById('topSellingChart').getContext('2d');
    const topSellingChart = new Chart(topSellingCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($topSellingCars, 'name')) ?>,
            datasets: [{
                label: 'Số đơn đặt',
                data: <?= json_encode(array_column($topSellingCars, 'sold')) ?>,
                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Top 5 xe bán chạy nhất',
                    font: {
                        size: 16
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });

    const accessoriesCtx = document.getElementById('topAccessoriesChart').getContext('2d');
    new Chart(accessoriesCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($topSellingAccessories, 'name')) ?>,
            datasets: [{
                label: 'Số đơn',
                data: <?= json_encode(array_column($topSellingAccessories, 'sold')) ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Top 5 phụ kiện bán chạy',
                    font: {
                        size: 16
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                }
            }
        }
    });

    const statusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: ['Đã Hoànthành','Đã xác nhận', 'Chờ xử lý', 'Đã hủy'],
            datasets: [{
                data: [
                     <?= $orderStatusStats['completed'] ?>,
                    <?= $orderStatusStats['confirmed'] ?>,
                    <?= $orderStatusStats['pending'] ?>,
                    <?= $orderStatusStats['cancelled'] ?>
                ],
backgroundColor: [
    'rgba(0, 123, 255, 0.7)',   // Hoàn thành (mới thêm, đặt trên cùng)
    'rgba(40, 167, 69, 0.7)',   // Thành công
    'rgba(255, 193, 7, 0.7)',   // Đang xử lý
    'rgba(220, 53, 69, 0.7)'    // Thất bại
],
borderColor: [
    'rgba(0, 123, 255, 1)',     // Hoàn thành
    'rgba(40, 167, 69, 1)',     // Thành công
    'rgba(255, 193, 7, 1)',     // Đang xử lý
    'rgba(220, 53, 69, 1)'      // Thất bại
],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Phân bổ trạng thái đơn hàng',
                    font: {
                        size: 16
                    }
                }
            }
        }
    });
</script>