<?php
// ==============================================================
// MODEL: ROOM (QUẢN LÝ PHÒNG TRỌ)
// ==============================================================

class Room extends Model {
    protected string $table = 'rooms';

    /**
     * Lấy danh sách phòng kèm thông tin chi nhánh & loại phòng
     */
    public function getAllWithDetails(string $orderBy = 'r.id DESC'): array {
        $sql = "SELECT r.*, b.name as branch_name, b.address as branch_address, b.city,
                       rt.name as room_type_name
                FROM rooms r
                JOIN branches b ON r.branch_id = b.id
                JOIN room_types rt ON r.room_type_id = rt.id
                ORDER BY {$orderBy}";
        return $this->query($sql);
    }

    /**
     * Tìm 1 phòng theo ID kèm đầy đủ thông tin chi nhánh & loại phòng
     */
    public function getDetailsById(int $id): ?array {
        $sql = "SELECT r.*, b.name as branch_name, b.address as branch_address, b.ward, b.district, b.city,
                       b.manager_name, b.manager_phone,
                       rt.name as room_type_name
                FROM rooms r
                JOIN branches b ON r.branch_id = b.id
                JOIN room_types rt ON r.room_type_id = rt.id
                WHERE r.id = :id
                LIMIT 1";
        return $this->queryOne($sql, [':id' => $id]);
    }

    /**
     * Tìm phòng theo Slug
     */
    public function getDetailsBySlug(string $slug): ?array {
        $sql = "SELECT r.*, b.name as branch_name, b.address as branch_address, b.ward, b.district, b.city,
                       b.manager_name, b.manager_phone,
                       rt.name as room_type_name
                FROM rooms r
                JOIN branches b ON r.branch_id = b.id
                JOIN room_types rt ON r.room_type_id = rt.id
                WHERE r.slug = :slug
                LIMIT 1";
        return $this->queryOne($sql, [':slug' => $slug]);
    }

    /**
     * Lấy các phòng nổi bật hiển thị trang chủ
     */
    public function getFeatured(int $limit = 6): array {
        $sql = "SELECT r.*, b.name as branch_name, b.city, rt.name as room_type_name
                FROM rooms r
                JOIN branches b ON r.branch_id = b.id
                JOIN room_types rt ON r.room_type_id = rt.id
                WHERE r.is_featured = 1 AND r.status = 'available'
                ORDER BY r.id DESC
                LIMIT {$limit}";
        return $this->query($sql);
    }

    /**
     * Lấy các phòng mới nhất
     */
    public function getLatest(int $limit = 6): array {
        $sql = "SELECT r.*, b.name as branch_name, b.city, rt.name as room_type_name
                FROM rooms r
                JOIN branches b ON r.branch_id = b.id
                JOIN room_types rt ON r.room_type_id = rt.id
                ORDER BY r.id DESC
                LIMIT {$limit}";
        return $this->query($sql);
    }

    /**
     * Lọc và tìm kiếm phòng trọ với phân trang và AJAX
     */
    public function filter(array $filters = [], int $page = 1, int $perPage = 6): array {
        $whereClauses = ["1 = 1"];
        $params = [];

        if (!empty($filters['keyword'])) {
            $whereClauses[] = "(r.title LIKE :kw OR r.room_number LIKE :kw OR b.name LIKE :kw OR b.address LIKE :kw)";
            $params[':kw'] = '%' . trim($filters['keyword']) . '%';
        }

        if (!empty($filters['branch_id'])) {
            $whereClauses[] = "r.branch_id = :branch_id";
            $params[':branch_id'] = (int)$filters['branch_id'];
        }

        if (!empty($filters['room_type_id'])) {
            $whereClauses[] = "r.room_type_id = :room_type_id";
            $params[':room_type_id'] = (int)$filters['room_type_id'];
        }

        if (!empty($filters['status'])) {
            $whereClauses[] = "r.status = :status";
            $params[':status'] = $filters['status'];
        }

        if (isset($filters['min_price']) && is_numeric($filters['min_price']) && $filters['min_price'] > 0) {
            $whereClauses[] = "r.price >= :min_price";
            $params[':min_price'] = (float)$filters['min_price'];
        }

        if (isset($filters['max_price']) && is_numeric($filters['max_price']) && $filters['max_price'] > 0) {
            $whereClauses[] = "r.price <= :max_price";
            $params[':max_price'] = (float)$filters['max_price'];
        }

        $whereSql = implode(' AND ', $whereClauses);

        // Đếm tổng số
        $countSql = "SELECT COUNT(*) as total 
                     FROM rooms r 
                     JOIN branches b ON r.branch_id = b.id 
                     JOIN room_types rt ON r.room_type_id = rt.id 
                     WHERE {$whereSql}";
        $totalRow = $this->queryOne($countSql, $params);
        $total = (int)($totalRow['total'] ?? 0);

        // Sắp xếp
        $orderBy = "r.id DESC";
        if (!empty($filters['sort'])) {
            $orderBy = match ($filters['sort']) {
                'price_asc' => "r.price ASC",
                'price_desc' => "r.price DESC",
                'area_asc' => "r.area ASC",
                'area_desc' => "r.area DESC",
                default => "r.id DESC"
            };
        }

        // Phân trang
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT r.*, b.name as branch_name, b.address as branch_address, b.city, rt.name as room_type_name
                FROM rooms r
                JOIN branches b ON r.branch_id = b.id
                JOIN room_types rt ON r.room_type_id = rt.id
                WHERE {$whereSql}
                ORDER BY {$orderBy}
                LIMIT {$perPage} OFFSET {$offset}";

        $rooms = $this->query($sql, $params);

        return [
            'data' => $rooms,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }
}
