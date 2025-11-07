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
    <link rel="stylesheet" href="<?= htmlspecialchars(($baseUrl ?? ''), ENT_QUOTES, 'UTF-8') ?>/assets/css/app.css">
</head>
<body class="page page--home">
    <?php include BASE_PATH . '/app/Views/partials/_navbar.php'; ?>

    <main class="page-content py-5">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="glass-card p-4 p-md-5">
                        <h1 class="h3 fw-bold text-gradient mb-3"><span id="welcome-text">Chào mừng!</span></h1>
                        <p class="text-secondary mb-4" id="welcome-desc">Bạn đã đăng nhập thành công. Đây là trang Home đơn giản để điều hướng sau khi đăng nhập.</p>

                        <div class="d-flex gap-2">
                            <a class="btn btn-primary" href="<?= htmlspecialchars($urls['features'] ?? ($baseUrl ? rtrim($baseUrl,'/').'/features' : '/features'), ENT_QUOTES, 'UTF-8') ?>">Xem tính năng</a>
                            <a class="btn btn-outline-primary" href="<?= htmlspecialchars($urls['home'] ?? ($baseUrl ? rtrim($baseUrl,'/').'/' : '/'), ENT_QUOTES, 'UTF-8') ?>">Về trang chủ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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

                const welcome = document.getElementById('welcome-text');
                const desc = document.getElementById('welcome-desc');
                if (welcome) {
                    welcome.textContent = `Chào mừng, ${name}!`;
                }
                if (desc) {
                    desc.textContent = 'Bạn đã đăng nhập thành công. Chúc bạn một ngày tốt lành!';
                }
            } catch (_) {
                // ignore
            }
        });
    </script>
    </body>
    </html>
