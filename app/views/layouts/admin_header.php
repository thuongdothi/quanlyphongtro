<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Quản Trị Hệ Thống - Nhà Trọ An Bình') ?></title>
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
    <!-- Custom Admin CSS -->
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/admin.css" rel="stylesheet">
</head>
<body class="admin-body">

    <!-- Sidebar Admin -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-brand">
            <i class="fas fa-building text-primary me-2 fa-lg"></i>
            <span>ADMIN QUẢN TRỊ</span>
        </div>

        <div class="admin-menu-header">Tổng Quan & Vận Hành</div>
        <a href="<?= BASE_URL ?>/admin/dashboard" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-chart-pie"></i> Bảng Điều Khiển
        </a>

        <div class="admin-menu-header">Quản Lý Phòng & Khu Trọ</div>
        <a href="<?= BASE_URL ?>/admin/rooms" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/rooms') ? 'active' : '' ?>">
            <i class="fas fa-door-closed"></i> Danh Sách Phòng
        </a>
        <a href="<?= BASE_URL ?>/admin/branches" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/branches') ? 'active' : '' ?>">
            <i class="fas fa-city"></i> Khu Trọ / Dãy Trọ
        </a>
        <a href="<?= BASE_URL ?>/admin/roomTypes" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/roomTypes') ? 'active' : '' ?>">
            <i class="fas fa-tags"></i> Loại Phòng
        </a>

        <div class="admin-menu-header">Khách Thuê & Hợp Đồng</div>
        <a href="<?= BASE_URL ?>/admin/tenants" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/tenants') ? 'active' : '' ?>">
            <i class="fas fa-users"></i> Khách Thuê
        </a>
        <a href="<?= BASE_URL ?>/admin/contracts" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/contracts') ? 'active' : '' ?>">
            <i class="fas fa-file-signature"></i> Hợp Đồng Thuê
        </a>
        <a href="<?= BASE_URL ?>/admin/bookings" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/bookings') ? 'active' : '' ?>">
            <i class="fas fa-calendar-check"></i> Lịch Hẹn Xem Phòng
        </a>

        <div class="admin-menu-header">Điện Nước & Hóa Đơn</div>
        <a href="<?= BASE_URL ?>/admin/meterReadings" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/meterReadings') ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt"></i> Ghi Chỉ Số Điện Nước
        </a>
        <a href="<?= BASE_URL ?>/admin/invoices" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/invoices') ? 'active' : '' ?>">
            <i class="fas fa-file-invoice-dollar"></i> Hóa Đơn Tiền Trọ
        </a>
        <a href="<?= BASE_URL ?>/admin/services" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/services') ? 'active' : '' ?>">
            <i class="fas fa-concierge-bell"></i> Biểu Giá Dịch Vụ
        </a>

        <div class="admin-menu-header">Chăm Sóc & Hệ Thống</div>
        <a href="<?= BASE_URL ?>/admin/maintenance" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/maintenance') ? 'active' : '' ?>">
            <i class="fas fa-tools"></i> Xử Lý Sự Cố
        </a>
        <a href="<?= BASE_URL ?>/admin/posts" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/posts') ? 'active' : '' ?>">
            <i class="fas fa-newspaper"></i> Tin Tức & Cẩm Nang
        </a>
        <a href="<?= BASE_URL ?>/admin/users" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/users') ? 'active' : '' ?>">
            <i class="fas fa-user-shield"></i> Tài Khoản Hệ Thống
        </a>
        <a href="<?= BASE_URL ?>/admin/settings" class="admin-nav-item <?= str_contains($_SERVER['REQUEST_URI'] ?? '', 'admin/settings') ? 'active' : '' ?>">
            <i class="fas fa-cogs"></i> Cài Đặt & VietQR
        </a>
        
        <div class="p-3 mt-4">
            <a href="<?= BASE_URL ?>/" target="_blank" class="btn btn-outline-light btn-sm w-100 rounded-pill">
                <i class="fas fa-external-link-alt me-1"></i> Xem Trang Chủ
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="admin-wrapper">
        <!-- Topbar -->
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <h5 class="mb-0 fw-bold text-dark"><?= htmlspecialchars($pageTitle ?? 'Quản Trị') ?></h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-light border rounded-pill px-3 py-1 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <img src="<?= BASE_URL ?>/assets/images/avatar-default.png" class="rounded-circle" width="30" height="30" alt="Avatar">
                        <span class="fw-bold small"><?= htmlspecialchars(Auth::user()['full_name'] ?? 'Admin') ?></span>
                        <i class="fas fa-chevron-down small text-muted"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/tenant/profile"><i class="fas fa-user-edit me-2"></i> Hồ sơ của tôi</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/settings"><i class="fas fa-cogs me-2"></i> Cài đặt</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>/auth/logout"><i class="fas fa-sign-out-alt me-2"></i> Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Admin Content -->
        <main class="admin-content">
            <?= flash() ?>
