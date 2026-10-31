<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/tenant">Cổng khách thuê</a></li>
            <li class="breadcrumb-item active" aria-current="page">Hợp đồng thuê phòng</li>
        </ol>
    </nav>

    <?php if ($contract): ?>
        <div class="card border rounded-4 p-4 p-md-5 shadow-sm bg-white">
            <div class="d-flex justify-content-between align-items-center pb-4 mb-4 border-bottom">
                <div>
                    <h3 class="fw-bold mb-1">HỢP ĐỒNG THUÊ PHÒNG TRỌ</h3>
                    <p class="text-muted small mb-0">Mã hợp đồng: <strong><?= $contract['contract_number'] ?></strong></p>
                </div>
                <div>
                    <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill btn-sm">
                        <i class="fas fa-print me-1"></i> In Hợp Đồng
                    </button>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold text-primary mb-3">BÊN CHO THUÊ (BÊN A)</h6>
                        <p class="small mb-1">Đại diện: <strong><?= htmlspecialchars($contract['manager_name']) ?></strong></p>
                        <p class="small mb-1">Cơ sở: <strong><?= htmlspecialchars($contract['branch_name']) ?></strong></p>
                        <p class="small mb-1">Địa chỉ: <?= htmlspecialchars($contract['branch_address']) ?></p>
                        <p class="small mb-0">Hotline: <?= htmlspecialchars($contract['manager_phone']) ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                        <h6 class="fw-bold text-primary mb-3">BÊN THUÊ PHÒNG (BÊN B)</h6>
                        <p class="small mb-1">Họ tên: <strong><?= htmlspecialchars($contract['tenant_name']) ?></strong></p>
                        <p class="small mb-1">CCCD / CMND: <?= htmlspecialchars($contract['tenant_id_card']) ?></p>
                        <p class="small mb-1">Số điện thoại: <?= htmlspecialchars($contract['tenant_phone']) ?></p>
                        <p class="small mb-0">Quê quán: <?= htmlspecialchars($contract['tenant_hometown'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>

            <h5 class="fw-bold mb-3">Nội Dung Hợp Đồng & Thỏa Thuận</h5>
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="w-25 bg-light fw-bold">Phòng thuê:</td>
                            <td><strong><?= htmlspecialchars($contract['room_title']) ?> (Phòng <?= $contract['room_number'] ?>)</strong> - Diện tích: <?= $contract['area'] ?> m²</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Thời hạn thuê:</td>
                            <td>Từ ngày <strong><?= formatDate($contract['start_date']) ?></strong> đến hết ngày <strong><?= formatDate($contract['end_date']) ?></strong></td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Giá thuê mỗi tháng:</td>
                            <td class="text-primary fw-bold fs-5"><?= formatMoney($contract['rental_price']) ?> / tháng</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Tiền đặt cọc giữ phòng:</td>
                            <td class="text-danger fw-bold fs-5"><?= formatMoney($contract['deposit_amount']) ?></td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Chỉ số bàn giao đầu kỳ:</td>
                            <td>Chỉ số điện: <strong><?= $contract['initial_electricity_index'] ?> kWh</strong> | Chỉ số nước: <strong><?= $contract['initial_water_index'] ?> m³</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h6 class="fw-bold mb-2">Điều Khoản Chung:</h6>
            <div class="p-3 bg-light rounded-3 border small text-muted mb-4" style="line-height: 1.8;">
                <?= nl2br(htmlspecialchars($contract['terms'] ?? '1. Bên B thanh toán tiền thuê từ ngày 1 đến ngày 5 hàng tháng.\n2. Giữ gìn an ninh trật tự, vệ sinh chung và thiết bị trong phòng.\n3. Kết thúc hợp đồng trước hạn phải thông báo trước 30 ngày.')) ?>
            </div>

            <div class="row text-center mt-5">
                <div class="col-6">
                    <p class="fw-bold mb-5">ĐẠI DIỆN BÊN A (CHỦ NHÀ)</p>
                    <p class="fw-bold text-primary"><?= htmlspecialchars($contract['manager_name']) ?></p>
                </div>
                <div class="col-6">
                    <p class="fw-bold mb-5">ĐẠI DIỆN BÊN B (KHÁCH THUÊ)</p>
                    <p class="fw-bold text-primary"><?= htmlspecialchars($contract['tenant_name']) ?></p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="card border rounded-4 p-5 text-center bg-white shadow-sm">
            <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold">Bạn chưa có hợp đồng nào đang hiệu lực!</h5>
            <p class="text-muted small">Vui lòng liên hệ ban quản lý qua hotline 0901.234.567 để được hỗ trợ làm hợp đồng.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
