<div id="banner-container" class="position-relative">
    <!-- Nút ẩn -->
    <button id="hide-banner-btn" class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2 rounded-4"
        aria-label="Ẩn banner" title="Ẩn banner">
        <i class="bi bi-x-lg"></i>
    </button>

    <!-- Swiper -->
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <?php foreach ($banners as $banner): ?>
                <div class="swiper-slide rounded-4 overflow-hidden">
                    <img src="<?= $banner['image_url'] ?>" class="w-100" alt="Banner">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
