-- ==============================================================
-- CƠ SỞ DỮ LIỆU: HỆ THỐNG QUẢN LÝ PHÒNG TRỌ (PHP & MYSQL)
-- Đồ Án Chuyên Đề Web PHP - Mô Hình MVC - Điểm A Chuẩn Mực
-- ==============================================================

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `invoice_details`;
DROP TABLE IF EXISTS `invoices`;
DROP TABLE IF EXISTS `meter_readings`;
DROP TABLE IF EXISTS `maintenance_requests`;
DROP TABLE IF EXISTS `bookings`;
DROP TABLE IF EXISTS `contracts`;
DROP TABLE IF EXISTS `tenants`;
DROP TABLE IF EXISTS `rooms`;
DROP TABLE IF EXISTS `room_types`;
DROP TABLE IF EXISTS `branches`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `contacts`;
DROP TABLE IF EXISTS `settings`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `roles`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. Bảng Vai trò (roles)
CREATE TABLE `roles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE,
    `description` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Quản trị viên / Chủ nhà trọ'),
(2, 'tenant', 'Khách thuê phòng');

-- 2. Bảng Người dùng (users)
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `role_id` INT NOT NULL DEFAULT 2,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `phone` VARCHAR(20) NOT NULL,
    `avatar` VARCHAR(255) DEFAULT 'assets/images/avatar-default.png',
    `status` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Mật khẩu admin: admin123 | Mật khẩu khách thuê: 123456
INSERT INTO `users` (`id`, `role_id`, `username`, `password`, `full_name`, `email`, `phone`, `status`) VALUES
(1, 1, 'admin', '$2y$10$8oiOihOChLgyMNTGQN7BNe/U5GkQelnD1ih3yZfRD8NnUjz.Ep.H6', 'Nguyễn Văn Quản Trị', 'admin@phongtroanbinh.com', '0901234567', 1),
(2, 2, 'khach1', '$2y$10$E6TfALuE.cAsksanXmqxAe0sF95k.3UkhXbWCe91LjuHqRrUTo5X6', 'Trần Thị Thu Thảo', 'thuthao@gmail.com', '0912345678', 1),
(3, 2, 'khach2', '$2y$10$E6TfALuE.cAsksanXmqxAe0sF95k.3UkhXbWCe91LjuHqRrUTo5X6', 'Lê Hoàng Nam', 'hoangnam@gmail.com', '0987654321', 1),
(4, 2, 'khach3', '$2y$10$E6TfALuE.cAsksanXmqxAe0sF95k.3UkhXbWCe91LjuHqRrUTo5X6', 'Phạm Minh Đức', 'minhduc@gmail.com', '0934567890', 1);

-- 3. Bảng Chi nhánh / Khu trọ (branches)
CREATE TABLE `branches` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `ward` VARCHAR(100) NULL,
    `district` VARCHAR(100) NOT NULL,
    `city` VARCHAR(100) NOT NULL,
    `manager_name` VARCHAR(100) NOT NULL,
    `manager_phone` VARCHAR(20) NOT NULL,
    `description` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `branches` (`id`, `name`, `address`, `ward`, `district`, `city`, `manager_name`, `manager_phone`, `description`) VALUES
(1, 'Cơ sở 1 - An Bình Cầu Giấy', 'Số 26 Ngõ 165 Cầu Giấy', 'Dịch Vọng', 'Cầu Giấy', 'Hà Nội', 'Nguyễn Văn Quản Trị', '0901234567', 'Gần các trường ĐH Quốc Gia, Sư Phạm, Báo Chí. Tòa nhà 5 tầng có thang máy, camera an ninh, khóa vân tay.'),
(2, 'Cơ sở 2 - An Bình Bình Thạnh', '158/24 Xô Viết Nghệ Tĩnh', 'Phường 21', 'Bình Thạnh', 'TP. Hồ Chí Minh', 'Trần Văn Quản Lý', '0909888999', 'Gần HUTECH, UEF, Ngoại Thương CS2. Khu dân cư văn minh yên tĩnh, giờ giấc tự do không chung chủ.'),
(3, 'Cơ sở 3 - An Bình Quận 10', '497/12 Sư Vạn Hạnh', 'Phường 12', 'Quận 10', 'TP. Hồ Chí Minh', 'Lê Thị Thu Trúc', '0918777666', 'Trung tâm Quận 10, gần ĐH Bách Khoa, Huflit, bệnh viện 115. Phòng studio cao cấp ban công.');

-- 4. Bảng Loại phòng (room_types)
CREATE TABLE `room_types` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `description` TEXT NULL,
    `base_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `room_types` (`id`, `name`, `description`, `base_price`) VALUES
