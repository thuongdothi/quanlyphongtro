<?php
// ==============================================================
// AUTH - QUẢN LÝ PHIÊN ĐĂNG NHẬP, PHÂN QUYỀN VÀ BẢO MẬT
// ==============================================================

class Auth {

    /**
     * Kiểm tra người dùng đã đăng nhập chưa
     */
    public static function check(): bool {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
    }

    /**
     * Lấy thông tin người dùng hiện tại
     */
    public static function user(): ?array {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Lấy ID người dùng hiện tại
     */
    public static function id(): ?int {
        return $_SESSION['user']['id'] ?? null;
    }

    /**
     * Lấy Role ID hoặc Role Name
     */
    public static function role(): string {
        return $_SESSION['user']['role_name'] ?? '';
    }

    /**
     * Kiểm tra có phải Quản trị viên (Admin) không
     */
    public static function isAdmin(): bool {
        return self::check() && (self::role() === 'admin' || ($_SESSION['user']['role_id'] ?? 0) == 1);
    }

    /**
     * Kiểm tra có phải Khách thuê không
     */
    public static function isTenant(): bool {
        return self::check() && (self::role() === 'tenant' || ($_SESSION['user']['role_id'] ?? 0) == 2);
    }

    /**
     * Thiết lập session đăng nhập
     */
    public static function login(array $user): void {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'role_id' => $user['role_id'],
            'role_name' => $user['role_name'] ?? ($user['role_id'] == 1 ? 'admin' : 'tenant'),
            'username' => $user['username'],
            'full_name' => $user['full_name'],
            'email' => $user['email'],
            'phone' => $user['phone'],
            'avatar' => $user['avatar'] ?? 'assets/images/avatar-default.png'
        ];
    }

    /**
     * Đăng xuất hệ thống
     */
    public static function logout(): void {
        unset($_SESSION['user']);
        session_destroy();
    }

    /**
     * Yêu cầu phải đăng nhập
     */
    public static function requireLogin(): void {
        if (!self::check()) {
            $_SESSION['flash_message'] = 'Vui lòng đăng nhập để tiếp tục!';
            $_SESSION['flash_type'] = 'warning';
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }
    }

    /**
     * Yêu cầu quyền Quản trị viên
     */
    public static function requireAdmin(): void {
        self::requireLogin();
        if (!self::isAdmin()) {
            $_SESSION['flash_message'] = 'Bạn không có quyền truy cập khu vực Quản trị!';
            $_SESSION['flash_type'] = 'danger';
            header("Location: " . BASE_URL . "/");
            exit;
        }
    }

    /**
     * Yêu cầu quyền Khách thuê
     */
    public static function requireTenant(): void {
        self::requireLogin();
        if (!self::isTenant() && !self::isAdmin()) {
            $_SESSION['flash_message'] = 'Khu vực này dành riêng cho Khách thuê!';
            $_SESSION['flash_type'] = 'danger';
            header("Location: " . BASE_URL . "/");
            exit;
        }
    }
}
