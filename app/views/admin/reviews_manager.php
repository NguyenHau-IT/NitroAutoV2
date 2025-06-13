<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-ticket-perforated-fill me-2 text-primary fs-4"></i> Quản lý Đánh giá
    </h2>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
    <thead class="bg-light text-center">
    <tr class="align-middle">
        <th>ID</th>
        <th>Người đánh giá</th>
        <th>Xe được đánh giá</th>
        <th>Sao đánh giá</th>
        <th>Nội dung đánh giá</th>
        <th>Thời gian</th>
        <th>Hành động</th>
    </tr>
</thead>
<tbody class="text-center">
    <?php foreach ($reviews as $review): ?>
        <tr>
            <td><?= $review['id'] ?></td>
            <td><?= htmlspecialchars($review['user_name']) ?></td>
            <td><?= htmlspecialchars($review['car_name']) ?></td>
            <td><?= $review['rating'] ?> ⭐</td>
            <td><?= htmlspecialchars($review['comment']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></td>
            <td>
                <a href="/admin/reviews/delete/<?= $review['id'] ?>" class="btn btn-sm btn-outline-danger me-1" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                    <i class="bi bi-trash-fill"></i> Xoá
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>
</div>