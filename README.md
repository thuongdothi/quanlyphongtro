# ĐỒ ÁN CHUYÊN ĐỀ: HỆ THỐNG QUẢN LÝ PHÒNG TRỌ (NHÀ TRỌ AN BÌNH)

> **Môn học:** Lập trình Web PHP & MySQL  
> **Kiến trúc:** Mô hình MVC (Model - View - Controller), Hướng đối tượng (OOP), PDO Prepared Statements  
> **Giao diện:** Responsive HTML5/CSS3, Bootstrap 5, FontAwesome 6, Chart.js, AJAX Search & Filter  
> **Tính năng nổi bật:** Tự động tạo hóa đơn tiền trọ, thanh toán mã VietQR động NAPAS 24/7, Cổng thông tin khách thuê (Tenant Portal)  

---

## 1. TỔNG QUAN HỆ THỐNG

Dự án **Quản lý phòng trọ An Bình** là một hệ thống website động hoàn chỉnh phục vụ cả 2 đối tượng người dùng:
1. **Khách thuê & Người tìm phòng (Frontend):**
   - Khám phá danh sách phòng trọ tại nhiều cơ sở (Hà Nội, TP.HCM).
   - Bộ lọc động thông minh bằng **AJAX**: lọc theo khoảng giá, loại phòng, cơ sở, trạng thái còn trống/đang thuê mà không cần tải lại trang.
   - Chi tiết phòng trọ: thông số diện tích, tiện nghi, biểu phí dịch vụ, định vị cơ sở.
   - Đặt lịch hẹn xem phòng trực tuyến (Form AJAX Modal).
   - Xem nội quy, tin tức cẩm nang thuê trọ, gửi góp ý liên hệ.
   - **Cổng khách thuê (Tenant Portal):** Xem phòng đang thuê, tra cứu hợp đồng, xem hóa đơn tiền trọ hàng tháng, quét mã VietQR tự động điền số tài khoản và số tiền để thanh toán, gửi yêu cầu báo hỏng/sửa chữa thiết bị, đổi mật khẩu.

2. **Quản trị viên / Chủ trọ (Admin Dashboard):**
   - **Dashboard trực quan:** Thống kê số phòng, tỷ lệ lấp đầy, doanh thu tháng này, doanh thu năm bằng **Biểu đồ cột tương tác (Chart.js)**.
   - **Quản lý Phòng trọ:** Thêm, sửa, xóa phòng, upload ảnh đại diện, cài đặt giá thuê, tiền cọc, tiện ích.
   - **Quản lý Cơ sở / Khu trọ & Loại phòng:** Quản lý chuỗi nhà trọ theo quận/thành phố.
   - **Quản lý Khách thuê:** Lưu trữ CCCD/CMND, số điện thoại, quê quán, tạo tài khoản khách thuê tự động.
   - **Quản lý Hợp đồng thuê:** Lập hợp đồng mới (ràng buộc phòng còn trống, tính tiền cọc, chỉ số điện nước bàn giao), in hợp đồng, thanh lý hợp đồng.
   - **Ghi chỉ số Điện - Nước:** Nhập chỉ số cũ/mới hàng tháng, tự động tính điện năng và khối nước tiêu thụ.
   - **Quản lý Hóa đơn tự động:** Chức năng 1-click **Tự động lập hóa đơn tháng** cho toàn bộ phòng thuê dựa trên chỉ số điện nước + biểu giá dịch vụ, in hóa đơn có kèm VietQR, xác nhận thu tiền mặt.
   - **Xử lý sự cố / Báo hỏng:** Tiếp nhận phản ánh từ khách thuê, phân công kỹ thuật, cập nhật chi phí sửa chữa.
   - **Cài đặt hệ thống & VietQR:** Cấu hình tài khoản ngân hàng nhận tiền thuê trọ (tự động tạo QR code cho mọi hóa đơn).

---

## 2. TÀI KHOẢN ĐĂNG NHẬP SẴN CÓ

| Vai trò | Tên đăng nhập | Mật khẩu | Quyền hạn |
|---|---|---|---|
| **Quản trị viên (Admin)** | `admin` | `admin123` | Toàn quyền quản trị hệ thống, phòng, khách thuê, hợp đồng, hóa đơn, doanh thu |
| **Khách thuê 1 (Tenant)** | `khach1` | `123456` | Khách thuê phòng P.101 Cầu Giấy (xem HĐ, hóa đơn, VietQR, báo sự cố) |
| **Khách thuê 2 (Tenant)** | `khach2` | `123456` | Khách thuê phòng P.201 Cầu Giấy |
| **Khách thuê 3 (Tenant)** | `khach3` | `123456` | Khách thuê phòng P.102 Bình Thạnh |

---

## 3. CẤU TRÚC THƯ MỤC CHUẨN MVC