(1, 'Phòng Studio Full Đồ', 'Căn hộ mini đầy đủ máy lạnh, tủ lạnh, bếp riêng, máy giặt riêng, giường nệm cao cấp.', 4800000.00),
(2, 'Phòng Gác Lửng Hiện Đại', 'Phòng trọ cao trần đúc gác bê tông kiên cố, ốp gạch men sạch đẹp, thông thoáng.', 3600000.00),
(3, 'Phòng Đơn Ban Công Thoáng', 'Phòng có cửa sổ lớn và ban công đón nắng, máy lạnh, vệ sinh khép kín trong phòng.', 3200000.00),
(4, 'Phòng Tiêu Chuẩn Tiết Kiệm', 'Phòng nhỏ gọn tiện nghi cơ bản, máy lạnh, bình nóng lạnh, phù hợp 1-2 bạn sinh viên.', 2500000.00);

-- 5. Bảng Phòng trọ (rooms)
CREATE TABLE `rooms` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `branch_id` INT NOT NULL,
    `room_type_id` INT NOT NULL,
    `room_number` VARCHAR(20) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `price` DECIMAL(12,2) NOT NULL,
    `deposit_price` DECIMAL(12,2) NOT NULL,
    `area` FLOAT NOT NULL,
    `max_tenants` INT NOT NULL DEFAULT 2,
    `current_tenants` INT NOT NULL DEFAULT 0,
    `floor` INT NOT NULL DEFAULT 1,
    `status` ENUM('available', 'rented', 'maintenance') NOT NULL DEFAULT 'available',
    `description` TEXT NULL,
    `amenities` TEXT NULL,
    `image` VARCHAR(255) NULL,
    `is_featured` TINYINT NOT NULL DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`branch_id`) REFERENCES `branches`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`room_type_id`) REFERENCES `room_types`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rooms` (`id`, `branch_id`, `room_type_id`, `room_number`, `title`, `slug`, `price`, `deposit_price`, `area`, `max_tenants`, `current_tenants`, `floor`, `status`, `description`, `amenities`, `image`, `is_featured`) VALUES
(1, 1, 1, 'P.101', 'Phòng Studio 101 Full Nội Thất Cầu Giấy', 'phong-studio-101-full-noi-that-cau-giay', 5000000.00, 5000000.00, 28, 2, 2, 1, 'rented', 'Phòng studio tầng 1 thoáng mát, nội thất cao cấp: Tủ lạnh Panasonic, Máy lạnh Inverter, Máy giặt riêng, Sofa, Bếp từ.', 'Máy lạnh, Tủ lạnh, Bình nóng lạnh, Máy giặt riêng, Giường nệm, Tủ quần áo, Bếp điện, Wifi tốc độ cao, Khóa vân tay, Bãi xe rộng', 'assets/images/rooms/room1.jpg', 1),
(2, 1, 2, 'P.201', 'Phòng Gác Lửng 201 Ban Công Thoáng Mát', 'phong-gac-lung-201-ban-cong-thoang-mat', 3800000.00, 3800000.00, 25, 3, 2, 2, 'rented', 'Gác đúc bê tông đứng thẳng người, ban công đón gió trời tự nhiên, đã có máy lạnh và bình nóng lạnh.', 'Máy lạnh, Bình nóng lạnh, Gác lửng đúc, Ban công riêng, Wifi, Khóa cổng vân tay, Camera 24/7', 'assets/images/rooms/room2.jpg', 1),
(3, 1, 3, 'P.202', 'Phòng Đơn 202 Có Cửa Sổ View Đẹp', 'phong-don-202-co-cua-so-view-dep', 3300000.00, 3300000.00, 20, 2, 0, 2, 'available', 'Phòng đơn sạch sẽ, vệ sinh khép kín có vách kính tắm, bình nóng lạnh, máy lạnh mới 100%.', 'Máy lạnh, Bình nóng lạnh, Cửa sổ lớn, Vệ sinh khép kín, Giờ giấc tự do, Wifi', 'assets/images/rooms/room3.jpg', 1),
(4, 1, 4, 'P.301', 'Phòng Tiêu Chuẩn 301 Giá Rẻ Cho Sinh Viên', 'phong-tieu-chuan-301-gia-re-cho-sinh-vien', 2600000.00, 2600000.00, 18, 2, 0, 3, 'available', 'Phòng tầng 3 giá mềm, có quạt trần, bình nước nóng năng lượng mặt trời, nhà xe rộng rãi miễn phí.', 'Bình nóng lạnh, Quạt trần, Kệ bếp, Bãi để xe miễn phí, Wifi tốc độ cao', 'assets/images/rooms/room4.jpg', 0),
(5, 2, 1, 'P.102', 'Studio 102 Xô Viết Nghệ Tĩnh Bình Thạnh', 'studio-102-xo-viet-nghe-tinh-binh-thanh', 5200000.00, 5200000.00, 30, 3, 2, 1, 'rented', 'Phòng cao cấp trung tâm Bình Thạnh, di chuyển qua Q1 chỉ 5 phút. Nội thất chuẩn khách sạn 3 sao.', 'Máy lạnh, Tủ lạnh Inverter, Máy giặt, Bếp từ âm, Bàn làm việc, Tủ quần áo lớn, Khóa thông minh', 'assets/images/rooms/room5.jpg', 1),
(6, 2, 2, 'P.203', 'Phòng Gác Cao Ráo 203 Bình Thạnh', 'phong-gac-cao-rao-203-binh-thanh', 3700000.00, 3700000.00, 24, 3, 0, 2, 'available', 'Gác lửng lót gỗ sang trọng, trần thạch cao đèn led âm trần, WC rộng rãi lát gạch chống trượt.', 'Máy lạnh, Gác lửng gỗ, Bếp riêng, Bồn rửa chén inox, Cửa sổ trời, Camera an ninh', 'assets/images/rooms/room6.jpg', 1),
(7, 2, 3, 'P.302', 'Phòng Ban Công 302 Gần HUTECH', 'phong-ban-cong-302-gan-hutech', 3500000.00, 3500000.00, 22, 2, 0, 3, 'available', 'Vị trí đắc địa gần ngã tư Hàng Xanh, ban công phơi đồ riêng, máy lạnh tiết kiệm điện.', 'Máy lạnh, Ban công riêng, Bình nóng lạnh, Bãi xe có bảo vệ, Thang máy di chuyển', 'assets/images/rooms/room7.jpg', 0),
(8, 2, 4, 'P.401', 'Phòng 401 Đang Nâng Cấp Sơn Mới', 'phong-401-dang-nang-cap-son-moi', 2800000.00, 2800000.00, 20, 2, 0, 4, 'maintenance', 'Phòng đang bảo trì bảo dưỡng máy lạnh và sơn mới nước sơn.', 'Máy lạnh, Bình nóng lạnh, Kệ bếp, Cửa sổ', 'assets/images/rooms/room8.jpg', 0),
(9, 3, 1, 'P.303', 'Căn Hộ Mini 303 Sư Vạn Hạnh Quận 10', 'can-ho-mini-303-su-van-hanh-quan-10', 5500000.00, 5500000.00, 32, 3, 1, 3, 'rented', 'Căn hộ mini view thoáng ngắm thành phố, thang máy thẻ từ, bảo vệ 24/7, đầy đủ tiện nghi nhập khẩu.', 'Thang máy thẻ từ, Máy lạnh, Tủ lạnh 2 cánh, Máy giặt sấy, Tủ quần áo âm tường, Smart TV, Sofa', 'assets/images/rooms/room9.jpg', 1),
(10, 3, 2, 'P.402', 'Phòng Gác Đúc 402 Q10 Cực Đẹp', 'phong-gac-duc-402-q10-cuc-dep', 4000000.00, 4000000.00, 26, 3, 0, 4, 'available', 'Không gian hiện đại phong cách Bắc Âu tối giản, có bàn học và giá sách tích hợp.', 'Máy lạnh Inverter, Gác đúc cao cấp, Bếp nấu ăn riêng, Wifi riêng từng phòng, Khóa vân tay', 'assets/images/rooms/room10.jpg', 1),
(11, 3, 3, 'P.501', 'Phòng 501 View Sân Thượng Thoáng Mát', 'phong-501-view-san-thuong-thoang-mat', 3600000.00, 3600000.00, 22, 2, 0, 5, 'available', 'Sát sân thượng lộng gió ngắm cảnh đêm Sài Gòn, rất phù hợp bạn trẻ thích không gian chill.', 'Máy lạnh, Bình nước nóng, Sân thượng BBQ chung, Giờ tự do, Bãi xe rộng', 'assets/images/rooms/room11.jpg', 0),
(12, 3, 4, 'P.103', 'Phòng Tầng Trệt 103 Tiện Đi Lại', 'phong-tang-tret-103-tien-di-lai', 3200000.00, 3200000.00, 20, 2, 0, 1, 'available', 'Phòng ngay tầng trệt không cần leo lầu, phù hợp ai thích tiện lợi hoặc có xe đắt tiền.', 'Máy lạnh, Bình nóng lạnh, Kệ bếp, Cửa sổ lớn, Vệ sinh riêng', 'assets/images/rooms/room12.jpg', 0);

-- 6. Bảng Khách thuê (tenants)
CREATE TABLE `tenants` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `id_card` VARCHAR(20) NOT NULL UNIQUE,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `gender` ENUM('male', 'female', 'other') NOT NULL DEFAULT 'male',
    `date_of_birth` DATE NULL,
    `hometown` VARCHAR(100) NULL,
    `temporary_residence` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tenants` (`id`, `user_id`, `full_name`, `id_card`, `phone`, `email`, `gender`, `date_of_birth`, `hometown`, `temporary_residence`) VALUES
