<?php
// ==============================================================
// MODEL: CONTRACT (HỢP ĐỒNG THUÊ PHÒNG)
// ==============================================================

class Contract extends Model {
    protected string $table = 'contracts';

    /**
     * Lấy danh sách hợp đồng kèm thông tin phòng & người thuê
     */
    public function getAllWithDetails(string $orderBy = 'c.id DESC'): array {
        $sql = "SELECT c.*, r.room_number, r.title as room_title,
                       b.name as branch_name,
                       t.full_name as tenant_name, t.phone as tenant_phone, t.id_card as tenant_id_card
                FROM contracts c
                JOIN rooms r ON c.room_id = r.id
                JOIN branches b ON r.branch_id = b.id
                JOIN tenants t ON c.tenant_id = t.id
                ORDER BY {$orderBy}";
        return $this->query($sql);
    }

    /**
     * Lấy chi tiết 1 hợp đồng
     */
    public function getDetailsById(int $id): ?array {
        $sql = "SELECT c.*, r.room_number, r.title as room_title, r.area, r.price as default_room_price,
                       b.name as branch_name, b.address as branch_address, b.manager_name, b.manager_phone,
                       t.full_name as tenant_name, t.phone as tenant_phone, t.id_card as tenant_id_card,
                       t.email as tenant_email, t.hometown as tenant_hometown, t.date_of_birth
                FROM contracts c
                JOIN rooms r ON c.room_id = r.id
                JOIN branches b ON r.branch_id = b.id
                JOIN tenants t ON c.tenant_id = t.id
                WHERE c.id = :id
                LIMIT 1";
        return $this->queryOne($sql, [':id' => $id]);
    }
}
