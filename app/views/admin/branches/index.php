<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="row g-4">
    <!-- Form thêm mới -->
    <div class="col-lg-4">
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle text-primary me-2"></i>Thêm Cơ Sở / Khu Trọ</h6>
            <form action="<?= BASE_URL ?>/admin/branches" method="POST">
                <input type="hidden" name="action" value="add">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Tên cơ sở / khu trọ <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Ví dụ: Cơ sở 4 - An Bình Thanh Xuân" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control" placeholder="Số 12 Ngõ 85 Nguyễn Trãi..." required>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Quận / Huyện <span class="text-danger">*</span></label>
                        <input type="text" name="district" class="form-control" placeholder="Thanh Xuân" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" placeholder="Hà Nội" required>
                    </div>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Quản lý cơ sở <span class="text-danger">*</span></label>
                        <input type="text" name="manager_name" class="form-control" placeholder="Nguyễn Văn A" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Hotline quản lý <span class="text-danger">*</span></label>
                        <input type="text" name="manager_phone" class="form-control" placeholder="0901234567" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Mô tả đặc điểm</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="Gần các trường ĐH nào, tiện ích thang máy..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2 rounded-pill fw-bold">
                    <i class="fas fa-save me-1"></i> Lưu Khu Trọ Mới
                </button>
            </form>
        </div>
    </div>

    <!-- Danh sách cơ sở -->
    <div class="col-lg-8">
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-city text-primary me-2"></i>Danh Sách Khu Trọ & Thống Kê Phòng</h6>
            
            <div class="table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Tên khu trọ</th>
                            <th>Địa chỉ</th>
                            <th>Quản lý</th>
                            <th>Tổng phòng</th>
                            <th>Trống</th>
                            <th class="text-end">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($branches as $b): ?>
                            <tr>
                                <td>
                                    <strong class="d-block"><?= htmlspecialchars($b['name']) ?></strong>
                                    <span class="badge bg-primary-subtle text-primary"><?= htmlspecialchars($b['city']) ?></span>
                                </td>
                                <td class="small text-muted"><?= htmlspecialchars($b['address']) ?>, <?= htmlspecialchars($b['district']) ?></td>
                                <td class="small">
                                    <span class="d-block fw-bold"><?= htmlspecialchars($b['manager_name']) ?></span>
                                    <span class="text-muted"><?= htmlspecialchars($b['manager_phone']) ?></span>
                                </td>
                                <td><span class="badge bg-light text-dark border"><?= $b['total_rooms'] ?> phòng</span></td>
                                <td><span class="badge bg-success"><?= $b['available_rooms'] ?? 0 ?> phòng</span></td>
                                <td class="text-end">
                                    <a href="<?= BASE_URL ?>/admin/branchDelete/<?= $b['id'] ?>" class="btn btn-sm btn-outline-danger btn-action btn-confirm-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
