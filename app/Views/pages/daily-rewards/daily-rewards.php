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
    <title><?= htmlspecialchars($appName . ' - Phần Thưởng Hằng Ngày', ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- custom css -->
    <link rel="stylesheet" href="public/assets/css/daily-rewards.css">
    <link rel="stylesheet" href="public/assets/css/app.css">
    <link rel="stylesheet" href="public/assets/css/footer.css">
    <link rel="stylesheet" href="public/assets/css/navbar.css">
</head>
<body class="page page--daily-rewards">
    <?php include BASE_PATH . '/app/Views/partials/_navbar.php'; ?>

    <main class="page-content">
        <section class="daily-reward-section">
            <div class="container">
                <div class="reward-header mb-5">
                    <h1 class="reward-title">
                        <i class="fas fa-gift me-2"></i>Phần thưởng hằng ngày
                    </h1>
                    <p class="reward-subtitle">Điểm danh mỗi ngày để nhận phần thưởng hấp dẫn!</p>
                </div>

                <div class="reward-box">
                    <div class="reward-grid" id="rewardGrid">
                        <!-- Reward cards will be generated here -->
                    </div>

                    <div class="claim-container">
                        <button class="btn btn-gradient btn-lg" id="claimBtn">
                            <i class="fas fa-check-circle me-2"></i>Điểm danh hôm nay
                        </button>
                        <div class="claim-status mt-3" id="claimStatus"></div>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <div class="note-box">
                    <h2 class="note-title">
                        <i class="fas fa-info-circle me-2"></i>Cách điểm danh
                    </h2>
                    <ul class="note-list">
                        <li>Mỗi ngày bạn có thể điểm danh một lần để nhận phần thưởng</li>
                        <li>Bạn chỉ có thể điểm danh khi ấn vào nút "Điểm danh hôm nay"</li>
                        <li>Chuỗi điểm danh sẽ reset nếu bạn bỏ qua một ngày</li>
                        <li>Càng nhiều ngày liên tiếp, phần thưởng càng lớn</li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <?php include BASE_PATH . '/app/Views/partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Daily rewards data
        const rewardDays = [
            { day: 1, points: 10, icon: 'gift' },
            { day: 2, points: 15, icon: 'gift' },
            { day: 3, points: 20, icon: 'gift' },
            { day: 4, points: 25, icon: 'gift' },
            { day: 5, points: 30, icon: 'gift' },
            { day: 6, points: 40, icon: 'gift' },
            { day: 7, points: 50, icon: 'star' },
            { day: 8, points: 60, icon: 'gift' },
            { day: 9, points: 75, icon: 'gift' },
            { day: 10, points: 100, icon: 'crown' }
        ];

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadRewardData();
            renderRewardCards();
            setupClaimButton();
        });

        // Load reward data from localStorage
        function loadRewardData() {
            const today = new Date().toDateString();
            const savedData = localStorage.getItem('dailyRewards');
            
            if (!savedData) {
                window.rewardData = {
                    lastClaimed: null,
                    currentStreak: 0,
                    claimedDays: []
                };
            } else {
                window.rewardData = JSON.parse(savedData);
                
                // Check if a day has passed
                if (window.rewardData.lastClaimed !== today) {
                    // Check if it's been more than 24 hours
                    if (window.rewardData.lastClaimed) {
                        const lastDate = new Date(window.rewardData.lastClaimed);
                        const currentDate = new Date(today);
                        const daysDiff = Math.floor((currentDate - lastDate) / (1000 * 60 * 60 * 24));
                        
                        if (daysDiff > 1) {
                            // Reset streak if more than 1 day gap
                            window.rewardData.currentStreak = 0;
                            window.rewardData.claimedDays = [];
                        }
                    }
                }
            }
        }

        // Render reward cards
        function renderRewardCards() {
            const grid = document.getElementById('rewardGrid');
            grid.innerHTML = '';
            
            const today = new Date().toDateString();
            const isTodayClaimed = window.rewardData.lastClaimed === today;

            rewardDays.forEach((reward, index) => {
                const isClaimed = index < window.rewardData.currentStreak;
                const isToday = index === window.rewardData.currentStreak && !isTodayClaimed;
                
                const card = document.createElement('div');
                card.className = `reward-card ${isClaimed ? 'claimed' : ''} ${isToday ? 'today' : ''}`;
                
                let icon = 'gift';
                if (reward.icon === 'star') icon = 'star';
                if (reward.icon === 'crown') icon = 'crown';
                
                card.innerHTML = `
                    <div class="icon">
                        <i class="fas fa-${isClaimed ? 'check-circle' : icon}"></i>
                    </div>
                    <div class="day">Ngày ${reward.day}</div>
                    <div class="points">${isClaimed ? `+${reward.points} điểm` : '+' + reward.points + ' điểm'}</div>
                `;
                
                grid.appendChild(card);
            });
        }

        // Setup claim button
        function setupClaimButton() {
            const claimBtn = document.getElementById('claimBtn');
            const claimStatus = document.getElementById('claimStatus');
            
            const today = new Date().toDateString();
            const isTodayClaimed = window.rewardData.lastClaimed === today;

            if (isTodayClaimed) {
                claimBtn.disabled = true;
                claimBtn.innerHTML = '<i class="fas fa-check me-2"></i>Đã điểm danh hôm nay';
            } else {
                claimBtn.addEventListener('click', claimReward);
                claimStatus.innerHTML = `<small class="text-muted">Chuỗi hiện tại: <strong>${window.rewardData.currentStreak} ngày</strong></small>`;
            }
        }

        // Claim daily reward
        function claimReward() {
            const today = new Date().toDateString();
            const isTodayClaimed = window.rewardData.lastClaimed === today;

            if (isTodayClaimed) {
                alert('Bạn đã điểm danh hôm nay rồi!');
                return;
            }

            // Increase streak and add to claimed days
            window.rewardData.currentStreak++;
            window.rewardData.lastClaimed = today;
            window.rewardData.claimedDays.push(today);

            // Get reward points for today
            const reward = rewardDays[window.rewardData.currentStreak - 1];
            const pointsEarned = reward ? reward.points : 0;

            // Update localStorage
            localStorage.setItem('dailyRewards', JSON.stringify(window.rewardData));

            // Show success message
            const claimStatus = document.getElementById('claimStatus');
            claimStatus.innerHTML = `
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    Chúc mừng! Bạn vừa nhận được <strong>+${pointsEarned} điểm</strong>
                </div>
            `;

            // Refresh UI
            setTimeout(() => {
                renderRewardCards();
                setupClaimButton();
                location.reload();
            }, 1500);
        }
    </script>
</body>
</html>
