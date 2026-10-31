<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <h5 class="fw-bold mb-0"><i class="fas fa-file-contract text-primary me-2"></i>Lập Hợp Đồng Thuê Phòng Mới</h5>
        <a href="<?= BASE_URL ?>/admin/contracts" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Quay Lại
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/contractAdd" method="POST">
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Chọn phòng trọ còn trống <span class="text-danger">*</span></label>
                <select name="room_id" id="contract_room_select" class="form-select" required>
                    <option value="">-- Chọn phòng còn trống --</option>
                    <?php foreach ($availableRooms as $r): ?>
                        <option value="<?= $r['id'] ?>" data-price="<?= (float)$r['price'] ?>" data-deposit="<?= (float)$r['deposit_price'] ?>">
                            Phòng <?= $r['room_number'] ?> - <?= htmlspecialchars($r['title']) ?> (<?= formatMoney($r['price']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Khách thuê phòng <span class="text-danger">*</span></label>
                <select name="tenant_id" class="form-select" required>
                    <option value="">-- Chọn khách thuê --</option>
                    <?php foreach ($tenants as $t): ?>
                        <option value="<?= $t['id'] ?>">
                            <?= htmlspecialchars($t['full_name']) ?> - CCCD: <?= $t['id_card'] ?> (SĐT: <?= $t['phone'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Ngày bắt đầu thuê <span class="text-danger">*</span></label>
                <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Ngày hết hạn hợp đồng <span class="text-danger">*</span></label>
                <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime('+1 year')) ?>" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Giá thuê thỏa thuận (VNĐ/tháng) <span class="text-danger">*</span></label>
                <input type="number" name="rental_price" id="contract_rental_price" class="form-control" step="50000" placeholder="3500000" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Tiền đặt cọc (VNĐ) <span class="text-danger">*</span></label>
                <input type="number" name="deposit_amount" id="contract_deposit_amount" class="form-control" step="50000" placeholder="3500000" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Chỉ số điện bàn giao ban đầu (kWh)</label>
                <input type="number" name="initial_electricity_index" class="form-control" value="0">
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Chỉ số nước bàn giao ban đầu (m³)</label>
                <input type="number" name="initial_water_index" class="form-control" value="0">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold">Điều khoản hợp đồng & Cam kết</label>
            <textarea name="terms" class="form-control" rows="3">1. Bên thuê thanh toán tiền thuê từ ngày 1 đến ngày 5 hàng tháng.
2. Giữ gìn an ninh trật tự, vệ sinh chung, không hút thuốc trong phòng kín.
3. Chấm dứt hợp đồng trước hạn phải thông báo trước tối thiểu 30 ngày để đối soát hoàn tiền cọc.</textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill fw-bold">
                <i class="fas fa-save me-1"></i> Ký & Lưu Hợp Đồng
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('contract_room_select').addEventListener('change', function() {
        const opt = this.options[this.selectedIndex];
        if (opt && opt.dataset.price) {
            document.getElementById('contract_rental_price').value = opt.dataset.price;
            document.getElementById('contract_deposit_amount').value = opt.dataset.deposit || opt.dataset.price;
        }
    });
</script>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
