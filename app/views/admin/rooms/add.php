<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <h5 class="fw-bold mb-0"><i class="fas fa-plus-circle text-primary me-2"></i>Thêm Phòng Trọ Mới</h5>
        <a href="<?= BASE_URL ?>/admin/rooms" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Quay Lại
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/roomAdd" method="POST" enctype="multipart/form-data">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Khu trọ / Dãy trọ <span class="text-danger">*</span></label>
                <select name="branch_id" class="form-select" required>
                    <?php foreach ($branches as $b): ?>
                        <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Loại phòng <span class="text-danger">*</span></label>
                <select name="room_type_id" class="form-select" required>
                    <?php foreach ($roomTypes as $rt): ?>
                        <option value="<?= $rt['id'] ?>"><?= htmlspecialchars($rt['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Mã / Số phòng <span class="text-danger">*</span></label>
                <input type="text" name="room_number" class="form-control" placeholder="P.101, P.202..." required>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-8">
                <label class="form-label small fw-bold">Tiêu đề bài đăng phòng <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" placeholder="Ví dụ: Phòng Studio Ban Công Thoáng Mát..." required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Trạng thái phòng</label>
                <select name="status" class="form-select">
                    <option value="available" selected>Còn trống</option>
                    <option value="rented">Đang thuê</option>
                    <option value="maintenance">Bảo trì</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Giá thuê (VNĐ/tháng) <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" placeholder="3500000" step="50000" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Tiền cọc mặc định (VNĐ)</label>
                <input type="number" name="deposit_price" class="form-control" placeholder="3500000" step="50000">
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Diện tích (m²)</label>
                <input type="number" name="area" class="form-control" placeholder="25" step="0.5" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Vị trí tầng</label>
                <input type="number" name="floor" class="form-control" value="1" min="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small fw-bold">Số người tối đa</label>
                <input type="number" name="max_tenants" class="form-control" value="2" min="1" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Tiện nghi có sẵn (phân cách bởi dấu phẩy)</label>
            <input type="text" name="amenities" class="form-control" value="Máy lạnh, Bình nóng lạnh, Giường nệm, Tủ quần áo, Wifi, Khóa vân tay, Bãi xe">
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-8">
                <label class="form-label small fw-bold">Mô tả chi tiết phòng</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Mô tả không gian, hướng phòng, giờ giấc, nội thất..."></textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Ảnh đại diện phòng</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1">
                    <label class="form-check-label small fw-bold" for="is_featured">
                        Đánh dấu là phòng nổi bật trang chủ
                    </label>
                </div>
            </div>
        </div>

        <div class="pt-3 border-top text-end">
            <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill fw-bold">
                <i class="fas fa-save me-1"></i> Thêm Mới Phòng Trọ
            </button>
        </div>
    </form>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
