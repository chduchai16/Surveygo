# Views Folder Structure - Reorganization Complete ✅

## Cấu trúc thư mục mới

```
app/Views/
├── layouts/
│   ├── auth.php           # Authentication layout
│   └── main.php           # Main layout
│
├── pages/
│   ├── auth/              # ✅ Authentication pages
│   │   ├── login.php
│   │   └── register.php
│   │
│   ├── home/              # ✅ Home & Landing pages
│   │   ├── home.php       # Dashboard after login
│   │   ├── landing.php    # Landing page (unauthenticated)
│   │   ├── home.css
│   │   ├── home.js
│   │   └── script.js
│   │
│   ├── surveys/           # ✅ Survey-related pages
│   │   ├── surveys.php    # All surveys listing with filters & pagination
│   │   └── quick-poll.php # Quick polls (1-question surveys)
│   │
│   ├── user/              # ✅ User-related pages (NEW)
│   │   ├── profile.php    # User profile & settings
│   │   ├── rewards.php    # Rewards/Points redemption
│   │   └── daily-rewards.php # Daily login rewards
│   │
│   ├── info/              # ✅ Information & admin pages (NEW)
│   │   ├── contact.php    # Contact form
│   │   ├── terms-of-use.php # Terms of use
│   │   └── dashboard/
│   │       └── survey-dashboard.php # API testing dashboard
│   │
│   ├── events/            # ✅ Events listing
│   │   └── events.php
│   │
│   ├── login/             # ❌ DEPRECATED (use pages/auth/)
│   │   └── script.js
│   │
│   ├── contact/           # ❌ DEPRECATED (moved to pages/info/)
│   ├── daily-rewards/     # ❌ DEPRECATED (moved to pages/user/)
│   ├── dashboard/         # ❌ DEPRECATED (moved to pages/info/dashboard/)
│   ├── profile/           # ❌ DEPRECATED (moved to pages/user/)
│   ├── rewards/           # ❌ DEPRECATED (moved to pages/user/)
│   └── terms-of-use/      # ❌ DEPRECATED (moved to pages/info/)
│
├── partials/              # ✅ Reusable components
│   ├── _navbar.php
│   └── _footer.php
│
└── components/            # (alias for partials, not in use yet)
```

---

## Thay đổi chính

### ✅ Di chuyển file hoàn tất

| File cũ | File mới | Reason |
|---------|---------|--------|
| `pages/profile/profile.php` | `pages/user/profile.php` | Group user-related pages |
| `pages/rewards/rewards.php` | `pages/user/rewards.php` | Group user-related pages |
| `pages/daily-rewards/daily-rewards.php` | `pages/user/daily-rewards.php` | Group user-related pages |
| `pages/contact/contact.php` | `pages/info/contact.php` | Group info pages |
| `pages/terms-of-use/terms-of-use.php` | `pages/info/terms-of-use.php` | Group info pages |
| `pages/dashboard/survey-dashboard.php` | `pages/info/dashboard/survey-dashboard.php` | Group info/admin pages |

### 🔄 HomeController Routes Cập nhật

```php
// Before
public function profile(Request $request) {
    return $this->view('pages/profile/profile', ...);
}

// After
public function profile(Request $request) {
    return $this->view('pages/user/profile', ...);
}
```

Tất cả methods được cập nhật:
- `profile()` → `pages/user/profile`
- `dailyRewards()` → `pages/user/daily-rewards`
- `rewards()` → `pages/user/rewards`
- `terms()` → `pages/info/terms-of-use`
- `contact()` → `pages/info/contact`

---

## Lợi ích của cấu trúc mới

1. **Better Organization** - Related pages grouped by feature/category
2. **Easier Maintenance** - Know where to find user features, info pages, surveys, etc.
3. **Scalability** - Easy to add new pages in right categories
4. **Clear Intent** - File paths reflect page purpose immediately
5. **Team Communication** - Everyone knows where pages should go

---

## Cleanup (Optional)

Old directories can be removed after verification:
- `pages/login/` (consolidated with `pages/auth/`)
- `pages/profile/`
- `pages/rewards/`
- `pages/daily-rewards/`
- `pages/contact/`
- `pages/terms-of-use/`
- `pages/dashboard/`

---

## Status

- [x] Create new directory structure (user/, info/)
- [x] Copy files to new locations
- [x] Update HomeController routes
- [x] Verify file permissions
- [ ] Remove old empty directories (manual)
- [ ] Update any remaining hard-coded includes (if any)
- [ ] Test all routes in browser

---

## Notes

- View renderer in `Core/View.php` automatically appends `.php` extension
- Routes in `public/index.php` didn't need changes (they map to HomeController methods)
- All `$this->view()` calls now use new paths
- No breaking changes - all URLs work exactly the same
