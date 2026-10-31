<?php
// ==============================================================
// MODEL: MAINTENANCE (YÊU CẦU SỬA CHỮA / BÁO SỰ CỐ)
// ==============================================================

class Maintenance extends Model {
    protected string $table = 'maintenance_requests';

    /**
     * Lấy toàn bộ yêu cầu sửa chữa kèm thông tin phòng và khách
     */
    public function getAllWithDetails(string $status = ''): array {
        $where = "1 = 1";
        $params = [];
        if (!empty($status)) {
            $where .= " AND m.status = :status";
            $params[':status'] = $status;
        }

        $sql = "SELECT m.*, r.room_number, b.name as branch_name,
                       t.full_name as tenant_name, t.phone as tenant_phone
                FROM maintenance_requests m
                JOIN rooms r ON m.room_id = r.id
                JOIN branches b ON r.branch_id = b.id
                JOIN tenants t ON m.tenant_id = t.id
                WHERE {$where}
                ORDER BY m.id DESC";
        return $this->query($sql, $params);
    }

    /**
     * Lấy yêu cầu sửa chữa của 1 khách thuê
     */
    public function getByTenantId(int $tenantId): array {
        $sql = "SELECT m.*, r.room_number
                FROM maintenance_requests m
                JOIN rooms r ON m.room_id = r.id
                WHERE m.tenant_id = :tid
                ORDER BY m.id DESC";
        return $this->query($sql, [':tid' => $tenantId]);
    }
}
