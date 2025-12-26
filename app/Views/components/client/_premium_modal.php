<!-- Premium Upgrade Modal -->
<div class="modal fade" id="premiumModal" tabindex="-1" aria-labelledby="premiumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="premiumModalLabel">
                    <i class="fas fa-crown text-warning me-2"></i>Nâng cấp Premium
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <!-- Loading State -->
                <div id="premium-loading">
                    <div class="spinner-border text-primary mb-3" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <p class="text-muted">Đang tạo mã thanh toán...</p>
                </div>

                <!-- QR Code Display -->
                <div id="premium-qr" style="display: none;">
                    <div class="mb-3">
                        <img id="premium-qr-image" src="" alt="QR Code" class="img-fluid rounded shadow"
                            style="max-width: 250px; border: 3px solid #f0f0f0;">
                    </div>
                    <p class="mb-2 text-muted">Quét mã QR để thanh toán</p>
                    <h4 class="text-primary fw-bold mb-3">15.000đ</h4>

                    <!-- Payment Status -->
                    <div id="payment-status" class="alert alert-warning mb-0">
                        <i class="fas fa-clock me-2"></i>
                        <span>Đang chờ thanh toán...</span>
                    </div>
                </div>

                <!-- Error State -->
                <div id="premium-error" style="display: none;">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-circle text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="text-danger mb-2">Đã xảy ra lỗi</h5>
                    <p class="text-muted mb-3" id="premium-error-text">Không thể kết nối tới dịch vụ thanh toán</p>
                    <button class="btn btn-outline-primary" type="button" id="btn-retry-premium">
                        <i class="fas fa-redo me-1"></i>Thử lại
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #premiumModal .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    }

    #premium-qr-image {
        transition: transform 0.3s ease;
    }

    #premium-qr-image:hover {
        transform: scale(1.05);
    }

    #payment-status {
        border-radius: 10px;
    }
</style>

<script>
    (function () {
        var checkInterval = null;

        document.addEventListener('DOMContentLoaded', function () {
            var premiumModal = document.getElementById('premiumModal');
            if (!premiumModal) return;

            premiumModal.addEventListener('show.bs.modal', function () {
                createTransaction();
            });

            premiumModal.addEventListener('hidden.bs.modal', function () {
                if (checkInterval) {
                    clearInterval(checkInterval);
                    checkInterval = null;
                }
            });

            var retryBtn = document.getElementById('btn-retry-premium');
            if (retryBtn) {
                retryBtn.addEventListener('click', function () {
                    createTransaction();
                });
            }
        });

        function showState(state) {
            document.getElementById('premium-loading').style.display = state === 'loading' ? 'block' : 'none';
            document.getElementById('premium-qr').style.display = state === 'qr' ? 'block' : 'none';
            document.getElementById('premium-error').style.display = state === 'error' ? 'block' : 'none';
        }

        function createTransaction() {
            showState('loading');

            fetch('/api/premium/create-transaction', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.error) {
                        throw new Error(data.message || 'Lỗi không xác định');
                    }

                    var qrLink = data.qr_link;
                    if (qrLink) {
                        document.getElementById('premium-qr-image').src = qrLink;
                        showState('qr');
                        startAutoCheck();
                    } else {
                        throw new Error('Không nhận được mã QR');
                    }
                })
                .catch(function (error) {
                    console.error('Premium transaction error:', error);
                    document.getElementById('premium-error-text').textContent = error.message;
                    showState('error');
                });
        }

        function startAutoCheck() {
            if (checkInterval) clearInterval(checkInterval);
            checkInterval = setInterval(checkPaymentStatus, 5000);
        }

        function checkPaymentStatus() {
            fetch('/api/premium/check-payment', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.is_paid) {
                        if (checkInterval) {
                            clearInterval(checkInterval);
                            checkInterval = null;
                        }
                        // Close modal and reload page
                        var modal = bootstrap.Modal.getInstance(document.getElementById('premiumModal'));
                        if (modal) modal.hide();
                        window.location.reload();
                    }
                })
                .catch(function (error) {
                    console.error('Check payment error:', error);
                });
        }

        // Check premium status on page load
        window.checkPremiumStatus = function () {
            fetch('/api/premium/status', {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    if (data.is_premium) {
                        updatePremiumBadge(true);
                    }
                })
                .catch(function (error) {
                    console.error('Check premium status error:', error);
                });
        };

        function updatePremiumBadge(isPremium) {
            var navUsername = document.getElementById('nav-username');
            var premiumItem = document.getElementById('nav-premium-item');

            if (isPremium) {
                if (navUsername && !navUsername.innerHTML.includes('fa-crown')) {
                    var userName = navUsername.textContent || navUsername.innerText;
                    navUsername.innerHTML = '<i class="fas fa-crown text-warning me-1"></i>' + userName;
                }
                if (premiumItem) {
                    premiumItem.style.display = 'none';
                }
            }
        }
    })();
</script>