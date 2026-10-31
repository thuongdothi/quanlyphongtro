<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/tenant">Cổng khách thuê</a></li>
            <li class="breadcrumb-item active" aria-current="page">Báo hỏng & Sửa chữa</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Form gửi sự cố -->
        <div class="col-lg-5">
            <div class="card border rounded-4 p-4 shadow-sm bg-white">
                <h5 class="fw-bold mb-3"><i class="fas fa-wrench text-warning me-2"></i>Gửi Yêu Cầu Sửa Chữa</h5>
                
                <?php if ($tenant && !empty($tenant['room_id'])): ?>
                    <form action="<?= BASE_URL ?>/tenant/maintenance" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Phòng gặp sự cố</label>
                            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($tenant['room_title']) ?> (<?= $tenant['room_number'] ?>)" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Tiêu đề sự cố <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="Ví dụ: Hỏng vòi nước, Điều hòa chảy nước..." required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Mô tả chi tiết <span class="text-danger">*</span></label>
                            <textarea name="description" rows="4" class="form-control" placeholder="Mô tả hiện trạng sự cố, thời gian tiện để kỹ thuật viên qua kiểm tra..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 py-2 rounded-pill fw-bold">
                            <i class="fas fa-paper-plane me-1"></i> Gửi Yêu Cầu Cho Ban Quản Lý
                        </button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning small mb-0">
                        <i class="fas fa-info-circle me-1"></i> Bạn cần được phân phòng thuê để có thể gửi yêu cầu sửa chữa.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Lịch sử yêu cầu -->
        <div class="col-lg-7">
            <div class="card border rounded-4 p-4 shadow-sm bg-white">
                <h5 class="fw-bold mb-3"><i class="fas fa-history text-primary me-2"></i>Lịch Sử & Tiến Độ Xử Lý</h5>

                <?php if (empty($requests)): ?>
                    <p class="text-muted small text-center py-5">Bạn chưa gửi yêu cầu báo hỏng nào.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light small">
                                <tr>
                                    <th>Sự cố</th>
                                    <th>Thời gian gửi</th>
                                    <th>Trạng thái</th>
                                    <th>Phản hồi của BQL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($requests as $req): ?>
                                    <tr>
                                        <td>
                                            <strong class="d-block small"><?= htmlspecialchars($req['title']) ?></strong>
                                            <small class="text-muted"><?= htmlspecialchars($req['description']) ?></small>
                                        </td>
                                        <td class="small text-muted"><?= formatDateTime($req['created_at']) ?></td>
                                        <td><?= maintenanceStatusBadge($req['status']) ?></td>
                                        <td class="small">
                                            <?= !empty($req['admin_notes']) ? htmlspecialchars($req['admin_notes']) : '<span class="text-muted">Đang chờ điều phối</span>' ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
