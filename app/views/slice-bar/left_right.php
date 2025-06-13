<style>
    #hide-banner-left-btn,
    #hide-banner-right-btn {
        z-index: 1050;
    }
</style>

<?php if ($banner_left != null): ?>
    <div id="banner-left" class="position-fixed top-50 start-0 translate-middle-y d-none d-lg-block z-3" style="left: 10px; width: 12vw; height: 60vh;">
        <button id="hide-banner-left-btn" 
            style="position: absolute; top: 5px; right: 5px; background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 24px; height: 24px; font-weight: bold; cursor: pointer;">
            &times;
        </button>
        <a href="#">
            <img src="<?php echo htmlspecialchars($banner_left['image_url']); ?>" alt="Banner Trái"
                class="rounded-4 shadow"
                style="width: 100%; height: 100%; object-fit: cover;">
        </a>
    </div>
<?php endif; ?>

<?php if ($banner_right != null): ?>
    <div id="banner-right" class="position-fixed top-50 end-0 translate-middle-y d-none d-lg-block z-3" style="right: 10px; width: 12vw; height: 60vh;">
        <button id="hide-banner-right-btn" 
            style="position: absolute; top: 5px; left: 5px; background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 24px; height: 24px; font-weight: bold; cursor: pointer;">
            &times;
        </button>
        <a href="#">
            <img src="<?php echo htmlspecialchars($banner_right['image_url']); ?>" alt="Banner Phải"
                class="rounded-4 shadow"
                style="width: 100%; height: 100%; object-fit: cover;">
        </a>
    </div>
<?php endif; ?>
