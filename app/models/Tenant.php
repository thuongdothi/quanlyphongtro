<?php
// ==============================================================
// MODEL: TENANT (KHÁCH THUÊ PHÒNG)
// ==============================================================

class Tenant extends Model {
    protected string $table = 'tenants';

    /**
     * Lấy danh sách khách kèm phòng đang thuê và trạng thái hợp đồng
     */
    public function getAllWithRoom(): array {
        $sql = "SELECT t.*, u.username,
                       c.id as contract_id, c.contract_number, c.status as contract_status,
                       r.id as room_id, r.room_number, r.title as room_title,
                       b.name as branch_name
                FROM tenants t
                LEFT JOIN users u ON t.user_id = u.id
                LEFT JOIN contracts c ON t.id = c.tenant_id AND c.status = 'active'
                LEFT JOIN rooms r ON c.room_id = r.id
                LEFT JOIN branches b ON r.branch_id = b.id
                ORDER BY t.id DESC";
        return $this->query($sql);
    }

    /**
     * Tìm khách thuê theo User ID đăng nhập
     */
    public function getByUserId(int $userId): ?array {
        $sql = "SELECT t.*, 
                       c.id as contract_id, c.contract_number, c.rental_price, c.deposit_amount,
                       c.start_date, c.end_date, c.terms, c.status as contract_status,
                       r.id as room_id, r.room_number, r.title as room_title, r.area, r.image as room_image,
                       r.amenities,
                       b.id as branch_id, b.name as branch_name, b.address as branch_address,
                       b.manager_name, b.manager_phone
                FROM tenants t
                LEFT JOIN contracts c ON t.id = c.tenant_id AND c.status = 'active'
                LEFT JOIN rooms r ON c.room_id = r.id
                LEFT JOIN branches b ON r.branch_id = b.id
                WHERE t.user_id = :uid
                LIMIT 1";
        return $this->queryOne($sql, [':uid' => $userId]);
    }
}
