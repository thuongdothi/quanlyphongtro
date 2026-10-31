<?php
// ==============================================================
// FRONT CONTROLLER - ĐIỂM BẮT ĐẦU CỦA ỨNG DỤNG (ENTRY POINT)
// ==============================================================

// Nạp cấu hình
require_once __DIR__ . '/app/config/config.php';

// Nạp các lớp lõi (Core Framework)
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/Auth.php';
require_once APP_PATH . '/core/Helpers.php';
require_once APP_PATH . '/core/App.php';

// Khởi chạy ứng dụng
$app = new App();
