<?php
// ==============================================================
// BASE MODEL - CUNG CẤP CÁC PHƯƠNG THỨC CRUD HƯỚNG ĐỐI TƯỢNG (OOP)
// ==============================================================

class Model {
    protected PDO $db;
    protected string $table = '';
    protected string $primaryKey = 'id';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Lấy tất cả bản ghi
     */
    public function all(string $orderBy = 'id DESC'): array {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Tìm theo khóa chính ID
     */
    public function find($id): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Tìm theo một cột và giá trị
     */
    public function findBy(string $column, $value): ?array {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':val' => $value]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Lấy danh sách thỏa mãn điều kiện
     */
    public function where(string $column, $value, string $orderBy = 'id DESC'): array {
        $sql = "SELECT * FROM {$this->table} WHERE {$column} = :val ORDER BY {$orderBy}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':val' => $value]);
        return $stmt->fetchAll();
    }

    /**
     * Tạo mới bản ghi
     */
    public function create(array $data): int|string {
        $columns = implode(', ', array_map(fn($col) => "`$col`", array_keys($data)));
        $placeholders = implode(', ', array_map(fn($col) => ":$col", array_keys($data)));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    /**
     * Cập nhật bản ghi theo ID
     */
    public function update($id, array $data): bool {
        $setClauses = [];
        foreach ($data as $col => $val) {
            $setClauses[] = "`$col` = :$col";
        }
        $setString = implode(', ', $setClauses);
        $sql = "UPDATE {$this->table} SET {$setString} WHERE {$this->primaryKey} = :_primary_id";
        
        $stmt = $this->db->prepare($sql);
        $data['_primary_id'] = $id;
        return $stmt->execute($data);
    }

    /**
     * Xóa bản ghi theo ID
     */
    public function delete($id): bool {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Đếm tổng số bản ghi
     */
    public function count(string $where = '', array $params = []): int {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if (!empty($where)) {
            $sql .= " WHERE " . $where;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }

    /**
     * Thực thi câu SQL tùy chỉnh có tham số an toàn (Prepared Statement)
     */
    public function query(string $sql, array $params = []): array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Thực thi câu lệnh SQL trả về 1 dòng
     */
    public function queryOne(string $sql, array $params = []): ?array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