(1, 2, 'Trần Thị Thu Thảo', '038198001234', '0912345678', 'thuthao@gmail.com', 'female', '2002-05-15', 'Nam Định', 'Tạm trú tại P.101 Cầu Giấy, Hà Nội'),
(2, 3, 'Lê Hoàng Nam', '079201005678', '0987654321', 'hoangnam@gmail.com', 'male', '2001-08-20', 'Thanh Hóa', 'Tạm trú tại P.201 Cầu Giấy, Hà Nội'),
(3, 4, 'Phạm Minh Đức', '040200009876', '0934567890', 'minhduc@gmail.com', 'male', '2000-11-10', 'Hải Phòng', 'Tạm trú tại P.102 Bình Thạnh, TP.HCM'),
(4, NULL, 'Võ Ngọc Lan', '079302004561', '0945678123', 'ngoclan@gmail.com', 'female', '2003-03-25', 'Đồng Nai', 'Tạm trú tại P.303 Quận 10, TP.HCM'),
(5, NULL, 'Đỗ Khắc Cường', '001201007890', '0978123456', 'khaccuong@gmail.com', 'male', '1999-09-12', 'Bắc Ninh', 'Chưa ký hợp đồng');

-- 7. Bảng Hợp đồng thuê (contracts)
CREATE TABLE `contracts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `contract_number` VARCHAR(50) NOT NULL UNIQUE,
    `room_id` INT NOT NULL,
    `tenant_id` INT NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `rental_price` DECIMAL(12,2) NOT NULL,
    `deposit_amount` DECIMAL(12,2) NOT NULL,
    `initial_electricity_index` INT NOT NULL DEFAULT 0,
    `initial_water_index` INT NOT NULL DEFAULT 0,
    `payment_cycle` INT NOT NULL DEFAULT 1,
    `terms` TEXT NULL,
    `status` ENUM('active', 'expired', 'terminated') NOT NULL DEFAULT 'active',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE RESTRICT,
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contracts` (`id`, `contract_number`, `room_id`, `tenant_id`, `start_date`, `end_date`, `rental_price`, `deposit_amount`, `initial_electricity_index`, `initial_water_index`, `payment_cycle`, `terms`, `status`) VALUES
(1, 'HD-2026-001', 1, 1, '2026-01-01', '2026-12-31', 5000000.00, 5000000.00, 120, 45, 1, 'Bên thuê thanh toán tiền thuê từ ngày 1 đến ngày 5 hàng tháng. Giữ gìn an ninh trật tự, không hút thuốc trong phòng kín.', 'active'),
(2, 'HD-2026-002', 2, 2, '2026-03-01', '2027-02-28', 3800000.00, 3800000.00, 310, 80, 1, 'Hợp đồng thời hạn 1 năm. Kết thúc trước hạn phải báo trước 30 ngày.', 'active'),
(3, 'HD-2026-003', 5, 3, '2026-02-15', '2027-02-14', 5200000.00, 5200000.00, 205, 50, 1, 'Tiền cọc 1 tháng tiền phòng. Hoàn trả sau khi bàn giao phòng nguyên vẹn.', 'active'),
(4, 'HD-2026-004', 9, 4, '2026-04-01', '2027-03-31', 5500000.00, 5500000.00, 85, 30, 1, 'Căn hộ đầy đủ nội thất bàn giao theo biên bản đính kèm.', 'active');

