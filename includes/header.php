<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['user'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
$current_uri = $_SERVER['REQUEST_URI'];
$uri_segments = explode('/', trim($current_uri, '/'));
$current_page = $uri_segments[0] ?? 'home'; // lấy segment đầu tiên
$count_cart = Cart::getCartCount($user_id ?? null);

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="NitroAuto - Cửa hàng xe, phụ kiện và dịch vụ xe hơi hàng đầu. Khám phá các sản phẩm chất lượng và dịch vụ chuyên nghiệp.">
    <title>NITRO AUTO</title>
    <link rel="icon" href="/uploads/favicon.ico" type="image/ico">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap&subset=vietnamese" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <header class="text-center bg-nitro-gradient">
    <nav class="navbar navbar-expand-lg navbar-light py-3">
        <div class="container">
            <a class="navbar-brand" href="/home">
                <img src="/uploads/logo-white.png" alt="logo" width="120" height="auto">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav d-flex gap-3">
                    <li class="nav-item <?= ($current_page == 'home' || $current_page == '') ? 'active' : '' ?>">
                        <a class="nav-link" href="/home"><i class="icon fas fa-home"></i><span> NitroAuto</span></a>
                    </li>
                    <li class="nav-item dropdown <?= ($current_page == 'product_list' || $current_page == 'accessories' || $current_page == 'services') ? 'active' : '' ?>">
                        <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon fas fa-list"></i><span> Danh mục sản phẩm</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="productDropdown">
                            <li><a class="dropdown-item" href="/accessories">Phụ Kiện cho xe</a></li>
                            <li><a class="dropdown-item" href="/services">Dịch vụ</a></li>
                        </ul>
                    </li>
                    <li class="nav-item <?= ($current_page == 'OrderForm') ? 'active' : '' ?>">
                        <a class="nav-link" href="/OrderForm"><i class="icon fas fa-car"></i><span> Mua hàng</span></a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'favorites') ? 'active' : '' ?>">
                        <a class="nav-link" href="/favorites"><i class="icon fas fa-heart"></i><span> Yêu thích</span></a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'appointments') ? 'active' : '' ?>">
                        <a class="nav-link" href="/appointments"><i class="icon fas fa-calendar-alt"></i><span> Lịch hẹn</span></a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'user_orders') ? 'active' : '' ?>">
                        <a class="nav-link" href="/user_orders"><i class="icon fas fa-history"></i><span> Lịch sử</span></a>
                    </li>
                    <li class="nav-item <?= ($current_page == 'test_drive') ? 'active' : '' ?>">
                        <a class="nav-link" href="/test_drive"><i class="icon fas fa-car-side"></i><span> Lái thử</span></a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto d-flex align-items-center gap-3">
                    <?php if ($user && $user['role'] === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/admindashbroad"><i class="fas fa-user-shield"></i> Admin</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($user): ?>
                        <li class="nav-item <?= ($current_page == 'cart') ? 'active' : '' ?>">
                            <a class="nav-link " href="/cart">
                                <div class="position-relative">
                                    <i class="icon fas fa-shopping-cart fa-lg"></i>
                                    <?php if ($count_cart > 0): ?>
                                        <span class="cart-badge position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                                            <?= $count_cart ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <span>Giỏ hàng</span>
                            </a>
                        </li>
                        <li class="nav-item <?= ($current_page == 'profile' || $current_page == 'edit_profile') ? 'active' : '' ?>">
                            <a class="nav-link" href="/profile">
                                <i class="icon fas fa-user"></i> <?= htmlspecialchars($user['full_name']) ?>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item <?= ($current_page == 'auth') ? 'active' : '' ?>">
                            <a class="nav-link" href="/auth">
                                <i class="icon fas fa-user-circle"></i> Đăng nhập / Đăng ký
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <button id="toggle-theme" class="btn btn-outline-dark" title="Đổi chế độ sáng/tối">
                            <i class="icon bi bi-moon-fill"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>