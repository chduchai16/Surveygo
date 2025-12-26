// Registration form handler
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('register-form');
    
    if (!registerForm) {
        console.log('[auth.js] register form not found');
        return;
    }
    
    registerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const feedbackDiv = document.getElementById('register-feedback');
        const passwordMatchError = document.getElementById('passwordMatchError');
        
        // Clear previous feedback
        if (feedbackDiv) feedbackDiv.innerHTML = '';
        if (passwordMatchError) passwordMatchError.textContent = '';
        
        // Collect form data
        const formData = new FormData(this);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        
        // Validate password match
        const password = data.password;
        const confirmPassword = document.getElementById('confirm-password').value;
        
        if (password !== confirmPassword) {
            if (passwordMatchError) {
                passwordMatchError.textContent = 'Mật khẩu không khớp';
            }
            return;
        }
        
        // Disable submit button
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang đăng ký...';
        }
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.error) {
                // Show error message
                if (feedbackDiv) {
                    feedbackDiv.className = 'alert alert-danger';
                    feedbackDiv.textContent = result.message || 'Đăng ký thất bại!';
                }
            } else {
                // Show success message
                if (feedbackDiv) {
                    feedbackDiv.className = 'alert alert-success';
                    let message = 'Đăng ký thành công!';
                    
                    // Show referral bonus if applicable
                    if (result.data && result.data.referral_bonus > 0) {
                        message += ` Bạn đã nhận ${result.data.referral_bonus} điểm thưởng từ mã mời!`;
                    }
                    
                    feedbackDiv.textContent = message;
                }
                
                // Save user to localStorage
                if (result.data && result.data.user) {
                    localStorage.setItem('app.user', JSON.stringify(result.data.user));
                }
                
                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
            }
        } catch (error) {
            console.error('Registration error:', error);
            if (feedbackDiv) {
                feedbackDiv.className = 'alert alert-danger';
                feedbackDiv.textContent = 'Có lỗi xảy ra. Vui lòng thử lại!';
            }
        } finally {
            // Re-enable submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Đăng ký';
            }
        }
    });
});