-- 8. Bảng Dịch vụ & Đơn giá (services)
CREATE TABLE `services` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `price` DECIMAL(12,2) NOT NULL,
    `unit` VARCHAR(50) NOT NULL,
    `type` ENUM('meter', 'fixed') NOT NULL DEFAULT 'fixed',
    `description` VARCHAR(255) NULL,
    `is_active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`id`, `name`, `price`, `unit`, `type`, `description`, `is_active`) VALUES
(1, 'Điện sinh hoạt', 3800.00, 'kWh (số)', 'meter', 'Tính theo chỉ số đồng hồ điện riêng từng phòng', 1),
(2, 'Nước máy sinh hoạt', 28000.00, 'm3 (khối)', 'meter', 'Tính theo chỉ số đồng hồ nước riêng từng phòng', 1),
(3, 'Internet Wifi tốc độ cao', 100000.00, 'Phòng/tháng', 'fixed', 'Cáp quang FPT 250Mbps phủ sóng mesh toàn khu', 1),
(4, 'Phí vệ sinh & rác sinh hoạt', 50000.00, 'Phòng/tháng', 'fixed', 'Dọn vệ sinh hành lang 3 lần/tuần, đổ rác hàng ngày', 1),
(5, 'Giữ xe máy', 100000.00, 'Xe/tháng', 'fixed', 'Bãi xe có camera an ninh và khóa từ chống trộm', 1),
(6, 'Dịch vụ giặt sấy chung', 50000.00, 'Người/tháng', 'fixed', 'Sử dụng máy giặt và sân phơi có mái che tự do', 1);

-- 9. Bảng Chỉ số điện nước (meter_readings)
CREATE TABLE `meter_readings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `room_id` INT NOT NULL,
    `month` INT NOT NULL,
    `year` INT NOT NULL,
    `old_electricity` INT NOT NULL,
    `new_electricity` INT NOT NULL,
    `electricity_consumed` INT NOT NULL,
    `old_water` INT NOT NULL,
    `new_water` INT NOT NULL,
    `water_consumed` INT NOT NULL,
    `recorded_date` DATE NOT NULL,
    `notes` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `meter_readings` (`id`, `room_id`, `month`, `year`, `old_electricity`, `new_electricity`, `electricity_consumed`, `old_water`, `new_water`, `water_consumed`, `recorded_date`, `notes`) VALUES
