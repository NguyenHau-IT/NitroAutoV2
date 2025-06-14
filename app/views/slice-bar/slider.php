<!-- Banner làm nền -->
<div id="banner-container" class="position-fixed top-0 start-0 w-100 h-100 z-0">
    <div class="swiper mySwiper h-100 w-100">
        <div class="swiper-wrapper">
            <?php foreach ($banners as $banner): ?>
                <div class="swiper-slide banner-bg-slide" style="background-image: url('<?= $banner['image_url'] ?>');"></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
