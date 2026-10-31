<?php
// ==============================================================
// CONTROLLER: TENANT (CỔNG THÔNG TIN KHÁCH THUÊ PHÒNG)
// ==============================================================

class TenantController extends Controller {

    public function __construct() {
        Auth::requireLogin();
    }

    /**
     * Trang tổng quan của khách thuê
     */
    public function index(): void {
        $tenantModel = $this->model('Tenant');
        $invoiceModel = $this->model('Invoice');
        $maintenanceModel = $this->model('Maintenance');

        $tenant = $tenantModel->getByUserId(Auth::id());
        $invoices = [];
        $maintenances = [];

        if ($tenant) {
            $invoices = $invoiceModel->getByTenantId($tenant['id']);
            $maintenances = $maintenanceModel->getByTenantId($tenant['id']);
        }

        $data = [
            'pageTitle' => 'Cổng Thông Tin Khách Thuê - ' . Auth::user()['full_name'],
            'tenant' => $tenant,
            'invoices' => array_slice($invoices, 0, 5),
            'maintenances' => array_slice($maintenances, 0, 5)
        ];

        $this->view('tenant/index', $data);
    }

    /**
     * Xem chi tiết hợp đồng thuê
     */
    public function contract(): void {
        $tenantModel = $this->model('Tenant');
        $contractModel = $this->model('Contract');

        $tenant = $tenantModel->getByUserId(Auth::id());
        $contract = null;

        if ($tenant && !empty($tenant['contract_id'])) {
            $contract = $contractModel->getDetailsById((int)$tenant['contract_id']);
        }

        $data = [
            'pageTitle' => 'Hợp Đồng Thuê Phòng Của Tôi',
            'tenant' => $tenant,
            'contract' => $contract
        ];

        $this->view('tenant/contract', $data);
    }

    /**
     * Danh sách hóa đơn của khách thuê
     */
    public function invoices(): void {
        $tenantModel = $this->model('Tenant');
        $invoiceModel = $this->model('Invoice');

        $tenant = $tenantModel->getByUserId(Auth::id());
        $invoices = $tenant ? $invoiceModel->getByTenantId($tenant['id']) : [];

        $data = [
            'pageTitle' => 'Lịch Sử Hóa Đơn & Tiền Phòng',
            'invoices' => $invoices,
            'tenant' => $tenant
        ];

        $this->view('tenant/invoices', $data);
    }

    /**
     * Chi tiết hóa đơn kèm mã thanh toán VietQR
     */
    public function invoiceDetail(int $id = 0): void {
        $tenantModel = $this->model('Tenant');
        $invoiceModel = $this->model('Invoice');
        $settingModel = $this->model('Setting');

        $tenant = $tenantModel->getByUserId(Auth::id());
        $invoice = $invoiceModel->getDetailsById($id);

        if (!$invoice || ($tenant && $invoice['tenant_id'] != $tenant['id'] && !Auth::isAdmin())) {
            flash('Hóa đơn không tồn tại hoặc bạn không có quyền xem!', 'danger');
            $this->redirect('tenant/invoices');
        }

        $items = $invoiceModel->getItems($id);
        $settings = $settingModel->getAllKeyValue();

        // Tạo link VietQR tự động
        $bankBin = $settings['bank_bin'] ?? '970422';
        $bankAccount = $settings['bank_account'] ?? '0901234567';
        $amount = (int)$invoice['total_amount'];
        $qrDesc = "TT TIEN PHONG " . $invoice['invoice_code'];
        $vietQr = vietQrUrl($bankBin, $bankAccount, $amount, $qrDesc);

        $data = [
            'pageTitle' => 'Chi Tiết Hóa Đơn ' . $invoice['invoice_code'],
            'invoice' => $invoice,
            'items' => $items,
            'settings' => $settings,
            'vietQr' => $vietQr
        ];

        $this->view('tenant/invoice_detail', $data);
    }