(1, 1, 9, 2026, 420, 510, 90, 85, 93, 8, '2026-09-30', 'Chỉ số tháng 9 phòng 101'),
(2, 1, 10, 2026, 510, 615, 105, 93, 102, 9, '2026-10-30', 'Chỉ số tháng 10 phòng 101'),
(3, 2, 9, 2026, 580, 660, 80, 115, 121, 6, '2026-09-30', 'Chỉ số tháng 9 phòng 201'),
(4, 2, 10, 2026, 660, 755, 95, 121, 128, 7, '2026-10-30', 'Chỉ số tháng 10 phòng 201'),
(5, 5, 9, 2026, 320, 440, 120, 72, 82, 10, '2026-09-30', 'Chỉ số tháng 9 phòng 102'),
(6, 5, 10, 2026, 440, 570, 130, 82, 93, 11, '2026-10-30', 'Chỉ số tháng 10 phòng 102'),
(7, 9, 9, 2026, 180, 290, 110, 50, 58, 8, '2026-09-30', 'Chỉ số tháng 9 phòng 303'),
(8, 9, 10, 2026, 290, 415, 125, 58, 67, 9, '2026-10-30', 'Chỉ số tháng 10 phòng 303');

-- 10. Bảng Hóa đơn thanh toán (invoices)
CREATE TABLE `invoices` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `invoice_code` VARCHAR(50) NOT NULL UNIQUE,
    `contract_id` INT NOT NULL,
    `room_id` INT NOT NULL,
    `tenant_id` INT NOT NULL,
    `month` INT NOT NULL,
    `year` INT NOT NULL,
    `room_amount` DECIMAL(12,2) NOT NULL,
    `electricity_amount` DECIMAL(12,2) NOT NULL,
    `water_amount` DECIMAL(12,2) NOT NULL,
    `service_amount` DECIMAL(12,2) NOT NULL,
    `other_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `total_amount` DECIMAL(12,2) NOT NULL,
    `due_date` DATE NOT NULL,
    `payment_date` DATETIME NULL,
    `payment_method` VARCHAR(50) NULL,
    `status` ENUM('unpaid', 'paid', 'overdue') NOT NULL DEFAULT 'unpaid',
    `notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`contract_id`) REFERENCES `contracts`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `invoices` (`id`, `invoice_code`, `contract_id`, `room_id`, `tenant_id`, `month`, `year`, `room_amount`, `electricity_amount`, `water_amount`, `service_amount`, `other_amount`, `total_amount`, `due_date`, `payment_date`, `payment_method`, `status`, `notes`) VALUES
