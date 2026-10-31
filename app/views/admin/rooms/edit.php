<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <h5 class="fw-bold mb-0"><i class="fas fa-edit text-primary me-2"></i>Chỉnh Sửa Phòng: <?= $room['room_number'] ?></h5>
        <a href="<?= BASE_URL ?>/admin/rooms" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Quay Lại
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/roomEdit/<?= $room['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Khu trọ / Dãy trọ <span class="text-danger">*</span></label>
                <select name="branch_id" class="form-select" required>
                    <?php foreach ($branches as $b): ?>
                        <option value="<?= $b['id'] ?>" <?= $room['branch_id'] == $b['id'] ? 'selected' : '' ?>><?= htmlspecialchars($b['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Loại phòng <span class="text-danger">*</span></label>
                <select name="room_type_id" class="form-select" required>
                    <?php foreach ($roomTypes as $rt): ?>
                        <option value="<?= $rt['id'] ?>" <?= $room['room_type_id'] == $rt['id'] ? 'selected' : '' ?>><?= htmlspecialchars($rt['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Mã / Số phòng <span class="text-danger">*</span></label>
                <input type="text" name="room_number" class="form-control" value="<?= htmlspecialchars($room['room_number']) ?>" required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-8">
                <label class="form-label small fw-bold">Tiêu đề bài đăng phòng <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($room['title']) ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Trạng thái phòng</label>
                <select name="status" class="form-select">
                    <option value="available" <?= $room['status'] === 'available' ? 'selected' : '' ?>>Còn trống</option>
                    <option value="rented" <?= $room['status'] === 'rented' ? 'selected' : '' ?>>Đang thuê</option>
                    <option value="maintenance" <?= $room['status'] === 'maintenance' ? 'selected' : '' ?>>Bảo trì</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Giá thuê (VNĐ/tháng) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" value="<?= (float)$room['price'] ?>" step="50000" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Tiền cọc mặc định (VNĐ)</label>
                <input type="number" name="deposit_price" class="form-control" value="<?= (float)$room['deposit_price'] ?>" step="50000">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Diện tích (m²)</label>
                <input type="number" name="area" class="form-control" value="<?= $room['area'] ?>" step="0.5" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Vị trí tầng</label>
                <input type="number" name="floor" class="form-control" value="<?= $room['floor'] ?>" min="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Số người tối đa</label>
                <input type="number" name="max_tenants" class="form-control" value="<?= $room['max_tenants'] ?>" min="1" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Tiện nghi có sẵn</label>
            <input type="text" name="amenities" class="form-control" value="<?= htmlspecialchars($room['amenities'] ?? '') ?>">
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-8">
                <label class="form-label small fw-bold">Mô tả chi tiết phòng</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($room['description'] ?? '') ?></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Thay đổi ảnh phòng</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <?php if ($room['image']): ?>
                    <div class="mt-2">
                        <img src="<?= BASE_URL ?>/<?= $room['image'] ?>" class="rounded border" width="90" height="60" style="object-fit:cover;" alt="Current">
                    </div>
                <?php endif; ?>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" <?= $room['is_featured'] ? 'checked' : '' ?>>
                    <label class="form-check-label small fw-bold" for="is_featured">
                        Đánh dấu là phòng nổi bật
                    </label>
                </div>
            </div>
        </div>

        <div class="pt-3 border-top text-end">
            <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill fw-bold">
                <i class="fas fa-save me-1"></i> Cập Nhật Phòng Trọ
            </button>
        </div>
    </form>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
