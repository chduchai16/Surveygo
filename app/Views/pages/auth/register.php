<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="auth-card">
                    <div class="text-center">
                        <div class="auth-icon mb-3">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h2 class="auth-title">Đăng ký tài khoản</h2>
                    </div>

                    <form id="register-form"
                        action="<?= htmlspecialchars(rtrim((string) ($baseUrl ?? ''), '/') . '/api/register', ENT_QUOTES, 'UTF-8') ?>"
                        method="post">
                        <!-- Họ và tên -->
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2"></i>Họ và tên
                            </label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập họ và tên"
                                required autocomplete="name">
                        </div>

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label for="register-email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" class="form-control" id="register-email" name="email"
                                placeholder="Nhập email của bạn" required autocomplete="email">
                        </div>

                        <!-- Mật khẩu -->
                        <div class="form-group mb-3">
                            <label for="register-password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Mật khẩu
                            </label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control" id="register-password" name="password"
                                    placeholder="Nhập mật khẩu (ít nhất 6 ký tự)" required minlength="6"
                                    autocomplete="new-password">
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('register-password', 'toggleIconPassword')">
                                    <i class="fas fa-eye" id="toggleIconPassword"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Xác nhận mật khẩu -->
                        <div class="form-group mb-3">
                            <label for="confirm-password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Xác nhận mật khẩu
                            </label>
                            <div class="password-wrapper">
                                <input type="password" class="form-control" id="confirm-password"
                                    placeholder="Nhập lại mật khẩu" required autocomplete="new-password">
                                <button type="button" class="password-toggle"
                                    onclick="togglePassword('confirm-password', 'toggleIconConfirm')">
                                    <i class="fas fa-eye" id="toggleIconConfirm"></i>
                                </button>
                            </div>
                            <small class="text-danger" id="passwordMatchError"></small>
                        </div>

                        <!-- Mã mời (optional) - Chỉ hiển thị khi có link mời -->
                        <div class="form-group mb-3 d-none" id="invite-code-group">
                            <label for="invite-code" class="form-label">
                                <i class="fas fa-gift me-2"></i>Mã mời <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="invite-code" 
                                   name="invite_code" 
                                   placeholder="Nhập mã mời (6 ký tự)" 
                                   maxlength="6"
                                   pattern="[A-Z0-9]{6}"
                                   style="text-transform: uppercase;">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Nhập mã mời để bạn và người giới thiệu đều nhận <strong>500 điểm</strong>
                            </small>
                            <small class="text-success" id="inviteCodeSuccess"></small>
                            <small class="text-danger" id="inviteCodeError"></small>
                        </div>

                        <!-- Điều khoản & Điều kiện -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Tôi đồng ý với <a href="/terms-of-use" class="terms-link">Điều khoản sử dụng</a> và
                                <a href="#" class="terms-link">Chính sách bảo mật</a>
                            </label>
                        </div>

                        <!-- Nút đăng ký -->
                        <button type="submit" class="btn btn-gradient w-100 mb-3">
                            <i class="fas fa-user-plus me-2"></i>Đăng ký
                        </button>

                        <!-- Form feedback -->
                        <div class="form-feedback mt-3" id="register-feedback"></div>
                    </form>

                    <!-- Liên kết đăng nhập -->
                    <div class="text-center mt-4">
                        <p class="mb-0 small">Đã có tài khoản? <a
                                href="<?= htmlspecialchars($urls['login'] ?? '/login', ENT_QUOTES, 'UTF-8') ?>"
                                class="signup-link">Đăng nhập ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vanta Background -->
