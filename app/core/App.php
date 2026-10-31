<?php
// ==============================================================
// APP ROUTER - ĐIỀU PHỐI YÊU CẦU ĐẾN CONTROLLER & ACTION PHÙ HỢP
// ==============================================================

class App {
    protected string $controllerName = 'HomeController';
    protected string $method = 'index';
    protected array $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // 1. Kiểm tra Controller
        if (!empty($url[0])) {
            $candidateName = ucfirst($url[0]) . 'Controller';
            if (file_exists(APP_PATH . '/controllers/' . $candidateName . '.php')) {
                $this->controllerName = $candidateName;
                unset($url[0]);
            }
        }

        require_once APP_PATH . '/controllers/' . $this->controllerName . '.php';
        $controllerInstance = new $this->controllerName();

        // 2. Kiểm tra Action (Method)
        if (!empty($url[1])) {
            $candidateMethod = $url[1];
            if (method_exists($controllerInstance, $candidateMethod)) {
                $this->method = $candidateMethod;
                unset($url[1]);
            }
        }

        // 3. Tham số còn lại (Params)
        $this->params = $url ? array_values($url) : [];

        // 4. Gọi Controller Method cùng Params
        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    /**
     * Tách URL thành mảng [controller, action, param1, ...]
     */
    protected function parseUrl(): array {
        if (isset($_GET['url']) && !empty(trim($_GET['url']))) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }

        // Hỗ trợ Clean URL từ REQUEST_URI (khi dùng mod_rewrite hoặc built-in server)
        $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
        $scriptDir = dirname($_SERVER['SCRIPT_NAME'] ?? '');
        
        if ($scriptDir !== '/' && $scriptDir !== '\\' && !empty($scriptDir)) {
            if (str_starts_with($requestUri, $scriptDir)) {
                $requestUri = substr($requestUri, strlen($scriptDir));
            }
        }

        $requestUri = trim($requestUri, '/');
        if (empty($requestUri) || $requestUri === 'index.php') {
            return [];
        }

        return explode('/', filter_var($requestUri, FILTER_SANITIZE_URL));
    }
}
