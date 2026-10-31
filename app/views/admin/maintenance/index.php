<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1"><i class="fas fa-tools text-danger me-2"></i>Quản Lý & Xử Lý Sự Cố Sửa Chữa</h5>
            <p class="text-muted small mb-0">Tiếp nhận yêu cầu hỏng hóc từ khách thuê và điều phối kỹ thuật</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Phòng</th>
                    <th>Người báo</th>
                    <th>Sự cố</th>
                    <th>Thời gian gửi</th>
                    <th>Chi phí sửa</th>
                    <th>Ghi chú / Phản hồi BQL</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Cập nhật</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($requests)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Không có yêu cầu sự cố nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($requests as $mt): ?>
                        <tr>
                            <td>
                                <strong class="badge bg-light text-dark border"><?= $mt['room_number'] ?></strong>
                                <small class="text-muted d-block"><?= htmlspecialchars($mt['branch_name']) ?></small>
                            </td>
                            <td>
                                <strong class="d-block"><?= htmlspecialchars($mt['tenant_name']) ?></strong>
                                <small class="text-muted"><a href="tel:<?= $mt['tenant_phone'] ?>"><?= $mt['tenant_phone'] ?></a></small>
                            </td>
                            <td>
                                <strong class="d-block text-dark"><?= htmlspecialchars($mt['title']) ?></strong>
                                <small class="text-muted"><?= htmlspecialchars($mt['description']) ?></small>
                            </td>
                            <td class="small text-muted"><?= formatDateTime($mt['created_at']) ?></td>
                            <td class="fw-bold"><?= formatMoney($mt['cost']) ?></td>
                            <td class="small"><?= htmlspecialchars($mt['admin_notes'] ?? 'Chưa ghi chú') ?></td>
                            <td><?= maintenanceStatusBadge($mt['status']) ?></td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill btn-sm" data-bs-toggle="modal" data-bs-target="#editMtModal<?= $mt['id'] ?>">
                                    <i class="fas fa-edit me-1"></i> Xử lý
                                </button>
                            </td>
                        </tr>

                        <!-- Modal cập nhật xử lý -->
                        <div class="modal fade" id="editMtModal<?= $mt['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow rounded-4">
                                    <div class="modal-header bg-light">
                                        <h6 class="modal-title fw-bold"><i class="fas fa-wrench me-1"></i> Xử Lý Sự Cố: Phòng <?= $mt['room_number'] ?></h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= BASE_URL ?>/admin/maintenance" method="POST">
                                        <div class="modal-body p-4">
                                            <input type="hidden" name="id" value="<?= $mt['id'] ?>">
                                            <p class="small text-muted mb-3"><strong>Sự cố:</strong> <?= htmlspecialchars($mt['title']) ?> - <?= htmlspecialchars($mt['description']) ?></p>

                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Trạng thái xử lý</label>
                                                <select name="status" class="form-select">
                                                    <option value="pending" <?= $mt['status'] === 'pending' ? 'selected' : '' ?>>Đang chờ xử lý</option>
                                                    <option value="in_progress" <?= $mt['status'] === 'in_progress' ? 'selected' : '' ?>>Đang tiến hành sửa</option>
                                                    <option value="completed" <?= $mt['status'] === 'completed' ? 'selected' : '' ?>>Đã khắc phục xong</option>
                                                    <option value="rejected" <?= $mt['status'] === 'rejected' ? 'selected' : '' ?>>Từ chối yêu cầu</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Chi phí sửa chữa (VNĐ)</label>
                                                <input type="number" name="cost" class="form-control" value="<?= (float)$mt['cost'] ?>" step="5000">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label small fw-bold">Ghi chú phản hồi cho khách thuê</label>
                                                <textarea name="admin_notes" class="form-control" rows="2" placeholder="Ví dụ: Đã thay linh kiện mới..."><?= htmlspecialchars($mt['admin_notes'] ?? '') ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary rounded-pill btn-sm" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" class="btn btn-primary-custom rounded-pill btn-sm px-4">Lưu Xử Lý</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
