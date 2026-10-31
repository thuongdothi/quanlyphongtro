<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/tenant/invoices">Hóa đơn</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $invoice['invoice_code'] ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Main Invoice Content -->
        <div class="col-lg-8">
            <div class="card border rounded-4 p-4 p-md-5 shadow-sm bg-white" id="invoicePrintSection">
                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4 mb-4 border-bottom">
                    <div>
                        <h4 class="fw-bold mb-1 text-primary"><i class="fas fa-home me-2"></i><?= htmlspecialchars($settings['site_name'] ?? 'NHÀ TRỌ AN BÌNH') ?></h4>
                        <p class="text-muted small mb-0"><?= htmlspecialchars($settings['address'] ?? 'Hà Nội') ?> | Hotline: <?= htmlspecialchars($settings['hotline'] ?? '0901234567') ?></p>
                    </div>
                    <div class="text-md-end mt-2 mt-md-0">
                        <h5 class="fw-bold mb-1">HÓA ĐƠN TIỀN TRỌ</h5>
                        <p class="text-muted small mb-0">Mã: <strong><?= $invoice['invoice_code'] ?></strong></p>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Thông tin khách thuê:</small>
                        <h6 class="fw-bold mb-1"><?= htmlspecialchars($invoice['tenant_name']) ?></h6>
                        <p class="small text-muted mb-0">SĐT: <?= htmlspecialchars($invoice['tenant_phone']) ?></p>
                        <p class="small text-muted">Phòng: <strong><?= $invoice['room_number'] ?></strong> (<?= htmlspecialchars($invoice['branch_name']) ?>)</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small class="text-muted d-block">Kỳ hóa đơn:</small>
                        <h6 class="fw-bold mb-1">Tháng <?= $invoice['month'] ?> / <?= $invoice['year'] ?></h6>
                        <p class="small text-muted mb-1">Hạn nộp: <strong class="text-danger"><?= formatDate($invoice['due_date']) ?></strong></p>
                        <div>Trạng thái: <?= invoiceStatusBadge($invoice['status']) ?></div>
                    </div>
                </div>

                <!-- Itemized Breakdown -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nội dung thanh toán</th>
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
                            <?php else: ?>
                                <tr>
                                    <td>1</td>
                                    <td>Tiền thuê phòng tháng <?= $invoice['month'] ?>/<?= $invoice['year'] ?></td>
                                    <td class="text-center">1</td>
                                    <td class="text-end"><?= formatMoney($invoice['room_amount']) ?></td>
                                    <td class="text-end fw-semibold"><?= formatMoney($invoice['room_amount']) ?></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Tiền điện sinh hoạt</td>
                                    <td class="text-center">-</td>
                                    <td class="text-end">-</td>
                                    <td class="text-end fw-semibold"><?= formatMoney($invoice['electricity_amount']) ?></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tiền nước sinh hoạt</td>
                                    <td class="text-center">-</td>
                                    <td class="text-end">-</td>
                                    <td class="text-end fw-semibold"><?= formatMoney($invoice['water_amount']) ?></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Các dịch vụ cố định (Wifi, Rác, Gửi xe)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-end">-</td>
                                    <td class="text-end fw-semibold"><?= formatMoney($invoice['service_amount']) ?></td>
                                </tr>
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

                <?php if ($invoice['status'] === 'paid'): ?>
                    <div class="alert alert-success d-flex align-items-center gap-2 mb-0">
                        <i class="fas fa-check-circle fa-2x"></i>
                        <div>
                            <strong>Hóa đơn đã được thanh toán!</strong>
                            <div class="small">Ngày thanh toán: <?= formatDateTime($invoice['payment_date']) ?> (Hình thức: <?= htmlspecialchars($invoice['payment_method'] ?? 'Chuyển khoản') ?>)</div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-4 pt-3 border-top d-print-none">
                    <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-print me-1"></i> In Hóa Đơn Này
                    </button>
                </div>
            </div>
        </div>

        <!-- VietQR Box -->
        <div class="col-lg-4">
            <div class="card border rounded-4 p-4 shadow-sm bg-white text-center">
                <h5 class="fw-bold mb-2"><i class="fas fa-qrcode text-primary me-2"></i>Thanh Toán VietQR</h5>
                <p class="text-muted small mb-3">Mở app Ngân hàng bất kỳ (MB, Vietcombank, Techcombank, Momo...) để quét mã chuyển tiền tức thì.</p>

                <div class="p-2 border rounded-3 bg-light d-inline-block mb-3">
                    <img src="<?= $vietQr ?>" class="img-fluid rounded" style="max-width: 250px;" alt="VietQR Code">
                </div>

                <div class="text-start bg-light p-3 rounded-3 border small mb-3">
                    <div class="mb-1"><span class="text-muted">Ngân hàng:</span> <strong><?= htmlspecialchars($settings['bank_name'] ?? 'MBBANK') ?></strong></div>
                    <div class="mb-1"><span class="text-muted">Số tài khoản:</span> <strong class="text-primary fs-6"><?= htmlspecialchars($settings['bank_account'] ?? '0901234567') ?></strong></div>
                    <div class="mb-1"><span class="text-muted">Chủ tài khoản:</span> <strong><?= htmlspecialchars($settings['bank_owner'] ?? 'NGUYEN VAN QUAN TRI') ?></strong></div>
                    <div class="mb-1"><span class="text-muted">Số tiền:</span> <strong class="text-danger fs-6"><?= formatMoney($invoice['total_amount']) ?></strong></div>
                    <div><span class="text-muted">Nội dung CK:</span> <strong>TT TIEN PHONG <?= $invoice['invoice_code'] ?></strong></div>
                </div>

                <small class="text-muted d-block">
                    Sau khi chuyển khoản thành công, hệ thống quản lý sẽ đối soát và cập nhật trạng thái "Đã thanh toán" cho phòng của bạn trong vòng 15-30 phút.
                </small>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
