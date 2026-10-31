<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Cổng Khách Thuê</h2>
            <p class="text-muted mb-0">Xin chào, <strong><?= htmlspecialchars(Auth::user()['full_name']) ?></strong>! Chúc bạn một ngày tốt lành.</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/tenant/maintenance" class="btn btn-outline-danger rounded-pill fw-bold btn-sm">
                <i class="fas fa-wrench me-1"></i> Báo Hỏng / Sửa Chữa
            </a>
        </div>
    </div>

    <!-- Thông tin phòng đang thuê -->
    <div class="card border rounded-4 p-4 shadow-sm bg-white mb-4">
        <?php if (!empty($tenant['room_id'])): ?>
            <div class="row align-items-center">
                <div class="col-md-3 mb-3 mb-md-0">
                    <img src="<?= BASE_URL ?>/<?= $tenant['room_image'] ?: 'assets/images/rooms/room1.jpg' ?>" class="img-fluid rounded-3 shadow-sm" style="max-height: 180px; width: 100%; object-fit: cover;" alt="Phòng">
                </div>
                <div class="col-md-6 mb-3 mb-md-0">
                    <span class="badge bg-success mb-2"><i class="fas fa-check-circle me-1"></i> Hợp đồng đang hiệu lực</span>
                    <h4 class="fw-bold mb-1"><?= htmlspecialchars($tenant['room_title']) ?> (<?= $tenant['room_number'] ?>)</h4>
                    <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?= htmlspecialchars($tenant['branch_name']) ?> - <?= htmlspecialchars($tenant['branch_address']) ?></p>
                    <div class="d-flex flex-wrap gap-3 small text-secondary">
                        <span><i class="fas fa-vector-square text-primary me-1"></i> <?= $tenant['area'] ?> m²</span>
                        <span><i class="fas fa-calendar-alt text-primary me-1"></i> Thời hạn: <?= formatDate($tenant['start_date']) ?> - <?= formatDate($tenant['end_date']) ?></span>
                        <span><i class="fas fa-money-bill-wave text-success me-1"></i> <?= formatMoney($tenant['rental_price']) ?>/tháng</span>
                    </div>
                </div>
                <div class="col-md-3 text-md-end">
                    <p class="small text-muted mb-1">Quản lý cơ sở:</p>
                    <p class="fw-bold mb-1"><?= htmlspecialchars($tenant['manager_name'] ?? 'BQL An Bình') ?></p>
                    <a href="tel:<?= $tenant['manager_phone'] ?? '0901234567' ?>" class="btn btn-sm btn-outline-primary rounded-pill mb-2">
                        <i class="fas fa-phone-alt me-1"></i> <?= $tenant['manager_phone'] ?? '0901.234.567' ?>
                    </a>
                    <div>
                        <a href="<?= BASE_URL ?>/tenant/contract" class="small fw-bold text-decoration-underline">Xem chi tiết hợp đồng</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-4">
                <div class="stat-icon yellow mx-auto mb-2"><i class="fas fa-home"></i></div>
                <h5 class="fw-bold">Bạn chưa được gắn phòng thuê nào!</h5>
                <p class="text-muted small mb-3">Vui lòng liên hệ ban quản lý để hoàn tất thủ tục ký hợp đồng hoặc xem danh sách phòng còn trống.</p>
                <a href="<?= BASE_URL ?>/room" class="btn btn-primary-custom rounded-pill btn-sm">Xem phòng còn trống</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Hóa đơn gần đây -->
    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border rounded-4 p-4 shadow-sm bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-file-invoice-dollar text-primary me-2"></i>Hóa Đơn Cần Thanh Toán</h5>
                    <a href="<?= BASE_URL ?>/tenant/invoices" class="small fw-bold">Xem tất cả</a>
                </div>
                
                <?php if (empty($invoices)): ?>
                    <p class="text-muted small text-center py-4">Chưa có hóa đơn nào phát sinh.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small">
                                <tr>
                                    <th>Mã HĐ</th>
                                    <th>Kỳ</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($invoices as $inv): ?>
                                    <tr>
                                        <td class="fw-bold small"><?= $inv['invoice_code'] ?></td>
                                        <td class="small">Tháng <?= $inv['month'] ?>/<?= $inv['year'] ?></td>
                                        <td class="fw-bold text-primary"><?= formatMoney($inv['total_amount']) ?></td>
                                        <td><?= invoiceStatusBadge($inv['status']) ?></td>
                                        <td class="text-end">
                                            <a href="<?= BASE_URL ?>/tenant/invoiceDetail/<?= $inv['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill">
                                                Xem & Trả <i class="fas fa-chevron-right ms-1"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border rounded-4 p-4 shadow-sm bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-tools text-warning me-2"></i>Sự Cố Đã Gửi</h5>
                    <a href="<?= BASE_URL ?>/tenant/maintenance" class="small fw-bold">Báo hỏng mới</a>
                </div>

                <?php if (empty($maintenances)): ?>
                    <p class="text-muted small text-center py-4">Không có yêu cầu sự cố nào đang chờ xử lý.</p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($maintenances as $req): ?>
                            <div class="p-3 border rounded-3 bg-light">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="fw-bold small mb-0"><?= htmlspecialchars($req['title']) ?></h6>
                                    <?= maintenanceStatusBadge($req['status']) ?>
                                </div>
                                <p class="small text-muted mb-2"><?= truncateText($req['description'], 70) ?></p>
                                <small class="text-secondary"><i class="far fa-clock me-1"></i> <?= formatDateTime($req['created_at']) ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
