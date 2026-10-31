<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<!-- Filter & Search Banner -->
<div class="bg-primary-light py-4 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="fw-bold mb-1">Danh Sách Phòng Trọ</h2>
                <p class="text-muted small mb-0">Hệ thống phòng trọ tiện nghi, có gác lửng, ban công thoáng mát</p>
            </div>
            <div>
                <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill" id="roomCountBadge"><?= $total ?> phòng</span>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Sidebar Bộ Lọc (Filter Form) -->
        <div class="col-lg-3">
            <div class="card border rounded-4 p-4 shadow-sm bg-white sticky-top" style="top: 90px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="fas fa-filter text-primary me-2"></i>Bộ Lọc Phòng</h5>
                    <a href="<?= BASE_URL ?>/room" class="small text-danger fw-semibold">Xóa lọc</a>
                </div>

                <form id="roomFilterForm" data-action-url="<?= BASE_URL ?>/room/ajaxFilter" action="<?= BASE_URL ?>/room" method="GET">
                    <!-- Keyword search -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Tìm kiếm</label>
                        <input type="text" name="kw" class="form-control form-control-sm" placeholder="Tên phòng, địa chỉ..." value="<?= htmlspecialchars($filters['keyword']) ?>">
                    </div>

                    <!-- Branch / Khu trọ -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Khu trọ / Cơ sở</label>
                        <select name="branch" class="form-select form-select-sm">
                            <option value="">Tất cả cơ sở</option>
                            <?php foreach ($branches as $b): ?>
                                <option value="<?= $b['id'] ?>" <?= $filters['branch_id'] == $b['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($b['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Loại phòng -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Loại phòng</label>
                        <select name="type" class="form-select form-select-sm">
                            <option value="">Tất cả loại</option>
                            <?php foreach ($roomTypes as $t): ?>
                                <option value="<?= $t['id'] ?>" <?= $filters['room_type_id'] == $t['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Trạng thái phòng</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Tất cả</option>
                            <option value="available" <?= $filters['status'] === 'available' ? 'selected' : '' ?>>Còn trống</option>
                            <option value="rented" <?= $filters['status'] === 'rented' ? 'selected' : '' ?>>Đang thuê</option>
                        </select>
                    </div>

                    <!-- Mức giá -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Mức giá tối đa</label>
                        <select name="max_price" class="form-select form-select-sm">
                            <option value="">Tất cả mức giá</option>
                            <option value="3000000" <?= $filters['max_price'] == 3000000 ? 'selected' : '' ?>>Dưới 3.000.000 đ</option>
                            <option value="4000000" <?= $filters['max_price'] == 4000000 ? 'selected' : '' ?>>Dưới 4.000.000 đ</option>
                            <option value="5000000" <?= $filters['max_price'] == 5000000 ? 'selected' : '' ?>>Dưới 5.000.000 đ</option>
                            <option value="6000000" <?= $filters['max_price'] == 6000000 ? 'selected' : '' ?>>Dưới 6.000.000 đ</option>
                        </select>
                    </div>

                    <!-- Sắp xếp -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Sắp xếp theo</label>
                        <select name="sort" class="form-select form-select-sm">
                            <option value="newest" <?= $filters['sort'] === 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                            <option value="price_asc" <?= $filters['sort'] === 'price_asc' ? 'selected' : '' ?>>Giá: Thấp đến Cao</option>
                            <option value="price_desc" <?= $filters['sort'] === 'price_desc' ? 'selected' : '' ?>>Giá: Cao đến Thấp</option>
                            <option value="area_desc" <?= $filters['sort'] === 'area_desc' ? 'selected' : '' ?>>Diện tích rộng nhất</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 btn-sm rounded-pill py-2">
                        <i class="fas fa-search me-1"></i> Áp Dụng Bộ Lọc
                    </button>
                </form>
            </div>
        </div>

        <!-- Danh Sách Phòng Container (AJAX rendered) -->
        <div class="col-lg-9">
            <div class="row g-4" id="roomListContainer">
                <?php if (empty($rooms)): ?>
                    <div class="col-12 text-center py-5">
                        <div class="bg-light p-5 rounded-4 border">
                            <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                            <h5 class="fw-bold">Không tìm thấy phòng trọ nào phù hợp!</h5>
                            <p class="text-muted">Bạn hãy thử nới lỏng các tiêu chí tìm kiếm hoặc mức giá.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($rooms as $room): ?>
                        <div class="col-lg-4 col-md-6 mb-2">
                            <div class="room-card">
                                <div class="room-thumb-wrapper">
                                    <img src="<?= BASE_URL ?>/<?= $room['image'] ?: 'assets/images/rooms/room1.jpg' ?>" class="room-thumb" alt="<?= htmlspecialchars($room['title']) ?>">
                                    <div class="room-badge-status"><?= roomStatusBadge($room['status']) ?></div>
                                    <div class="room-badge-type"><?= htmlspecialchars($room['room_type_name']) ?></div>
                                    <div class="room-price-tag"><?= formatMoney($room['price']) ?> <span style="font-size:0.75rem; color:#64748b; font-weight:normal;">/tháng</span></div>
                                </div>
                                <div class="room-body">
                                    <h5 class="room-title">
                                        <a href="<?= BASE_URL ?>/room/detail/<?= $room['slug'] ?>"><?= htmlspecialchars($room['title']) ?> (<?= $room['room_number'] ?>)</a>
                                    </h5>
                                    <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-danger me-1"></i> <?= htmlspecialchars($room['branch_address']) ?>, <?= htmlspecialchars($room['city']) ?></p>
                                    <div class="room-meta">
                                        <div class="room-meta-item"><i class="fas fa-vector-square text-primary"></i> <?= $room['area'] ?> m²</div>
                                        <div class="room-meta-item"><i class="fas fa-layer-group text-primary"></i> Tầng <?= $room['floor'] ?></div>
                                        <div class="room-meta-item"><i class="fas fa-building text-primary"></i> <?= htmlspecialchars($room['branch_name']) ?></div>
                                    </div>
                                    <div class="room-footer">
                                        <span class="small text-muted">Cọc: <strong><?= formatMoney($room['deposit_price']) ?></strong></span>
                                        <a href="<?= BASE_URL ?>/room/detail/<?= $room['slug'] ?>" class="btn btn-sm btn-outline-primary fw-bold">Chi tiết <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination Container -->
            <div class="mt-5" id="paginationContainer">
                <?php if ($totalPages > 1): ?>
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= BASE_URL ?>/room?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>"><i class="fas fa-chevron-left"></i></a>
                            </li>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>/room?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= BASE_URL ?>/room?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>"><i class="fas fa-chevron-right"></i></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
