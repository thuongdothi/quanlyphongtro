<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<!-- Top Summary Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6">
        <div class="stat-card-admin">
            <div>
                <small class="text-muted fw-bold d-block text-uppercase">Tổng số phòng</small>
                <h3 class="fw-bold mb-0 text-dark"><?= $totalRooms ?></h3>
                <small class="text-success"><i class="fas fa-check-circle me-1"></i><?= $availableRooms ?> phòng trống</small>
            </div>
            <div class="stat-icon blue">
                <i class="fas fa-door-open"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="stat-card-admin">
            <div>
                <small class="text-muted fw-bold d-block text-uppercase">Phòng đang thuê</small>
                <h3 class="fw-bold mb-0 text-dark"><?= $rentedRooms ?></h3>
                <small class="text-primary"><i class="fas fa-file-contract me-1"></i><?= $activeContracts ?> hợp đồng hiệu lực</small>
            </div>
            <div class="stat-icon green">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="stat-card-admin">
            <div>
                <small class="text-muted fw-bold d-block text-uppercase">Doanh thu tháng <?= date('m/Y') ?></small>
                <h3 class="fw-bold mb-0 text-primary" style="font-size: 1.45rem;"><?= formatMoney($monthRevenue) ?></h3>
                <small class="text-success">Đã thu: <?= formatMoney($paidRevenue) ?></small>
            </div>
            <div class="stat-icon yellow">
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="stat-card-admin">
            <div>
                <small class="text-muted fw-bold d-block text-uppercase">Cần xử lý</small>
                <h3 class="fw-bold mb-0 text-danger"><?= $pendingBookings + $pendingMaintenances ?></h3>
                <small class="text-muted"><?= $pendingBookings ?> lịch hẹn • <?= $pendingMaintenances ?> sự cố</small>
            </div>
            <div class="stat-icon red">
                <i class="fas fa-bell"></i>
            </div>
        </div>
    </div>
</div>

<!-- Revenue Chart Section -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card border rounded-4 p-4 shadow-sm bg-white h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-chart-bar text-primary me-2"></i>Biểu Đồ Doanh Thu Năm <?= date('Y') ?> (VNĐ)</h6>
                <span class="badge bg-light text-muted border">Tự động đồng bộ từ Hóa đơn</span>
            </div>
            <div style="height: 300px; position: relative;">
                <canvas id="revenueChartCanvas" data-chart-json='<?= json_encode($revenueChart) ?>'></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border rounded-4 p-4 shadow-sm bg-white h-100">
            <h6 class="fw-bold mb-3"><i class="fas fa-pie-chart text-success me-2"></i>Tỷ Lệ Lấp Đầy Phòng</h6>
            
            <div class="d-flex flex-column gap-3 my-auto">
                <div>
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span>Đang thuê (<?= $rentedRooms ?> phòng)</span>
                        <span class="text-primary"><?= $totalRooms > 0 ? round(($rentedRooms / $totalRooms) * 100) : 0 ?>%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $totalRooms > 0 ? ($rentedRooms / $totalRooms) * 100 : 0 ?>%"></div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span>Còn trống (<?= $availableRooms ?> phòng)</span>
                        <span class="text-success"><?= $totalRooms > 0 ? round(($availableRooms / $totalRooms) * 100) : 0 ?>%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $totalRooms > 0 ? ($availableRooms / $totalRooms) * 100 : 0 ?>%"></div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between small fw-bold mb-1">
                        <span>Đang bảo trì (<?= $maintenanceRooms ?> phòng)</span>
                        <span class="text-warning"><?= $totalRooms > 0 ? round(($maintenanceRooms / $totalRooms) * 100) : 0 ?>%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $totalRooms > 0 ? ($maintenanceRooms / $totalRooms) * 100 : 0 ?>%"></div>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-top mt-3 text-center">
                <a href="<?= BASE_URL ?>/admin/rooms" class="btn btn-sm btn-outline-primary rounded-pill w-100 fw-bold">
                    Quản lý danh sách phòng <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings and Maintenances -->
<div class="row g-4">
    <!-- Lịch hẹn xem phòng gần nhất -->
    <div class="col-lg-6">
        <div class="card border rounded-4 p-4 shadow-sm bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-calendar-check text-primary me-2"></i>Lịch Hẹn Xem Phòng Mới Nhất</h6>
                <a href="<?= BASE_URL ?>/admin/bookings" class="small fw-bold">Xem tất cả</a>
            </div>

            <?php if (empty($recentBookings)): ?>
                <p class="text-muted small text-center py-4">Chưa có lịch hẹn nào.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Khách hẹn</th>
                                <th>Phòng</th>
                                <th>Ngày hẹn</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentBookings as $bk): ?>
                                <tr>
                                    <td>
                                        <strong class="d-block"><?= htmlspecialchars($bk['full_name']) ?></strong>
                                        <span class="text-muted"><?= htmlspecialchars($bk['phone']) ?></span>
                                    </td>
                                    <td><span class="badge bg-light text-dark border"><?= $bk['room_number'] ?></span></td>
                                    <td><?= formatDate($bk['booking_date']) ?> (<?= $bk['booking_time'] ?>)</td>
                                    <td><?= bookingStatusBadge($bk['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sự cố cần khắc phục gần nhất -->
    <div class="col-lg-6">
        <div class="card border rounded-4 p-4 shadow-sm bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-wrench text-danger me-2"></i>Yêu Cầu Sửa Chữa Mới</h6>
                <a href="<?= BASE_URL ?>/admin/maintenance" class="small fw-bold">Xem tất cả</a>
            </div>

            <?php if (empty($recentMaintenances)): ?>
                <p class="text-muted small text-center py-4">Hiện không có sự cố nào cần xử lý.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Phòng</th>
                                <th>Sự cố</th>
                                <th>Người báo</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentMaintenances as $mt): ?>
                                <tr>
                                    <td><span class="badge bg-light text-dark border"><?= $mt['room_number'] ?></span></td>
                                    <td>
                                        <strong class="d-block"><?= htmlspecialchars($mt['title']) ?></strong>
                                        <span class="text-muted"><?= truncateText($mt['description'], 45) ?></span>
                                    </td>
                                    <td><?= htmlspecialchars($mt['tenant_name']) ?></td>
                                    <td><?= maintenanceStatusBadge($mt['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
