<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="row g-4 justify-content-center">
    <div class="col-lg-8">
        <div class="card border rounded-4 p-4 p-md-5 shadow-sm bg-white">
            <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                <div>
                    <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-home me-2"></i><?= htmlspecialchars($settings['site_name'] ?? 'NHÀ TRỌ AN BÌNH') ?></h4>
                    <p class="text-muted small mb-0"><?= htmlspecialchars($settings['address'] ?? 'Hà Nội') ?> | Hotline: <?= htmlspecialchars($settings['hotline'] ?? '0901234567') ?></p>
                </div>
                <div class="text-end">
                    <h5 class="fw-bold mb-1">HÓA ĐƠN TIỀN TRỌ</h5>
                    <p class="text-muted small mb-0">Mã: <strong><?= $invoice['invoice_code'] ?></strong></p>
                    <div class="mt-1"><?= invoiceStatusBadge($invoice['status']) ?></div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <small class="text-muted d-block">Thông tin khách thuê:</small>
                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($invoice['tenant_name']) ?></h6>
                    <p class="small text-muted mb-0">Số điện thoại: <?= htmlspecialchars($invoice['tenant_phone']) ?></p>
                    <p class="small text-muted mb-0">Phòng: <strong>Phòng <?= $invoice['room_number'] ?></strong> (<?= htmlspecialchars($invoice['branch_name']) ?>)</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted d-block">Kỳ thanh toán:</small>
                    <h6 class="fw-bold mb-1">Tháng <?= $invoice['month'] ?> / <?= $invoice['year'] ?></h6>
                    <p class="small text-muted mb-0">Hạn thanh toán: <strong class="text-danger"><?= formatDate($invoice['due_date']) ?></strong></p>
                    <?php if ($invoice['status'] === 'paid'): ?>
                        <p class="small text-success mb-0">Đã nộp ngày: <?= formatDateTime($invoice['payment_date']) ?> (<?= htmlspecialchars($invoice['payment_method'] ?? 'Tiền mặt') ?>)</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Khoản thu</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): ?>
                            <?php $idx = 1; foreach ($items as $item): ?>
                                <tr>
                                    <td><?= $idx++ ?></td>
                                    <td>
                                        <strong class="d-block"><?= htmlspecialchars($item['item_name']) ?></strong>
                                        <?php if (!empty($item['note'])): ?>
                                            <small class="text-muted"><?= htmlspecialchars($item['note']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><?= (float)$item['quantity'] ?></td>
                                    <td class="text-end"><?= formatMoney($item['unit_price']) ?></td>
                                    <td class="text-end fw-semibold"><?= formatMoney($item['subtotal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <th colspan="4" class="text-end fs-6">TỔNG CỘNG THANH TOÁN:</th>
                            <th class="text-end text-primary fs-5 fw-bold"><?= formatMoney($invoice['total_amount']) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                <a href="<?= BASE_URL ?>/admin/invoices" class="btn btn-outline-secondary rounded-pill btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
                <div class="d-flex gap-2">
                    <?php if ($invoice['status'] === 'unpaid'): ?>
                        <a href="<?= BASE_URL ?>/admin/invoiceStatus/<?= $invoice['id'] ?>?status=paid&method=Tiền+mặt" class="btn btn-success rounded-pill btn-sm fw-bold">
                            <i class="fas fa-check me-1"></i> Thu Tiền Mặt & Đóng HĐ
                        </a>
                    <?php endif; ?>
                    <button onclick="window.print()" class="btn btn-primary-custom rounded-pill btn-sm fw-bold">
                        <i class="fas fa-print me-1"></i> In Hóa Đơn
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- VietQR side preview -->
    <div class="col-lg-4">
        <div class="card border rounded-4 p-4 shadow-sm bg-white text-center">
            <h6 class="fw-bold mb-2"><i class="fas fa-qrcode text-primary me-2"></i>Mã VietQR Thanh Toán</h6>
            <p class="text-muted small mb-3">Mã QR động dành cho khách quét chuyển khoản</p>

            <img src="<?= $vietQr ?>" class="img-fluid rounded border p-2 mb-3" style="max-width: 230px;" alt="VietQR">

            <div class="text-start bg-light p-3 rounded-3 border small">
                <div>STK: <strong><?= htmlspecialchars($settings['bank_account'] ?? '0901234567') ?></strong> (<?= htmlspecialchars($settings['bank_name'] ?? 'MBBANK') ?>)</div>
                <div>Chủ TK: <strong><?= htmlspecialchars($settings['bank_owner'] ?? 'NGUYEN VAN QUAN TRI') ?></strong></div>
                <div>Số tiền: <strong class="text-danger"><?= formatMoney($invoice['total_amount']) ?></strong></div>
                <div>Nội dung: <strong>TT TIEN PHONG <?= $invoice['invoice_code'] ?></strong></div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
