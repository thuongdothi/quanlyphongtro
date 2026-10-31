<?php
// ==============================================================
// MODEL: BOOKING (ĐẶT LỊCH HẸN XEM PHÒNG)
// ==============================================================

class Booking extends Model {
    protected string $table = 'bookings';

    /**
     * Lấy toàn bộ lịch hẹn xem phòng kèm thông tin phòng
     */
    public function getAllWithRoom(): array {
        $sql = "SELECT bk.*, r.room_number, r.title as room_title, b.name as branch_name, r.price
                FROM bookings bk
                JOIN rooms r ON bk.room_id = r.id
                JOIN branches b ON r.branch_id = b.id
                ORDER BY bk.id DESC";
        return $this->query($sql);
    }
}
