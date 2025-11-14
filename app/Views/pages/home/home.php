<?php
/** @var string $appName */
/** @var array $urls */

$appName = $appName ?? 'PHP Application';
$urls = $urls ?? [];

// Hàm trợ giúp cho URL được giả định:
$url = static fn($urls_array, $key, $default) => $urls_array[$key] ?? $default;
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    
    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($appName . ' - Home', ENT_QUOTES, 'UTF-8') ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="public/assets/css/home.css">
    
    <link rel="stylesheet" href="public/assets/css/app.css">
    
    <link rel="stylesheet" href="public/assets/css/footer.css">
    
    <link rel="stylesheet" href="public/assets/css/navbar.css">

    <style>
        <?php @include __DIR__ . '/home.css'; ?>
    </style>
</head>

<body class="page page--home">
    <?php include BASE_PATH . '/app/Views/partials/_navbar.php'; ?>

    <section class="welcome-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="welcome-title" id="welcome-text">Xin chào! 👋</h1>
                    <p class="welcome-text text-muted">Hãy hoàn thành các khảo sát mới để tiếp tục
                        tăng thu nhập của bạn.</p>
                    </div>
                <div class="col-lg-6 text-lg-end mt-4 mt-lg-0">
                    <div
                        class="points-card d-inline-flex align-items-center justify-content-between w-100 p-3 p-md-4">
                        <div class="points-info text-start">
                            <div class="points-label">Điểm hiện có</div>
                            <div class="points-value" id="user-points">1,250</div>
                            </div>
                        <a href="<?= $url($urls, 'rewards', '/rewards') ?>"
                            class="btn btn-outline-accent flex-shrink-0">
                            <i class="fas fa-gift me-2"></i>Đổi thưởng ngay
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <section class="stats-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-number">24</div>
                        <div class="text-muted">Khảo sát hoàn thành</div>
                        </div>
                    </div>
                <div class="col-md-4 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                        <div class="stat-number">5</div>
                        <div class="text-muted">Khảo sát mới</div>
                        </div>
                    </div>
                <div class="col-md-4 col-6">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-trophy"></i></div>
                        <div class="stat-number">Top 15%</div>
                        <div class="text-muted">Xếp hạng</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <section id="surveys" class="surveys-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Khảo sát mới dành cho bạn (6)</h2>
                <a href="<?= $url($urls, 'surveys', '/surveys') ?>" class="view-all">Xem tất cả <i
                        class="fas fa-arrow-right ms-1"></i></a>
                </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="survey-card">
                        <div class="survey-badge">
                            <i class="fas fa-star me-1"></i>Mới
                            </div>
                        <div class="survey-header">
                            <h3 class="survey-title">Khảo sát về thói quen mua sắm online
                            </h3>
                            <div class="survey-meta">
                                <span class="text-primary fw-bold"><i
                                        class="fas fa-coins me-1"></i>+50 điểm</span>
                                <span><i class="fas fa-clock me-1"></i>10 phút</span>
                                </div>
                            </div>
                        <p class="survey-desc">Chia sẻ ý kiến của bạn về trải nghiệm mua sắm
                            trực tuyến và xu hướng tiêu dùng.</p>
                        <a href="#" class="btn btn-gradient mt-auto w-100">Bắt đầu ngay</a>
                        </div>
                    </div>

                <div class="col-lg-4 col-md-6">
                    <div class="survey-card">
                        <div class="survey-badge badge-hot">
                            <i class="fas fa-fire me-1"></i>Hot
                            </div>
                        <div class="survey-header">
                            <h3 class="survey-title">Đánh giá sản phẩm công nghệ</h3>
                            <div class="survey-meta">
                                <span class="text-primary fw-bold"><i
                                        class="fas fa-coins me-1"></i>+40 điểm</span>
                                <span><i class="fas fa-clock me-1"></i>8 phút</span>
                                </div>
                            </div>
                        <p class="survey-desc">Cho chúng tôi biết suy nghĩ của bạn về các sản
                            phẩm điện tử và công nghệ mới.</p>
                        <a href="#" class="btn btn-gradient mt-auto w-100">Bắt đầu ngay</a>
                        </div>
                    </div>

                <div class="col-lg-4 col-md-6">
                    <div class="survey-card">
                        <div class="survey-badge">
                            <i class="fas fa-star me-1"></i>Mới
                            </div>
                        <div class="survey-header">
                            <h3 class="survey-title">Khảo sát về sức khỏe & thể thao</h3>
                            <div class="survey-meta">
                                <span class="text-primary fw-bold"><i
                                        class="fas fa-coins me-1"></i>+60 điểm</span>
                                <span><i class="fas fa-clock me-1"></i>12 phút</span>
                                </div>
                            </div>
                        <p class="survey-desc">Chia sẻ thói quen tập luyện và quan điểm về lối
                            sống lành mạnh của bạn.</p>
                        <a href="#" class="btn btn-gradient mt-auto w-100">Bắt đầu ngay</a>
                        </div>
                    </div>

                <div class="col-lg-4 col-md-6">
                    <div class="survey-card">
                        <div class="survey-badge">
                            <i class="fas fa-star me-1"></i>Mới
                            </div>
                        <div class="survey-header">
                            <h3 class="survey-title">Khảo sát về thói quen ăn uống</h3>
                            <div class="survey-meta">
                                <span class="text-primary fw-bold"><i
                                        class="fas fa-coins me-1"></i>+55 điểm</span>
                                <span><i class="fas fa-clock me-1"></i>10 phút</span>
                                </div>
                            </div>
                        <p class="survey-desc">Chia sẻ sở thích ăn uống của bạn và các xu hướng
                            tiêu dùng thực phẩm.</p>
                        <a href="#" class="btn btn-gradient mt-auto w-100">Bắt đầu ngay</a>
                        </div>
                    </div>

                <div class="col-lg-4 col-md-6">
                    <div class="survey-card">
                        <div class="survey-badge badge-hot">
                            <i class="fas fa-fire me-1"></i>Hot
                            </div>
                        <div class="survey-header">
                            <h3 class="survey-title">Khảo sát về du lịch và du lịch</h3>
                            <div class="survey-meta">
                                <span class="text-primary fw-bold"><i
                                        class="fas fa-coins me-1"></i>+70 điểm</span>
                                <span><i class="fas fa-clock me-1"></i>15 phút</span>
                                </div>
                            </div>
                        <p class="survey-desc">Cho chúng tôi biết về những trải nghiệm du lịch
                            yêu thích của bạn và các điểm đến mơ ước.</p>
                        <a href="#" class="btn btn-gradient mt-auto w-100">Bắt đầu ngay</a>
                        </div>
                    </div>

                <div class="col-lg-4 col-md-6">
                    <div class="survey-card">
                        <div class="survey-badge">
                            <i class="fas fa-star me-1"></i>Mới
                            </div>
                        <div class="survey-header">
                            <h3 class="survey-title">Khảo sát về giải trí & truyền hình</h3>
                            <div class="survey-meta">
                                <span class="text-primary fw-bold"><i
                                        class="fas fa-coins me-1"></i>+45 điểm</span>
                                <span><i class="fas fa-clock me-1"></i>8 phút</span>
                                </div>
                            </div>
                        <p class="survey-desc">Chia sẻ sở thích giải trí, phim ảnh và các chương
                            trình TV yêu thích của bạn.</p>
                        <a href="#" class="btn btn-gradient mt-auto w-100">Bắt đầu ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

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