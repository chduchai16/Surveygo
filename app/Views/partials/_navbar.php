<?php
$currentPath = $currentPath ?? ($_SERVER['REQUEST_URI'] ?? '/');
$baseUrl = $baseUrl ?? '';
$urls = $urls ?? [];
$basePath = (string)(parse_url($baseUrl, PHP_URL_PATH) ?? '');
$basePath = $basePath === '/' ? '' : rtrim($basePath, '/');

$normalize = static function (string $path) use ($basePath): string {
    if ($basePath !== '' && str_starts_with($path, $basePath)) {
        $trimmed = substr($path, strlen($basePath));
        return $trimmed === '' ? '/' : $trimmed;
    }

    return $path === '' ? '/' : $path;
};

$current = $normalize($currentPath);

$url = static function (array $urls, string $key, string $fallbackPath = '/') use ($baseUrl) {
    $given = $urls[$key] ?? null;
    if (is_string($given) && $given !== '') {
        return htmlspecialchars($given, ENT_QUOTES, 'UTF-8');
    }

    $normalizedBase = rtrim((string)$baseUrl, '/');
    $normalizedPath = '/' . ltrim((string)$fallbackPath, '/');
    $computed = $normalizedBase === '' ? $normalizedPath : ($normalizedBase . $normalizedPath);
    return htmlspecialchars($computed, ENT_QUOTES, 'UTF-8');
};
?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="<?= $url($urls, 'home', '/') ?>">Surveygo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link <?= $current === '/features' ? 'active' : '' ?>" href="<?= $url($urls, 'features', '/features') ?>">
                        <i class="fas fa-poll me-1"></i>Khảo sát
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#how-it-works">
                        <i class="fas fa-bolt me-1"></i>Quick Poll
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">
                        <i class="fas fa-gift me-1"></i>Đổi điểm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#login">
                        <i class="fas fa-calendar me-1"></i>Sự kiện
                    </a>
                </li>
            </ul>
            <a class="btn btn-gradient" href="<?= $url($urls, 'register', '/register') ?>">Đăng ký ngay</a>
        </div>
    </div>
</nav>
<script>
// Client-side navbar auth toggle using localStorage
(function(){
  try {
    var raw = localStorage.getItem('app.user');
    var user = raw ? JSON.parse(raw) : null;
    var nav = document.querySelector('#mainNav .navbar-nav');
    if (!nav) return;

    // Helpers
    var q = function(sel){ return nav.querySelector(sel); };
    var qa = function(sel){ return nav.querySelectorAll(sel); };

    // Find login/register links by href
    var links = qa('a.nav-link');
    var loginLi = null, registerLi = null;
    links.forEach(function(a){
      var href = a.getAttribute('href') || '';
      if (href.indexOf('/login') !== -1) loginLi = a.closest('li');
      if (href.indexOf('/register') !== -1) registerLi = a.closest('li');
    });

    var registerBtn = nav.parentElement.querySelector('a.btn-gradient');
    if (registerBtn && registerBtn.getAttribute('href').indexOf('/register') !== -1) {
      registerBtn._isRegisterBtn = true;
    }

    var ensureUserDropdown = function(name){
      var existing = document.getElementById('nav-user');
      if (existing) { existing.style.display = ''; existing.querySelector('#nav-username').textContent = name; return; }
      var li = document.createElement('li');
      li.className = 'nav-item dropdown';
      li.id = 'nav-user';
      li.innerHTML = '\n        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">\n          <span id="nav-username"></span>\n        </a>\n        <ul class="dropdown-menu dropdown-menu-end">\n          <li><a class="dropdown-item" href="/home">Trang của tôi</a></li>\n          <li><hr class="dropdown-divider"></li>\n          <li><button class="dropdown-item" id="btn-logout" type="button">Đăng xuất</button></li>\n        </ul>\n      ';
      nav.appendChild(li);
      var brand = document.querySelector('a.navbar-brand');
      var base = brand ? (brand.getAttribute('href') || '/') : '/';
      if (base.endsWith('/')) base = base.slice(0,-1);
      var homeLink = li.querySelector('a.dropdown-item');
      if (homeLink) homeLink.setAttribute('href', base + '/home');
      var label = li.querySelector('#nav-username');
      if (label) label.textContent = name;
      var logoutBtn = li.querySelector('#btn-logout');
      if (logoutBtn) {
        logoutBtn.addEventListener('click', function(){
          try { localStorage.removeItem('app.user'); } catch(e) {}
          var brand = document.querySelector('a.navbar-brand');
          var base = brand ? (brand.getAttribute('href') || '/') : '/';
          if (base.endsWith('/')) base = base.slice(0,-1);
          window.location.href = base + '/login';
        });
      }
    };

    if (user && (user.name || user.email)) {
      if (loginLi) loginLi.style.display = 'none';
      if (registerLi) registerLi.style.display = 'none';
      var registerBtn = nav.parentElement.querySelector('a.btn-gradient');
      if (registerBtn) registerBtn.style.display = 'none';
      ensureUserDropdown(user.name || user.email || 'Tài khoản');
    } else {
      var dropdown = document.getElementById('nav-user');
      if (dropdown) dropdown.style.display = 'none';
    }
  } catch(e) {}
})();
</script>
