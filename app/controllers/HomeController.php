<?php
// ==============================================================
// CONTROLLER: HOME (TRANG CHỦ, GIỚI THIỆU, TIN TỨC, LIÊN HỆ)
// ==============================================================

class HomeController extends Controller {

    public function index(): void {
        $roomModel = $this->model('Room');
        $branchModel = $this->model('Branch');
        $roomTypeModel = $this->model('RoomType');
        $postModel = $this->model('Post');
        $settingModel = $this->model('Setting');

        $data = [
            'pageTitle' => 'Hệ Thống Nhà Trọ An Bình - Cho Thuê Phòng Trọ Tiện Nghi, Giá Tốt',
            'featuredRooms' => $roomModel->getFeatured(6),
            'latestRooms' => $roomModel->getLatest(6),
            'branches' => $branchModel->getAllWithRoomCount(),
            'roomTypes' => $roomTypeModel->all(),
            'posts' => $postModel->getActivePosts(3),
            'settings' => $settingModel->getAllKeyValue(),
            'totalRooms' => $roomModel->count(),
            'availableRooms' => $roomModel->count("status = 'available'")
        ];

        $this->view('home/index', $data);
    }

    public function about(): void {
        $branchModel = $this->model('Branch');
        $settingModel = $this->model('Setting');

        $data = [
            'pageTitle' => 'Giới Thiệu - Hệ Thống Nhà Trọ An Bình',
            'branches' => $branchModel->all(),
            'settings' => $settingModel->getAllKeyValue()
        ];

        $this->view('home/about', $data);
    }

    public function contact(): void {
        $settingModel = $this->model('Setting');
        $contactModel = $this->model('Contact');

        $success = null;
        $error = null;

        if ($this->isPost()) {
            $fullName = trim($this->post('full_name', ''));
            $email = trim($this->post('email', ''));
            $phone = trim($this->post('phone', ''));
            $subject = trim($this->post('subject', ''));
            $message = trim($this->post('message', ''));

            if (empty($fullName) || empty($phone) || empty($message)) {
                $error = 'Vui lòng điền đầy đủ Họ tên, Số điện thoại và Nội dung liên hệ!';
            } else {
                $contactModel->create([
                    'full_name' => htmlspecialchars($fullName),
                    'email' => htmlspecialchars($email),
                    'phone' => htmlspecialchars($phone),
                    'subject' => htmlspecialchars($subject ?: 'Liên hệ từ website'),
                    'message' => htmlspecialchars($message),
                    'status' => 'unread'
                ]);
                $success = 'Cảm ơn bạn đã gửi liên hệ! Ban quản lý sẽ phản hồi trong thời gian sớm nhất.';
            }
        }

        $data = [
            'pageTitle' => 'Liên Hệ & Hỗ Trợ - Nhà Trọ An Bình',
            'settings' => $settingModel->getAllKeyValue(),
            'success' => $success,
            'error' => $error
        ];

        $this->view('home/contact', $data);
    }

    public function news(): void {
        $postModel = $this->model('Post');
        $data = [
            'pageTitle' => 'Tin Tức & Cẩm Nang Thuê Trọ',
            'posts' => $postModel->getActivePosts(12)
        ];
        $this->view('home/news', $data);
    }

    public function postDetail(string $slug = ''): void {
        $postModel = $this->model('Post');
        $post = $postModel->getBySlug($slug);

        if (!$post) {
            $this->redirect('home/news');
        }

        $postModel->incrementViews($post['id']);
        $relatedPosts = $postModel->getActivePosts(4);

        $data = [
            'pageTitle' => $post['title'],
            'post' => $post,
            'relatedPosts' => $relatedPosts
        ];

        $this->view('home/post_detail', $data);
    }
}
