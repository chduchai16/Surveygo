<?php
/** @var string $appName */
/** @var array $urls */

$appName = $appName ?? 'PHP Application';
$urls = $urls ?? [];

// Ensure URLs have absolute base prefix even if controller didn't pass them.
$__base = rtrim((string)($baseUrl ?? ''), '/');
$__mk = static function (string $base, string $path): string {
    $p = '/' . ltrim($path, '/');
    return $base === '' ? $p : ($base . $p);
};
$urls['home'] = $urls['home'] ?? $__mk($__base, '/');
$urls['features'] = $urls['features'] ?? $__mk($__base, '/features');
$urls['login'] = $urls['login'] ?? $__mk($__base, '/login');
$urls['register'] = $urls['register'] ?? $__mk($__base, '/register');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($appName . ' - Profile', ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- custom css -->
    <link rel="stylesheet" href="public/assets/css/profile.css">
    <link rel="stylesheet" href="public/assets/css/app.css">
    <link rel="stylesheet" href="public/assets/css/footer.css">
    <link rel="stylesheet" href="public/assets/css/navbar.css">
</head>
<body class="page page--profile">
    <?php include BASE_PATH . '/app/Views/partials/_navbar.php'; ?>

    <!-- Profile Content -->
    <main class="page-content profile-page">
        <section class="user-info-section">
            <div class="container">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-lg-3 mb-4">
                        <div class="profile-card text-center">
                            <div class="avatar-section mb-3">
                                <div class="avatar-wrapper">
                                    <img src="https://ui-avatars.com/api/?name=Nguyen+Van+A&size=150&background=667eea&color=fff"
                                        alt="Avatar" class="avatar-img" id="avatarPreview">
                                    <label for="avatarUpload" class="avatar-upload-btn">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                    <input type="file" id="avatarUpload" accept="image/*" style="display: none;">
                                </div>
                            </div>
                            <h4 class="user-fullname">Nguyễn Văn A</h4>

                            <div class="user-stats mt-4">
                                <div class="stat-item">
                                    <i class="fas fa-coins"></i>
                                    <span class="stat-value">1,250</span>
                                    <span class="stat-label">Điểm thưởng</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-clipboard-check"></i>
                                    <span class="stat-value">24</span>
                                    <span class="stat-label">Khảo sát</span>
                                </div>
                            </div>

                            <div class="member-since mt-3">
                                <small>Thành viên từ 01/2024</small>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-lg-9">
                        <!-- Tabs -->
                        <ul class="nav custom-tabs mb-4" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="pill" data-bs-target="#info"
                                    type="button" role="tab">
                                    <i class="fas fa-user me-2"></i>Thông tin chung
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="security-tab" data-bs-toggle="pill" data-bs-target="#security"
                                    type="button" role="tab">
                                    <i class="fas fa-lock me-2"></i>Bảo mật
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="activity-tab" data-bs-toggle="pill" data-bs-target="#activity"
                                    type="button" role="tab">
                                    <i class="fas fa-history me-2"></i>Hoạt động
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="profileTabsContent">
                            <!-- Thông tin chung -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <div class="info-card">
                                    <div class="card-header-custom">
                                        <h5><i class="fas fa-id-card me-2"></i>Thông tin cá nhân</h5>
                                        <button class="btn btn-sm btn-outline-primary" id="editBtn">
                                            <i class="fas fa-edit me-1"></i>Chỉnh sửa
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <form id="userInfoForm">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-user me-2"></i>Họ và tên
                                                    </label>
                                                    <input type="text" class="form-control" id="fullName"
                                                        value="Nguyễn Văn A" disabled>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-venus-mars me-2"></i>Giới tính
                                                    </label>
                                                    <select class="form-select" id="gender" disabled>
                                                        <option value="male" selected>Nam</option>
                                                        <option value="female">Nữ</option>
                                                        <option value="other">Khác</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-birthday-cake me-2"></i>Ngày sinh
                                                    </label>
                                                    <input type="date" class="form-control" id="birthday" value="1995-05-15"
                                                        disabled>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-phone me-2"></i>Số điện thoại
                                                    </label>
                                                    <input type="tel" class="form-control" id="phone" value="0123456789"
                                                        disabled>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fas fa-envelope me-2"></i>Email
                                                </label>
                                                <input type="email" class="form-control" id="email"
                                                    value="nguyenvana@example.com" disabled>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fas fa-map-marker-alt me-2"></i>Địa chỉ
                                                </label>
                                                <textarea class="form-control" id="address" rows="2"
                                                    disabled>123 Đường ABC, Quận 1, TP. Hồ Chí Minh</textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fas fa-info-circle me-2"></i>Giới thiệu bản thân
                                                </label>
                                                <textarea class="form-control" id="bio" rows="3"
                                                    disabled>Tôi là người yêu thích khảo sát và nghiên cứu thị trường.</textarea>
                                            </div>

                                            <div class="d-flex gap-2" id="formActions" style="display: none;">
                                                <button type="submit" class="btn btn-gradient" id="saveBtn">
                                                    <i class="fas fa-save me-2"></i>Lưu thay đổi
                                                </button>
                                                <button type="button" class="btn btn-outline-primary" id="cancelBtn">
                                                    <i class="fas fa-times me-2"></i>Hủy
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Bảo mật -->
                            <div class="tab-pane fade" id="security" role="tabpanel">
                                <div class="info-card mb-4">
                                    <div class="card-header-custom">
                                        <h5><i class="fas fa-key me-2"></i>Đổi mật khẩu</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="changePasswordForm">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fas fa-lock me-2"></i>Mật khẩu hiện tại
                                                </label>
                                                <div class="password-wrapper">
                                                    <input type="password" class="form-control" id="currentPassword"
                                                        placeholder="Nhập mật khẩu hiện tại">
                                                    <button type="button" class="password-toggle"
                                                        onclick="togglePassword('currentPassword', 'toggleIcon1')">
                                                        <i class="fas fa-eye" id="toggleIcon1"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fas fa-lock me-2"></i>Mật khẩu mới
                                                </label>
                                                <div class="password-wrapper">
                                                    <input type="password" class="form-control" id="newPassword"
                                                        placeholder="Nhập mật khẩu mới">
                                                    <button type="button" class="password-toggle"
                                                        onclick="togglePassword('newPassword', 'toggleIcon2')">
                                                        <i class="fas fa-eye" id="toggleIcon2"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    <i class="fas fa-lock me-2"></i>Xác nhận mật khẩu mới
                                                </label>
                                                <div class="password-wrapper">
                                                    <input type="password" class="form-control" id="confirmPassword"
                                                        placeholder="Nhập lại mật khẩu mới">
                                                    <button type="button" class="password-toggle"
                                                        onclick="togglePassword('confirmPassword', 'toggleIcon3')">
                                                        <i class="fas fa-eye" id="toggleIcon3"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-gradient">
                                                <i class="fas fa-save me-2"></i>Đổi mật khẩu
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Hoạt động -->
                            <div class="tab-pane fade" id="activity" role="tabpanel">
                                <div class="info-card">
                                    <div class="card-header-custom">
                                        <h5><i class="fas fa-history me-2"></i>Lịch sử hoạt động</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="activity-timeline">
                                            <div class="activity-item">
                                                <div class="activity-icon bg-success">
                                                    <i class="fas fa-check"></i>
                                                </div>
                                                <div class="activity-content">
                                                    <h6>Hoàn thành khảo sát "Khảo sát trải nghiệm người dùng"</h6>
                                                    <p class="text-muted mb-0">
                                                        <small><i class="fas fa-clock me-1"></i>Hôm nay, 14:30</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="activity-item">
                                                <div class="activity-icon bg-info">
                                                    <i class="fas fa-gift"></i>
                                                </div>
                                                <div class="activity-content">
                                                    <h6>Đổi 500 điểm lấy voucher Shopee 50K</h6>
                                                    <p class="text-muted mb-0">
                                                        <small><i class="fas fa-clock me-1"></i>Hôm qua, 10:15</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="activity-item">
                                                <div class="activity-icon bg-success">
                                                    <i class="fas fa-check"></i>
                                                </div>
                                                <div class="activity-content">
                                                    <h6>Hoàn thành Quick Poll về sản phẩm công nghệ</h6>
                                                    <p class="text-muted mb-0">
                                                        <small><i class="fas fa-clock me-1"></i>2 ngày trước, 16:45</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="activity-item">
                                                <div class="activity-icon bg-warning">
                                                    <i class="fas fa-user-edit"></i>
                                                </div>
                                                <div class="activity-content">
                                                    <h6>Cập nhật thông tin cá nhân</h6>
                                                    <p class="text-muted mb-0">
                                                        <small><i class="fas fa-clock me-1"></i>1 tuần trước, 09:20</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="activity-item">
                                                <div class="activity-icon bg-primary">
                                                    <i class="fas fa-sign-in-alt"></i>
                                                </div>
                                                <div class="activity-content">
                                                    <h6>Đăng nhập tài khoản</h6>
                                                    <p class="text-muted mb-0">
                                                        <small><i class="fas fa-clock me-1"></i>2 tuần trước, 08:00</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include BASE_PATH . '/app/Views/partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ẩn/hiện mật khẩu
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Xem trước ảnh đại diện
        document.getElementById('avatarUpload').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    document.getElementById('avatarPreview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        const editBtn = document.getElementById('editBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const saveBtn = document.getElementById('saveBtn');
        const formActions = document.getElementById('formActions');
        const formInputs = document.querySelectorAll('#userInfoForm input, #userInfoForm select, #userInfoForm textarea');

        let originalValues = {};

        editBtn.addEventListener('click', function () {
            // Lưu giá trị ban đầu
            formInputs.forEach(input => {
                originalValues[input.id] = input.value;
            });

            // Cho phép chỉnh sửa form
            formInputs.forEach(input => {
                input.disabled = false;
            });

            // Ẩn/hiện nút
            editBtn.style.display = 'none';
            formActions.style.display = 'flex';
        });

        cancelBtn.addEventListener('click', function () {
            // Khôi phục giá trị ban đầu
            formInputs.forEach(input => {
                if (originalValues[input.id] !== undefined) {
                    input.value = originalValues[input.id];
                }
            });

            // Vô hiệu hóa form
            formInputs.forEach(input => {
                input.disabled = true;
            });

            // Ẩn/hiện nút
            editBtn.style.display = 'inline-block';
            formActions.style.display = 'none';
        });

        // Gửi form thông tin người dùng
        document.getElementById('userInfoForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Lấy giá trị từ form
            const fullName = document.getElementById('fullName').value;
            const gender = document.getElementById('gender').value;
            const birthday = document.getElementById('birthday').value;
            const phone = document.getElementById('phone').value;
            const email = document.getElementById('email').value;
            const address = document.getElementById('address').value;
            const bio = document.getElementById('bio').value;

            // Kiểm tra dữ liệu
            if (!fullName || !email || !phone) {
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
                return;
            }

            setTimeout(() => {
                // Cập nhật tên người dùng trên thanh menu
                const userNameElement = document.querySelector('.user-name');
                if (userNameElement) {
                    userNameElement.textContent = fullName;
                }
                document.querySelector('.user-fullname').textContent = fullName;

                // Hiển thị thông báo thành công
                alert('Cập nhật thông tin thành công!');

                // Ẩn form actions
                editBtn.style.display = 'inline-block';
                formActions.style.display = 'none';

                // Vô hiệu hóa form
                formInputs.forEach(input => {
                    input.disabled = true;
                });
            }, 500);
        });

        // đổi mật khẩu
        document.getElementById('changePasswordForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Kiểm tra dữ liệu
            if (!currentPassword || !newPassword || !confirmPassword) {
                alert('Vui lòng điền đầy đủ thông tin!');
                return;
            }

            if (newPassword.length < 8) {
                alert('Mật khẩu mới phải có ít nhất 8 ký tự!');
                return;
            }

            if (newPassword !== confirmPassword) {
                alert('Mật khẩu xác nhận không khớp!');
                return;
            }

            setTimeout(() => {
                // Xóa dữ liệu form
                document.getElementById('changePasswordForm').reset();
                alert('Đổi mật khẩu thành công!');
            }, 500);
        });
    </script>
</body>
</html>
