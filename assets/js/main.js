// ==============================================================
// JAVASCRIPT FRONTEND: TÌM KIẾM AJAX & TƯƠNG TÁC NGƯỜI DÙNG
// ==============================================================

document.addEventListener('DOMContentLoaded', function () {
    // 1. Tự động ẩn thông báo flash sau 5 giây
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            if (bsAlert) bsAlert.close();
        }, 5000);
    });

    // 2. Xử lý Lọc & Tìm kiếm phòng bằng AJAX (nếu ở trang danh sách phòng)
    const filterForm = document.getElementById('roomFilterForm');
    const roomListContainer = document.getElementById('roomListContainer');
    const roomCountBadge = document.getElementById('roomCountBadge');
    const paginationContainer = document.getElementById('paginationContainer');

    if (filterForm && roomListContainer) {
        let debounceTimer;

        function fetchFilteredRooms(page = 1) {
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            params.set('page', page);

            // Hiệu ứng đang tải (Loading spinner)
            roomListContainer.innerHTML = `
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="mt-2 text-muted fw-semibold">Đang tìm kiếm phòng phù hợp...</p>
                </div>
            `;

            fetch(filterForm.dataset.actionUrl + '?' + params.toString())
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        renderRoomCards(data.rooms);
                        if (roomCountBadge) {
                            roomCountBadge.textContent = `${data.total} phòng`;
                        }
                        renderPagination(data.page, data.totalPages);
                    }
                })
                .catch(err => {
                    console.error('Lỗi AJAX:', err);
                    roomListContainer.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <i class="fas fa-exclamation-circle text-danger fa-3x mb-3"></i>
                            <h5>Đã xảy ra sự cố khi tải dữ liệu!</h5>
                            <p class="text-muted">Vui lòng tải lại trang hoặc kiểm tra kết nối mạng.</p>
                        </div>
                    `;
                });
        }

        function renderRoomCards(rooms) {
            if (!rooms || rooms.length === 0) {
                roomListContainer.innerHTML = `
                    <div class="col-12 text-center py-5">
                        <div class="bg-light p-5 rounded-4 border">
                            <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                            <h5 class="fw-bold">Không tìm thấy phòng trọ nào phù hợp!</h5>
                            <p class="text-muted">Bạn hãy thử nới lỏng các tiêu chí tìm kiếm hoặc mức giá.</p>
                        </div>
                    </div>
                `;
                return;
            }

            let html = '';
            rooms.forEach(r => {
                html += `
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="room-card">
                            <div class="room-thumb-wrapper">
                                <img src="${r.image}" class="room-thumb" alt="${r.title}">
                                <div class="room-badge-status">${r.status_badge}</div>
                                <div class="room-badge-type">${r.room_type_name}</div>
                                <div class="room-price-tag">${r.price_formatted} <span style="font-size:0.75rem; color:#64748b; font-weight:normal;">/tháng</span></div>
                            </div>
                            <div class="room-body">
                                <h5 class="room-title">
                                    <a href="${r.url}">${r.title} (${r.room_number})</a>
                                </h5>
                                <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-danger me-1"></i> ${r.branch_address}, ${r.city}</p>
                                <div class="room-meta">
                                    <div class="room-meta-item"><i class="fas fa-vector-square text-primary"></i> ${r.area} m²</div>
                                    <div class="room-meta-item"><i class="fas fa-layer-group text-primary"></i> Tầng ${r.floor}</div>
                                    <div class="room-meta-item"><i class="fas fa-building text-primary"></i> ${r.branch_name}</div>
                                </div>
                                <div class="room-footer">
                                    <span class="small text-muted">Cọc: <strong>${r.deposit_formatted}</strong></span>
                                    <a href="${r.url}" class="btn btn-sm btn-outline-primary fw-bold">Chi tiết <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            roomListContainer.innerHTML = html;
        }

        function renderPagination(currentPage, totalPages) {
            if (!paginationContainer) return;
            if (totalPages <= 1) {
                paginationContainer.innerHTML = '';
                return;
            }

            let html = '<ul class="pagination justify-content-center">';
            // Nút Prev
            if (currentPage > 1) {
                html += `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}"><i class="fas fa-chevron-left"></i></a></li>`;
            }

            for (let i = 1; i <= totalPages; i++) {
                const active = i === currentPage ? 'active' : '';
                html += `<li class="page-item ${active}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
            }

            // Nút Next
            if (currentPage < totalPages) {
                html += `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}"><i class="fas fa-chevron-right"></i></a></li>`;
            }
            html += '</ul>';

            paginationContainer.innerHTML = html;

            paginationContainer.querySelectorAll('.page-link').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const page = parseInt(this.dataset.page);
                    if (page) fetchFilteredRooms(page);
                });
            });
        }

        // Bắt sự kiện thay đổi input để tìm kiếm AJAX
        filterForm.querySelectorAll('select, input[type="radio"]').forEach(el => {
            el.addEventListener('change', () => fetchFilteredRooms(1));
        });

        const kwInput = filterForm.querySelector('input[name="kw"]');
        if (kwInput) {
            kwInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => fetchFilteredRooms(1), 350);
            });
        }
    }

    // 3. Xử lý gửi Form Đặt lịch hẹn xem phòng bằng AJAX
    const bookingForm = document.getElementById('bookingModalForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btnSubmit = bookingForm.querySelector('button[type="submit"]');
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang gửi...';

            const formData = new FormData(bookingForm);
            fetch(bookingForm.action + '?is_ajax=1', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Xác Nhận Đặt Lịch';
                if (data.status === 'success') {
                    alert(data.message);
                    const modalEl = document.getElementById('bookingModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();
                    bookingForm.reset();
                } else {
                    alert(data.message || 'Đã có lỗi xảy ra!');
                }
            })
            .catch(err => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = '<i class="fas fa-paper-plane me-1"></i> Xác Nhận Đặt Lịch';
                alert('Không thể kết nối đến máy chủ. Vui lòng thử lại!');
            });
        });
    }
});
