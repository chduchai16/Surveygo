## SurveyGo — Hệ thống Quản lý Khảo sát PHP MVC (XAMPP-ready)

[![PHP](https://img.shields.io/badge/PHP-%3E%3D%208.1-777bb4?logo=php)](https://www.php.net/)
[![MySQL/MariaDB](https://img.shields.io/badge/MySQL%2FMariaDB-10.4%2B-00618a?logo=mysql)](https://mariadb.org/)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952b3?logo=bootstrap)](https://getbootstrap.com/)
[![Status](https://img.shields.io/badge/Status-Production-success)](#)

Dự án PHP thuần theo hướng MVC (không framework) với Router/Controller/View đầy đủ tính năng, giao diện modern Bootstrap 5.3, hệ thống xác thực, và RESTful API hoàn chỉnh. Chạy trực tiếp trong `htdocs` của XAMPP hoặc bằng PHP built-in server.

---

### 📋 Mô tả ngắn
Hệ thống quản lý khảo sát trực tuyến với các tính năng:
- Tạo và quản lý khảo sát, câu hỏi
- Hệ thống điểm thưởng và đổi quà
- Quản lý sự kiện và vòng quay may mắn
- Tính năng Premium cho người dùng
- Điểm danh hàng ngày
- Hệ thống mời bạn bè

---

### 🎯 Tính năng chính

#### Người dùng (User)
- Đăng ký, đăng nhập, quản lý hồ sơ cá nhân
- Tham gia khảo sát và nhận điểm thưởng
- Đổi điểm lấy phần thưởng (Gift card, tiền mặt...)
- Điểm danh hàng ngày để nhận thưởng
- Tham gia sự kiện và quay vòng quay may mắn
- Đăng ký tài khoản Premium
- Gửi phản hồi và liên hệ

#### Quản trị viên (Admin)
- Dashboard thống kê tổng quan
- Quản lý khảo sát: tạo, sửa, xóa, phê duyệt
- Quản lý câu hỏi và câu trả lời
- Quản lý người dùng
- Quản lý sự kiện
- Quản lý phần thưởng và yêu cầu đổi thưởng
- Quản lý phản hồi và tin nhắn liên hệ
- Xem nhật ký hoạt động

---

### 🏗️ Kiến trúc / Tech Stack

| Thành phần | Công nghệ |
|------------|-----------|
| Backend | PHP 8.1+, PDO MySQL |
| Frontend | Bootstrap 5.3, JavaScript ES6 |
| Database | MySQL/MariaDB 10.4+ |
| API | RESTful JSON API |
| Documentation | Swagger/OpenAPI 3.0 |

#### Cấu trúc thư mục
```
├── app/
│   ├── Controllers/         # Xử lý logic nghiệp vụ
│   │   ├── AuthController.php
│   │   ├── AdminController.php
│   │   ├── SurveyController.php
│   │   ├── QuestionController.php
│   │   ├── EventController.php
│   │   ├── RewardController.php
│   │   ├── PremiumController.php
│   │   └── ...
│   ├── Models/              # Tương tác database
│   │   ├── User.php
│   │   ├── Survey.php
│   │   ├── Question.php
│   │   ├── Event.php
│   │   ├── Reward.php
│   │   └── ...
│   ├── Views/               # Giao diện PHP + partials
│   ├── Core/                # Router, Request, Response, Database
│   └── Middlewares/         # AuthMiddleware, RoleMiddleware
├── config/
│   └── app.php              # Cấu hình app & database
├── public/
│   ├── index.php            # Front controller + routes
│   ├── swagger/             # API Documentation
│   └── assets/              # CSS, JS, images
├── sql/
│   └── mysql/init.sql       # Schema + seed data
└── README.md
```

---

### ⚙️ Yêu cầu hệ thống
- Windows/macOS/Linux
- PHP >= 8.1 với extension `pdo_mysql`
- MySQL/MariaDB 10.4+
- XAMPP (khuyến nghị trên Windows) hoặc PHP CLI
- Apache `mod_rewrite` bật nếu chạy qua Apache

---

### 🚀 Cài đặt & Quick Start

1. **Clone/Copy mã nguồn** vào `C:\xampp\htdocs\SurveyGo`

2. **Cấu hình database** trong `config/app.php`:
   ```php
   'db' => [
       'host' => 'localhost',
       'database' => 'mvc_app',
       'username' => 'root',
       'password' => '',
   ]
   ```

3. **Bật XAMPP** (Apache + MySQL)

4. **Tạo database** với tên `mvc_app` trong phpMyAdmin

5. **Truy cập ứng dụng**:
   - XAMPP: `http://localhost/SurveyGo/`
   - PHP Built-in Server:
     ```bash
     cd path/to/SurveyGo
     php -S 127.0.0.1:8000 -t public
     # Truy cập http://127.0.0.1:8000
     ```

6. **Dữ liệu mẫu** (seed):
   - Tài khoản: `user1@example.com` / `password`
   - Admin: `admin@example.com` / `admin123`

---

### 📚 API Documentation

Truy cập Swagger UI: `http://localhost/SurveyGo/public/swagger/`

#### Nhóm API chính:

| Nhóm | Mô tả |
|------|-------|
| Auth | Đăng ký, đăng nhập, đổi mật khẩu |
| Survey | CRUD khảo sát, nộp bài |
| Question | CRUD câu hỏi |
| Event | Quản lý sự kiện, vòng quay may mắn |
| Reward | Danh sách phần thưởng, đổi thưởng |
| Daily Reward | Điểm danh hàng ngày |
| Premium | Đăng ký Premium, thanh toán |
| User Points | Quản lý điểm người dùng |
| Admin | Thống kê, quản lý hệ thống |

#### Ví dụ API:

```bash
# Đăng nhập
curl -X POST http://localhost/SurveyGo/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user1@example.com","password":"password"}'

# Lấy danh sách khảo sát
curl http://localhost/SurveyGo/api/surveys

# Kiểm tra trạng thái hệ thống
curl http://localhost/SurveyGo/api/health
```

---

### 🔧 Cấu hình

File: `config/app.php`

| Cấu hình | Mô tả |
|----------|-------|
| `app.base_url` | URL gốc (rỗng = auto-detect) |
| `app.debug` | Chế độ debug (true/false) |
| `db.*` | Thông tin kết nối database |

---

### 📖 Tài liệu
- API Documentation: `/public/swagger/`
- API Testing Guide: `API_TESTING_GUIDE.md`

---

### 👥 Đóng góp
1. Fork dự án
2. Tạo branch mới (`git checkout -b feature/AmazingFeature`)
3. Commit thay đổi (`git commit -m 'Add some AmazingFeature'`)
4. Push lên branch (`git push origin feature/AmazingFeature`)
5. Mở Pull Request

---

### 📄 License
Dự án được phát triển cho mục đích học tập.
