<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="row g-4">
    <!-- Form thêm/sửa dịch vụ -->
    <div class="col-lg-4">
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle text-primary me-2"></i>Thêm Dịch Vụ Mới</h6>
            <form action="<?= BASE_URL ?>/admin/services" method="POST">
                <input type="hidden" name="action" value="add">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Tên dịch vụ <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Ví dụ: Giữ xe đạp điện" required>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label small fw-bold">Đơn giá (VNĐ) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" placeholder="50000" step="1000" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-bold">Đơn vị tính <span class="text-danger">*</span></label>
                        <input type="text" name="unit" class="form-control" placeholder="Xe/tháng, kWh..." required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Cách tính</label>
                    <select name="type" class="form-select">
                        <option value="fixed" selected>Cố định hàng tháng</option>
                        <option value="meter">Theo chỉ số đồng hồ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Mô tả dịch vụ</label>
                    <textarea name="description" rows="2" class="form-control" placeholder="Ghi chú chi tiết..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2 rounded-pill fw-bold">
                    <i class="fas fa-save me-1"></i> Lưu Dịch Vụ
                </button>
            </form>
        </div>
    </div>

    <!-- Danh sách dịch vụ -->
    <div class="col-lg-8">
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-concierge-bell text-primary me-2"></i>Biểu Giá Dịch Vụ & Tiện Ích Đang Áp Dụng</h6>
            <div class="table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Tên dịch vụ</th>
                            <th>Đơn giá</th>
                            <th>Đơn vị tính</th>
                            <th>Cách tính</th>
                            <th>Mô tả</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($services as $srv): ?>
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($srv['name']) ?></td>
                                <td class="text-primary fw-bold"><?= formatMoney($srv['price']) ?></td>
                                <td><?= htmlspecialchars($srv['unit']) ?></td>
                                <td>
                                    <span class="badge <?= $srv['type'] === 'meter' ? 'bg-info' : 'bg-secondary' ?>">
                                        <?= $srv['type'] === 'meter' ? 'Theo chỉ số đồng hồ' : 'Cố định hàng tháng' ?>
                                    </span>
                                </td>
                                <td class="small text-muted"><?= htmlspecialchars($srv['description'] ?? 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