    /**
     * Báo hỏng / sự cố sửa chữa
     */
    public function maintenance(): void {
        $tenantModel = $this->model('Tenant');
        $maintenanceModel = $this->model('Maintenance');

        $tenant = $tenantModel->getByUserId(Auth::id());

        if ($this->isPost()) {
            $title = trim($this->post('title', ''));
            $description = trim($this->post('description', ''));

            if (empty($title) || empty($description)) {
                flash('Vui lòng nhập tiêu đề sự cố và mô tả chi tiết!', 'danger');
            } elseif (!$tenant || empty($tenant['room_id'])) {
                flash('Bạn hiện chưa thuê phòng nào để gửi yêu cầu sửa chữa!', 'warning');
            } else {
                $maintenanceModel->create([
                    'room_id' => $tenant['room_id'],
                    'tenant_id' => $tenant['id'],
                    'title' => htmlspecialchars($title),
                    'description' => htmlspecialchars($description),
                    'status' => 'pending'
                ]);

                flash('Đã gửi yêu cầu sửa chữa thành công! Kỹ thuật viên sẽ kiểm tra và khắc phục sớm nhất.', 'success');
                $this->redirect('tenant/maintenance');
            }
        }

        $requests = $tenant ? $maintenanceModel->getByTenantId($tenant['id']) : [];

        $data = [
            'pageTitle' => 'Báo Hỏng Thiết Bị & Sửa Chữa',
            'tenant' => $tenant,
            'requests' => $requests
        ];

        $this->view('tenant/maintenance', $data);
    }

    /**
     * Thông tin cá nhân & Đổi mật khẩu
     */
    public function profile(): void {
        $userModel = $this->model('User');
        $tenantModel = $this->model('Tenant');

        $user = $userModel->find(Auth::id());
        $tenant = $tenantModel->getByUserId(Auth::id());

        if ($this->isPost()) {
            $action = $this->post('action', 'update_info');

            if ($action === 'update_info') {
                $fullName = trim($this->post('full_name', ''));
                $phone = trim($this->post('phone', ''));
                $email = trim($this->post('email', ''));
                $hometown = trim($this->post('hometown', ''));

                if (empty($fullName) || empty($phone) || empty($email)) {
                    flash('Vui lòng điền đầy đủ các thông tin bắt buộc!', 'danger');
                } else {
                    $userModel->update(Auth::id(), [
                        'full_name' => htmlspecialchars($fullName),
                        'phone' => htmlspecialchars($phone),
                        'email' => htmlspecialchars($email)
                    ]);

                    if ($tenant) {
                        $tenantModel->update($tenant['id'], [
                            'full_name' => htmlspecialchars($fullName),
                            'phone' => htmlspecialchars($phone),
                            'email' => htmlspecialchars($email),
                            'hometown' => htmlspecialchars($hometown)
                        ]);
                    }

                    $_SESSION['user']['full_name'] = $fullName;
                    $_SESSION['user']['phone'] = $phone;
                    $_SESSION['user']['email'] = $email;

                    flash('Cập nhật thông tin thành công!', 'success');
                    $this->redirect('tenant/profile');
                }
            } elseif ($action === 'change_password') {
                $oldPassword = trim($this->post('old_password', ''));
                $newPassword = trim($this->post('new_password', ''));
                $confirmPassword = trim($this->post('confirm_password', ''));

                if (!password_verify($oldPassword, $user['password'])) {
                    flash('Mật khẩu hiện tại không chính xác!', 'danger');
                } elseif (strlen($newPassword) < 6) {
                    flash('Mật khẩu mới phải từ 6 ký tự trở lên!', 'danger');
                } elseif ($newPassword !== $confirmPassword) {
                    flash('Mật khẩu mới xác nhận không khớp!', 'danger');
                } else {
                    $userModel->update(Auth::id(), [
                        'password' => password_hash($newPassword, PASSWORD_BCRYPT)
                    ]);
                    flash('Đổi mật khẩu thành công!', 'success');
                    $this->redirect('tenant/profile');
                }
            }
        }

        $data = [
            'pageTitle' => 'Thông Tin Cá Nhân & Đổi Mật Khẩu',
            'user' => $user,
            'tenant' => $tenant
        ];

        $this->view('tenant/profile', $data);
    }
}
