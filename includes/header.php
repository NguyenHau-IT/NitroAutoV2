<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$current_uri = $_SERVER['REQUEST_URI'];
$uri_segments = explode('/', trim($current_uri, '/'));
$current_page = $uri_segments[0] ?? 'home';
$count_cart = Cart::getCartCount($user_id ?? null);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NitroAuto - Cửa hàng xe, phụ kiện và dịch vụ xe hơi hàng đầu.">
    <title>NITRO AUTO</title>
    <link rel="icon" href="/uploads/favicon.ico" type="image/ico">

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

</head>

<body>
    <header class="text-center bg-nitro-gradient z-3 position-relative">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="/">
                    <img src="/uploads/logo-white.png" alt="logo" width="120">
                </a>

                <!-- Toggle Button for Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Main Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto d-flex gap-3 align-items-center">
                        <!-- Logo bên trái -->
                        <li class="nav-item <?= ($current_page == 'home') ? 'active' : '' ?>">
                            <a class="nav-link" href="/home"><i class="fas fa-car me-2"></i>Danh sách xe</a>
                        </li>

                        <li class="nav-item dropdown <?= in_array($current_page, ['accessories', 'services', 'favorites', 'appointments', 'user_orders', 'test_drive']) ? 'active' : '' ?>">
                            <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-list"></i><span> Danh mục</span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="productDropdown">
                                <li><a class="dropdown-item" href="/accessories"><i class="fas fa-tools me-2"></i>Phụ Kiện cho xe</a></li>
                                <li><a class="dropdown-item" href="/services"><i class="fas fa-toolbox me-2"></i>Dịch vụ</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="/favorites"><i class="fas fa-heart me-2"></i>Yêu thích</a></li>
                                <li><a class="dropdown-item" href="/appointments"><i class="fas fa-calendar-alt me-2"></i>Lịch hẹn</a></li>
                                <li><a class="dropdown-item" href="/user_orders"><i class="fas fa-history me-2"></i>Lịch sử</a></li>
                                <li><a class="dropdown-item" href="/test_drive"><i class="fas fa-car-side me-2"></i>Lái thử</a></li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Search form giữa navbar -->
                    <form action="" method="POST" id="search-form" class="d-flex flex-grow-1 mx-3" style="min-width: 250px; max-width: 600px;">
                        <div class="input-group w-100 border border-secondary rounded-pill overflow-hidden">
                            <input type="text" name="search" class="form-control border-0"
                                placeholder="Bạn đang tìm kiếm xe gì..."
                                value="<?= @htmlspecialchars($_POST['search'] ?? '') ?>">
                            <button class="btn btn-secondary border-0" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Right-side menu -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center gap-3">
                        <?php if ($user && $user['role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/admindashbroad"><i class="fas fa-user-shield"></i> Admin</a>
                            </li>
                        <?php endif; ?>

                        <?php if ($user): ?>
                            <?php if ($current_page != ''): ?>
                                <li class="nav-item <?= ($current_page == 'cart') ? 'active' : '' ?>">
                                    <a class="nav-link" href="/cart">
                                        <div class="position-relative">
                                            <i class="fas fa-shopping-cart fa-lg"></i>
                                            <?php if ($count_cart > 0): ?>
                                                <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                                                    <?= $count_cart ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <span>Giỏ hàng</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item <?= in_array($current_page, ['profile', 'edit_profile']) ? 'active' : '' ?>">
                                <a class="nav-link" href="/profile">
                                    <i class="fas fa-user"></i> <?= htmlspecialchars($user['full_name']) ?>
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item <?= ($current_page == 'auth') ? 'active' : '' ?>">
                                <a class="nav-link" href="/auth">
                                    <i class="fas fa-user-circle"></i> Đăng nhập / Đăng ký
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item">
                            <button id="toggle-theme" class="btn btn-outline-dark" title="Đổi chế độ sáng/tối">
                                <i class="bi bi-moon-fill"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>