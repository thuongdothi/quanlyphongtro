<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="bg-primary-light py-5 border-bottom">
    <div class="container text-center">
        <h1 class="fw-bold mb-2">Tin Tức & Cẩm Nang Thuê Trọ</h1>
        <p class="text-muted mb-0">Chia sẻ kiến thức, kinh nghiệm tìm phòng trọ và mẹo sinh hoạt hữu ích</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <?php foreach ($posts as $post): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border rounded-4 overflow-hidden shadow-sm hover-shadow">
                    <img src="<?= BASE_URL ?>/<?= $post['image'] ?: 'assets/images/posts/post1.jpg' ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($post['title']) ?>">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="text-muted small mb-2">
                            <i class="far fa-calendar-alt me-1"></i> <?= formatDate($post['created_at']) ?> • 
                            <i class="far fa-eye ms-2 me-1"></i> <?= $post['views'] ?> lượt xem
                        </div>
                        <h5 class="card-title fw-bold mb-3">
                            <a href="<?= BASE_URL ?>/home/postDetail/<?= $post['slug'] ?>" class="text-dark"><?= htmlspecialchars($post['title']) ?></a>
                        </h5>
                        <p class="text-muted small mb-4"><?= truncateText($post['summary'], 110) ?></p>
                        <a href="<?= BASE_URL ?>/home/postDetail/<?= $post['slug'] ?>" class="mt-auto fw-bold small text-primary">
                            Đọc bài viết <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
