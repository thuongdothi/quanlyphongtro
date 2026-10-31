<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1"><i class="fas fa-calendar-check text-primary me-2"></i>Quản Lý Lịch Hẹn Xem Phòng (<?= count($bookings) ?> lượt)</h5>
            <p class="text-muted small mb-0">Theo dõi khách đặt lịch hẹn xem phòng từ trang chủ và cập nhật trạng thái</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Họ tên khách hẹn</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Phòng muốn xem</th>
                    <th>Ngày & Giờ hẹn</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Chưa có lịch hẹn nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bookings as $bk): ?>
                        <tr>
                            <td class="fw-bold"><?= htmlspecialchars($bk['full_name']) ?></td>
                            <td><a href="tel:<?= $bk['phone'] ?>"><?= htmlspecialchars($bk['phone']) ?></a></td>
                            <td class="small text-muted"><?= htmlspecialchars($bk['email'] ?? 'N/A') ?></td>
                            <td>
                                <strong class="badge bg-light text-dark border"><?= $bk['room_number'] ?></strong>
                                <small class="text-muted d-block"><?= htmlspecialchars($bk['branch_name']) ?></small>
                            </td>
                            <td>
                                <strong><?= formatDate($bk['booking_date']) ?></strong>
                                <small class="text-primary d-block fw-semibold"><?= $bk['booking_time'] ?></small>
                            </td>
                            <td class="small text-muted"><?= htmlspecialchars($bk['notes'] ?? 'Không có') ?></td>
                            <td><?= bookingStatusBadge($bk['status']) ?></td>
                            <td class="text-end">
                                <?php if ($bk['status'] === 'pending'): ?>
                                    <a href="<?= BASE_URL ?>/admin/bookings?id=<?= $bk['id'] ?>&action=confirmed" class="btn btn-sm btn-outline-success btn-action me-1" title="Xác nhận lịch">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>/admin/bookings?id=<?= $bk['id'] ?>&action=cancelled" class="btn btn-sm btn-outline-danger btn-action" title="Hủy lịch">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php elseif ($bk['status'] === 'confirmed'): ?>
                                    <a href="<?= BASE_URL ?>/admin/bookings?id=<?= $bk['id'] ?>&action=completed" class="btn btn-sm btn-outline-primary btn-action" title="Đã dẫn xem phòng">
                                        <i class="fas fa-check-double"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
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
