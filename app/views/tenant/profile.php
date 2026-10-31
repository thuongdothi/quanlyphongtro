<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/tenant">Cổng khách thuê</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hồ sơ cá nhân</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Cập nhật thông tin -->
        <div class="col-lg-6">
            <div class="card border rounded-4 p-4 shadow-sm bg-white h-100">
                <h5 class="fw-bold mb-3 pb-2 border-bottom"><i class="fas fa-user-edit text-primary me-2"></i>Thông Tin Tài Khoản</h5>
                <form action="<?= BASE_URL ?>/tenant/profile" method="POST">
                    <input type="hidden" name="action" value="update_info">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tên đăng nhập</label>
                        <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['username']) ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Quê quán</label>
                        <input type="text" name="hometown" class="form-control" value="<?= htmlspecialchars($tenant['hometown'] ?? '') ?>">
                    </div>

                    <button type="submit" class="btn btn-primary-custom rounded-pill px-4 fw-bold">
                        <i class="fas fa-save me-1"></i> Lưu Thay Đổi
                    </button>
                </form>
            </div>
        </div>

        <!-- Đổi mật khẩu -->
        <div class="col-lg-6">
            <div class="card border rounded-4 p-4 shadow-sm bg-white h-100">
                <h5 class="fw-bold mb-3 pb-2 border-bottom"><i class="fas fa-key text-warning me-2"></i>Đổi Mật Khẩu</h5>
                <form action="<?= BASE_URL ?>/tenant/profile" method="POST">
                    <input type="hidden" name="action" value="change_password">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                        <input type="password" name="old_password" class="form-control" placeholder="••••••••" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" name="new_password" class="form-control" placeholder="Tối thiểu 6 ký tự" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Xác nhận mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu mới" required>
                    </div>

                    <button type="submit" class="btn btn-outline-warning rounded-pill px-4 fw-bold text-dark">
                        <i class="fas fa-shield-alt me-1"></i> Cập Nhật Mật Khẩu
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
