<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/room">Phòng trọ</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($room['room_number']) ?></li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Main details -->
        <div class="col-lg-8">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <h1 class="fw-bold mb-1"><?= htmlspecialchars($room['title']) ?> (<?= $room['room_number'] ?>)</h1>
                    <p class="text-muted mb-0"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?= htmlspecialchars($room['branch_address']) ?>, <?= htmlspecialchars($room['city']) ?></p>
                </div>
                <div>
                    <?= roomStatusBadge($room['status']) ?>
                </div>
            </div>

            <!-- Big Main Photo -->
            <div class="mb-4 overflow-hidden rounded-4 shadow-sm border">
                <img src="<?= BASE_URL ?>/<?= $room['image'] ?: 'assets/images/rooms/room1.jpg' ?>" class="img-fluid w-100" style="max-height: 480px; object-fit: cover;" alt="<?= htmlspecialchars($room['title']) ?>">
            </div>

            <!-- Quick Specs Card -->
            <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4">
                <h5 class="fw-bold mb-3 pb-2 border-bottom"><i class="fas fa-info-circle text-primary me-2"></i>Thông Số Cơ Bản</h5>
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <div class="p-2 border rounded bg-light text-center">
                            <small class="text-muted d-block">Giá thuê</small>
                            <strong class="text-primary fs-5"><?= formatMoney($room['price']) ?></strong>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-2 border rounded bg-light text-center">
                            <small class="text-muted d-block">Tiền đặt cọc</small>
                            <strong class="text-dark fs-5"><?= formatMoney($room['deposit_price']) ?></strong>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-2 border rounded bg-light text-center">
                            <small class="text-muted d-block">Diện tích</small>
                            <strong class="text-dark fs-5"><?= $room['area'] ?> m²</strong>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="p-2 border rounded bg-light text-center">
                            <small class="text-muted d-block">Vị trí tầng</small>
                            <strong class="text-dark fs-5">Tầng <?= $room['floor'] ?></strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Amenities -->
            <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4">
                <h5 class="fw-bold mb-3 pb-2 border-bottom"><i class="fas fa-couch text-primary me-2"></i>Tiện Nghi Có Sẵn</h5>
                <div class="row g-2">
                    <?php if (!empty($amenities)): ?>
                        <?php foreach ($amenities as $am): ?>
                            <div class="col-md-4 col-6">
                                <div class="d-flex align-items-center gap-2 p-2 border rounded bg-light">
                                    <i class="fas fa-check-circle text-success"></i>
                                    <span class="small fw-semibold"><?= htmlspecialchars($am) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">Tiện nghi cơ bản, vệ sinh khép kín.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Description -->
            <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4">
                <h5 class="fw-bold mb-3 pb-2 border-bottom"><i class="fas fa-align-left text-primary me-2"></i>Mô Tả Chi Tiết</h5>
                <div class="text-muted" style="line-height: 1.8;">
                    <?= nl2br(htmlspecialchars($room['description'] ?? 'Chưa có mô tả chi tiết cho phòng này.')) ?>
                </div>
            </div>

            <!-- Utility Rates Table -->
            <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4">
                <h5 class="fw-bold mb-3 pb-2 border-bottom"><i class="fas fa-bolt text-warning me-2"></i>Biểu Phí Điện Nước & Dịch Vụ</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Dịch vụ</th>
                                <th>Đơn giá</th>
                                <th>Đơn vị tính</th>
                                <th>Hình thức tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $srv): ?>
                                <tr>
                                    <td class="fw-semibold"><?= htmlspecialchars($srv['name']) ?></td>
                                    <td class="text-primary fw-bold"><?= formatMoney($srv['price']) ?></td>
                                    <td><?= htmlspecialchars($srv['unit']) ?></td>
                                    <td>
                                        <span class="badge <?= $srv['type'] === 'meter' ? 'bg-info' : 'bg-secondary' ?>">
                                            <?= $srv['type'] === 'meter' ? 'Theo đồng hồ' : 'Cố định hàng tháng' ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Contact & Booking -->
        <div class="col-lg-4">
            <div class="card border rounded-4 p-4 shadow-sm bg-white sticky-top" style="top: 90px;">
                <div class="text-center pb-3 mb-3 border-bottom">
                    <small class="text-muted d-block">Giá thuê niêm yết</small>
                    <h2 class="text-primary fw-extrabold mb-1"><?= formatMoney($room['price']) ?></h2>
                    <small class="text-muted">/tháng (Chưa gồm điện nước)</small>
                </div>

                <?php if ($room['status'] === 'available'): ?>
                    <button type="button" class="btn btn-primary-custom w-100 py-3 rounded-pill fw-bold mb-3 shadow" data-bs-toggle="modal" data-bs-target="#bookingModal">
                        <i class="fas fa-calendar-alt me-2"></i> Hẹn Lịch Xem Phòng Miễn Phí
                    </button>
                <?php else: ?>
                    <div class="alert alert-warning text-center small mb-3">
                        <i class="fas fa-info-circle me-1"></i> Phòng này hiện đang có người thuê. Bạn có thể tham khảo các phòng tương tự bên dưới.
                    </div>
                <?php endif; ?>

                <a href="tel:<?= htmlspecialchars($room['manager_phone'] ?? '0901234567') ?>" class="btn btn-outline-success w-100 py-2 rounded-pill fw-bold mb-4">
                    <i class="fas fa-phone-alt me-2"></i> Gọi Quản Lý: <?= htmlspecialchars($room['manager_phone'] ?? '0901234567') ?>
                </a>

                <div class="p-3 bg-light rounded-3 border">
                    <h6 class="fw-bold mb-2"><i class="fas fa-shield-alt text-primary me-2"></i>Cam Kết Của Nhà Trọ:</h6>
                    <ul class="list-unstyled small text-muted mb-0 d-flex flex-column gap-2">
                        <li><i class="fas fa-check text-success me-2"></i> Hợp đồng pháp lý rõ ràng, minh bạch</li>
                        <li><i class="fas fa-check text-success me-2"></i> Không tăng giá thuê bất hợp lý</li>
                        <li><i class="fas fa-check text-success me-2"></i> Hỗ trợ sửa chữa sự cố trong 24h</li>
                        <li><i class="fas fa-check text-success me-2"></i> Giờ giấc tự do, chìa khóa trao tay</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Đặt Lịch Xem Phòng -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="bookingModalLabel"><i class="fas fa-calendar-check me-2"></i>Hẹn Lịch Xem Phòng <?= $room['room_number'] ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bookingModalForm" action="<?= BASE_URL ?>/room/book" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="room_id" value="<?= $room['id'] ?>">
                    <input type="hidden" name="room_slug" value="<?= $room['slug'] ?>">

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" placeholder="Nguyễn Văn A" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" placeholder="0901234567" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="name@gmail.com">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Ngày hẹn xem <span class="text-danger">*</span></label>
                            <input type="date" name="booking_date" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Giờ hẹn <span class="text-danger">*</span></label>
                            <select name="booking_time" class="form-select" required>
                                <option value="09:00">09:00 Sáng</option>
                                <option value="10:30">10:30 Sáng</option>
                                <option value="14:00">14:00 Chiều</option>
                                <option value="16:00">16:00 Chiều</option>
                                <option value="18:00" selected>18:00 Tối</option>
                                <option value="19:30">19:30 Tối</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Ghi chú thêm</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Ví dụ: Mình đi 2 người, muốn chuyển vào đầu tháng sau..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary-custom rounded-pill px-4">
                        <i class="fas fa-paper-plane me-1"></i> Xác Nhận Đặt Lịch
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
