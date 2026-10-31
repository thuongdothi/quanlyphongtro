<?php
// ==============================================================
// MODEL: SETTING (CẤU HÌNH HỆ THỐNG)
// ==============================================================

class Setting extends Model {
    protected string $table = 'settings';
    protected string $primaryKey = 'key_name';

    /**
     * Lấy toàn bộ cài đặt dưới dạng Key -> Value
     */
    public function getAllKeyValue(): array {
        $rows = $this->all('key_name ASC');
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['key_name']] = $row['value'];
        }
        return $settings;
    }

    /**
     * Lấy giá trị của 1 key
     */
    public function getValue(string $key, string $default = ''): string {
        $row = $this->findBy('key_name', $key);
        return $row ? $row['value'] : $default;
    }

    /**
     * Cập nhật hoặc thêm key
     */
    public function set(string $key, string $value): bool {
        $existing = $this->findBy('key_name', $key);
        if ($existing) {
            $sql = "UPDATE settings SET value = :val WHERE key_name = :key";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':val' => $value, ':key' => $key]);
        } else {
            $sql = "INSERT INTO settings (key_name, value) VALUES (:key, :val)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([':key' => $key, ':val' => $value]);
        }
    }
}