(1, 'HD09-P101-2026', 1, 1, 1, 9, 2026, 5000000.00, 342000.00, 224000.00, 250000.00, 0.00, 5816000.00, '2026-10-05', '2026-10-04 14:30:00', 'Chuyển khoản VietQR', 'paid', 'Đã thanh toán đúng hạn'),
(2, 'HD10-P101-2026', 1, 1, 1, 10, 2026, 5000000.00, 399000.00, 252000.00, 250000.00, 0.00, 5901000.00, '2026-11-05', NULL, NULL, 'unpaid', 'Tiền phòng và điện nước tháng 10/2026'),
(3, 'HD09-P201-2026', 2, 2, 2, 9, 2026, 3800000.00, 304000.00, 168000.00, 250000.00, 0.00, 4522000.00, '2026-10-05', '2026-10-05 09:15:00', 'Chuyển khoản VietQR', 'paid', 'Đã nhận tiền qua ngân hàng'),
(4, 'HD10-P201-2026', 2, 2, 2, 10, 2026, 3800000.00, 361000.00, 196000.00, 250000.00, 0.00, 4607000.00, '2026-11-05', NULL, NULL, 'unpaid', 'Tiền phòng và điện nước tháng 10/2026'),
(5, 'HD09-P102-2026', 3, 5, 3, 9, 2026, 5200000.00, 456000.00, 280000.00, 250000.00, 0.00, 6186000.00, '2026-10-05', '2026-10-03 20:00:00', 'Tiền mặt', 'paid', 'Thu tiền mặt tại phòng'),
(6, 'HD10-P102-2026', 3, 5, 3, 10, 2026, 5200000.00, 494000.00, 308000.00, 250000.00, 0.00, 6252000.00, '2026-11-05', NULL, NULL, 'unpaid', 'Hóa đơn tháng 10/2026'),
(7, 'HD09-P303-2026', 4, 9, 4, 9, 2026, 5500000.00, 418000.00, 224000.00, 250000.00, 0.00, 6392000.00, '2026-10-05', '2026-10-04 11:20:00', 'Chuyển khoản VietQR', 'paid', 'Đã thanh toán'),
(8, 'HD10-P303-2026', 4, 9, 4, 10, 2026, 5500000.00, 475000.00, 252000.00, 250000.00, 0.00, 6477000.00, '2026-11-05', NULL, NULL, 'unpaid', 'Hóa đơn tháng 10/2026');

-- 11. Bảng Chi tiết hóa đơn (invoice_details)
CREATE TABLE `invoice_details` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `invoice_id` INT NOT NULL,
    `item_name` VARCHAR(100) NOT NULL,
    `quantity` DECIMAL(10,2) NOT NULL DEFAULT 1.00,
    `unit_price` DECIMAL(12,2) NOT NULL,
    `subtotal` DECIMAL(12,2) NOT NULL,
    `note` VARCHAR(255) NULL,
    FOREIGN KEY (`invoice_id`) REFERENCES `invoices`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `invoice_details` (`invoice_id`, `item_name`, `quantity`, `unit_price`, `subtotal`, `note`) VALUES
(2, 'Tiền thuê phòng tháng 10/2026', 1.00, 5000000.00, 5000000.00, 'Phòng 101'),
(2, 'Điện sinh hoạt (Chỉ số: 510 -> 615)', 105.00, 3800.00, 399000.00, '105 kWh'),
(2, 'Nước máy sinh hoạt (Chỉ số: 93 -> 102)', 9.00, 28000.00, 252000.00, '9 m3'),
(2, 'Internet Wifi tốc độ cao', 1.00, 100000.00, 100000.00, '1 phòng'),
(2, 'Phí vệ sinh & rác', 1.00, 50000.00, 50000.00, '1 phòng'),
(2, 'Phí giữ xe máy (1 xe)', 1.00, 100000.00, 100000.00, '1 xe máy'),

(4, 'Tiền thuê phòng tháng 10/2026', 1.00, 3800000.00, 3800000.00, 'Phòng 201'),
(4, 'Điện sinh hoạt (Chỉ số: 660 -> 755)', 95.00, 3800.00, 361000.00, '95 kWh'),
(4, 'Nước máy sinh hoạt (Chỉ số: 121 -> 128)', 7.00, 28000.00, 196000.00, '7 m3'),
(4, 'Internet Wifi tốc độ cao', 1.00, 100000.00, 100000.00, '1 phòng'),
(4, 'Phí vệ sinh & rác', 1.00, 50000.00, 50000.00, '1 phòng'),
(4, 'Phí giữ xe máy', 1.00, 100000.00, 100000.00, '1 xe máy');

-- 12. Bảng Yêu cầu sửa chữa / Báo sự cố (maintenance_requests)
CREATE TABLE `maintenance_requests` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `room_id` INT NOT NULL,
    `tenant_id` INT NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `image` VARCHAR(255) NULL,
    `status` ENUM('pending', 'in_progress', 'completed', 'rejected') NOT NULL DEFAULT 'pending',
    `cost` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `admin_notes` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `resolved_at` DATETIME NULL,
    FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`tenant_id`) REFERENCES `tenants`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `maintenance_requests` (`id`, `room_id`, `tenant_id`, `title`, `description`, `status`, `cost`, `admin_notes`, `created_at`, `resolved_at`) VALUES
