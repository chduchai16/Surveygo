document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('login-form');
  if (!form) return;

  const feedback = document.getElementById('login-feedback');
  const submitBtn = form.querySelector('button[type="submit"]');

  const showMsg = (msg, type = 'danger') => {
    if (!feedback) return;
    feedback.innerHTML = `<div class="alert alert-${type}" role="alert">${msg}</div>`;
  };

  form.addEventListener('submit', async (e) => {
    // If no fetch available, let the default form POST happen
    if (typeof window.fetch !== 'function') return;
    e.preventDefault();

    try {
      submitBtn && (submitBtn.disabled = true);
      showMsg('Đang đăng nhập...', 'info');

      const formData = new FormData(form);
      const payload = new URLSearchParams();
      formData.forEach((v, k) => payload.append(k, v));

      const res = await fetch(form.action || '/api/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: payload.toString(),
      });

      const data = await res.json().catch(() => ({}));

      if (!res.ok || data.error) {
        const msg = data.message || 'Đăng nhập thất bại.';
        showMsg(msg, 'danger');
        return;
      }

      // Persist lightweight user info for personalization
      try {
        if (data && data.data && data.data.user) {
          localStorage.setItem('app.user', JSON.stringify(data.data.user));
        }
      } catch (_) {}

      showMsg('Đăng nhập thành công. Đang chuyển hướng...', 'success');
      // Redirect to app base + /home
      const brand = document.querySelector('a.navbar-brand');
      let base = (brand && brand.getAttribute('href')) || '/';
      if (base.endsWith('/')) {
        base = base.slice(0, -1);
      }
      const redirectUrl = base + '/home';
      setTimeout(() => {
        window.location.href = redirectUrl;
      }, 800);
    } catch (err) {
      showMsg('Có lỗi xảy ra. Vui lòng thử lại.', 'danger');
    } finally {
      submitBtn && (submitBtn.disabled = false);
    }
  });
});
