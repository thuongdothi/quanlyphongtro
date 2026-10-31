<?php
// ==============================================================
// MODEL: METER READING (CHỈ SỐ ĐIỆN NƯỚC HÀNG THÁNG)
// ==============================================================

class MeterReading extends Model {
    protected string $table = 'meter_readings';

    /**
     * Lấy danh sách chỉ số kèm phòng và chi nhánh
     */
    public function getAllWithDetails(int $month = 0, int $year = 0): array {
        $where = "1 = 1";
        $params = [];
        if ($month > 0) {
            $where .= " AND mr.month = :month";
            $params[':month'] = $month;
        }
        if ($year > 0) {
            $where .= " AND mr.year = :year";
            $params[':year'] = $year;
        }

        $sql = "SELECT mr.*, r.room_number, r.title as room_title, b.name as branch_name
                FROM meter_readings mr
                JOIN rooms r ON mr.room_id = r.id
                JOIN branches b ON r.branch_id = b.id
                WHERE {$where}
                ORDER BY mr.year DESC, mr.month DESC, r.room_number ASC";
        return $this->query($sql, $params);
    }

    /**
     * Lấy chỉ số kỳ trước gần nhất của phòng
     */
    public function getLatestReading(int $roomId): ?array {
        $sql = "SELECT * FROM meter_readings 
                WHERE room_id = :rid 
                ORDER BY year DESC, month DESC 
                LIMIT 1";
        return $this->queryOne($sql, [':rid' => $roomId]);
    }
}
