<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/tenant">Cổng khách thuê</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hóa đơn tiền phòng</li>
        </ol>
    </nav>

    <div class="card border rounded-4 p-4 shadow-sm bg-white">
        <h4 class="fw-bold mb-3"><i class="fas fa-file-invoice-dollar text-primary me-2"></i>Lịch Sử Hóa Đơn & Tiền Phòng</h4>
        
        <?php if (empty($invoices)): ?>
            <div class="text-center py-5">
                <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                <h5 class="fw-bold">Chưa có hóa đơn nào!</h5>
                <p class="text-muted small">Hóa đơn sẽ được hệ thống tự động lập và gửi đến bạn vào cuối mỗi tháng.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã hóa đơn</th>
                            <th>Kỳ thu</th>
                            <th>Phòng</th>
                            <th>Tiền phòng</th>
                            <th>Tiền điện</th>
                            <th>Tiền nước</th>
                            <th>Dịch vụ</th>
                            <th>Tổng thanh toán</th>
                            <th>Hạn nộp</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $inv): ?>
                            <tr>
                                <td class="fw-bold"><?= $inv['invoice_code'] ?></td>
                                <td>Tháng <?= $inv['month'] ?>/<?= $inv['year'] ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $inv['room_number'] ?></span></td>
                                <td><?= formatMoney($inv['room_amount']) ?></td>
                                <td><?= formatMoney($inv['electricity_amount']) ?></td>
                                <td><?= formatMoney($inv['water_amount']) ?></td>
                                <td><?= formatMoney($inv['service_amount']) ?></td>
                                <td class="fw-bold text-primary"><?= formatMoney($inv['total_amount']) ?></td>
                                <td class="small"><?= formatDate($inv['due_date']) ?></td>
                                <td><?= invoiceStatusBadge($inv['status']) ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>/tenant/invoiceDetail/<?= $inv['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill fw-bold">
                                        Chi tiết & QR <i class="fas fa-chevron-right ms-1"></i>
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

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
