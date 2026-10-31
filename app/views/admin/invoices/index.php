<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h5 class="fw-bold mb-1"><i class="fas fa-file-invoice-dollar text-primary me-2"></i>Quản Lý Hóa Đơn & Tiền Phòng</h5>
            <p class="text-muted small mb-0">Theo dõi công nợ, xuất hóa đơn tự động và cập nhật trạng thái thanh toán</p>
        </div>
        <div>
            <!-- Form tự động lập hóa đơn -->
            <form action="<?= BASE_URL ?>/admin/invoiceGenerate" method="POST" class="d-inline-flex gap-2">
                <input type="hidden" name="month" value="<?= $filters['month'] ?>">
                <input type="hidden" name="year" value="<?= $filters['year'] ?>">
                <button type="submit" class="btn btn-success rounded-pill btn-sm fw-bold">
                    <i class="fas fa-magic me-1"></i> Tự Động Lập Hóa Đơn Tháng <?= $filters['month'] ?>
                </button>
            </form>
        </div>
    </div>

    <!-- Filter form -->
    <form action="<?= BASE_URL ?>/admin/invoices" method="GET" class="row g-2 mb-4 p-3 bg-light rounded-3 border">
        <div class="col-md-3 col-6">
            <label class="form-label small fw-bold text-muted">Tháng</label>
            <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= $m ?>" <?= $m == $filters['month'] ? 'selected' : '' ?>>Tháng <?= $m ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-3 col-6">
            <label class="form-label small fw-bold text-muted">Năm</label>
            <input type="number" name="year" class="form-control form-control-sm" value="<?= $filters['year'] ?>" onchange="this.form.submit()">
        </div>
        <div class="col-md-3 col-6">
            <label class="form-label small fw-bold text-muted">Trạng thái thanh toán</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Tất cả trạng thái</option>
                <option value="paid" <?= $filters['status'] === 'paid' ? 'selected' : '' ?>>Đã thanh toán</option>
                <option value="unpaid" <?= $filters['status'] === 'unpaid' ? 'selected' : '' ?>>Chưa thanh toán</option>
            </select>
        </div>
        <div class="col-md-3 col-6 d-flex align-items-end">
            <button type="submit" class="btn btn-outline-primary btn-sm w-100 rounded-pill fw-bold">
                <i class="fas fa-filter me-1"></i> Lọc Dữ Liệu
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Mã HĐ</th>
                    <th>Phòng</th>
                    <th>Khách thuê</th>
                    <th>Tiền phòng</th>
                    <th>Điện</th>
                    <th>Nước</th>
                    <th>Dịch vụ</th>
                    <th>Tổng tiền</th>
                    <th>Hạn nộp</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($invoices)): ?>
                    <tr>
                        <td colspan="11" class="text-center py-4 text-muted">Không có hóa đơn nào phù hợp với bộ lọc.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($invoices as $inv): ?>
                        <tr>
                            <td><strong class="text-primary"><?= $inv['invoice_code'] ?></strong></td>
                            <td>
                                <strong class="badge bg-light text-dark border"><?= $inv['room_number'] ?></strong>
                                <small class="text-muted d-block"><?= htmlspecialchars($inv['branch_name']) ?></small>
                            </td>
                            <td>
                                <strong class="d-block"><?= htmlspecialchars($inv['tenant_name']) ?></strong>
                                <small class="text-muted"><?= htmlspecialchars($inv['tenant_phone']) ?></small>
                            </td>
                            <td><?= formatMoney($inv['room_amount']) ?></td>
                            <td><?= formatMoney($inv['electricity_amount']) ?></td>
                            <td><?= formatMoney($inv['water_amount']) ?></td>
                            <td><?= formatMoney($inv['service_amount']) ?></td>
                            <td class="fw-bold text-primary fs-6"><?= formatMoney($inv['total_amount']) ?></td>
                            <td class="small"><?= formatDate($inv['due_date']) ?></td>
                            <td><?= invoiceStatusBadge($inv['status']) ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL ?>/admin/invoiceDetail/<?= $inv['id'] ?>" class="btn btn-sm btn-outline-primary btn-action me-1" title="Chi tiết & In">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if ($inv['status'] === 'unpaid'): ?>
                                    <a href="<?= BASE_URL ?>/admin/invoiceStatus/<?= $inv['id'] ?>?status=paid&method=Tiền+mặt" class="btn btn-sm btn-outline-success btn-action me-1" title="Xác nhận đã thu tiền">
                                        <i class="fas fa-check"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="<?= BASE_URL ?>/admin/invoiceStatus/<?= $inv['id'] ?>?status=unpaid" class="btn btn-sm btn-outline-warning btn-action me-1" title="Đánh dấu chưa thanh toán">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
