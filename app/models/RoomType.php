<?php
// ==============================================================
// MODEL: ROOM TYPE (LOẠI PHÒNG TRỌ)
// ==============================================================

class RoomType extends Model {
    protected string $table = 'room_types';

    /**
     * Lấy danh sách loại phòng kèm số lượng phòng hiện có
     */
    public function getAllWithRoomCount(): array {
        $sql = "SELECT rt.*, COUNT(r.id) as total_rooms
                FROM room_types rt
                LEFT JOIN rooms r ON rt.id = r.room_type_id
                GROUP BY rt.id
                ORDER BY rt.id ASC";
        return $this->query($sql);
    }
}
