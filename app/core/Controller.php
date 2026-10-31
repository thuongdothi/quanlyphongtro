<?php
// ==============================================================
// BASE CONTROLLER - ĐIỀU KHIỂN VIEW, MODEL VÀ CÁC TIỆN ÍCH REQUEST
// ==============================================================

class Controller {

    /**
     * Khởi tạo Model
     */
    protected function model(string $modelName) {
        $file = APP_PATH . '/models/' . $modelName . '.php';
        if (file_exists($file)) {
            require_once $file;
            return new $modelName();
        }
        die("Không tìm thấy Model: " . htmlspecialchars($modelName));
    }

    /**
     * Render View và truyền dữ liệu
     */
    protected function view(string $viewPath, array $data = []): void {
        extract($data);
        $file = VIEW_PATH . '/' . $viewPath . '.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            die("Không tìm thấy View: " . htmlspecialchars($viewPath));
        }
    }

    /**
     * Trả về phản hồi dạng JSON cho AJAX
     */
    protected function json(mixed $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /**
     * Chuyển hướng URL (Redirect)
     */
    protected function redirect(string $path): void {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            header("Location: " . $path);
        } else {
            $path = ltrim($path, '/');
            header("Location: " . BASE_URL . '/' . $path);
        }
        exit;
    }

    /**
     * Lấy dữ liệu POST được làm sạch cơ bản
     */
    protected function post(?string $key = null, mixed $default = null): mixed {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }

    /**
     * Lấy dữ liệu GET
     */
    protected function get(?string $key = null, mixed $default = null): mixed {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }

    /**
     * Kiểm tra phương thức request
     */
    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
