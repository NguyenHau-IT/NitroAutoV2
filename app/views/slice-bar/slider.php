<?php if (!empty($banners)): ?>
<style>
    #hide-banner-btn {
        z-index: 1050;
    }
</style>

<div id="banner-container" class="mt-4 bg-light rounded-4 shadow overflow-hidden position-relative">

    <!-- Nút ẩn -->
    <button id="hide-banner-btn" class="btn btn-sm btn-outline-secondary position-absolute top-0 end-0 m-2"
        aria-label="Ẩn banner" title="Ẩn banner">
        <i class="bi bi-x-lg"></i>
    </button>

    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-indicators">
            <?php foreach ($banners as $index => $banner): ?>
                <button type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide-to="<?= $index ?>"
                        class="<?= $index === 0 ? 'active' : '' ?>"
                        aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>

        <div class="carousel-inner rounded-4">
            <?php foreach ($banners as $index => $banner): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <img src="<?= $banner['image_url'] ?>" class="d-block w-100 carousel-img" alt="Banner <?= $index + 1 ?>">
                </div>
            <?php endforeach; ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<?php endif; ?>
