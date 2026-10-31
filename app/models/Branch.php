<?php
// ==============================================================
// MODEL: BRANCH (KHU TRỌ / DÃY TRỌ / CƠ SỞ)
// ==============================================================

class Branch extends Model {
    protected string $table = 'branches';

    /**
     * Lấy danh sách chi nhánh kèm số lượng phòng
     */
    public function getAllWithRoomCount(): array {
        $sql = "SELECT b.*, COUNT(r.id) as total_rooms,
                       SUM(CASE WHEN r.status = 'available' THEN 1 ELSE 0 END) as available_rooms,
                       SUM(CASE WHEN r.status = 'rented' THEN 1 ELSE 0 END) as rented_rooms
                FROM branches b
                LEFT JOIN rooms r ON b.id = r.branch_id
                GROUP BY b.id
                ORDER BY b.id ASC";
        return $this->query($sql);
    }
}
