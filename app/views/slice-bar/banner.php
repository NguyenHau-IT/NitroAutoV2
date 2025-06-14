<div id="custom-banner-wrapper" class="position-relative mt-4">
    <!-- Nút ẩn banner -->
    <button id="custom-banner-close-btn"
            class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2 rounded-circle z-2"
            aria-label="Ẩn banner" title="Ẩn banner">
        <i class="bi bi-x-lg"></i>
    </button>

    <!-- Swiper -->
    <div class="swiper customBannerSwiper rounded-4 shadow overflow-hidden">
        <div class="swiper-wrapper">
            <?php foreach ($banners as $banner): ?>
                <div class="swiper-slide">
                    <img src="<?= $banner['image_url'] ?>"
                         alt="Banner"
                         class="img-fluid w-100 d-block" style="object-fit: cover;">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
