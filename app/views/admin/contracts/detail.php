<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4 p-md-5">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <div>
            <h4 class="fw-bold mb-1">CHI TIẾT HỢP ĐỒNG THUÊ: <?= $contract['contract_number'] ?></h4>
            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i><?= strtoupper($contract['status']) ?></span>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fas fa-print me-1"></i> In Hợp Đồng
            </button>
            <a href="<?= BASE_URL ?>/admin/contracts" class="btn btn-outline-primary btn-sm rounded-pill">
                Quay Lại
            </a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="p-3 bg-light rounded-3 border">
                <h6 class="fw-bold text-primary mb-2">ĐẠI DIỆN BÊN CHO THUÊ (BÊN A)</h6>
                <p class="small mb-1">Cơ sở: <strong><?= htmlspecialchars($contract['branch_name']) ?></strong></p>
                <p class="small mb-1">Địa chỉ: <?= htmlspecialchars($contract['branch_address']) ?></p>
                <p class="small mb-1">Người quản lý: <?= htmlspecialchars($contract['manager_name']) ?></p>
                <p class="small mb-0">Hotline: <?= htmlspecialchars($contract['manager_phone']) ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="p-3 bg-light rounded-3 border">
                <h6 class="fw-bold text-primary mb-2">BÊN THUÊ PHÒNG (BÊN B)</h6>
                <p class="small mb-1">Họ tên: <strong><?= htmlspecialchars($contract['tenant_name']) ?></strong></p>
                <p class="small mb-1">CCCD / CMND: <?= htmlspecialchars($contract['tenant_id_card']) ?></p>
                <p class="small mb-1">Số điện thoại: <?= htmlspecialchars($contract['tenant_phone']) ?></p>
                <p class="small mb-0">Email: <?= htmlspecialchars($contract['tenant_email'] ?? 'N/A') ?></p>
            </div>
        </div>
    </div>

    <h6 class="fw-bold mb-3">Thông Tin Chi Tiết Thỏa Thuận</h6>
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="w-25 bg-light fw-bold">Phòng thuê:</td>
                    <td><strong>Phòng <?= $contract['room_number'] ?> - <?= htmlspecialchars($contract['room_title']) ?></strong> (Diện tích: <?= $contract['area'] ?> m²)</td>
                </tr>
                <tr>
                    <td class="bg-light fw-bold">Thời hạn hợp đồng:</td>
                    <td>Từ ngày <strong><?= formatDate($contract['start_date']) ?></strong> đến ngày <strong><?= formatDate($contract['end_date']) ?></strong></td>
                </tr>
                <tr>
                    <td class="bg-light fw-bold">Giá thuê hàng tháng:</td>
                    <td class="text-primary fw-bold fs-5"><?= formatMoney($contract['rental_price']) ?> / tháng</td>
                </tr>
                <tr>
                    <td class="bg-light fw-bold">Tiền đặt cọc giữ chỗ:</td>
                    <td class="text-danger fw-bold fs-5"><?= formatMoney($contract['deposit_amount']) ?></td>
                </tr>
                <tr>
                    <td class="bg-light fw-bold">Chỉ số bàn giao ban đầu:</td>
                    <td>Điện: <strong><?= $contract['initial_electricity_index'] ?> kWh</strong> | Nước: <strong><?= $contract['initial_water_index'] ?> m³</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <h6 class="fw-bold mb-2">Điều Khoản Chung:</h6>
    <div class="p-3 bg-light rounded-3 border small text-muted mb-4" style="line-height: 1.8;">
        <?= nl2br(htmlspecialchars($contract['terms'] ?? '')) ?>
    </div>

    <div class="row text-center mt-5 pt-4">
        <div class="col-6">
            <p class="fw-bold mb-5">ĐẠI DIỆN BÊN CHO THUÊ</p>
            <p class="fw-bold text-primary"><?= htmlspecialchars($contract['manager_name']) ?></p>
        </div>
        <div class="col-6">
            <p class="fw-bold mb-5">ĐẠI DIỆN BÊN THUÊ PHÒNG</p>
            <p class="fw-bold text-primary"><?= htmlspecialchars($contract['tenant_name']) ?></p>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
