<?php
require 'config/database.php';
if (!isset($_SESSION['user'])) {
    header("Location: /home");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
        }

        #layout {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

#sidebar {
    width: 220px;
    min-width: 220px;
    max-width: 220px;
    flex: 0 0 220px; /* Ngăn không cho sidebar co giãn */
    transition: all 0.3s ease;
    z-index: 100;
}

        #sidebar.collapsed {
            position: absolute;
            left: -220px;
        }

        #main-content {
            flex-grow: 1;
            transition: all 0.3s ease;
        }

        #main-content.expanded {
            width: 100% !important;
            max-width: 100%;
        }

        nav .nav-link {
            transition: background 0.3s ease, color 0.3s ease;
            padding: 10px 12px;
            border-radius: 5px;
        }

        nav .nav-link.active {
            background-color: #0d6efd !important;
            color: white !important;
            font-weight: bold;
            border-left: 4px solid #ffc107;
            padding-left: 16px;
        }

        nav .nav-link.active i {
            color: white !important;
        }

        nav .nav-link:hover {
            background-color: #1a73e8;
            color: white;
        }
    </style>
</head>

<body>
    <header class="bg-dark text-white py-3 px-4 shadow-sm w-100">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button id="sidebarToggle" class="btn btn-outline-light btn-sm d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="h5 mb-0">Admin Dashboard</h1>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span>Xin chào, <strong><?= htmlspecialchars($_SESSION['user']['full_name']) ?></strong></span>
                <a class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" href="/home">
                    <i class="bi bi-house-door-fill"></i> Trang chủ
                </a>
                <a class="btn btn-outline-danger btn-sm d-flex align-items-center gap-1" href="/logout">
                    <i class="bi bi-box-arrow-right"></i> Đăng xuất
                </a>
            </div>
        </div>
    </header>

    <div id="layout">
        <nav id="sidebar" class="bg-dark text-white p-3 vh-100 sticky-top">
            <ul class="nav flex-column">
                <?php
                $tabs = [
                    'dashboard' => ['label' => 'Trang chính', 'icon' => 'bi-house-door-fill'],
                    'cars' => ['label' => 'Quản lý xe', 'icon' => 'bi-car-front'],
                    'used_cars' => ['label' => 'Bài đăng xe củ', 'icon' => 'bi-car-front-fill'],
                    'brands' => ['label' => 'Hãng xe', 'icon' => 'bi-buildings'],
                    'categories' => ['label' => 'Danh mục', 'icon' => 'bi-tags'],
                    'accessories' => ['label' => 'Phụ kiện', 'icon' => 'bi-tools'],
                    'users' => ['label' => 'Người dùng', 'icon' => 'bi-people'],
                    'orders' => ['label' => 'Đơn hàng', 'icon' => 'bi-bag-check'],
                    'test_drives' => ['label' => 'Lái thử', 'icon' => 'bi-speedometer2'],
                    'service_orders' => ['label' => 'Lịch hẹn dịch vụ', 'icon' => 'bi-calendar-check'],
                    'car_services' => ['label' => 'Dịch vụ xe', 'icon' => 'bi-tools'],
                    'promotions' => ['label' => 'Khuyến mãi', 'icon' => 'bi-stars'],
                    'banners' => ['label' => 'Banner', 'icon' => 'bi-image'],
                    'reviews' => ['label' => 'Đánh giá', 'icon' => 'bi-chat-square-text'],
                ];

                foreach ($tabs as $id => $tab): ?>
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center gap-2" href="#<?= $id ?>">
                            <i class="bi <?= $tab['icon'] ?>"></i> <?= $tab['label'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <main id="main-content" class="p-3 mt-4">
            <section id="cars" class="d-none"><?php require_once __DIR__ . '/car_manager.php'; ?></section>
            <section id="brands" class="d-none"><?php require_once __DIR__ . '/brands_manager.php'; ?></section>
            <section id="categories" class="d-none"><?php require_once __DIR__ . '/categories_manager.php'; ?></section>
            <section id="accessories" class="d-none"><?php require_once __DIR__ . '/accessories_manager.php'; ?></section>
            <section id="users" class="d-none"><?php require_once __DIR__ . '/users_manager.php'; ?></section>
            <section id="orders" class="d-none"><?php require_once __DIR__ . '/orders_manager.php'; ?></section>
            <section id="test_drives" class="d-none"><?php require_once __DIR__ . '/test_drives_manager.php'; ?></section>
            <section id="banners" class="d-none"><?php require_once __DIR__ . '/banners_manager.php'; ?></section>
            <section id="used_cars" class="d-none"><?php require_once __DIR__ . '/used_cars_manager.php'; ?></section>
            <section id="car_services" class="d-none"><?php require_once __DIR__ . '/cars_services_manager.php'; ?></section>
            <section id="promotions" class="d-none"><?php require_once __DIR__ . '/promotions_manager.php'; ?></section>
            <section id="service_orders" class="d-none"><?php require_once __DIR__ . '/serviceOrder_manager.php'; ?></section>
            <section id="reviews" class="d-none"><?php require_once __DIR__ . '/reviews_manager.php'; ?></section>
            <section id="dashboard" class="d-none"><?php require_once __DIR__ . '/revenue_manager.php'; ?></section>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navLinks = document.querySelectorAll("nav .nav-link");
            const sections = document.querySelectorAll("main section");

            function showSection(id) {
                sections.forEach(section => {
                    section.classList.add("d-none");
                    if (section.id === id) section.classList.remove("d-none");
                });

                navLinks.forEach(link => {
                    link.classList.remove("active");
                    if (link.getAttribute("href") === `#${id}`) {
                        link.classList.add("active");
                    }
                });
            }

            const query = window.location.search;
            const hash = window.location.hash;
            const fullParams = new URLSearchParams(query + hash.replace('#', '&'));
            const status = fullParams.get("status");
            const message = fullParams.get("message");

            if (status && message && typeof Swal !== 'undefined') {
                let icon = "info";
                let title = "Thông báo";
                if (status === "success") { icon = "success"; title = "Thành công!"; }
                else if (status === "error") { icon = "error"; title = "Lỗi!"; }
                else if (status === "warning") { icon = "warning"; title = "Cảnh báo!"; }

                Swal.fire({
                    icon: icon,
                    title: title,
                    text: decodeURIComponent(message),
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                }).then(() => {
                    const cleanUrl = window.location.pathname + window.location.hash;
                    history.replaceState(null, "", cleanUrl);
                });
            }

            navLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute("href").substring(1);
                    history.pushState(null, "", `#${targetId}`);
                    showSection(targetId);
                });
            });

            const currentHash = window.location.hash.substring(1);
            if (currentHash && document.getElementById(currentHash)) {
                showSection(currentHash);
            } else {
                showSection("dashboard");
            }

            window.addEventListener("popstate", function () {
                const hash = window.location.hash.substring(1);
                if (hash && document.getElementById(hash)) {
                    showSection(hash);
                }
            });

            // Toggle sidebar
            document.getElementById("sidebarToggle").addEventListener("click", function () {
                const sidebar = document.getElementById("sidebar");
                const main = document.getElementById("main-content");
                sidebar.classList.toggle("collapsed");
                main.classList.toggle("expanded");
            });
        });
    </script>
</body>

</html>
