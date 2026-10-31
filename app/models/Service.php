<?php
// ==============================================================
// MODEL: SERVICE (DỊCH VỤ & BIỂU GIÁ)
// ==============================================================

class Service extends Model {
    protected string $table = 'services';

    public function getActiveServices(): array {
        return $this->where('is_active', 1, 'id ASC');
    }
}
