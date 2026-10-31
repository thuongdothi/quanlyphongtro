<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Hệ Thống Nhà Trọ An Bình') ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://cdn-icons-png.flaticon.com/512/609/609803.png">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>

    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL ?>/">
                <div class="brand-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div>
                    <span class="d-block" style="line-height: 1.1;">NHÀ TRỌ AN BÌNH</span>
                    <small class="text-muted fw-normal" style="font-size: 0.72rem; letter-spacing: 0.05em;">HỆ THỐNG PHÒNG TRỌ TIỆN NGHI</small>
                </div>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= empty($_GET['url']) ? 'active' : '' ?>" href="<?= BASE_URL ?>/">Trang Chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (str_starts_with($_GET['url'] ?? '', 'room')) ? 'active' : '' ?>" href="<?= BASE_URL ?>/room">Phòng Trọ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['url'] ?? '') === 'home/about' ? 'active' : '' ?>" href="<?= BASE_URL ?>/home/about">Giới Thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['url'] ?? '') === 'home/news' ? 'active' : '' ?>" href="<?= BASE_URL ?>/home/news">Cẩm Nang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['url'] ?? '') === 'home/contact' ? 'active' : '' ?>" href="<?= BASE_URL ?>/home/contact">Liên Hệ</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    <a href="tel:0901234567" class="btn btn-light border text-danger fw-bold rounded-pill px-3 py-2 small d-none d-xl-flex align-items-center gap-2">
                        <i class="fas fa-phone-alt"></i> 0901.234.567
                    </a>

                    <?php if (Auth::check()): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle rounded-pill px-3 py-2 fw-semibold d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle fa-lg"></i>
                                <span><?= htmlspecialchars(Auth::user()['full_name']) ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                                <?php if (Auth::isAdmin()): ?>
                                    <li><a class="dropdown-item fw-bold text-primary" href="<?= BASE_URL ?>/admin/dashboard"><i class="fas fa-tachometer-alt me-2"></i> Trang Quản Trị</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/tenant"><i class="fas fa-door-open me-2"></i> Cổng Khách Thuê</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/tenant/contract"><i class="fas fa-file-contract me-2"></i> Hợp Đồng Của Tôi</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/tenant/invoices"><i class="fas fa-receipt me-2"></i> Hóa Đơn Tiền Trọ</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/tenant/maintenance"><i class="fas fa-wrench me-2"></i> Báo Hỏng / Sự Cố</a></li>
                                <li><a class="dropdown-item" href="<?= BASE_URL ?>/tenant/profile"><i class="fas fa-user-cog me-2"></i> Thông Tin Cá Nhân</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/auth/logout"><i class="fas fa-sign-out-alt me-2"></i> Đăng Xuất</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/auth/login" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold">
                            <i class="fas fa-sign-in-alt me-1"></i> Đăng Nhập
                        </a>
                        <a href="<?= BASE_URL ?>/auth/register" class="btn btn-primary-custom rounded-pill px-3 py-2">
                            <i class="fas fa-user-plus me-1"></i> Đăng Ký
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash message container -->
    <div class="container mt-3">
        <?= flash() ?>
    </div>
