<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <h5 class="fw-bold mb-0"><i class="fas fa-user-plus text-primary me-2"></i>Thêm Khách Thuê Mới</h5>
        <a href="<?= BASE_URL ?>/admin/tenants" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Quay Lại
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/tenantAdd" method="POST">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Họ và tên khách thuê <span class="text-danger">*</span></label>
                <input type="text" name="full_name" class="form-control" placeholder="Nguyễn Văn A" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Số CCCD / CMND <span class="text-danger">*</span></label>
                <input type="text" name="id_card" class="form-control" placeholder="00120100xxxx" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                <input type="tel" name="phone" class="form-control" placeholder="0901234567" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="vana@gmail.com" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Giới tính</label>
                <select name="gender" class="form-select">
                    <option value="male" selected>Nam</option>
                    <option value="female">Nữ</option>
                    <option value="other">Khác</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Ngày sinh</label>
                <input type="date" name="date_of_birth" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Quê quán</label>
                <input type="text" name="hometown" class="form-control" placeholder="Thanh Hóa, Nam Định...">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Địa chỉ đăng ký tạm trú</label>
                <input type="text" name="temporary_residence" class="form-control" placeholder="Tạm trú tại...">
            </div>
        </div>

        <div class="p-3 bg-light rounded-3 border mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="create_account" id="create_account" value="1" checked>
                <label class="form-check-label fw-bold small" for="create_account">
                    Tự động tạo tài khoản đăng nhập Cổng Khách Thuê (Tên đăng nhập: <code>tenant_SĐT</code>, Mật khẩu mặc định: <code>123456</code>)
                </label>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill fw-bold">
                <i class="fas fa-save me-1"></i> Lưu Hồ Sơ Khách Thuê
            </button>
        </div>
    </form>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
