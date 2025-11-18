# Views - Hướng dẫn cấu trúc

Folder này chứa tất cả các view templates (HTML) cho ứng dụng.

## 📁 Cấu trúc Thư mục

```
Views/
├── layouts/           Các layout chính (wrapper cho pages)
├── pages/             Tất cả các trang view
│   ├── auth/          Trang đăng nhập, đăng ký
│   ├── home/          Trang home và landing page
│   ├── surveys/       Danh sách surveys và quick polls
│   ├── user/          Trang cá nhân, rewards, daily rewards
│   ├── info/          Liên hệ, điều khoản, dashboard
│   └── events/        Trang sự kiện
├── partials/          Các component tái sử dụng (navbar, footer)
└── components/        Alias cho partials (chưa dùng)
```

## 🔍 Cách tìm views

**User-related pages** (Trang liên quan đến người dùng)
- Profile: `pages/user/profile.php`
- Rewards: `pages/user/rewards.php`
- Daily Rewards: `pages/user/daily-rewards.php`

**Info pages** (Trang thông tin)
- Contact: `pages/info/contact.php`
- Terms of Use: `pages/info/terms-of-use.php`
- API Dashboard: `pages/info/dashboard/survey-dashboard.php`

**Auth pages** (Trang xác thực)
- Login: `pages/auth/login.php`
- Register: `pages/auth/register.php`

**Survey pages** (Trang khảo sát)
- All Surveys: `pages/surveys/surveys.php`
- Quick Polls: `pages/surveys/quick-poll.php`

**Other pages**
- Home/Landing: `pages/home/landing.php` (unauthenticated)
- Home (authenticated): `pages/home/home.php`
- Events: `pages/events/events.php`

## 🔄 Thêm view mới

1. Tạo file `.php` trong folder phù hợp
2. Update `HomeController.php` thêm method route
3. Add route vào `public/index.php`

**Example:**
```php
// In app/Controllers/HomeController.php
public function newPage(Request $request) {
    return $this->view('pages/user/new-page', $this->pageData($request));
}

// In public/index.php
$router->get('/new-page', [HomeController::class, 'newPage']);
```

## 📝 Quy tắc

1. **Organized by feature** - Mỗi loại trang có folder riêng
2. **Consistent naming** - Dùng kebab-case cho tên file (`profile.php`, không phải `profileView.php`)
3. **Reusable components** - Dùng `partials/` cho navbar, footer, v.v.
4. **Include paths** - Luôn dùng `BASE_PATH . '/app/Views/...'` cho include

## 📚 Data passed to views

```php
// Mọi view nhận những biến này
$appName;        // Tên ứng dụng
$urls;           // URL helpers
$baseUrl;        // Base URL của app
$currentPath;    // Current request path
```

## 🚀 Best Practices

✅ Do:
- Organize by feature/category
- Use meaningful folder names
- Keep views simple - logic goes in controllers
- Reuse components from partials/
- Document complex templates

❌ Don't:
- Mix business logic in views
- Store data in views
- Create too many nested folders (2-3 levels max)
- Hardcode URLs - use `$urls` or `$baseUrl`
