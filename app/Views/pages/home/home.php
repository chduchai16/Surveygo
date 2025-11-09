<?php
/** @var string $appName */
/** @var array $urls */

$appName = $appName ?? 'PHP Application';
$urls = $urls ?? [];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($appName . ' - Home', ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- custom css  -->
    <link rel="stylesheet" href="public/assets/css/home.css">
    <link rel="stylesheet" href="public/assets/css/app.css">
    <link rel="stylesheet" href="public/assets/css/footer.css">
    <link rel="stylesheet" href="public/assets/css/navbar.css">

    <style><?php @include __DIR__ . '/home.css'; ?></style>
</head>
<body class="page page--home">
    <?php include BASE_PATH . '/app/Views/partials/_navbar.php'; ?>

    <!-- Phần chào mừng -->
    <section class="welcome-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="welcome-title" id="welcome-text">Xin chào! 👋</h1>
                </div>
                <div class="col-lg-4 text-end">
                    <div class="points-card">
                        <div class="points-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="points-info">
                            <div class="points-label">Điểm của bạn</div>
                            <div class="points-value" id="user-points">1250</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Thống kê nhanh -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-number">24</div>
                        <div>Khảo sát hoàn thành</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-number">5</div>
                        <div>Khảo sát mới</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="stat-number" id="total-points">1,250</div>
                        <div>Tổng điểm</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="stat-number">Top 15%</div>
                        <div>Xếp hạng</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Các khảo sát có sẵn -->
    <section id="surveys" class="surveys-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Khảo sát mới</h2>
                <a href="#all-surveys" class="view-all">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
            </div>

            <div class="row g-4">
                <!-- Thẻ khảo sát 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="survey-card">
                        <div class="survey-badge">
                            <i class="fas fa-star me-1"></i>Mới
                        </div>
                        <div class="survey-header">
                            <h3 class="survey-title">Khảo sát về thói quen mua sắm online</h3>
                            <div class="survey-meta">
                                <span><i class="fas fa-clock me-1"></i>10 phút</span>
                                <span><i class="fas fa-coins me-1"></i>+50 điểm</span>
                            </div>
                        </div>
                        <p class="survey-desc">Chia sẻ ý kiến của bạn về trải nghiệm mua sắm trực tuyến và xu hướng tiêu dùng.</p>
                        <a href="#" class="btn btn-gradient w-100">Bắt đầu ngay</a>
                    </div>
                </div>

                <!-- Thẻ khảo sát 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="survey-card">
                        <div class="survey-badge badge-hot">
                            <i class="fas fa-fire me-1"></i>Hot
                        </div>
                        <div class="survey-header">
                            <h3 class="survey-title">Đánh giá sản phẩm công nghệ</h3>
                            <div class="survey-meta">
                                <span><i class="fas fa-clock me-1"></i>8 phút</span>
                                <span><i class="fas fa-coins me-1"></i>+40 điểm</span>
                            </div>
                        </div>
                        <p class="survey-desc">Cho chúng tôi biết suy nghĩ của bạn về các sản phẩm điện tử và công nghệ mới.</p>
                        <a href="#" class="btn btn-gradient w-100">Bắt đầu ngay</a>
                    </div>
                </div>

                <!-- Thẻ khảo sát 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="survey-card">
                        <div class="survey-badge">
                            <i class="fas fa-star me-1"></i>Mới
                        </div>
                        <div class="survey-header">
                            <h3 class="survey-title">Khảo sát về sức khỏe & thể thao</h3>
                            <div class="survey-meta">
                                <span><i class="fas fa-clock me-1"></i>12 phút</span>
                                <span><i class="fas fa-coins me-1"></i>+60 điểm</span>
                            </div>
                        </div>
                        <p class="survey-desc">Chia sẻ thói quen tập luyện và quan điểm về lối sống lành mạnh của bạn.</p>
                        <a href="#" class="btn btn-gradient w-100">Bắt đầu ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hoạt động gần đây -->
    <section class="activity-section">
        <div class="container">
            <h2 class="section-title mb-3">Hoạt động gần đây</h2>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Hoàn thành khảo sát "Trải nghiệm du lịch"</h4>
                        <p>Bạn đã nhận được +45 điểm</p>
                    </div>
                    <div class="activity-time">2 giờ trước</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon activity-icon-reward">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Đổi thưởng thành công</h4>
                        <p>Voucher Shopee 50.000đ</p>
                    </div>
                    <div class="activity-time">1 ngày trước</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Hoàn thành khảo sát "Thói quen ăn uống"</h4>
                        <p>Bạn đã nhận được +35 điểm</p>
                    </div>
                    <div class="activity-time">2 ngày trước</div>
                </div>
            </div>
        </div>
    </section>

    <?php include BASE_PATH . '/app/Views/partials/_footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Cá nhân hóa bằng localStorage: đọc thông tin người dùng đã lưu sau đăng nhập
        document.addEventListener('DOMContentLoaded', () => {
            try {
                const raw = localStorage.getItem('app.user');
                if (!raw) return;
                const user = JSON.parse(raw);
                const name = (user && (user.name || user.email)) || '';
                if (!name) return;

                const welcomeText = document.getElementById('welcome-text');
                if (welcomeText) {
                    welcomeText.textContent = `Xin chào, ${name}! 👋`;
                }

                // Cập nhật điểm nếu có
                if (user.points) {
                    const userPointsEl = document.getElementById('user-points');
                    const totalPointsEl = document.getElementById('total-points');
                    if (userPointsEl) userPointsEl.textContent = user.points.toLocaleString('vi-VN');
                    if (totalPointsEl) totalPointsEl.textContent = user.points.toLocaleString('vi-VN');
                }
            } catch (_) {
                // ignore
            }
        });
    </script>
    </body>
    </html>
