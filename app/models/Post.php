<?php
// ==============================================================
// MODEL: POST (BÀI VIẾT / TIN TỨC / KINH NGHIỆM THUÊ TRỌ)
// ==============================================================

class Post extends Model {
    protected string $table = 'posts';

    public function getAllWithAuthor(): array {
        $sql = "SELECT p.*, u.full_name as author_name
                FROM posts p
                JOIN users u ON p.author_id = u.id
                ORDER BY p.id DESC";
        return $this->query($sql);
    }

    public function getActivePosts(int $limit = 6): array {
        $sql = "SELECT p.*, u.full_name as author_name
                FROM posts p
                JOIN users u ON p.author_id = u.id
                WHERE p.status = 1
                ORDER BY p.id DESC
                LIMIT {$limit}";
        return $this->query($sql);
    }

    public function getBySlug(string $slug): ?array {
        $sql = "SELECT p.*, u.full_name as author_name
                FROM posts p
                JOIN users u ON p.author_id = u.id
                WHERE p.slug = :slug AND p.status = 1
                LIMIT 1";
        return $this->queryOne($sql, [':slug' => $slug]);
    }

    public function incrementViews(int $id): void {
        $sql = "UPDATE posts SET views = views + 1 WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
