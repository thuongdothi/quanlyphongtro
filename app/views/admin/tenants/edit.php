<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <h5 class="fw-bold mb-0"><i class="fas fa-user-edit text-primary me-2"></i>Sửa Hồ Sơ Khách Thuê: <?= htmlspecialchars($tenant['full_name']) ?></h5>
        <a href="<?= BASE_URL ?>/admin/tenants" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Quay Lại
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/tenantEdit/<?= $tenant['id'] ?>" method="POST">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Họ và tên khách thuê <span class="text-danger">*</span></label>
                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($tenant['full_name']) ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Số CCCD / CMND <span class="text-danger">*</span></label>
                <input type="text" name="id_card" class="form-control" value="<?= htmlspecialchars($tenant['id_card']) ?>" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($tenant['phone']) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($tenant['email']) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Giới tính</label>
                <select name="gender" class="form-select">
                    <option value="male" <?= $tenant['gender'] === 'male' ? 'selected' : '' ?>>Nam</option>
                    <option value="female" <?= $tenant['gender'] === 'female' ? 'selected' : '' ?>>Nữ</option>
                    <option value="other" <?= $tenant['gender'] === 'other' ? 'selected' : '' ?>>Khác</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Ngày sinh</label>
                <input type="date" name="date_of_birth" class="form-control" value="<?= $tenant['date_of_birth'] ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Quê quán</label>
                <input type="text" name="hometown" class="form-control" value="<?= htmlspecialchars($tenant['hometown'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Địa chỉ đăng ký tạm trú</label>
                <input type="text" name="temporary_residence" class="form-control" value="<?= htmlspecialchars($tenant['temporary_residence'] ?? '') ?>">
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill fw-bold">
                <i class="fas fa-save me-1"></i> Cập Nhật Hồ Sơ
            </button>
        </div>
    </form>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