<div id="vanta-bg" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;"></div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta/dist/vanta.net.min.js"></script>
<script>
    // Khởi tạo Vanta Net
    window.addEventListener('load', function () {
        if (typeof VANTA !== 'undefined') {
            VANTA.NET({
                el: "#vanta-bg",
                mouseControls: true,
                touchControls: true,
                gyroControls: false,
                minHeight: 200.00,
                minWidth: 200.00,
                scale: 1.00,
                scaleMobile: 1.00,
                color: 0x10BCD3,
                backgroundColor: 0x0a1428,
                points: 15.00,
                maxDistance: 20.00,
                spacing: 15.00
            });
        }
    });

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

    // Show invite code field when accessing via invite link (token or code)
    window.addEventListener('load', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const inviteToken = urlParams.get('token'); // token-based invite url
        const inviteParam = urlParams.get('invite'); // code-based invite 
        
        if (inviteToken || inviteParam) {
            // Show the invite code field group
            const inviteCodeGroup = document.getElementById('invite-code-group');
            const inviteInput = document.getElementById('invite-code');
            const registerForm = document.getElementById('register-form');
            
            if (inviteCodeGroup) {
                inviteCodeGroup.classList.remove('d-none');
            }
            
            // Make invite code required when accessed via invite link
            if (inviteInput) {
                inviteInput.setAttribute('required', 'required');
            }
            
            // If token is present, add it as hidden field
            if (inviteToken && registerForm) {
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = 'invite_token';
                tokenInput.value = inviteToken;
                registerForm.appendChild(tokenInput);
            }
            
            // Add a helpful message - always ask for manual code entry
            const inviteHelpText = inviteCodeGroup?.querySelector('.form-text');
            if (inviteHelpText) {
                inviteHelpText.innerHTML = '\u003ci class="fas fa-info-circle me-1"\u003e\u003c/i\u003e Bạn đã được mời! Hãy nhập mã mời để cả hai nhận \u003cstrong\u003e500 điểm\u003c/strong\u003e.';
            }
        }
    });

    // Validate invite code
    function validateInviteCode(code) {
        if (!code || code.length !== 6) return;
        
        const successDiv = document.getElementById('inviteCodeSuccess');
        const errorDiv = document.getElementById('inviteCodeError');
        const inviteInput = document.getElementById('invite-code');
        
        // Clear previous messages
        successDiv.textContent = '';
        errorDiv.textContent = '';
        
        // Validate code via API
        fetch('/api/invites/validate?code=' + code.toUpperCase())
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    errorDiv.textContent = data.message || 'Không thể kiểm tra mã mời';
                    inviteInput.classList.add('is-invalid');
                    inviteInput.classList.remove('is-valid');
                } else if (data.valid) {
                    successDiv.textContent = '✓ ' + data.message;
                    inviteInput.classList.add('is-valid');
                    inviteInput.classList.remove('is-invalid');
                } else {
                    errorDiv.textContent = data.message || 'Mã mời không hợp lệ';
                    inviteInput.classList.add('is-invalid');
                    inviteInput.classList.remove('is-valid');
                }
            })
            .catch(err => {
                console.error('Validation error:', err);
                errorDiv.textContent = 'Không thể kiểm tra mã mời';
            });
    }

    // Validate invite code on blur
    const inviteCodeInput = document.getElementById('invite-code');
    if (inviteCodeInput) {
        inviteCodeInput.addEventListener('blur', function() {
            const code = this.value.trim();
            if (code.length === 6) {
                validateInviteCode(code);
            } else if (code.length > 0) {
                document.getElementById('inviteCodeError').textContent = 'Mã mời phải có 6 ký tự';
                document.getElementById('inviteCodeSuccess').textContent = '';
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else {
                // Empty is okay (optional field)
                document.getElementById('inviteCodeError').textContent = '';
                document.getElementById('inviteCodeSuccess').textContent = '';
                this.classList.remove('is-invalid', 'is-valid');
            }
        });

        // Auto-uppercase as user types
        inviteCodeInput.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
    }

    // Kiểm tra khớp mật khẩu
    document.getElementById('confirm-password').addEventListener('input', function (e) {
        const password = document.getElementById('register-password').value;
        const confirmPassword = e.target.value;
        const errorDiv = document.getElementById('passwordMatchError');

        if (confirmPassword.length > 0) {
            if (password !== confirmPassword) {
                errorDiv.textContent = 'Mật khẩu không khớp';
            } else {
                errorDiv.textContent = '';
            }
        } else {
            errorDiv.textContent = '';
        }
    });
</script>
<script src="/public/assets/js/toast-helper.js"></script>