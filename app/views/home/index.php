<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <span class="badge bg-primary px-3 py-2 rounded-pill mb-3 fw-bold">
                    <i class="fas fa-sparkles me-1"></i> GIẢI PHÁP THUÊ TRỌ THỜI ĐẠI MỚI
                </span>
                <h1 class="hero-title">Tìm Phòng Trọ Tiện Nghi, An Ninh & Giá Tốt Nhất</h1>
                <p class="hero-subtitle">
                    Hệ thống phòng trọ hiện đại tại Hà Nội và TP.HCM. Giờ giấc tự do, khóa vân tay an toàn, full nội thất cao cấp chỉ việc xách vali vào ở!
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="<?= BASE_URL ?>/room" class="btn btn-primary-custom btn-lg rounded-pill px-4">
                        <i class="fas fa-search me-2"></i> Khám Phá Phòng Ngay
                    </a>
                    <a href="<?= BASE_URL ?>/home/about" class="btn btn-outline-light btn-lg rounded-pill px-4">
                        <i class="fas fa-info-circle me-2"></i> Tìm Hiểu Thêm
                    </a>
                </div>
            </div>

            <!-- Quick Search Card -->
            <div class="col-lg-5">
                <div class="search-box-card">
                    <h4 class="fw-bold mb-3 text-dark"><i class="fas fa-sliders-h text-primary me-2"></i>Tìm Phòng Nhanh</h4>
                    <form action="<?= BASE_URL ?>/room" method="GET">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Từ khóa / Khu vực</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                                <input type="text" name="kw" class="form-control bg-light border-start-0" placeholder="Ví dụ: Cầu Giấy, Bình Thạnh, P.101...">
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Khu trọ / Cơ sở</label>
                                <select name="branch" class="form-select bg-light">
                                    <option value="">Tất cả cơ sở</option>
                                    <?php foreach ($branches as $b): ?>
                                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Loại phòng</label>
                                <select name="type" class="form-select bg-light">
                                    <option value="">Tất cả loại</option>
                                    <?php foreach ($roomTypes as $t): ?>
                                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Mức giá tối đa</label>
                                <select name="max_price" class="form-select bg-light">
                                    <option value="">Tất cả mức giá</option>
                                    <option value="3000000">Dưới 3 triệu</option>
                                    <option value="4000000">Dưới 4 triệu</option>
                                    <option value="5000000">Dưới 5 triệu</option>
                                    <option value="6000000">Dưới 6 triệu</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-muted">Trạng thái</label>
                                <select name="status" class="form-select bg-light">
                                    <option value="">Tất cả</option>
                                    <option value="available" selected>Còn trống</option>
                                    <option value="rented">Đang thuê</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 py-3 fw-bold rounded-pill">
                            <i class="fas fa-search me-1"></i> Tìm Kiếm Ngay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Counters -->
<section class="py-5" style="margin-top: -40px; position: relative; z-index: 10;">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-number"><?= $totalRooms ?>+</div>
                    <div class="stat-label">Tổng số phòng trọ</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-number text-success"><?= $availableRooms ?></div>
                    <div class="stat-label">Phòng đang sẵn sàng</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-number text-warning"><?= count($branches) ?></div>
                    <div class="stat-label">Cơ sở tại HN & TP.HCM</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-number text-info">99%</div>
                    <div class="stat-label">Khách thuê hài lòng</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Rooms -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary-subtle text-primary fw-bold px-3 py-2 rounded-pill mb-2">PHÒNG NỔI BẬT</span>
            <h2 class="section-title">Phòng Trọ Đang Được Quan Tâm Nhất</h2>
            <p class="section-desc">Không gian sống tiện nghi, sạch sẽ, thoáng mát với đầy đủ nội thất cao cấp.</p>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredRooms as $room): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="room-card">
                        <div class="room-thumb-wrapper">
                            <img src="<?= BASE_URL ?>/<?= $room['image'] ?: 'assets/images/rooms/room1.jpg' ?>" class="room-thumb" alt="<?= htmlspecialchars($room['title']) ?>">
                            <div class="room-badge-status"><?= roomStatusBadge($room['status']) ?></div>
                            <div class="room-badge-type"><?= htmlspecialchars($room['room_type_name']) ?></div>
                            <div class="room-price-tag"><?= formatMoney($room['price']) ?> <span style="font-size:0.75rem; color:#64748b; font-weight:normal;">/tháng</span></div>
                        </div>
                        <div class="room-body">
                            <h5 class="room-title">
                                <a href="<?= BASE_URL ?>/room/detail/<?= $room['slug'] ?>"><?= htmlspecialchars($room['title']) ?> (<?= $room['room_number'] ?>)</a>
                            </h5>
                            <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?= htmlspecialchars($room['branch_name']) ?> - <?= htmlspecialchars($room['city']) ?></p>
                            <div class="room-meta">
                                <div class="room-meta-item"><i class="fas fa-vector-square text-primary"></i> <?= $room['area'] ?> m²</div>
                                <div class="room-meta-item"><i class="fas fa-layer-group text-primary"></i> Tầng <?= $room['floor'] ?></div>
                                <div class="room-meta-item"><i class="fas fa-users text-primary"></i> Tối đa <?= $room['max_tenants'] ?> người</div>
                            </div>
                            <div class="room-footer">
                                <span class="small text-muted">Cọc: <strong><?= formatMoney($room['deposit_price']) ?></strong></span>
                                <a href="<?= BASE_URL ?>/room/detail/<?= $room['slug'] ?>" class="btn btn-sm btn-outline-primary fw-bold">Chi tiết <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?= BASE_URL ?>/room" class="btn btn-primary-custom px-5 py-3 rounded-pill fw-bold">
                Xem Tất Cả <?= $totalRooms ?> Phòng Trọ <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Branches Section -->
