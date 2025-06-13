<div class="reviews-section mt-4">
    <h4>Đánh giá xe</h4>

    <!-- Form gửi comment -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="/reviews/save">
                <input type="hidden" name="car_id" value="<?= htmlspecialchars($car_id) ?>">

                <label>Chọn số sao:</label>
                <select name="rating" class="form-select" required>
                    <option value="">-- Chọn sao --</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?> ⭐</option>
                    <?php endfor; ?>
                </select>

                <label>Nhận xét:</label>
                <textarea name="comment" class="form-control" required></textarea>

                <button type="submit" class="btn btn-primary mt-2">Gửi đánh giá</button>
            </form>
        </div>
    </div>

    <!-- Danh sách đánh giá -->
    <?php if (empty($reviews)): ?>
        <p>Chưa có đánh giá nào cho xe này.</p>
    <?php else: ?>
<?php if ($averageRating): ?>
    <p class="mt-2">Đánh giá trung bình: ⭐ <?= round($averageRating, 1) ?>/5</p>
<?php endif; ?>
        <?php foreach ($reviews as $review): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <?= htmlspecialchars($review['full_name'] ?? 'Người dùng ẩn danh') ?>
                        <?php if ($review['rating']): ?>
                            - ⭐ <?= $review['rating'] ?>/5
                        <?php endif; ?>
                    </h6>
                    <?php if ($review['comment']): ?>
                        <p class="card-text"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                    <?php endif; ?>
                    <small class="text-muted">Đăng ngày: <?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
