<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="row g-4">
    <!-- Form ghi nhận chỉ số -->
    <div class="col-lg-4">
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-edit text-primary me-2"></i>Ghi Nhận Chỉ Số Điện Nước</h6>
            <form action="<?= BASE_URL ?>/admin/meterReadings" method="POST">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Tháng <span class="text-danger">*</span></label>
                        <select name="month" class="form-select form-select-sm" required>
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>" <?= $m == $month ? 'selected' : '' ?>>Tháng <?= $m ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Năm <span class="text-danger">*</span></label>
                        <input type="number" name="year" class="form-control form-control-sm" value="<?= $year ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Phòng trọ ghi nhận <span class="text-danger">*</span></label>
                    <select name="room_id" class="form-select form-select-sm" required>
                        <option value="">-- Chọn phòng đang thuê --</option>
                        <?php foreach ($rentedRooms as $r): ?>
                            <option value="<?= $r['id'] ?>">Phòng <?= $r['room_number'] ?> - <?= htmlspecialchars($r['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Điện -->
                <div class="p-3 bg-light rounded-3 border mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold small text-primary"><i class="fas fa-bolt me-1"></i>Chỉ số điện (kWh)</span>
                        <span class="badge bg-primary" id="elec_consumed_calc">0 kWh</span>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small text-muted">Số cũ</label>
                            <input type="number" name="old_electricity" id="old_electricity" class="form-control form-control-sm" placeholder="Số cũ" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Số mới</label>
                            <input type="number" name="new_electricity" id="new_electricity" class="form-control form-control-sm" placeholder="Số mới" required>
                        </div>
                    </div>
                </div>

                <!-- Nước -->
                <div class="p-3 bg-light rounded-3 border mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold small text-info"><i class="fas fa-tint me-1"></i>Chỉ số nước (m³)</span>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small text-muted">Số cũ</label>
                            <input type="number" name="old_water" class="form-control form-control-sm" placeholder="Số cũ" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Số mới</label>
                            <input type="number" name="new_water" class="form-control form-control-sm" placeholder="Số mới" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Ghi chú thêm</label>
                    <input type="text" name="notes" class="form-control form-control-sm" placeholder="Ví dụ: Đã kiểm tra công tơ chạy bình thường">
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2 rounded-pill fw-bold">
                    <i class="fas fa-save me-1"></i> Lưu Chỉ Số Điện Nước
                </button>
            </form>
        </div>
    </div>

    <!-- Danh sách chỉ số đã ghi trong tháng -->
    <div class="col-lg-8">
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-list text-primary me-2"></i>Chỉ Số Tháng <?= $month ?> / <?= $year ?></h6>
                <form action="<?= BASE_URL ?>/admin/meterReadings" method="GET" class="d-flex gap-2">
                    <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= $m == $month ? 'selected' : '' ?>>Tháng <?= $m ?></option>
                        <?php endfor; ?>
                    </select>
                    <input type="number" name="year" class="form-control form-control-sm" style="width: 85px;" value="<?= $year ?>" onchange="this.form.submit()">
                </form>
            </div>

            <div class="table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Phòng</th>
                            <th>Điện cũ → mới</th>
                            <th>Điện tiêu thụ</th>
                            <th>Nước cũ → mới</th>
                            <th>Nước tiêu thụ</th>
                            <th>Ngày ghi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($readings)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Chưa ghi nhận chỉ số nào cho tháng <?= $month ?>/<?= $year ?>.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($readings as $mr): ?>
                                <tr>
                                    <td>
                                        <strong class="badge bg-light text-dark border"><?= $mr['room_number'] ?></strong>
                                        <small class="text-muted d-block"><?= htmlspecialchars($mr['branch_name']) ?></small>
                                    </td>
                                    <td><?= $mr['old_electricity'] ?> → <?= $mr['new_electricity'] ?></td>
                                    <td><strong class="text-primary"><?= $mr['electricity_consumed'] ?> kWh</strong></td>
                                    <td><?= $mr['old_water'] ?> → <?= $mr['new_water'] ?></td>
                                    <td><strong class="text-info"><?= $mr['water_consumed'] ?> m³</strong></td>
                                    <td class="small text-muted"><?= formatDate($mr['recorded_date']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
