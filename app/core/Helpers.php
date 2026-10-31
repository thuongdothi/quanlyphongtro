<?php
// ==============================================================
// HELPERS - HÀM TIỆN ÍCH HỆ THỐNG
// ==============================================================

/**
 * Định dạng tiền tệ VNĐ
 */
function formatMoney(float|int|string|null $amount): string {
    if ($amount === null || $amount === '') return '0 đ';
    return number_format((float)$amount, 0, ',', '.') . ' đ';
}

/**
 * Định dạng ngày tháng
 */
function formatDate(?string $date, string $format = 'd/m/Y'): string {
    if (empty($date)) return '';
    $timestamp = strtotime($date);
    return $timestamp ? date($format, $timestamp) : '';
}

/**
 * Định dạng ngày giờ
 */
function formatDateTime(?string $dateTime): string {
    return formatDate($dateTime, 'H:i - d/m/Y');
}

/**
 * Tạo URL thân thiện (Slug)
 */
function slugify(string $text): string {
    $text = mb_strtolower($text, 'UTF-8');
    // Chuyển ký tự có dấu tiếng Việt sang không dấu
    $vietnameseMap = [
        'à'=>'a','á'=>'a','ả'=>'a','ã'=>'a','ạ'=>'a','ă'=>'a','ằ'=>'a','ắ'=>'a','ẳ'=>'a','ẵ'=>'a','ặ'=>'a','â'=>'a','ầ'=>'a','ấ'=>'a','ẩ'=>'a','ẫ'=>'a','ậ'=>'a',
        'è'=>'e','é'=>'e','ẻ'=>'e','ẽ'=>'e','ẹ'=>'e','ê'=>'e','ề'=>'e','ế'=>'e','ể'=>'e','ễ'=>'e','ệ'=>'e',
        'ì'=>'i','í'=>'i','ỉ'=>'i','ĩ'=>'i','ị'=>'i',
        'ò'=>'o','ó'=>'o','ỏ'=>'o','õ'=>'o','ọ'=>'o','ô'=>'o','ồ'=>'o','ố'=>'o','ổ'=>'o','ỗ'=>'o','ộ'=>'o','ơ'=>'o','ờ'=>'o','ớ'=>'o','ở'=>'o','ỡ'=>'o','ợ'=>'o',
        'ù'=>'u','ú'=>'u','ủ'=>'u','ũ'=>'u','ụ'=>'u','ư'=>'u','ừ'=>'u','ứ'=>'u','ử'=>'u','ữ'=>'u','ự'=>'u',
        'ỳ'=>'y','ý'=>'y','ỷ'=>'y','ỹ'=>'y','ỵ'=>'y',
        'đ'=>'d'
    ];
    $text = strtr($text, $vietnameseMap);
    // Thay ký tự đặc biệt bằng dấu gạch ngang
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    return trim($text, '-');
}

/**
 * Tạo link mã QR chuyển khoản VietQR tự động
 */
function vietQrUrl(string $bankBin, string $accountNo, float|int $amount, string $description): string {
    $encodedDesc = urlencode($description);
    return "https://img.vietqr.io/image/{$bankBin}-{$accountNo}-compact2.png?amount={$amount}&addInfo={$encodedDesc}&accountName=";
}

/**
 * Hiển thị Badge trạng thái phòng
 */
function roomStatusBadge(string $status): string {
    return match ($status) {
        'available' => '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Còn trống</span>',
        'rented' => '<span class="badge bg-danger"><i class="fas fa-user-check me-1"></i>Đang thuê</span>',
        'maintenance' => '<span class="badge bg-warning text-dark"><i class="fas fa-tools me-1"></i>Bảo trì</span>',
        default => '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>',
    };
}

/**
 * Hiển thị Badge trạng thái hóa đơn
 */
function invoiceStatusBadge(string $status): string {
    return match ($status) {
        'paid' => '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Đã thanh toán</span>',
        'unpaid' => '<span class="badge bg-danger"><i class="fas fa-clock me-1"></i>Chưa thanh toán</span>',
        'overdue' => '<span class="badge bg-dark"><i class="fas fa-exclamation-triangle me-1"></i>Quá hạn</span>',
        default => '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>',
    };
}

/**
 * Hiển thị Badge trạng thái sự cố
 */
function maintenanceStatusBadge(string $status): string {
    return match ($status) {
        'pending' => '<span class="badge bg-warning text-dark"><i class="fas fa-hourglass-start me-1"></i>Đang chờ</span>',
        'in_progress' => '<span class="badge bg-primary"><i class="fas fa-wrench me-1"></i>Đang sửa</span>',
        'completed' => '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Đã xong</span>',
        'rejected' => '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Từ chối</span>',
        default => '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>',
    };
}

/**
 * Hiển thị Badge trạng thái đặt phòng
 */
function bookingStatusBadge(string $status): string {
    return match ($status) {
        'pending' => '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>Chờ xác nhận</span>',
        'confirmed' => '<span class="badge bg-primary"><i class="fas fa-calendar-check me-1"></i>Đã xác nhận</span>',
        'completed' => '<span class="badge bg-success"><i class="fas fa-check-double me-1"></i>Đã xem xong</span>',
        'cancelled' => '<span class="badge bg-secondary"><i class="fas fa-ban me-1"></i>Đã hủy</span>',
        default => '<span class="badge bg-secondary">' . htmlspecialchars($status) . '</span>',
    };
}

/**
 * Lưu hoặc hiển thị thông báo Flash Message
 */
function flash(?string $message = null, string $type = 'success'): ?string {
    if ($message !== null) {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
        return null;
    }
    
    if (isset($_SESSION['flash_message'])) {
        $msg = $_SESSION['flash_message'];
        $t = $_SESSION['flash_type'] ?? 'info';
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        return "<div class=\"alert alert-{$t} alert-dismissible fade show shadow-sm\" role=\"alert\">
                    {$msg}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                </div>";
    }
    return null;
}

/**
 * Lấy giá trị input cũ
 */
function old(string $field, mixed $default = ''): mixed {
    return $_POST[$field] ?? $default;
}

/**
 * Rút gọn văn bản
 */
function truncateText(string $text, int $limit = 100): string {
    $cleanText = strip_tags($text);
    if (mb_strlen($cleanText, 'UTF-8') <= $limit) {
        return $cleanText;
    }
    return mb_substr($cleanText, 0, $limit, 'UTF-8') . '...';
}
