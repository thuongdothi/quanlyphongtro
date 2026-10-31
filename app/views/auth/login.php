<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="p-4 p-md-5 bg-white">
                    <div class="text-center mb-4">
                        <div class="stat-icon blue mx-auto mb-3">
                            <i class="fas fa-lock fa-lg"></i>
                        </div>
                        <h3 class="fw-bold">Đăng Nhập</h3>
                        <p class="text-muted small">Truy cập Cổng Khách Thuê & Bảng Quản Trị</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger py-2 small mb-3">
                            <i class="fas fa-exclamation-circle me-1"></i> <?= $error ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>/auth/login" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Tên đăng nhập hoặc Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="admin hoặc khach1" required autofocus>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Mật khẩu</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold mb-3 shadow-sm">
                            <i class="fas fa-sign-in-alt me-1"></i> Đăng Nhập Hệ Thống
                        </button>
                    </form>

                    <div class="p-3 rounded-3 bg-light border small text-muted mb-3">
                        <strong class="text-dark d-block mb-1">Tài khoản demo sẵn có:</strong>
                        <div>• Quản trị viên: <code>admin</code> / <code>admin123</code></div>
                        <div>• Khách thuê phòng 101: <code>khach1</code> / <code>123456</code></div>
                        <div>• Khách thuê phòng 201: <code>khach2</code> / <code>123456</code></div>
                    </div>

                    <div class="text-center small">
                        Bạn chưa có tài khoản? <a href="<?= BASE_URL ?>/auth/register" class="fw-bold">Đăng ký tài khoản mới</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
