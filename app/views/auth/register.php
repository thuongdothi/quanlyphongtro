<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="p-4 p-md-5 bg-white">
                    <div class="text-center mb-4">
                        <div class="stat-icon green mx-auto mb-3">
                            <i class="fas fa-user-plus fa-lg"></i>
                        </div>
                        <h3 class="fw-bold">Đăng Ký Tài Khoản</h3>
                        <p class="text-muted small">Dành cho khách thuê quản lý phòng & hóa đơn trực tuyến</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 small mb-3">
                            <i class="fas fa-exclamation-circle me-1"></i> <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>/auth/register" method="POST">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control" placeholder="Nguyễn Văn A" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Tên đăng nhập <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" placeholder="nguyenvana" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control" placeholder="0901234567" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="vana@gmail.com" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">CCCD / CMND</label>
                                <input type="text" name="id_card" class="form-control" placeholder="00120100xxxx">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Quê quán</label>
                                <input type="text" name="hometown" class="form-control" placeholder="Hà Nội, Nam Định...">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Tối thiểu 6 ký tự" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold mb-3 shadow-sm">
                            <i class="fas fa-check-circle me-1"></i> Hoàn Tất Đăng Ký
                        </button>
                    </form>

                    <div class="text-center small">
                        Đã có tài khoản? <a href="<?= BASE_URL ?>/auth/login" class="fw-bold">Đăng nhập tại đây</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
