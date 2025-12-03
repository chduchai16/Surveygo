(function (global) {
    function ensureContainer() {
        let container = document.getElementById('global-toast-container');
        if (container) return container;

        container = document.createElement('div');
        container.id = 'global-toast-container';
        container.className = 'position-fixed top-0 end-0 p-3 mt-3';
        container.style.zIndex = 1080;
        container.setAttribute('aria-live', 'polite');
        container.setAttribute('aria-atomic', 'true');

        document.body.appendChild(container);
        return container;
    }

    function iconFor(status) {
        switch ((status || '').toLowerCase()) {
            case 'success': return '<i class="fas fa-check-circle me-2"></i>';
            case 'warning': return '<i class="fas fa-exclamation-triangle me-2"></i>';
            case 'error':
            case 'danger': return '<i class="fas fa-times-circle me-2"></i>';
            case 'info': return '<i class="fas fa-info-circle me-2"></i>';
            default: return '<i class="fas fa-bell me-2"></i>';
        }
    }

    function bgClassFor(status) {
        switch ((status || '').toLowerCase()) {
            case 'success': return 'bg-success text-white';
            case 'warning': return 'bg-warning text-dark';
            case 'error':
            case 'danger': return 'bg-danger text-white';
            case 'info': return 'bg-info text-dark';
            default: return 'bg-secondary text-white';
        }
    }

    function escapeHtml(unsafe) {
        if (unsafe == null) return '';
        return String(unsafe)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showToast(status, text, opts = {}) {
        try {
            const container = ensureContainer();
            const toastId = 'toast-' + Date.now() + '-' + Math.random().toString(16).slice(2);

            // Giới hạn 5 toast
            if (container.children.length > 5) {
                container.removeChild(container.firstElementChild);
            }

            const wrapper = document.createElement('div');
            wrapper.innerHTML = `
                <div id="${toastId}" class="toast fade align-items-center ${bgClassFor(status)} border-0 mb-2" 
                    role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="d-flex">
                    <div class="toast-body d-flex align-items-center">
                        ${iconFor(status)}<div class="toast-text">${escapeHtml(text)}</div>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" style="filter: invert(1);"></button>
                  </div>
                </div>
            `;

            const toastEl = wrapper.firstElementChild;
            container.appendChild(toastEl);

            const delay = typeof opts.delay === 'number' ? opts.delay : 3000;
            const bsToast = new bootstrap.Toast(toastEl, { delay });

            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
            bsToast.show();

            return bsToast;
        } catch (e) {
            alert(text);
        }
    }

    global.showToast = showToast;
    global.ToastHelper = { show: showToast };
})(window);
