<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <h5 class="fw-bold mb-3 pb-2 border-bottom"><i class="fas fa-cogs text-primary me-2"></i>Cài Đặt Hệ Thống & Cổng VietQR</h5>

            <form action="<?= BASE_URL ?>/admin/settings" method="POST">
                <div class="mb-4">
                    <h6 class="fw-bold text-primary mb-3">1. Thông Tin Thương Hiệu & Liên Hệ</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tên hệ thống phòng trọ</label>
                            <input type="text" name="settings[site_name]" class="form-control" value="<?= htmlspecialchars($settings['site_name'] ?? 'HỆ THỐNG NHÀ TRỌ AN BÌNH') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Khẩu hiệu (Slogan)</label>
                            <input type="text" name="settings[site_slogan]" class="form-control" value="<?= htmlspecialchars($settings['site_slogan'] ?? 'Phòng Trọ Tiện Nghi - An Ninh - Văn Minh') ?>">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Hotline hỗ trợ 24/7</label>
                            <input type="text" name="settings[hotline]" class="form-control" value="<?= htmlspecialchars($settings['hotline'] ?? '0901.234.567') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email tiếp nhận thông tin</label>
                            <input type="email" name="settings[email]" class="form-control" value="<?= htmlspecialchars($settings['email'] ?? 'hotro@phongtroanbinh.com') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Địa chỉ trụ sở điều hành</label>
                        <input type="text" name="settings[address]" class="form-control" value="<?= htmlspecialchars($settings['address'] ?? 'Số 26 Ngõ 165 Cầu Giấy, TP. Hà Nội') ?>" required>
                    </div>
                </div>

                <div class="mb-4 pt-3 border-top">
                    <h6 class="fw-bold text-success mb-3"><i class="fas fa-qrcode me-2"></i>2. Cấu Hình Tài Khoản Ngân Hàng Nhận Tiền VietQR</h6>
                    <p class="text-muted small mb-3">Hệ thống sẽ tự động ghép thông tin số tài khoản, mã BIN ngân hàng và số tiền hóa đơn để sinh ra mã VietQR động chuẩn NAPAS 24/7 cho khách quét.</p>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tên Ngân Hàng</label>
                            <input type="text" name="settings[bank_name]" class="form-control" value="<?= htmlspecialchars($settings['bank_name'] ?? 'MBBANK') ?>" placeholder="MBBANK, Vietcombank, Techcombank..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Mã BIN Ngân Hàng (NAPAS)</label>
                            <input type="text" name="settings[bank_bin]" class="form-control" value="<?= htmlspecialchars($settings['bank_bin'] ?? '970422') ?>" placeholder="970422 (MB), 970436 (VCB)..." required>
                            <small class="text-muted">Mã BIN MBBank là 970422, Vietcombank là 970436, VPBank là 970432</small>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Số Tài Khoản Nhận Tiền</label>
                            <input type="text" name="settings[bank_account]" class="form-control" value="<?= htmlspecialchars($settings['bank_account'] ?? '0901234567') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Tên Chủ Tài Khoản (In hoa không dấu)</label>
                            <input type="text" name="settings[bank_owner]" class="form-control" value="<?= htmlspecialchars($settings['bank_owner'] ?? 'NGUYEN VAN QUAN TRI') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="mb-4 pt-3 border-top">
                    <h6 class="fw-bold text-warning mb-3">3. Nội Quy Tòa Nhà Chung</h6>
                    <textarea name="settings[rules]" class="form-control" rows="4"><?= htmlspecialchars($settings['rules'] ?? '') ?></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill fw-bold">
                        <i class="fas fa-save me-1"></i> Lưu Cấu Hình Hệ Thống
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border rounded-4 p-4 shadow-sm bg-white text-center">
            <h6 class="fw-bold mb-2">Xem Thử Mã VietQR Tự Động</h6>
            <p class="text-muted small mb-3">Mã demo quét thử với số tiền 500.000 đ</p>

            <img src="<?= vietQrUrl($settings['bank_bin'] ?? '970422', $settings['bank_account'] ?? '0901234567', 500000, 'DEMO QUANLYPHONGTRO') ?>" class="img-fluid rounded border p-2 mb-3" style="max-width: 220px;" alt="VietQR Demo">

            <div class="text-start bg-light p-3 rounded-3 border small">
                <div>Ngân hàng: <strong><?= htmlspecialchars($settings['bank_name'] ?? 'MBBANK') ?></strong></div>
                <div>Số tài khoản: <strong><?= htmlspecialchars($settings['bank_account'] ?? '0901234567') ?></strong></div>
                <div>Chủ TK: <strong><?= htmlspecialchars($settings['bank_owner'] ?? 'NGUYEN VAN QUAN TRI') ?></strong></div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
