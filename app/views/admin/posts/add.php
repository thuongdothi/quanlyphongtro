<?php require_once VIEW_PATH . '/layouts/admin_header.php'; ?>

<div class="card border rounded-4 shadow-sm bg-white p-4">
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
        <h5 class="fw-bold mb-0"><i class="fas fa-edit text-primary me-2"></i>Thêm Bài Viết Mới</h5>
        <a href="<?= BASE_URL ?>/admin/posts" class="btn btn-outline-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Quay Lại
        </a>
    </div>

    <form action="<?= BASE_URL ?>/admin/postAdd" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label small fw-bold">Tiêu đề bài viết <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề hấp dẫn..." required>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Tóm tắt ngắn (Summary) <span class="text-danger">*</span></label>
            <textarea name="summary" class="form-control" rows="2" placeholder="Tóm tắt 1-2 câu về nội dung bài viết..." required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Ảnh đại diện bài viết</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold">Nội dung bài viết (Hỗ trợ HTML) <span class="text-danger">*</span></label>
            <textarea name="content" class="form-control" rows="8" placeholder="Nhập nội dung bài viết..." required></textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary-custom px-4 py-2 rounded-pill fw-bold">
                <i class="fas fa-paper-plane me-1"></i> Đăng Bài Viết
            </button>
        </div>
    </form>
</div>

<?php require_once VIEW_PATH . '/layouts/admin_footer.php'; ?>
