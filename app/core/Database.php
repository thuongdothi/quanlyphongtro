<?php
// ==============================================================
// CLASS KẾT NỐI DATABASE (MÔ HÌNH SINGLETON DÙNG PDO BẢO MẬT)
// ==============================================================

class Database {
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                die("<h3>Lỗi kết nối Cơ sở dữ liệu:</h3> " . htmlspecialchars($e->getMessage()) . 
                    "<br><br><i>Vui lòng kiểm tra file cấu hình <code>app/config/config.php</code> và đảm bảo MySQL đang chạy trong XAMPP.</i>");
            }
        }
        return self::$instance;
    }
}