(1, 1, 1, 'Hỏng bóng đèn tuýp led khu vực bếp', 'Bóng đèn led trần bếp bị chớp tắt liên tục từ tối qua, nhờ ban quản lý cho thợ qua thay giúp.', 'completed', 80000.00, 'Đã cử thợ điện thay bóng tuýp led Rạng Đông mới', '2026-10-15 08:30:00', '2026-10-15 14:00:00'),
(2, 2, 2, 'Vòi xịt vệ sinh bị rò rỉ nước', 'Đầu vòi xịt trong nhà tắm bị rỉ nước liên tục gây hao nước, nhờ hỗ trợ thay gioăng cao su.', 'in_progress', 50000.00, 'Đã tiếp nhận, kỹ thuật đang qua xử lý', '2026-10-28 10:15:00', NULL),
(3, 5, 3, 'Điều hòa không mát, chỉ ra gió', 'Máy lạnh bật 16 độ nhưng không mát, có thể bị hết gas hoặc lâu ngày chưa vệ sinh lưới lọc.', 'pending', 0.00, NULL, '2026-10-30 09:00:00', NULL);

-- 13. Bảng Đặt lịch hẹn xem phòng (bookings)
CREATE TABLE `bookings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `room_id` INT NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `booking_date` DATE NOT NULL,
    `booking_time` VARCHAR(20) NOT NULL,
    `notes` TEXT NULL,
    `status` ENUM('pending', 'confirmed', 'cancelled', 'completed') NOT NULL DEFAULT 'pending',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `bookings` (`id`, `room_id`, `full_name`, `phone`, `email`, `booking_date`, `booking_time`, `notes`, `status`) VALUES
(1, 3, 'Hoàng Thùy Linh', '0918111222', 'thuylinh@gmail.com', '2026-11-02', '14:30', 'Em muốn qua xem phòng 202 vào chiều chủ nhật, nếu ưng em đặt cọc luôn.', 'confirmed'),
(2, 6, 'Nguyễn Tiến Dũng', '0988333444', 'tiendung@gmail.com', '2026-11-03', '09:00', 'Mình đi làm giờ hành chính nên chỉ xem được sáng sớm.', 'pending'),
(3, 10, 'Trần Minh Quân', '0977555666', 'minhquan@gmail.com', '2026-11-04', '18:00', 'Hẹn xem phòng sau giờ tan làm.', 'pending');

-- 14. Bảng Bài viết tin tức (posts)
CREATE TABLE `posts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `summary` TEXT NOT NULL,
    `content` LONGTEXT NOT NULL,
    `image` VARCHAR(255) NULL,
    `author_id` INT NOT NULL,
    `views` INT NOT NULL DEFAULT 0,
    `status` TINYINT NOT NULL DEFAULT 1,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `posts` (`id`, `title`, `slug`, `summary`, `content`, `image`, `author_id`, `views`, `status`) VALUES
(1, '5 Kinh nghiệm vàng khi tìm thuê phòng trọ cho sinh viên tân binh', '5-kinh-nghiem-vang-khi-tim-thue-phong-tro', 'Những điều lưu ý cực kỳ quan trọng về hợp đồng, tiền cọc, giá điện nước và an ninh khi tìm phòng trọ tại các thành phố lớn.', '<p>Khi bước vào ngưỡng cửa đại học hoặc bắt đầu đi làm tại các thành phố lớn như Hà Nội, TP.HCM, việc tìm kiếm một căn phòng trọ ưng ý, an toàn và chi phí hợp lý luôn là ưu tiên hàng đầu.</p><h3>1. Kiểm tra kỹ hợp đồng thuê và các khoản phí</h3><p>Hãy đọc thật kỹ thời hạn hợp đồng, số tiền cọc (thường là 1 tháng), điều kiện hoàn cọc và đơn giá các dịch vụ như điện, nước, internet, phí rác và gửi xe.</p><h3>2. Khảo sát an ninh khu vực xung quanh</h3><p>Nên chọn những nơi có camera an ninh, khóa cổng vân tay hoặc bảo vệ, tránh các con hẻm quá vắng vẻ vào ban đêm.</p><h3>3. Kiểm tra cơ sở vật chất phòng</h3><p>Kiểm tra vòi nước, bồn cầu, máy lạnh, đường điện trước khi ký biên bản bàn giao phòng để tránh phát sinh chi phí đền bù sau này.</p>', 'assets/images/posts/post1.jpg', 1, 150, 1),
(2, 'Hướng dẫn sử dụng thiết bị điện an toàn và tiết kiệm điện năng', 'huong-dan-su-dung-thiet-bi-dien-an-toan-va-tiet-kiem', 'Mẹo cài đặt nhiệt độ máy lạnh, cách sử dụng tủ lạnh và ngắt nguồn thiết bị giúp bạn tiết kiệm đến 30% tiền điện hàng tháng.', '<p>Tiền điện mùa hè luôn là nỗi lo lắng của các bạn thuê trọ. Dưới đây là những mẹo thiết thực giúp bạn tiết kiệm chi phí:</p><ul><li>Cài đặt máy lạnh ở mức 26-28 độ C kết hợp quạt gió nhẹ giúp phòng mát đều và tiết kiệm điện 20-30%.</li><li>Thường xuyên vệ sinh tấm lưới lọc bụi của máy lạnh mỗi tháng 1 lần.</li><li>Rút phích cắm các thiết bị điện tử khi không sử dụng thời gian dài.</li><li>Sử dụng bóng đèn LED tiết kiệm điện thay cho bóng sợi đốt truyền thống.</li></ul>', 'assets/images/posts/post2.jpg', 1, 89, 1),
(3, 'Nội quy an toàn phòng cháy chữa cháy (PCCC) tại hệ thống nhà trọ', 'noi-quy-an-toan-pccc-tai-he-thong-nha-tro', 'Các quy định nghiêm ngặt về an toàn điện, phòng ngừa cháy nổ và cách sử dụng bình chữa cháy mini tại tòa nhà.', '<p>Nhằm đảm bảo an toàn tính mạng và tài sản cho toàn thể cư dân trong hệ thống nhà trọ, Ban Quản Lý yêu cầu tất cả khách thuê nghiêm túc tuân thủ các quy định PCCC:</p><ol><li>Tuyệt đối không đun nấu bằng bếp gas mini không an toàn. Khuyến khích dùng bếp từ hoặc bếp hồng ngoại.</li><li>Không sạc xe đạp điện, xe máy điện qua đêm không có người trông coi tại khu vực tầng hầm.</li><li>Lối thoát hiểm và hành lang luôn phải thông thoáng, không để vật dụng cản trở.</li><li>Tự giác làm quen với vị trí đặt bình chữa cháy CO2 và bình bột tại mỗi tầng.</li></ol>', 'assets/images/posts/post3.jpg', 1, 230, 1);

