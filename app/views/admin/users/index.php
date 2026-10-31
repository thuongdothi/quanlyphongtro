<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1"><i class="fas fa-user-shield text-primary me-2"></i>Danh Sách Tài Khoản Người Dùng (<?= count($users) ?> tài khoản)</h5>
            <p class="text-muted small mb-0">Quản lý tài khoản Admin và Khách thuê, đặt lại mật khẩu</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Tên đăng nhập</th>
                    <th>Họ và tên</th>
                    <th>Vai trò (Role)</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td>
                            <strong class="d-block"><?= htmlspecialchars($u['username']) ?></strong>
                        </td>
                        <td><?= htmlspecialchars($u['full_name']) ?></td>
                        <td>
                            <?php if ($u['role_id'] == 1): ?>
                                <span class="badge bg-danger"><i class="fas fa-shield-alt me-1"></i>Quản trị viên</span>
                            <?php else: ?>
                                <span class="badge bg-primary-subtle text-primary"><i class="fas fa-user me-1"></i>Khách thuê</span>
                            <?php endif; ?>
                        </td>
                        <td class="small text-muted"><?= htmlspecialchars($u['email']) ?></td>
                        <td class="small"><?= htmlspecialchars($u['phone']) ?></td>
                        <td>
                            <?= $u['status'] == 1 ? '<span class="badge bg-success">Hoạt động</span>' : '<span class="badge bg-danger">Bị khóa</span>' ?>
                        </td>
                        <td class="small text-muted"><?= formatDate($u['created_at']) ?></td>
                        <td class="text-end">
                            <a href="<?= BASE_URL ?>/admin/userResetPassword/<?= $u['id'] ?>" class="btn btn-sm btn-outline-warning rounded-pill btn-action btn-confirm-delete" style="width:auto; padding: 2px 10px;" title="Reset mật khẩu về 123456">
                                <i class="fas fa-key me-1"></i> Reset MK
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
