<?php
// ==============================================================
// CẤU HÌNH HỆ THỐNG QUẢN LÝ PHÒNG TRỌ
// ==============================================================

// Bật thông báo lỗi trong môi trường phát triển (Development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Múi giờ Việt Nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Khởi tạo session an toàn nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cấu hình Cơ sở dữ liệu MySQL
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'quanlyphongtro');
define('DB_CHARSET', 'utf8mb4');

// Xác định Root Path và Base URL tự động (hoạt động tốt trên cả Apache htdocs và PHP Built-in server)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$baseUrl = rtrim($protocol . $host . $scriptName, '/');

define('BASE_URL', $baseUrl);
define('ROOT_PATH', dirname(__DIR__, 2));
define('APP_PATH', ROOT_PATH . '/app');
define('VIEW_PATH', APP_PATH . '/views');
define('UPLOAD_PATH', ROOT_PATH . '/assets/uploads');

// Cấu hình hệ thống mặc định
define('APP_NAME', 'Nhà Trọ An Bình');
define('APP_VERSION', '2.0');
