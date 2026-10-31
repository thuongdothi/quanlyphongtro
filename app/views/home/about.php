<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="bg-primary-light py-5 border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Giới Thiệu Về Nhà Trọ An Bình</h1>
        <p class="text-muted mb-0">Hệ thống phòng trọ hiện đại, an toàn và chuyên nghiệp hàng đầu</p>
    </div>
</div>

<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 fw-bold">SỨ MỆNH CỦA CHÚNG TÔI</span>
            <h2 class="fw-bold mb-3">Kiến Tạo Không Gian Sống Tiện Nghi Cho Mọi Khách Thuê</h2>
            <p class="text-muted">
                Được thành lập với mục tiêu nâng tầm chất lượng cuộc sống cho sinh viên và người đi làm, <strong>Hệ Thống Nhà Trọ An Bình</strong> không ngừng đầu tư nâng cấp cơ sở vật chất, áp dụng công nghệ số vào quy trình quản lý nhằm mang đến trải nghiệm sống văn minh, an toàn và minh bạch.
            </p>
            <p class="text-muted">
                Tại An Bình, chúng tôi tin rằng một nơi ở tốt không chỉ là chỗ ngả lưng sau ngày dài làm việc và học tập, mà còn là tổ ấm để bạn yên tâm phát triển tương lai.
            </p>
            <div class="row g-3 mt-2">
                <div class="col-6">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle text-success fa-lg"></i>
                        <span class="fw-semibold">Giờ giấc tự do 24/7</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle text-success fa-lg"></i>
                        <span class="fw-semibold">Không chung chủ</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle text-success fa-lg"></i>
                        <span class="fw-semibold">Khóa cổng vân tay</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle text-success fa-lg"></i>
                        <span class="fw-semibold">Minh bạch điện nước</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <img src="<?= BASE_URL ?>/assets/images/rooms/room2.jpg" class="img-fluid rounded-4 shadow" alt="Nhà trọ An Bình">
        </div>
    </div>

    <!-- Nội quy hệ thống -->
    <div class="card border-0 bg-light rounded-4 p-4 p-md-5 mb-5">
        <h3 class="fw-bold mb-4 text-center"><i class="fas fa-clipboard-list text-primary me-2"></i>Nội Quy Chung Tại Tòa Nhà</h3>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="p-3 bg-white rounded-3 border">
                    <h6 class="fw-bold text-primary mb-2"><i class="fas fa-shield-alt me-2"></i>1. An ninh & Trật tự</h6>
                    <p class="small text-muted mb-0">Tự giác bảo vệ tài sản cá nhân. Sau 23h đêm, vui lòng giảm âm lượng nhạc, tivi và không gây ồn ào ảnh hưởng phòng kế bên.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-white rounded-3 border">
                    <h6 class="fw-bold text-primary mb-2"><i class="fas fa-fire-extinguisher me-2"></i>2. Phòng cháy chữa cháy</h6>
                    <p class="small text-muted mb-0">Tuyệt đối không sử dụng bếp gas mini. Ngắt cầu dao điện và khóa vòi nước khi ra khỏi phòng dài ngày.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-white rounded-3 border">
                    <h6 class="fw-bold text-primary mb-2"><i class="fas fa-recycle me-2"></i>3. Vệ sinh môi trường</h6>
                    <p class="small text-muted mb-0">Buộc kín túi rác và để đúng nơi quy định tại mỗi tầng. Giữ gìn vệ sinh chung hành lang, cầu thang và khu vực để xe.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-white rounded-3 border">
                    <h6 class="fw-bold text-primary mb-2"><i class="fas fa-credit-card me-2"></i>4. Thanh toán hóa đơn</h6>
                    <p class="small text-muted mb-0">Thanh toán tiền thuê phòng và điện nước đúng hạn từ ngày 1 đến ngày 5 hàng tháng qua cổng VietQR trên hệ thống.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
