<?php
// ==============================================================
// MODEL: USER (TÀI KHOẢN NGƯỜI DÙNG & PHÂN QUYỀN)
// ==============================================================

class User extends Model {
    protected string $table = 'users';

    public function getAllWithRole(): array {
        $sql = "SELECT u.*, r.name as role_name, r.description as role_desc
                FROM users u
                JOIN roles r ON u.role_id = r.id
                ORDER BY u.id ASC";
        return $this->query($sql);
    }

    public function findByUsername(string $username): ?array {
        $sql = "SELECT u.*, r.name as role_name
                FROM users u
                JOIN roles r ON u.role_id = r.id
                WHERE u.username = :uname
                LIMIT 1";
        return $this->queryOne($sql, [':uname' => $username]);
    }

    public function findByEmail(string $email): ?array {
        $sql = "SELECT u.*, r.name as role_name
                FROM users u
                JOIN roles r ON u.role_id = r.id
                WHERE u.email = :email
                LIMIT 1";
        return $this->queryOne($sql, [':email' => $email]);
    }
}