<section class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-success-subtle text-success fw-bold px-3 py-2 rounded-pill mb-2">VỊ TRÍ ĐẮC ĐỊA</span>
            <h2 class="section-title">Hệ Thống Các Tòa Nhà & Cơ Sở Trọ</h2>
            <p class="section-desc">Gần các trường đại học lớn, khu văn phòng và các tuyến đường huyết mạch.</p>
        </div>

        <div class="row g-4">
            <?php foreach ($branches as $branch): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border rounded-4 p-4 shadow-sm hover-shadow">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="stat-icon blue">
                                    <i class="fas fa-building"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0"><?= htmlspecialchars($branch['name']) ?></h5>
                                    <span class="badge bg-primary-subtle text-primary"><?= htmlspecialchars($branch['city']) ?></span>
                                </div>
                            </div>
                        </div>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-map-marker-alt text-danger me-1"></i> <?= htmlspecialchars($branch['address']) ?>, <?= htmlspecialchars($branch['ward'] ?? '') ?>, <?= htmlspecialchars($branch['district']) ?>
                        </p>
                        <p class="small text-secondary mb-4"><?= truncateText($branch['description'] ?? '', 110) ?></p>
                        
                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <div>
                                <span class="small text-muted">Sẵn sàng:</span>
                                <strong class="text-success"><?= $branch['available_rooms'] ?? 0 ?> phòng trống</strong>
                            </div>
                            <a href="<?= BASE_URL ?>/room?branch=<?= $branch['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill fw-bold">Xem phòng</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Reasons To Choose -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-warning-subtle text-warning-emphasis fw-bold px-3 py-2 rounded-pill mb-2">TIỆN ÍCH VƯỢT TRỘI</span>
            <h2 class="section-title">Vì Sao Bạn Nên Chọn Nhà Trọ An Bình?</h2>
            <p class="section-desc">Chúng tôi mang lại trải nghiệm thuê trọ văn minh, tiện nghi và hoàn toàn yên tâm.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 border h-100 text-center">
                    <div class="stat-icon green mx-auto mb-3">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <h5 class="fw-bold">Khóa Vân Tay & Camera 24/7</h5>
                    <p class="text-muted small">Cổng ra vào khóa vân tay thẻ từ hiện đại, hệ thống camera an ninh giám sát 24/24 ở mọi lối đi hành lang và bãi xe.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 border h-100 text-center">
                    <div class="stat-icon yellow mx-auto mb-3">
                        <i class="fas fa-couch"></i>
                    </div>
                    <h5 class="fw-bold">Full Nội Thất Tiện Nghi</h5>
                    <p class="text-muted small">Phòng trang bị sẵn máy lạnh Inverter, tủ lạnh, giường nệm, tủ quần áo, bình nóng lạnh, gác lửng, khu bếp riêng.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 border h-100 text-center">
                    <div class="stat-icon purple mx-auto mb-3">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <h5 class="fw-bold">Hóa Đơn & Quét Mã VietQR</h5>
                    <p class="text-muted small">Theo dõi điện nước minh bạch trên cổng khách thuê, thanh toán 1 chạm tiện lợi qua mã QR động không lo nhầm lẫn.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest News -->
<section class="py-5 bg-light border-top">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="badge bg-info-subtle text-info-emphasis fw-bold px-3 py-2 rounded-pill mb-2">TIN TỨC MỚI</span>
                <h3 class="fw-bold mb-0">Cẩm Nang & Kinh Nghiệm Thuê Trọ</h3>
            </div>
            <a href="<?= BASE_URL ?>/home/news" class="btn btn-outline-primary rounded-pill fw-bold">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        <div class="row g-4">
            <?php foreach ($posts as $post): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                        <img src="<?= BASE_URL ?>/<?= $post['image'] ?: 'assets/images/posts/post1.jpg' ?>" class="card-img-top" style="height: 190px; object-fit: cover;" alt="<?= htmlspecialchars($post['title']) ?>">
                        <div class="card-body p-4 d-flex flex-direction-column">
                            <div class="text-muted small mb-2"><i class="far fa-calendar-alt me-1"></i> <?= formatDate($post['created_at']) ?> • <i class="far fa-eye ms-2 me-1"></i> <?= $post['views'] ?> lượt xem</div>
                            <h5 class="card-title fw-bold mb-3">
                                <a href="<?= BASE_URL ?>/home/postDetail/<?= $post['slug'] ?>" class="text-dark"><?= htmlspecialchars($post['title']) ?></a>
                            </h5>
                            <p class="text-muted small mb-4"><?= truncateText($post['summary'], 95) ?></p>
                            <a href="<?= BASE_URL ?>/home/postDetail/<?= $post['slug'] ?>" class="mt-auto fw-bold small text-primary">Đọc tiếp <i class="fas fa-chevron-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
