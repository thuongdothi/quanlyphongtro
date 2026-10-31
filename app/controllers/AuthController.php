<?php
// ==============================================================
// CONTROLLER: AUTH (ĐĂNG NHẬP, ĐĂNG KÝ, ĐĂNG XUẤT)
// ==============================================================

class AuthController extends Controller {

    public function login(): void {
        if (Auth::check()) {
            if (Auth::isAdmin()) {
                $this->redirect('admin/dashboard');
            } else {
                $this->redirect('tenant');
            }
        }

        $error = null;

        if ($this->isPost()) {
            $username = trim($this->post('username', ''));
            $password = trim($this->post('password', ''));

            if (empty($username) || empty($password)) {
                $error = 'Vui lòng nhập tên đăng nhập và mật khẩu!';
            } else {
                $userModel = $this->model('User');
                $user = $userModel->findByUsername($username);

                if (!$user) {
                    $user = $userModel->findByEmail($username);
                }

                if ($user && password_verify($password, $user['password'])) {
                    if ($user['status'] != 1) {
                        $error = 'Tài khoản của bạn đang bị tạm khóa. Vui lòng liên hệ ban quản lý!';
                    } else {
                        // Đăng nhập thành công
                        Auth::login($user);

                        flash('Đăng nhập thành công! Chào mừng ' . $user['full_name'], 'success');
                        if (Auth::isAdmin()) {
                            $this->redirect('admin/dashboard');
                        } else {
                            $this->redirect('tenant');
                        }
                    }
                } else {
                    $error = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
                }
            }
        }

        $data = [
            'pageTitle' => 'Đăng Nhập Hệ Thống - Nhà Trọ An Bình',
            'error' => $error
        ];

        $this->view('auth/login', $data);
    }

    public function register(): void {
        if (Auth::check()) {
            $this->redirect('/');
        }

        $error = null;

        if ($this->isPost()) {
            $username = trim($this->post('username', ''));
            $fullName = trim($this->post('full_name', ''));
            $email = trim($this->post('email', ''));
            $phone = trim($this->post('phone', ''));
            $password = trim($this->post('password', ''));
            $confirmPassword = trim($this->post('confirm_password', ''));
            $idCard = trim($this->post('id_card', ''));
            $hometown = trim($this->post('hometown', ''));

            if (empty($username) || empty($fullName) || empty($email) || empty($phone) || empty($password)) {
                $error = 'Vui lòng điền đầy đủ các thông tin bắt buộc!';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải có độ dài tối thiểu từ 6 ký tự!';
            } elseif ($password !== $confirmPassword) {
                $error = 'Mật khẩu xác nhận không khớp!';
            } else {
                $userModel = $this->model('User');
                $tenantModel = $this->model('Tenant');

                if ($userModel->findByUsername($username)) {
                    $error = 'Tên đăng nhập này đã có người sử dụng!';
                } elseif ($userModel->findByEmail($email)) {
                    $error = 'Địa chỉ email này đã được đăng ký!';
                } else {
                    // Tạo tài khoản user với role tenant (2)
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $userId = $userModel->create([
                        'role_id' => 2,
                        'username' => htmlspecialchars($username),
                        'password' => $hashedPassword,
                        'full_name' => htmlspecialchars($fullName),
                        'email' => htmlspecialchars($email),
                        'phone' => htmlspecialchars($phone),
                        'status' => 1
                    ]);

                    // Tạo hồ sơ khách thuê liên kết
                    $tenantModel->create([
                        'user_id' => $userId,
                        'full_name' => htmlspecialchars($fullName),
                        'id_card' => htmlspecialchars($idCard ?: ('ID' . time())),
                        'phone' => htmlspecialchars($phone),
                        'email' => htmlspecialchars($email),
                        'hometown' => htmlspecialchars($hometown),
                        'temporary_residence' => 'Chưa đăng ký phòng'
                    ]);

                    flash('Đăng ký tài khoản thành công! Vui lòng đăng nhập.', 'success');
                    $this->redirect('auth/login');
                }
            }
        }

        $data = [
            'pageTitle' => 'Đăng Ký Tài Khoản Khách Thuê - Nhà Trọ An Bình',
            'error' => $error
        ];

        $this->view('auth/register', $data);
    }

    public function logout(): void {
        Auth::logout();
        flash('Bạn đã đăng xuất khỏi hệ thống thành công!', 'info');
        $this->redirect('auth/login');
    }
}
