<!-- Header luôn hiển thị trên cùng -->
<?php require_once 'includes/header.php'; ?>

<!-- Banner nền toàn màn hình -->
<div id="banner-container" class="position-fixed top-0 start-0 w-100 h-100 z-n1">
    <?php require_once 'app/views/slice-bar/slider.php'; ?>
</div>

<!-- Overlay nội dung nằm giữa slider -->
<main class="position-relative z-2" style="min-height: 100vh;">

    <!-- Overlay nội dung -->
    <div class="overlay d-flex align-items-center justify-content-center text-white text-center px-3" style="min-height: 100vh;">
        <div>
            <h1 class="display-4 fw-bold mb-3 text-shadow">
                Chào mừng bạn đến <span class="text-warning">Auto</span>
            </h1>
            <p class="lead mb-4">Khám phá xe, tin tức, và nhiều hơn nữa.</p>
            <a href="#!" class="btn btn-warning btn-lg px-4 py-2 shadow">Bắt đầu ngay</a>
        </div>
    </div>
</main>

<!-- Footer -->
<?php require_once 'includes/footer.php'; ?>
