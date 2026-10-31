<?php
// ==============================================================
// CONTROLLER: ADMIN (QUẢN TRỊ TOÀN DIỆN HỆ THỐNG QUẢN LÝ PHÒNG TRỌ)
// ==============================================================

class AdminController extends Controller {

    public function __construct() {
        Auth::requireAdmin();
    }

    public function index(): void {
        $this->dashboard();
    }

    /**
     * Dashboard tổng quan với biểu đồ doanh thu và các chỉ số thống kê
     */
    public function dashboard(): void {
        $roomModel = $this->model('Room');
        $tenantModel = $this->model('Tenant');
        $contractModel = $this->model('Contract');
        $invoiceModel = $this->model('Invoice');
        $maintenanceModel = $this->model('Maintenance');
        $bookingModel = $this->model('Booking');

        $currentMonth = (int)date('m');
        $currentYear = (int)date('Y');

        // Doanh thu tháng này
        $revRow = $invoiceModel->queryOne(
            "SELECT SUM(total_amount) as total, 
                    SUM(CASE WHEN status = 'paid' THEN total_amount ELSE 0 END) as paid,
                    SUM(CASE WHEN status = 'unpaid' THEN total_amount ELSE 0 END) as unpaid
             FROM invoices WHERE month = :m AND year = :y",
            [':m' => $currentMonth, ':y' => $currentYear]
        );

        $data = [
            'pageTitle' => 'Bảng Điều Khiển Quản Trị - Hệ Thống Nhà Trọ An Bình',
            'totalRooms' => $roomModel->count(),
            'availableRooms' => $roomModel->count("status = 'available'"),
            'rentedRooms' => $roomModel->count("status = 'rented'"),
            'maintenanceRooms' => $roomModel->count("status = 'maintenance'"),
            'totalTenants' => $tenantModel->count(),
            'activeContracts' => $contractModel->count("status = 'active'"),
            'monthRevenue' => (float)($revRow['total'] ?? 0),
            'paidRevenue' => (float)($revRow['paid'] ?? 0),
            'unpaidRevenue' => (float)($revRow['unpaid'] ?? 0),
            'pendingMaintenances' => $maintenanceModel->count("status = 'pending'"),
            'pendingBookings' => $bookingModel->count("status = 'pending'"),
            'revenueChart' => $invoiceModel->getMonthlyRevenueChart($currentYear),
            'recentBookings' => array_slice($bookingModel->getAllWithRoom(), 0, 5),
            'recentMaintenances' => array_slice($maintenanceModel->getAllWithDetails(), 0, 5)
        ];

        $this->view('admin/dashboard', $data);
    }

    // -------------------------------------------------------------
    // QUẢN LÝ PHÒNG TRỌ (ROOMS)
    // -------------------------------------------------------------
    public function rooms(): void {
        $roomModel = $this->model('Room');
        $branchModel = $this->model('Branch');
        $roomTypeModel = $this->model('RoomType');

        $rooms = $roomModel->getAllWithDetails();

        $data = [
            'pageTitle' => 'Quản Lý Danh Sách Phòng Trọ',
            'rooms' => $rooms,
            'branches' => $branchModel->all(),
            'roomTypes' => $roomTypeModel->all()
        ];
        $this->view('admin/rooms/index', $data);
    }

    public function roomAdd(): void {
        $roomModel = $this->model('Room');
        $branchModel = $this->model('Branch');
        $roomTypeModel = $this->model('RoomType');

        if ($this->isPost()) {
            $branchId = (int)$this->post('branch_id');
            $roomTypeId = (int)$this->post('room_type_id');
            $roomNumber = trim($this->post('room_number', ''));
            $title = trim($this->post('title', ''));
            $price = (float)$this->post('price', 0);
            $depositPrice = (float)$this->post('deposit_price', $price);
            $area = (float)$this->post('area', 20);
            $maxTenants = (int)$this->post('max_tenants', 2);
            $floor = (int)$this->post('floor', 1);
            $status = $this->post('status', 'available');
            $amenities = trim($this->post('amenities', ''));
            $description = trim($this->post('description', ''));
            $isFeatured = $this->post('is_featured') ? 1 : 0;

            // Xử lý upload ảnh nếu có
            $imagePath = 'assets/images/rooms/room1.jpg';
            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $newName = 'room_' . time() . '.' . $ext;
                $target = ROOT_PATH . '/assets/images/rooms/' . $newName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $imagePath = 'assets/images/rooms/' . $newName;
                }
            }

