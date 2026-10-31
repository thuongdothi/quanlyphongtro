<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1"><i class="fas fa-users text-primary me-2"></i>Quản Lý Hồ Sơ Khách Thuê (<?= count($tenants) ?> người)</h5>
            <p class="text-muted small mb-0">Quản lý lý lịch cá nhân, CCCD, số điện thoại và phòng đang thuê</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/admin/tenantAdd" class="btn btn-primary-custom rounded-pill btn-sm fw-bold">
                <i class="fas fa-user-plus me-1"></i> Thêm Khách Thuê Mới
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Họ và tên</th>
                    <th>CCCD / CMND</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Phòng đang thuê</th>
                    <th>Hợp đồng</th>
                    <th>Tài khoản hệ thống</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tenants)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Chưa có khách thuê nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($tenants as $t): ?>
                        <tr>
                            <td>
                                <strong class="d-block"><?= htmlspecialchars($t['full_name']) ?></strong>
                                <small class="text-muted"><?= htmlspecialchars($t['hometown'] ?? 'Chưa rõ') ?></small>
                            </td>
                            <td><code><?= htmlspecialchars($t['id_card']) ?></code></td>
                            <td><a href="tel:<?= $t['phone'] ?>"><?= htmlspecialchars($t['phone']) ?></a></td>
                            <td class="small text-muted"><?= htmlspecialchars($t['email']) ?></td>
                            <td>
                                <?php if (!empty($t['room_number'])): ?>
                                    <span class="badge bg-success"><i class="fas fa-door-open me-1"></i><?= $t['room_number'] ?></span>
                                    <small class="text-muted d-block"><?= htmlspecialchars($t['branch_name']) ?></small>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Chưa thuê phòng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($t['contract_number'])): ?>
                                    <span class="badge bg-primary"><?= $t['contract_number'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border">Chưa lập HĐ</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($t['username'])): ?>
                                    <span class="badge bg-info-subtle text-info-emphasis"><i class="fas fa-check me-1"></i><?= $t['username'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border">Chưa tạo TK</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= BASE_URL ?>/admin/tenantEdit/<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary btn-action me-1" title="Sửa thông tin">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/admin/tenantDelete/<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger btn-action btn-confirm-delete" title="Xóa">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
