<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0 d-flex align-items-center">
        <i class="bi bi-people-fill me-2 text-primary fs-4"></i> Quản lý Người dùng
    </h2>
    <a href="/admin/user/add" class="btn btn-success d-flex align-items-center gap-1 shadow-sm">
        <i class="bi bi-person-plus-fill"></i> Thêm người dùng
    </a>
</div>

<div class="table-responsive rounded border shadow-sm mb-5 bg-white">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light text-center">
            <tr class="align-middle">
                <th>ID</th>
                <th>Tên</th>
                <th>Giới tính</th>
                <th>Email</th>
                <th>Điện thoại</th>
                <th>Địa chỉ</th>
                <th>Vai trò</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td class="text-start"><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><?= ($user['gender'] == 1 ? 'Nam' : 'Nữ') ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone']) ?></td>
                    <td class="text-start"><?= htmlspecialchars($user['address'] ?? '-') ?></td>
                    <td>
                        <?php
                        $role = $user['role'];
                        echo match ($role) {
                            'admin' => '<span class="badge bg-danger">Quản trị viên</span>',
                            'customer' => '<span class="badge bg-secondary">Người dùng</span>',
                            default => '<span class="badge bg-warning text-dark">Khác</span>',
                        };
                        ?>
                    </td>
                    <td><?= date('d/m/Y - H:i:s', strtotime($user['created_at'])) ?></td>
                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/admin/user/edit/<?= $user['id'] ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <a href="/admin/user/delete/<?= $user['id'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');"
                                class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                <i class="bi bi-trash3"></i> Xóa
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>