<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="row g-4">
    <!-- Form thêm mới -->
    <div class="col-lg-4">
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle text-primary me-2"></i>Thêm Loại Phòng</h6>
            <form action="<?= BASE_URL ?>/admin/roomTypes" method="POST">
                <input type="hidden" name="action" value="add">

                <div class="mb-3">
                    <label class="form-label small fw-bold">Tên loại phòng <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="Ví dụ: Phòng Studio Gác Lửng" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Giá cơ sở tham khảo (VNĐ)</label>
                    <input type="number" name="base_price" class="form-control" placeholder="3500000" step="50000">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Mô tả đặc trưng</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="Đặc điểm thiết kế, đồ dùng đi kèm..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary-custom w-100 py-2 rounded-pill fw-bold">
                    <i class="fas fa-save me-1"></i> Thêm Loại Phòng
                </button>
            </form>
        </div>
    </div>

    <!-- Danh sách loại phòng -->
    <div class="col-lg-8">
        <div class="card border rounded-4 shadow-sm bg-white p-4">
            <h6 class="fw-bold mb-3"><i class="fas fa-tags text-primary me-2"></i>Danh Sách Loại Phòng</h6>

            <div class="table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                        <tr>
                            <th>Tên loại phòng</th>
                            <th>Giá cơ sở</th>
                            <th>Mô tả</th>
                            <th>Số lượng phòng</th>
                            <th class="text-end">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roomTypes as $rt): ?>
                            <tr>
                                <td class="fw-bold"><?= htmlspecialchars($rt['name']) ?></td>
                                <td class="text-primary fw-bold"><?= formatMoney($rt['base_price']) ?></td>
                                <td class="small text-muted"><?= htmlspecialchars($rt['description'] ?? 'N/A') ?></td>
                                <td><span class="badge bg-light text-dark border"><?= $rt['total_rooms'] ?> phòng</span></td>
                                <td class="text-end">
                                    <a href="<?= BASE_URL ?>/admin/roomTypeDelete/<?= $rt['id'] ?>" class="btn btn-sm btn-outline-danger btn-action btn-confirm-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
