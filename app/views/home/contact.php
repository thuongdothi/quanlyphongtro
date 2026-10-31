<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="bg-primary-light py-5 border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Liên Hệ & Góp Ý</h1>
        <p class="text-muted mb-0">Ban Quản Lý Nhà Trọ An Bình luôn sẵn sàng lắng nghe và hỗ trợ bạn</p>
    </div>
</div>

<div class="container py-5">
    <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= $success ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-5">
        <div class="col-lg-5">
            <h3 class="fw-bold mb-3">Thông Tin Liên Hệ</h3>
            <p class="text-muted mb-4">Bạn đang tìm phòng trọ hoặc cần tư vấn thông tin chi tiết? Hãy liên hệ ngay với chúng tôi qua các kênh sau:</p>

            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="stat-icon blue">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Trụ Sở Chính</h6>
                    <p class="text-muted small mb-0"><?= htmlspecialchars($settings['address'] ?? 'Số 26 Ngõ 165 Cầu Giấy, TP. Hà Nội') ?></p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="stat-icon green">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Hotline Hỗ Trợ 24/7</h6>
                    <p class="text-muted small mb-0"><a href="tel:<?= $settings['hotline'] ?? '0901234567' ?>" class="fw-bold text-success"><?= htmlspecialchars($settings['hotline'] ?? '0901.234.567') ?></a></p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="stat-icon yellow">
                    <i class="fas fa-envelope"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Hòm Thư Điện Tử</h6>
                    <p class="text-muted small mb-0"><?= htmlspecialchars($settings['email'] ?? 'hotro@phongtroanbinh.com') ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border rounded-4 p-4 shadow-sm bg-white">
                <h4 class="fw-bold mb-3"><i class="fas fa-paper-plane text-primary me-2"></i>Gửi Tin Nhắn Cho Chúng Tôi</h4>
                <form action="<?= BASE_URL ?>/home/contact" method="POST">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="form-control" placeholder="Nguyễn Văn A" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="0901234567" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Tiêu đề liên hệ</label>
                            <input type="text" name="subject" class="form-control" placeholder="Hỏi thăm thuê phòng...">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Nội dung liên hệ <span class="text-danger">*</span></label>
                        <textarea name="message" rows="5" class="form-control" placeholder="Nhập câu hỏi hoặc yêu cầu của bạn..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill fw-bold">
                        <i class="fas fa-paper-plane me-1"></i> Gửi Tin Nhắn
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
