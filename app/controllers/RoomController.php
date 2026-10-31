<?php
// ==============================================================
// CONTROLLER: ROOM (DANH SÁCH PHÒNG, TÌM KIẾM, AJAX, CHI TIẾT & ĐẶT LỊCH)
// ==============================================================

class RoomController extends Controller {

    public function index(): void {
        $roomModel = $this->model('Room');
        $branchModel = $this->model('Branch');
        $roomTypeModel = $this->model('RoomType');

        $filters = [
            'keyword' => $this->get('kw', ''),
            'branch_id' => $this->get('branch', ''),
            'room_type_id' => $this->get('type', ''),
            'status' => $this->get('status', ''),
            'min_price' => $this->get('min_price', ''),
            'max_price' => $this->get('max_price', ''),
            'sort' => $this->get('sort', 'newest')
        ];

        $page = max(1, (int)$this->get('page', 1));
        $perPage = 6;

        $roomData = $roomModel->filter($filters, $page, $perPage);

        $data = [
            'pageTitle' => 'Danh Sách Phòng Trọ - Tìm Phòng Trọ Nhanh Chóng',
            'rooms' => $roomData['data'],
            'total' => $roomData['total'],
            'page' => $roomData['page'],
            'totalPages' => $roomData['total_pages'],
            'filters' => $filters,
            'branches' => $branchModel->all(),
            'roomTypes' => $roomTypeModel->all()
        ];

        $this->view('rooms/index', $data);
    }

    /**
     * AJAX Endpoint: Tìm kiếm và lọc phòng trọ tức thì không cần tải lại trang
     */
    public function ajaxFilter(): void {
        $roomModel = $this->model('Room');

        $filters = [
            'keyword' => $this->get('kw', ''),
            'branch_id' => $this->get('branch', ''),
            'room_type_id' => $this->get('type', ''),
            'status' => $this->get('status', ''),
            'min_price' => $this->get('min_price', ''),
            'max_price' => $this->get('max_price', ''),
            'sort' => $this->get('sort', 'newest')
        ];

        $page = max(1, (int)$this->get('page', 1));
        $perPage = 6;

        $result = $roomModel->filter($filters, $page, $perPage);

        // Format lại dữ liệu cho phía frontend JS dễ render
        $rooms = array_map(function($r) {
            return [
                'id' => $r['id'],
                'room_number' => $r['room_number'],
                'title' => $r['title'],
                'slug' => $r['slug'],
                'price' => (float)$r['price'],
                'price_formatted' => formatMoney($r['price']),
                'deposit_formatted' => formatMoney($r['deposit_price']),
                'area' => $r['area'],
                'floor' => $r['floor'],
                'status' => $r['status'],
                'status_badge' => roomStatusBadge($r['status']),
                'image' => BASE_URL . '/' . ($r['image'] ?: 'assets/images/rooms/room1.jpg'),
                'branch_name' => $r['branch_name'],
                'branch_address' => $r['branch_address'],
                'city' => $r['city'],
                'room_type_name' => $r['room_type_name'],
                'url' => BASE_URL . '/room/detail/' . $r['slug']
            ];
        }, $result['data']);

        $this->json([
            'status' => 'success',
            'rooms' => $rooms,
            'total' => $result['total'],
            'page' => $result['page'],
            'totalPages' => $result['total_pages']
        ]);
    }

    /**
     * Trang xem chi tiết phòng trọ
     */
    public function detail(string $slug = ''): void {
        $roomModel = $this->model('Room');
        $serviceModel = $this->model('Service');

        $room = $roomModel->getDetailsBySlug($slug);
        if (!$room) {
            flash('Không tìm thấy phòng trọ bạn yêu cầu!', 'warning');
            $this->redirect('room');
        }

        $amenities = array_filter(array_map('trim', explode(',', $room['amenities'] ?? '')));
        $services = $serviceModel->getActiveServices();
        $relatedRooms = $roomModel->getFeatured(3);

        $data = [
            'pageTitle' => $room['title'] . ' (' . $room['room_number'] . ')',
            'room' => $room,
            'amenities' => $amenities,
            'services' => $services,
            'relatedRooms' => $relatedRooms
        ];

        $this->view('rooms/detail', $data);
    }

    /**
     * Xử lý gửi yêu cầu đặt lịch hẹn xem phòng
     */
    public function book(): void {
        if (!$this->isPost()) {
            $this->redirect('room');
        }

        $bookingModel = $this->model('Booking');

        $roomId = (int)$this->post('room_id', 0);
        $fullName = trim($this->post('full_name', ''));
        $phone = trim($this->post('phone', ''));
        $email = trim($this->post('email', ''));
        $bookingDate = trim($this->post('booking_date', ''));
        $bookingTime = trim($this->post('booking_time', ''));
        $notes = trim($this->post('notes', ''));

        // Validate dữ liệu
        if ($roomId <= 0 || empty($fullName) || empty($phone) || empty($bookingDate) || empty($bookingTime)) {
            if ($this->get('is_ajax')) {
                $this->json(['status' => 'error', 'message' => 'Vui lòng điền đầy đủ các thông tin bắt buộc!'], 400);
            }
            flash('Vui lòng điền đầy đủ các thông tin bắt buộc!', 'danger');
            $this->redirect('room/detail/' . $this->post('room_slug', ''));
        }

        $bookingModel->create([
            'room_id' => $roomId,
            'full_name' => htmlspecialchars($fullName),
            'phone' => htmlspecialchars($phone),
            'email' => htmlspecialchars($email),
            'booking_date' => $bookingDate,
            'booking_time' => htmlspecialchars($bookingTime),
            'notes' => htmlspecialchars($notes),
            'status' => 'pending'
        ]);

        $message = "Đặt lịch hẹn xem phòng {$bookingDate} lúc {$bookingTime} thành công! Quản lý sẽ liên hệ lại với bạn qua số điện thoại để xác nhận.";

        if ($this->get('is_ajax')) {
            $this->json(['status' => 'success', 'message' => $message]);
        }

        flash($message, 'success');
        $this->redirect('room/detail/' . $this->post('room_slug', ''));
    }
}