-- 15. Bảng Tin nhắn liên hệ (contacts)
CREATE TABLE `contacts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `status` ENUM('unread', 'read') NOT NULL DEFAULT 'unread',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `contacts` (`id`, `full_name`, `email`, `phone`, `subject`, `message`, `status`) VALUES
(1, 'Lê Văn Bảy', 'baylevan@gmail.com', '0903112233', 'Hỏi thăm thuê phòng lâu dài cho 2 người', 'Chào ban quản lý, mình muốn hỏi cơ sở Bình Thạnh hiện còn phòng nào giá tầm 3.5tr - 4tr có gác không ạ? Chúng mình muốn thuê ở lâu dài.', 'unread'),
(2, 'Nguyễn Thị Hồng', 'hongnguyen@gmail.com', '0912445566', 'Chính sách nuôi thú cưng (mèo)', 'Cho mình hỏi ở cơ sở Cầu Giấy có cho phép nuôi 1 bé mèo nhỏ ngoan không làm ồn không ạ? Cảm ơn nhiều.', 'read');

-- 16. Bảng Cài đặt hệ thống (settings)
CREATE TABLE `settings` (
    `key_name` VARCHAR(50) PRIMARY KEY,
    `value` TEXT NOT NULL,
    `description` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`key_name`, `value`, `description`) VALUES
('site_name', 'HỆ THỐNG NHÀ TRỌ AN BÌNH', 'Tên thương hiệu hệ thống phòng trọ'),
('site_slogan', 'Phòng Trọ Tiện Nghi - An Ninh - Văn Minh - Đáng Sống', 'Khẩu hiệu của hệ thống'),
('hotline', '0901.234.567', 'Số điện thoại hỗ trợ 24/7'),
('email', 'hotro@phongtroanbinh.com', 'Email liên hệ'),
('address', 'Số 26 Ngõ 165 Cầu Giấy, TP. Hà Nội', 'Địa chỉ trụ sở chính'),
('bank_name', 'MBBANK', 'Tên ngân hàng (Dùng để hiển thị VietQR tự động)'),
('bank_account', '0901234567', 'Số tài khoản nhận tiền thuê trọ'),
('bank_owner', 'NGUYEN VAN QUAN TRI', 'Tên chủ tài khoản ngân hàng'),
('bank_bin', '970422', 'Mã BIN ngân hàng MBBank để tạo link VietQR chuẩn'),
('default_electricity_price', '3800', 'Giá điện mặc định (VNĐ/kWh)'),
('default_water_price', '28000', 'Giá nước mặc định (VNĐ/m3)'),
('rules', '1. Giữ gìn vệ sinh chung, không xả rác bừa bãi ra hành lang.\n2. Giờ giấc tự do nhưng hạn chế gây ồn sau 23h đêm.\n3. Khách tới chơi qua đêm phải báo trước với quản lý theo quy định.\n4. Đóng tiền phòng đúng hạn từ ngày 1 đến ngày 5 hàng tháng.', 'Nội quy phòng trọ');
