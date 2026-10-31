<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1"><i class="fas fa-file-signature text-primary me-2"></i>Quản Lý Hợp Đồng Thuê Phòng (<?= count($contracts) ?> hợp đồng)</h5>
            <p class="text-muted small mb-0">Theo dõi hợp đồng, giá thuê, tiền cọc và thời hạn kết thúc</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/admin/contractAdd" class="btn btn-primary-custom rounded-pill btn-sm fw-bold">
                <i class="fas fa-plus me-1"></i> Lập Hợp Đồng Mới
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Mã hợp đồng</th>
                    <th>Phòng thuê</th>
                    <th>Khách thuê</th>
                    <th>Giá thuê</th>
                    <th>Tiền đặt cọc</th>
                    <th>Thời hạn</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contracts)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Chưa có hợp đồng nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contracts as $c): ?>
                        <tr>
                            <td>
                                <strong class="d-block text-primary"><?= $c['contract_number'] ?></strong>
                                <small class="text-muted"><?= formatDate($c['created_at']) ?></small>
                            </td>
                            <td>
                                <strong class="badge bg-light text-dark border"><?= $c['room_number'] ?></strong>
                                <small class="text-muted d-block"><?= htmlspecialchars($c['branch_name']) ?></small>
                            </td>
                            <td>
                                <strong class="d-block"><?= htmlspecialchars($c['tenant_name']) ?></strong>
                                <small class="text-muted"><?= htmlspecialchars($c['tenant_phone']) ?></small>
                            </td>
                            <td class="fw-bold text-success"><?= formatMoney($c['rental_price']) ?></td>
                            <td class="fw-bold text-danger"><?= formatMoney($c['deposit_amount']) ?></td>
                            <td class="small">
                                <?= formatDate($c['start_date']) ?> → <?= formatDate($c['end_date']) ?>
                            </td>
                            <td>
                                <?php if ($c['status'] === 'active'): ?>
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Hiệu lực</span>
                                <?php elseif ($c['status'] === 'expired'): ?>
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Hết hạn</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><i class="fas fa-ban me-1"></i>Đã thanh lý</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= BASE_URL ?>/admin/contractDetail/<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary btn-action me-1" title="Xem & In">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($c['status'] === 'active'): ?>
                                    <a href="<?= BASE_URL ?>/admin/contractTerminate/<?= $c['id'] ?>" class="btn btn-sm btn-outline-warning btn-action btn-confirm-delete" title="Thanh lý hợp đồng">
                                        <i class="fas fa-door-open"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