```
quanlyphongtro/
├── app/
│   ├── config/
│   │   └── config.php          # Cấu hình Database, Base URL, timezone
│   ├── core/
│   │   ├── Database.php        # Kết nối PDO Singleton an toàn
│   │   ├── Model.php           # Base Model CRUD (all, find, where, create, update, delete)
│   │   ├── Controller.php      # Base Controller điều phối View, JSON AJAX, Redirect
│   │   ├── App.php             # Router phân tích URL điều hướng Controller/Action
│   │   ├── Auth.php            # Quản lý phiên Session, phân quyền Admin / Tenant
│   │   └── Helpers.php         # Format tiền tệ VNĐ, ngày tháng, VietQR, badge trạng thái
│   ├── models/
│   │   ├── Room.php, Branch.php, RoomType.php, Tenant.php, Contract.php
│   │   ├── Invoice.php, Service.php, MeterReading.php, Maintenance.php
│   │   ├── Booking.php, Post.php, Contact.php, User.php, Setting.php
│   ├── controllers/
│   │   ├── HomeController.php  # Trang chủ, giới thiệu, cẩm nang, liên hệ
│   │   ├── RoomController.php  # Danh sách phòng, lọc AJAX, chi tiết, đặt lịch
│   │   ├── AuthController.php  # Đăng nhập, đăng ký, đăng xuất (Bcrypt hash)
│   │   ├── TenantController.php# Cổng khách thuê: phòng, hợp đồng, hóa đơn, báo hỏng
│   │   └── AdminController.php # Backend quản trị toàn diện: dashboard, biểu đồ, phòng, hợp đồng...
│   └── views/
│       ├── layouts/            # Header, Footer, Admin Header, Admin Footer
│       ├── home/               # Views trang chủ, liên hệ, tin tức
│       ├── rooms/              # Views danh sách phòng, chi tiết phòng
│       ├── auth/               # Views đăng nhập, đăng ký
│       ├── tenant/             # Views cổng khách thuê
│       └── admin/              # Views dashboard, phòng, hợp đồng, hóa đơn, biểu đồ...
├── assets/
│   ├── css/                    # style.css, admin.css
│   ├── js/                     # main.js (AJAX search), admin.js (Chart.js)
│   └── images/                 # Ảnh phòng trọ thực tế, ảnh bài viết, avatar
├── database/
│   └── quanlyphongtro.sql      # CSDL 16 bảng + Seed data phong phú
├── docs/
│   ├── BAO_CAO_DO_AN.md        # Toàn văn báo cáo đồ án chuẩn mực
│   └── Báo_Cáo_Đồ_Án_Quản_Lý_Phòng_Trọ.docx # Báo cáo Word sẵn sàng nộp
├── index.php                   # Front Controller (Entry point)
├── .htaccess                   # Rewrite URL thân thiện
├── run.bat                     # 1-click chạy ngay hệ thống
├── import_db.bat               # 1-click import CSDL vào XAMPP
└── README.md
```

---

## 4. HƯỚNG DẪN CÀI ĐẶT & CHẠY ỨNG DỤNG

### Cách 1: Chạy nhanh bằng 1-Click (Khuyên dùng)
1. Đảm bảo bạn đã cài đặt XAMPP trên máy tính.
2. Nhấp đúp vào file `import_db.bat` để tự động tạo và import cơ sở dữ liệu `quanlyphongtro`.
3. Nhấp đúp vào file `run.bat`. Trình duyệt sẽ tự động mở trang web tại địa chỉ:
   ```
   http://localhost:8000/
   ```

### Cách 2: Chạy trên Apache XAMPP truyền thống
1. Khởi động **Apache** và **MySQL** trong **XAMPP Control Panel**.
2. Mở trình duyệt vào `http://localhost/phpmyadmin`, tạo cơ sở dữ liệu tên: `quanlyphongtro`.
3. Import file `database/quanlyphongtro.sql` vào cơ sở dữ liệu vừa tạo.
4. Copy toàn bộ thư mục `quanlyphongtro` vào thư mục `C:\xampp\htdocs\quanlyphongtro` (hoặc `C:\xampp1\htdocs\quanlyphongtro`).
5. Truy cập hệ thống tại:
   ```
   http://localhost/quanlyphongtro/
   ```

---

## 5. TIÊU CHÍ ĐÁNH GIÁ ĐỒ ÁN ĐẠT ĐIỂM TỐI ĐA (ĐIỂM A / 10.0)

- **HTML5, CSS3, JavaScript (2.0 điểm):** Bố cục hiện đại, chuẩn Responsive trên PC, Tablet, Mobile; tích hợp FontAwesome 6, Google Fonts, thư viện Chart.js vẽ biểu đồ doanh thu.
- **Xử lý nghiệp vụ & Validate (1.0 điểm):** Đầy đủ Use Case nghiệp vụ thuê trọ; kiểm tra ràng buộc ngày tháng, giá tiền, số lượng người, chỉ số công tơ điện nước.
- **Xây dựng CSDL & Kết nối (3.0 điểm):** Thiết kế 16 bảng chuẩn hóa 3NF, ràng buộc khóa ngoại (Foreign Keys), kết nối PDO bảo mật chống SQL Injection 100%.
- **Mô hình MVC & Framework hoàn chỉnh (3.0 điểm):** Tách biệt Model - View - Controller rõ ràng, lập trình hướng đối tượng OOP, tính năng phân trang (Pagination), tìm kiếm AJAX không load lại trang.
- **Trình bày & Báo cáo tiếng Anh (1.0 điểm):** Báo cáo đầy đủ sơ đồ phân tích kèm phần tóm tắt và câu hỏi phản biện bằng tiếng Anh theo đúng yêu cầu đề tài.
