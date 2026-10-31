<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1"><i class="fas fa-newspaper text-primary me-2"></i>Quản Lý Tin Tức & Cẩm Nang (<?= count($posts) ?> bài)</h5>
            <p class="text-muted small mb-0">Đăng tải thông báo, nội quy và chia sẻ kinh nghiệm thuê trọ</p>
        </div>
        <div>
            <a href="<?= BASE_URL ?>/admin/postAdd" class="btn btn-primary-custom rounded-pill btn-sm fw-bold">
                <i class="fas fa-plus me-1"></i> Viết Bài Mới
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tiêu đề bài viết</th>
                    <th>Tác giả</th>
                    <th>Lượt xem</th>
                    <th>Ngày đăng</th>
                    <th class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($posts)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Chưa có bài viết nào.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($posts as $p): ?>
                        <tr>
                            <td>
                                <img src="<?= BASE_URL ?>/<?= $p['image'] ?: 'assets/images/posts/post1.jpg' ?>" class="rounded-3" width="60" height="45" style="object-fit: cover;" alt="Post">
                            </td>
                            <td>
                                <a href="<?= BASE_URL ?>/home/postDetail/<?= $p['slug'] ?>" target="_blank" class="fw-bold text-dark">
                                    <?= htmlspecialchars($p['title']) ?>
                                </a>
                                <small class="text-muted d-block"><?= truncateText($p['summary'], 65) ?></small>
                            </td>
                            <td class="small text-muted"><?= htmlspecialchars($p['author_name']) ?></td>
                            <td><span class="badge bg-light text-dark border"><?= $p['views'] ?></span></td>
                            <td class="small text-muted"><?= formatDate($p['created_at']) ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL ?>/home/postDetail/<?= $p['slug'] ?>" target="_blank" class="btn btn-sm btn-outline-primary btn-action me-1" title="Xem trên web">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/admin/postDelete/<?= $p['id'] ?>" class="btn btn-sm btn-outline-danger btn-action btn-confirm-delete" title="Xóa">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