            $slug = slugify($title . ' ' . $roomNumber);

            $roomModel->create([
                'branch_id' => $branchId,
                'room_type_id' => $roomTypeId,
                'room_number' => htmlspecialchars($roomNumber),
                'title' => htmlspecialchars($title),
                'slug' => $slug,
                'price' => $price,
                'deposit_price' => $depositPrice,
                'area' => $area,
                'max_tenants' => $maxTenants,
                'floor' => $floor,
                'status' => $status,
                'amenities' => htmlspecialchars($amenities),
                'description' => htmlspecialchars($description),
                'image' => $imagePath,
                'is_featured' => $isFeatured
            ]);

            flash('Thêm phòng trọ mới thành công!', 'success');
            $this->redirect('admin/rooms');
        }

        $data = [
            'pageTitle' => 'Thêm Phòng Trọ Mới',
            'branches' => $branchModel->all(),
            'roomTypes' => $roomTypeModel->all()
        ];
        $this->view('admin/rooms/add', $data);
    }

    public function roomEdit(int $id = 0): void {
        $roomModel = $this->model('Room');
        $branchModel = $this->model('Branch');
        $roomTypeModel = $this->model('RoomType');

        $room = $roomModel->find($id);
        if (!$room) {
            flash('Phòng không tồn tại!', 'danger');
            $this->redirect('admin/rooms');
        }

        if ($this->isPost()) {
            $branchId = (int)$this->post('branch_id');
            $roomTypeId = (int)$this->post('room_type_id');
            $roomNumber = trim($this->post('room_number', ''));
            $title = trim($this->post('title', ''));
            $price = (float)$this->post('price', 0);
            $depositPrice = (float)$this->post('deposit_price', $price);
            $area = (float)$this->post('area', 20);
            $maxTenants = (int)$this->post('max_tenants', 2);
            $floor = (int)$this->post('floor', 1);
            $status = $this->post('status', 'available');
            $amenities = trim($this->post('amenities', ''));
            $description = trim($this->post('description', ''));
            $isFeatured = $this->post('is_featured') ? 1 : 0;

            $updateData = [
                'branch_id' => $branchId,
                'room_type_id' => $roomTypeId,
                'room_number' => htmlspecialchars($roomNumber),
                'title' => htmlspecialchars($title),
                'slug' => slugify($title . ' ' . $roomNumber),
                'price' => $price,
                'deposit_price' => $depositPrice,
                'area' => $area,
                'max_tenants' => $maxTenants,
                'floor' => $floor,
                'status' => $status,
                'amenities' => htmlspecialchars($amenities),
                'description' => htmlspecialchars($description),
                'is_featured' => $isFeatured
            ];

            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $newName = 'room_' . time() . '.' . $ext;
                $target = ROOT_PATH . '/assets/images/rooms/' . $newName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $updateData['image'] = 'assets/images/rooms/' . $newName;
                }
            }

            $roomModel->update($id, $updateData);
            flash('Cập nhật thông tin phòng thành công!', 'success');
            $this->redirect('admin/rooms');
        }

        $data = [
            'pageTitle' => 'Chỉnh Sửa Phòng ' . $room['room_number'],
            'room' => $room,
            'branches' => $branchModel->all(),
            'roomTypes' => $roomTypeModel->all()
        ];
        $this->view('admin/rooms/edit', $data);
    }

    public function roomDelete(int $id = 0): void {
        $roomModel = $this->model('Room');
        $room = $roomModel->find($id);
        if ($room) {
            $roomModel->delete($id);
            flash('Đã xóa phòng trọ thành công!', 'success');
        }
        $this->redirect('admin/rooms');
    }

    // -------------------------------------------------------------
    // QUẢN LÝ CƠ SỞ / KHU TRỌ (BRANCHES)
    // -------------------------------------------------------------
    public function branches(): void {
        $branchModel = $this->model('Branch');

        if ($this->isPost()) {
            $action = $this->post('action');
            if ($action === 'add') {
                $branchModel->create([
                    'name' => htmlspecialchars($this->post('name')),
                    'address' => htmlspecialchars($this->post('address')),
                    'ward' => htmlspecialchars($this->post('ward')),
                    'district' => htmlspecialchars($this->post('district')),
                    'city' => htmlspecialchars($this->post('city')),
                    'manager_name' => htmlspecialchars($this->post('manager_name')),
                    'manager_phone' => htmlspecialchars($this->post('manager_phone')),
                    'description' => htmlspecialchars($this->post('description'))
                ]);
                flash('Thêm khu trọ mới thành công!', 'success');
            } elseif ($action === 'edit') {
                $id = (int)$this->post('id');
                $branchModel->update($id, [
                    'name' => htmlspecialchars($this->post('name')),
                    'address' => htmlspecialchars($this->post('address')),
                    'ward' => htmlspecialchars($this->post('ward')),
                    'district' => htmlspecialchars($this->post('district')),
                    'city' => htmlspecialchars($this->post('city')),
                    'manager_name' => htmlspecialchars($this->post('manager_name')),
                    'manager_phone' => htmlspecialchars($this->post('manager_phone')),
                    'description' => htmlspecialchars($this->post('description'))
                ]);
                flash('Cập nhật khu trọ thành công!', 'success');
            }
            $this->redirect('admin/branches');
        }

        $data = [
            'pageTitle' => 'Quản Lý Khu Trọ / Tòa Nhà',
            'branches' => $branchModel->getAllWithRoomCount()
        ];
        $this->view('admin/branches/index', $data);
    }

    public function branchDelete(int $id = 0): void {
        $branchModel = $this->model('Branch');
        $branchModel->delete($id);
        flash('Đã xóa khu trọ!', 'success');
        $this->redirect('admin/branches');
    }

    // -------------------------------------------------------------
    // QUẢN LÝ LOẠI PHÒNG (ROOM TYPES)
    // -------------------------------------------------------------
    public function roomTypes(): void {
        $typeModel = $this->model('RoomType');

        if ($this->isPost()) {
            $action = $this->post('action');
            if ($action === 'add') {
                $typeModel->create([
                    'name' => htmlspecialchars($this->post('name')),
                    'description' => htmlspecialchars($this->post('description')),
                    'base_price' => (float)$this->post('base_price', 0)
                ]);
                flash('Thêm loại phòng mới thành công!', 'success');
            } elseif ($action === 'edit') {
                $id = (int)$this->post('id');
                $typeModel->update($id, [
                    'name' => htmlspecialchars($this->post('name')),
                    'description' => htmlspecialchars($this->post('description')),
                    'base_price' => (float)$this->post('base_price', 0)
                ]);
                flash('Cập nhật loại phòng thành công!', 'success');
            }
            $this->redirect('admin/roomTypes');
        }

        $data = [
            'pageTitle' => 'Quản Lý Loại Phòng Trọ',
            'roomTypes' => $typeModel->getAllWithRoomCount()
        ];
        $this->view('admin/room_types/index', $data);
    }

    public function roomTypeDelete(int $id = 0): void {
        $typeModel = $this->model('RoomType');
        $typeModel->delete($id);
        flash('Đã xóa loại phòng!', 'success');
        $this->redirect('admin/roomTypes');
    }

    // -------------------------------------------------------------
    // QUẢN LÝ KHÁCH THUÊ (TENANTS)
    // -------------------------------------------------------------
    public function tenants(): void {
        $tenantModel = $this->model('Tenant');
        $data = [
            'pageTitle' => 'Quản Lý Danh Sách Khách Thuê',
            'tenants' => $tenantModel->getAllWithRoom()
        ];
        $this->view('admin/tenants/index', $data);
    }

    public function tenantAdd(): void {
        $tenantModel = $this->model('Tenant');
        $userModel = $this->model('User');

        if ($this->isPost()) {
            $fullName = trim($this->post('full_name'));
            $idCard = trim($this->post('id_card'));
            $phone = trim($this->post('phone'));
            $email = trim($this->post('email'));
            $gender = $this->post('gender', 'male');
            $dob = $this->post('date_of_birth');
            $hometown = trim($this->post('hometown'));
            $temporary = trim($this->post('temporary_residence'));
            $createAccount = $this->post('create_account') ? true : false;

            $userId = null;
            if ($createAccount) {
                $username = 'tenant_' . preg_replace('/[^0-9]/', '', $phone);
                $userId = $userModel->create([
                    'role_id' => 2,
                    'username' => $username,
                    'password' => password_hash('123456', PASSWORD_BCRYPT),
                    'full_name' => htmlspecialchars($fullName),
                    'email' => htmlspecialchars($email),
                    'phone' => htmlspecialchars($phone),
                    'status' => 1
                ]);
            }

            $tenantModel->create([
                'user_id' => $userId,
                'full_name' => htmlspecialchars($fullName),
                'id_card' => htmlspecialchars($idCard),
                'phone' => htmlspecialchars($phone),
                'email' => htmlspecialchars($email),
                'gender' => $gender,
                'date_of_birth' => !empty($dob) ? $dob : null,
                'hometown' => htmlspecialchars($hometown),
                'temporary_residence' => htmlspecialchars($temporary)
            ]);

            flash('Thêm hồ sơ khách thuê thành công!' . ($userId ? ' (Tài khoản: ' . $username . ' / MK: 123456)' : ''), 'success');
            $this->redirect('admin/tenants');
        }

        $data = ['pageTitle' => 'Thêm Khách Thuê Mới'];
        $this->view('admin/tenants/add', $data);
    }

    public function tenantEdit(int $id = 0): void {
        $tenantModel = $this->model('Tenant');
        $tenant = $tenantModel->find($id);

        if (!$tenant) {
            flash('Khách thuê không tồn tại!', 'danger');
            $this->redirect('admin/tenants');
        }

        if ($this->isPost()) {
            $tenantModel->update($id, [
                'full_name' => htmlspecialchars($this->post('full_name')),
                'id_card' => htmlspecialchars($this->post('id_card')),
                'phone' => htmlspecialchars($this->post('phone')),
                'email' => htmlspecialchars($this->post('email')),
                'gender' => $this->post('gender', 'male'),
                'date_of_birth' => $this->post('date_of_birth') ?: null,
                'hometown' => htmlspecialchars($this->post('hometown')),
                'temporary_residence' => htmlspecialchars($this->post('temporary_residence'))
            ]);

            flash('Cập nhật khách thuê thành công!', 'success');
            $this->redirect('admin/tenants');
        }

        $data = [
            'pageTitle' => 'Chỉnh Sửa Khách Thuê: ' . $tenant['full_name'],
            'tenant' => $tenant
        ];
        $this->view('admin/tenants/edit', $data);
    }

    public function tenantDelete(int $id = 0): void {
        $tenantModel = $this->model('Tenant');
        $tenantModel->delete($id);
        flash('Đã xóa hồ sơ khách thuê!', 'success');
        $this->redirect('admin/tenants');
    }

    // -------------------------------------------------------------
    // QUẢN LÝ HỢP ĐỒNG (CONTRACTS)
    // -------------------------------------------------------------
    public function contracts(): void {
        $contractModel = $this->model('Contract');
        $data = [
            'pageTitle' => 'Quản Lý Hợp Đồng Thuê Phòng',
            'contracts' => $contractModel->getAllWithDetails()
        ];
        $this->view('admin/contracts/index', $data);
    }

    public function contractAdd(): void {
        $contractModel = $this->model('Contract');
        $roomModel = $this->model('Room');
        $tenantModel = $this->model('Tenant');

        if ($this->isPost()) {
            $roomId = (int)$this->post('room_id');
            $tenantId = (int)$this->post('tenant_id');
            $startDate = $this->post('start_date');
            $endDate = $this->post('end_date');
            $rentalPrice = (float)$this->post('rental_price');
            $depositAmount = (float)$this->post('deposit_amount');
            $initialElec = (int)$this->post('initial_electricity_index', 0);
            $initialWater = (int)$this->post('initial_water_index', 0);
            $terms = trim($this->post('terms'));

            $contractNumber = 'HD-' . date('Ym') . '-' . rand(100, 999);

            $contractModel->create([
                'contract_number' => $contractNumber,
                'room_id' => $roomId,
                'tenant_id' => $tenantId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'rental_price' => $rentalPrice,
                'deposit_amount' => $depositAmount,
                'initial_electricity_index' => $initialElec,
                'initial_water_index' => $initialWater,
                'terms' => htmlspecialchars($terms),
                'status' => 'active'
            ]);

            // Cập nhật trạng thái phòng thành 'rented'
            $roomModel->update($roomId, [
                'status' => 'rented',
                'current_tenants' => 1
            ]);

            flash('Tạo hợp đồng thuê phòng ' . $contractNumber . ' thành công!', 'success');
            $this->redirect('admin/contracts');
        }

        $data = [
            'pageTitle' => 'Lập Hợp Đồng Thuê Phòng Mới',
            'availableRooms' => $roomModel->where('status', 'available'),
            'tenants' => $tenantModel->all('full_name ASC')
        ];
        $this->view('admin/contracts/add', $data);
    }

    public function contractDetail(int $id = 0): void {
        $contractModel = $this->model('Contract');
        $contract = $contractModel->getDetailsById($id);

        if (!$contract) {
            flash('Hợp đồng không tồn tại!', 'danger');
            $this->redirect('admin/contracts');
        }

        $data = [
            'pageTitle' => 'Chi Tiết Hợp Đồng ' . $contract['contract_number'],
            'contract' => $contract
        ];
        $this->view('admin/contracts/detail', $data);
    }

    public function contractTerminate(int $id = 0): void {
        $contractModel = $this->model('Contract');
        $roomModel = $this->model('Room');

        $contract = $contractModel->find($id);
        if ($contract) {
            $contractModel->update($id, ['status' => 'terminated']);
            $roomModel->update($contract['room_id'], [
                'status' => 'available',
                'current_tenants' => 0
            ]);
            flash('Đã thanh lý kết thúc hợp đồng và cập nhật phòng về trạng thái Còn Trống!', 'success');
        }
        $this->redirect('admin/contracts');
    }

    // -------------------------------------------------------------
    // QUẢN LÝ CHỈ SỐ ĐIỆN NƯỚC (METER READINGS)
    // -------------------------------------------------------------
    public function meterReadings(): void {
        $meterModel = $this->model('MeterReading');
        $roomModel = $this->model('Room');

        $month = (int)$this->get('month', date('m'));
        $year = (int)$this->get('year', date('Y'));

        if ($this->isPost()) {
            $roomId = (int)$this->post('room_id');
            $m = (int)$this->post('month');
            $y = (int)$this->post('year');
            $oldElec = (int)$this->post('old_electricity');
            $newElec = (int)$this->post('new_electricity');
            $oldWater = (int)$this->post('old_water');
            $newWater = (int)$this->post('new_water');
            $notes = trim($this->post('notes'));

            $elecConsumed = max(0, $newElec - $oldElec);
            $waterConsumed = max(0, $newWater - $oldWater);

            $meterModel->create([
                'room_id' => $roomId,
                'month' => $m,
                'year' => $y,
                'old_electricity' => $oldElec,
                'new_electricity' => $newElec,
                'electricity_consumed' => $elecConsumed,
                'old_water' => $oldWater,
                'new_water' => $newWater,
                'water_consumed' => $waterConsumed,
                'recorded_date' => date('Y-m-d'),
                'notes' => htmlspecialchars($notes)
            ]);

            flash("Đã ghi nhận chỉ số điện nước tháng {$m}/{$y} thành công!", 'success');
            $this->redirect("admin/meterReadings?month={$m}&year={$y}");
        }

        $data = [
            'pageTitle' => "Chỉ Số Điện Nước Tháng {$month}/{$year}",
            'month' => $month,
            'year' => $year,
            'readings' => $meterModel->getAllWithDetails($month, $year),
            'rentedRooms' => $roomModel->where('status', 'rented')
        ];
        $this->view('admin/meter_readings/index', $data);
    }

    // -------------------------------------------------------------
    // QUẢN LÝ HÓA ĐƠN & TỰ ĐỘNG TÍNH TIỀN (INVOICES)
    // -------------------------------------------------------------
    public function invoices(): void {
        $invoiceModel = $this->model('Invoice');

        $filters = [
            'month' => $this->get('month', date('m')),
            'year' => $this->get('year', date('Y')),
            'status' => $this->get('status', '')
        ];

        $invoices = $invoiceModel->getAllWithDetails($filters);

        $data = [
            'pageTitle' => 'Quản Lý Hóa Đơn & Tiền Phòng',
            'invoices' => $invoices,
            'filters' => $filters
        ];
        $this->view('admin/invoices/index', $data);
    }

    /**
     * Tự động tạo hóa đơn tháng cho tất cả các phòng đang có hợp đồng hiệu lực
     */
    public function invoiceGenerate(): void {
        $contractModel = $this->model('Contract');
        $invoiceModel = $this->model('Invoice');
        $meterModel = $this->model('MeterReading');
        $serviceModel = $this->model('Service');

        $month = (int)$this->post('month', date('m'));
        $year = (int)$this->post('year', date('Y'));

        // Lấy tất cả hợp đồng active
        $contracts = $contractModel->getAllWithDetails();
        $activeContracts = array_filter($contracts, fn($c) => $c['status'] === 'active');

        $elecService = $serviceModel->findBy('name', 'Điện sinh hoạt') ?: ['price' => 3800];
        $waterService = $serviceModel->findBy('name', 'Nước máy sinh hoạt') ?: ['price' => 28000];
        $wifiService = $serviceModel->findBy('name', 'Internet Wifi tốc độ cao') ?: ['price' => 100000];
        $garbageService = $serviceModel->findBy('name', 'Phí vệ sinh & rác sinh hoạt') ?: ['price' => 50000];
        $parkingService = $serviceModel->findBy('name', 'Giữ xe máy') ?: ['price' => 100000];

        $createdCount = 0;

        foreach ($activeContracts as $c) {
            // Kiểm tra xem đã tạo hóa đơn tháng này cho phòng chưa
            $existing = $invoiceModel->queryOne(
                "SELECT id FROM invoices WHERE contract_id = :cid AND month = :m AND year = :y",
                [':cid' => $c['id'], ':m' => $month, ':y' => $year]
            );
            if ($existing) continue;

            // Tìm chỉ số điện nước tháng này của phòng
            $meter = $meterModel->queryOne(
                "SELECT * FROM meter_readings WHERE room_id = :rid AND month = :m AND year = :y",
                [':rid' => $c['room_id'], ':m' => $month, ':y' => $year]
            );

            $elecKwh = $meter ? $meter['electricity_consumed'] : 80;
            $waterM3 = $meter ? $meter['water_consumed'] : 6;

            $roomAmount = (float)$c['rental_price'];
            $elecAmount = $elecKwh * (float)$elecService['price'];
            $waterAmount = $waterM3 * (float)$waterService['price'];
            $fixedServices = (float)$wifiService['price'] + (float)$garbageService['price'] + (float)$parkingService['price'];
            $totalAmount = $roomAmount + $elecAmount + $waterAmount + $fixedServices;

            $invoiceCode = 'HD' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-P' . preg_replace('/[^0-9]/', '', $c['room_number']) . '-' . $year;

            // Hạn đóng tiền là ngày 5 tháng sau
            $dueDate = date('Y-m-d', strtotime("+5 days", strtotime("{$year}-{$month}-01")));

            $invId = $invoiceModel->create([
                'invoice_code' => $invoiceCode,
                'contract_id' => $c['id'],
                'room_id' => $c['room_id'],
                'tenant_id' => $c['tenant_id'],
                'month' => $month,
                'year' => $year,
                'room_amount' => $roomAmount,
                'electricity_amount' => $elecAmount,
                'water_amount' => $waterAmount,
                'service_amount' => $fixedServices,
                'total_amount' => $totalAmount,
                'due_date' => $dueDate,
                'status' => 'unpaid',
                'notes' => "Hóa đơn tiền phòng tháng {$month}/{$year}"
            ]);

            // Thêm chi tiết hóa đơn
            $invoiceModel->query(
                "INSERT INTO invoice_details (invoice_id, item_name, quantity, unit_price, subtotal, note) VALUES
                (:iid, 'Tiền thuê phòng', 1, :p1, :p1, 'Tháng {$month}/{$year}'),
                (:iid, 'Điện sinh hoạt', :q2, :u2, :s2, '{$elecKwh} kWh'),
                (:iid, 'Nước sinh hoạt', :q3, :u3, :s3, '{$waterM3} m3'),
                (:iid, 'Internet Wifi', 1, :p4, :p4, 'Gói phòng'),
                (:iid, 'Vệ sinh & rác', 1, :p5, :p5, 'Phí sinh hoạt'),
                (:iid, 'Giữ xe máy', 1, :p6, :p6, '1 xe')",
                [
                    ':iid' => $invId,
                    ':p1' => $roomAmount,
                    ':q2' => $elecKwh, ':u2' => $elecService['price'], ':s2' => $elecAmount,
                    ':q3' => $waterM3, ':u3' => $waterService['price'], ':s3' => $waterAmount,
                    ':p4' => $wifiService['price'],
                    ':p5' => $garbageService['price'],
                    ':p6' => $parkingService['price']
                ]
            );

            $createdCount++;
        }

        flash("Đã tự động khởi tạo {$createdCount} hóa đơn cho tháng {$month}/{$year}!", 'success');
        $this->redirect("admin/invoices?month={$month}&year={$year}");
    }

    public function invoiceDetail(int $id = 0): void {
        $invoiceModel = $this->model('Invoice');
        $settingModel = $this->model('Setting');

        $invoice = $invoiceModel->getDetailsById($id);
        if (!$invoice) {
            flash('Hóa đơn không tồn tại!', 'danger');
            $this->redirect('admin/invoices');
        }

        $items = $invoiceModel->getItems($id);
        $settings = $settingModel->getAllKeyValue();

        $bankBin = $settings['bank_bin'] ?? '970422';
        $bankAccount = $settings['bank_account'] ?? '0901234567';
        $amount = (int)$invoice['total_amount'];
        $qrDesc = "TT TIEN PHONG " . $invoice['invoice_code'];
        $vietQr = vietQrUrl($bankBin, $bankAccount, $amount, $qrDesc);

        $data = [
            'pageTitle' => 'Chi Tiết & In Hóa Đơn ' . $invoice['invoice_code'],
            'invoice' => $invoice,
            'items' => $items,
            'settings' => $settings,
            'vietQr' => $vietQr
        ];
        $this->view('admin/invoices/detail', $data);
    }

    public function invoiceStatus(int $id = 0): void {
        $invoiceModel = $this->model('Invoice');
        $status = $this->get('status', 'paid');
        $method = $this->get('method', 'Tiền mặt');

        $invoiceModel->update($id, [
            'status' => $status,
            'payment_date' => $status === 'paid' ? date('Y-m-d H:i:s') : null,
            'payment_method' => $status === 'paid' ? $method : null
        ]);

        flash('Đã cập nhật trạng thái hóa đơn thành công!', 'success');
        $this->redirect('admin/invoices');
    }

    // -------------------------------------------------------------
    // QUẢN LÝ DỊCH VỤ & BIỂU GIÁ (SERVICES)
    // -------------------------------------------------------------
    public function services(): void {
        $serviceModel = $this->model('Service');

        if ($this->isPost()) {
            $action = $this->post('action');
            if ($action === 'add') {
                $serviceModel->create([
                    'name' => htmlspecialchars($this->post('name')),
                    'price' => (float)$this->post('price'),
                    'unit' => htmlspecialchars($this->post('unit')),
                    'type' => $this->post('type', 'fixed'),
                    'description' => htmlspecialchars($this->post('description')),
                    'is_active' => 1
                ]);
                flash('Thêm dịch vụ thành công!', 'success');
            } elseif ($action === 'edit') {
                $id = (int)$this->post('id');
                $serviceModel->update($id, [
                    'name' => htmlspecialchars($this->post('name')),
                    'price' => (float)$this->post('price'),
                    'unit' => htmlspecialchars($this->post('unit')),
                    'type' => $this->post('type', 'fixed'),
                    'description' => htmlspecialchars($this->post('description'))
                ]);
                flash('Cập nhật biểu giá dịch vụ thành công!', 'success');
            }
            $this->redirect('admin/services');
        }

        $data = [
            'pageTitle' => 'Biểu Giá Dịch Vụ & Tiện Ích',
            'services' => $serviceModel->all('id ASC')
        ];
        $this->view('admin/services/index', $data);
    }

    // -------------------------------------------------------------
    // QUẢN LÝ SỰ CỐ / SỬA CHỮA (MAINTENANCE)
    // -------------------------------------------------------------
    public function maintenance(): void {
        $maintenanceModel = $this->model('Maintenance');

        if ($this->isPost()) {
            $id = (int)$this->post('id');
            $status = $this->post('status');
            $cost = (float)$this->post('cost', 0);
            $notes = trim($this->post('admin_notes', ''));

            $updateData = [
                'status' => $status,
                'cost' => $cost,
                'admin_notes' => htmlspecialchars($notes)
            ];
            if ($status === 'completed') {
                $updateData['resolved_at'] = date('Y-m-d H:i:s');
            }

            $maintenanceModel->update($id, $updateData);
            flash('Cập nhật xử lý sự cố thành công!', 'success');
            $this->redirect('admin/maintenance');
        }

        $data = [
            'pageTitle' => 'Xử Lý Sự Cố & Sửa Chữa',
            'requests' => $maintenanceModel->getAllWithDetails()
        ];
        $this->view('admin/maintenance/index', $data);
    }

    // -------------------------------------------------------------
    // QUẢN LÝ LỊCH HẸN XEM PHÒNG (BOOKINGS)
    // -------------------------------------------------------------
    public function bookings(): void {
        $bookingModel = $this->model('Booking');

        if ($this->get('action') && $this->get('id')) {
            $id = (int)$this->get('id');
            $status = $this->get('action'); // confirmed, cancelled, completed
            $bookingModel->update($id, ['status' => $status]);
            flash('Cập nhật lịch hẹn thành công!', 'success');
            $this->redirect('admin/bookings');
        }

        $data = [
            'pageTitle' => 'Quản Lý Lịch Hẹn Xem Phòng',
            'bookings' => $bookingModel->getAllWithRoom()
        ];
        $this->view('admin/bookings/index', $data);
    }

    // -------------------------------------------------------------
    // QUẢN LÝ BÀI VIẾT (POSTS)
    // -------------------------------------------------------------
    public function posts(): void {
        $postModel = $this->model('Post');
        $data = [
            'pageTitle' => 'Quản Lý Tin Tức & Cẩm Nang',
            'posts' => $postModel->getAllWithAuthor()
        ];
        $this->view('admin/posts/index', $data);
    }

    public function postAdd(): void {
        $postModel = $this->model('Post');

        if ($this->isPost()) {
            $title = trim($this->post('title'));
            $summary = trim($this->post('summary'));
            $content = $this->post('content');
            $slug = slugify($title);

            $imagePath = 'assets/images/posts/post1.jpg';
            if (!empty($_FILES['image']['name'])) {
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $newName = 'post_' . time() . '.' . $ext;
                $target = ROOT_PATH . '/assets/images/posts/' . $newName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $imagePath = 'assets/images/posts/' . $newName;
                }
            }

            $postModel->create([
                'title' => htmlspecialchars($title),
                'slug' => $slug,
                'summary' => htmlspecialchars($summary),
                'content' => $content,
                'image' => $imagePath,
                'author_id' => Auth::id(),
                'status' => 1
            ]);

            flash('Đăng bài viết mới thành công!', 'success');
            $this->redirect('admin/posts');
        }

        $data = ['pageTitle' => 'Thêm Bài Viết Mới'];
        $this->view('admin/posts/add', $data);
    }

    public function postDelete(int $id = 0): void {
        $postModel = $this->model('Post');
        $postModel->delete($id);
        flash('Đã xóa bài viết!', 'success');
        $this->redirect('admin/posts');
    }

    // -------------------------------------------------------------
    // QUẢN LÝ TÀI KHOẢN NGƯỜI DÙNG (USERS)
    // -------------------------------------------------------------
    public function users(): void {
        $userModel = $this->model('User');
        $data = [
            'pageTitle' => 'Quản Lý Tài Khoản Hệ Thống',
            'users' => $userModel->getAllWithRole()
        ];
        $this->view('admin/users/index', $data);
    }

    public function userResetPassword(int $id = 0): void {
        $userModel = $this->model('User');
        $newPass = '123456';
        $userModel->update($id, [
            'password' => password_hash($newPass, PASSWORD_BCRYPT)
        ]);
        flash('Đã đặt lại mật khẩu về mặc định: 123456', 'success');
        $this->redirect('admin/users');
    }

    // -------------------------------------------------------------
    // CÀI ĐẶT HỆ THỐNG & TÀI KHOẢN NGÂN HÀNG VIETQR (SETTINGS)
    // -------------------------------------------------------------
    public function settings(): void {
        $settingModel = $this->model('Setting');

        if ($this->isPost()) {
            $settingsData = $this->post('settings', []);
            foreach ($settingsData as $k => $v) {
                $settingModel->set($k, trim($v));
            }
            flash('Cập nhật cài đặt hệ thống thành công!', 'success');
            $this->redirect('admin/settings');
        }

        $data = [
            'pageTitle' => 'Cài Đặt Hệ Thống & Cổng VietQR',
            'settings' => $settingModel->getAllKeyValue()
        ];
        $this->view('admin/settings', $data);
    }
}
