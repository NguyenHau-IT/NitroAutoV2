<div class="mt-4 bg-white rounded-4 shadow p-4 border border-primary-subtle">
    <h3 class="text-primary mb-4 text-start">
        <i class="bi bi-newspaper me-2"></i> Tin tức
    </h3>

    <?php if (!empty($newsList)): ?>
        <div id="newsCarousel" style="height: 200px;" class="carousel slide" data-bs-ride="carousel" data-bs-interval="8000">
            <div class="carousel-inner">

                <?php
                $chunkedNews = array_chunk($newsList, 3);
                foreach ($chunkedNews as $index => $chunk):
                ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row g-4">
                            <?php foreach ($chunk as $news): ?>
                                <div class="col-md-4 h-100">
                                    <a href="<?= $news['link'] ?>" target="_blank" class="text-decoration-none text-dark fw-bold">
                                        <div class="card h-100 border-0 shadow-sm rounded-3 d-flex flex-column justify-content-between">
                                            <div class="card-body d-flex flex-column justify-content-between" style="height: 150px;">
                                                <h5 class="card-title mb-3 flex-shrink-0" style="height: 100px">
                                                    <i class="bi bi-circle-fill text-primary me-2 fs-3"></i>
                                                    <strong><?= $news['title'] ?></strong>
                                                </h5>
                                            </div>
                                            <div class="card-footer bg-white border-0 text-end flex-shrink-0" style="height: 50px;">
                                                <small class="text-muted fst-italic">
                                                    <i class="bi bi-clock me-1"></i><?= date("H:i - d/m/Y", strtotime($news['pubDate'])) ?>
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Nút trái -->
            <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                <i class="bi bi-chevron-left fs-2 text-dark bg-white p-2 rounded-circle shadow"></i>
                <span class="visually-hidden">Trước</span>
            </button>

            <!-- Nút phải -->
            <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                <i class="bi bi-chevron-right fs-2 text-dark bg-white p-2 rounded-circle shadow"></i>
                <span class="visually-hidden">Tiếp</span>
            </button>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center mt-3">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>Không lấy được tin tức thị trường ô tô.
        </div>
    <?php endif; ?>
</div>