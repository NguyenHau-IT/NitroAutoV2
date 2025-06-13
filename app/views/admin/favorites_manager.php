<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-heart-fill me-2 text-danger fs-4"></i> Quản lý Yêu thích
    </h2>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Xe</th>
                <th>Thời gian</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($favorites as $favorite): ?>
                <tr>
                    <td><?= htmlspecialchars($favorite['id']) ?></td>
                    <td><?= htmlspecialchars($favorite['user_name']) ?></td>
                    <td><?= htmlspecialchars($favorite['car_name']) ?></td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($favorite['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>