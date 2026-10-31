<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1"><i class="fas fa-door-closed text-primary me-2"></i>Danh Sách Phòng Trọ (<?= count($rooms) ?> phòng)</h5>
            <p class="text-muted small mb-0">Quản lý trạng thái, giá thuê và thông tin các phòng trong hệ thống</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/admin/roomAdd" class="btn btn-primary-custom rounded-pill btn-sm fw-bold">
                <i class="fas fa-plus me-1"></i> Thêm Phòng Mới
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Số phòng</th>
                    <th>Tên phòng / Tiêu đề</th>
                    <th>Khu trọ</th>
                    <th>Loại phòng</th>
                    <th>Giá thuê</th>
                    <th>Diện tích</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rooms)): ?>
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">Chưa có phòng trọ nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rooms as $r): ?>
                        <tr>
                            <td>
                                <img src="<?= BASE_URL ?>/<?= $r['image'] ?: 'assets/images/rooms/room1.jpg' ?>" class="rounded-3" width="55" height="45" style="object-fit: cover;" alt="Room">
                            </td>
                            <td>
                                <strong class="badge bg-light text-dark border fs-6"><?= $r['room_number'] ?></strong>
                                <?php if ($r['is_featured']): ?>
                                    <span class="badge bg-warning text-dark small ms-1" title="Nổi bật"><i class="fas fa-star"></i></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>/room/detail/<?= $r['slug'] ?>" target="_blank" class="fw-bold text-dark">
                                    <?= htmlspecialchars($r['title']) ?>
                                </a>
                                <small class="text-muted d-block">Tầng <?= $r['floor'] ?> • Tối đa <?= $r['max_tenants'] ?> người</small>
                            </td>
                            <td><?= htmlspecialchars($r['branch_name']) ?></td>
                            <td><span class="badge bg-info-subtle text-info-emphasis"><?= htmlspecialchars($r['room_type_name']) ?></span></td>
                            <td class="fw-bold text-primary"><?= formatMoney($r['price']) ?></td>
                            <td><?= $r['area'] ?> m²</td>
                            <td><?= roomStatusBadge($r['status']) ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL ?>/admin/roomEdit/<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary btn-action me-1" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/admin/roomDelete/<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger btn-action btn-confirm-delete" title="Xóa phòng">
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
