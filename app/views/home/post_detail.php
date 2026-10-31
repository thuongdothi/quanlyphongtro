<?php require_once VIEW_PATH . '/layouts/header.php'; ?>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/home/news">Cẩm nang</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($post['title']) ?></li>
                </ol>
            </nav>

            <h1 class="fw-bold mb-3"><?= htmlspecialchars($post['title']) ?></h1>
            <div class="d-flex align-items-center gap-3 text-muted small pb-3 mb-4 border-bottom">
                <span><i class="far fa-user me-1 text-primary"></i> <?= htmlspecialchars($post['author_name']) ?></span>
                <span><i class="far fa-calendar-alt me-1 text-primary"></i> <?= formatDate($post['created_at']) ?></span>
                <span><i class="far fa-eye me-1 text-primary"></i> <?= $post['views'] ?> lượt xem</span>
            </div>

            <div class="mb-4">
                <img src="<?= BASE_URL ?>/<?= $post['image'] ?: 'assets/images/posts/post1.jpg' ?>" class="img-fluid rounded-4 shadow-sm w-100" style="max-height: 400px; object-fit: cover;" alt="<?= htmlspecialchars($post['title']) ?>">
            </div>

            <div class="lead text-secondary fw-semibold mb-4 pb-3 border-bottom">
                <?= nl2br(htmlspecialchars($post['summary'])) ?>
            </div>

            <div class="post-content" style="line-height: 1.8; font-size: 1.05rem;">
                <?= $post['content'] ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border rounded-4 p-4 shadow-sm bg-white sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3 pb-2 border-bottom">Bài Viết Mới Nhất</h5>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($relatedPosts as $rel): ?>
                        <div class="d-flex gap-3 align-items-center">
                            <img src="<?= BASE_URL ?>/<?= $rel['image'] ?: 'assets/images/posts/post1.jpg' ?>" class="rounded-3" width="70" height="60" style="object-fit: cover;" alt="<?= htmlspecialchars($rel['title']) ?>">
                            <div>
                                <h6 class="small fw-bold mb-1">
                                    <a href="<?= BASE_URL ?>/home/postDetail/<?= $rel['slug'] ?>" class="text-dark"><?= truncateText($rel['title'], 55) ?></a>
                                </h6>
                                <small class="text-muted"><i class="far fa-clock me-1"></i> <?= formatDate($rel['created_at']) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4 pt-3 border-top text-center">
                    <p class="small text-muted mb-3">Bạn đang cần tìm phòng trọ tại Cầu Giấy, Bình Thạnh hay Quận 10?</p>
                    <a href="<?= BASE_URL ?>/room" class="btn btn-primary-custom w-100 rounded-pill fw-bold">
                        <i class="fas fa-search me-1"></i> Xem Danh Sách Phòng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEW_PATH . '/layouts/footer.php'; ?>
