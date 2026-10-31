    <!-- Footer -->
    <footer class="footer-main">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <i class="fas fa-home text-primary"></i> NHÀ TRỌ AN BÌNH
                    </div>
                    <p class="text-secondary small mb-3">
                        Hệ thống chuỗi phòng trọ cao cấp, hiện đại, an ninh bậc nhất tại Hà Nội và TP. Hồ Chí Minh. Giờ giấc tự do, khóa vân tay 24/7, không chung chủ, dịch vụ chuyên nghiệp.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Liên Kết Nhanh</h5>
                    <ul class="footer-links">
                        <li><a href="<?= BASE_URL ?>/">Trang Chủ</a></li>
                        <li><a href="<?= BASE_URL ?>/room">Tìm Phòng Trọ</a></li>
                        <li><a href="<?= BASE_URL ?>/home/about">Về Chúng Tôi</a></li>
                        <li><a href="<?= BASE_URL ?>/home/news">Cẩm Nang Thuê Trọ</a></li>
                        <li><a href="<?= BASE_URL ?>/home/contact">Liên Hệ & Góp Ý</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Các Cơ Sở Trọ</h5>
                    <ul class="footer-links small">
                        <li><i class="fas fa-map-pin text-primary me-2"></i><strong>CS 1:</strong> 26 Ngõ 165 Cầu Giấy, Hà Nội</li>
                        <li><i class="fas fa-map-pin text-primary me-2"></i><strong>CS 2:</strong> 158/24 Xô Viết Nghệ Tĩnh, Bình Thạnh, TP.HCM</li>
                        <li><i class="fas fa-map-pin text-primary me-2"></i><strong>CS 3:</strong> 497/12 Sư Vạn Hạnh, Q.10, TP.HCM</li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Hỗ Trợ Khách Hàng</h5>
                    <p class="small mb-2"><i class="fas fa-phone-alt text-primary me-2"></i> Hotline: <strong class="text-white">0901.234.567</strong></p>
                    <p class="small mb-2"><i class="fas fa-envelope text-primary me-2"></i> Email: hotro@phongtroanbinh.com</p>
                    <p class="small mb-3"><i class="fas fa-clock text-primary me-2"></i> Phục vụ: 24/7 (Cả ngày lễ & Chủ nhật)</p>
                    <div class="p-3 rounded bg-dark border border-secondary">
                        <small class="text-light d-block fw-bold mb-1">Tài khoản hỗ trợ trực tuyến</small>
                        <small class="text-secondary d-block">Admin: <code>admin</code> / <code>admin123</code></small>
                        <small class="text-secondary d-block">Khách thuê: <code>khach1</code> / <code>123456</code></small>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-top border-secondary text-center small text-secondary">
                <p class="mb-0">© <?= date('Y') ?> Đồ Án Chuyên Đề PHP & MySQL - Đề Tài Quản Lý Phòng Trọ - Mô hình MVC Điểm A. Thiết kế chuẩn Responsive.</p>
            </div>
        </div>
    </footer>

    <!-- Nút gọi điện nhanh nổi góc màn hình -->
    <a href="tel:0901234567" class="floating-hotline" title="Gọi hotline hỗ trợ">
        <i class="fas fa-phone"></i>
    </a>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom Main JS -->
    <script src="<?= BASE_URL ?>/assets/js/main.js"></script>
</body>
</html>
