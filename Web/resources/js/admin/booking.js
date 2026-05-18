/**
 * RuangKita Admin JS — resources/js/admin.js
 * Vite entry: resources/js/admin.js
 */

/* ============================================================
   RUANGKITA ADMIN APP
   ============================================================ */
const RuangKita = (() => {

    /* ── TOAST ── */
    const toastContainer = () => document.getElementById('toast-container');

    function toast(message, type = 'info', duration = 3500) {
        const icons = {
            success: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="toast-icon"><polyline points="20 6 9 17 4 12"/></svg>`,
            error: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="toast-icon"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`,
            warning: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="toast-icon"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
            info: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="toast-icon"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
        };

        const el = document.createElement('div');
        el.className = `toast ${type}`;
        el.innerHTML = `${icons[type] || icons.info}<span>${message}</span>`;
        toastContainer()?.appendChild(el);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => el.classList.add('show'));
        });

        setTimeout(() => {
            el.classList.add('hiding');
            el.addEventListener('transitionend', () => el.remove(), { once: true });
        }, duration);
    }

    /* ── MODAL ── */
    let _modalCallback = null;

    function createModal(message, type = 'warning') {
        // Remove existing
        document.getElementById('rk-modal-overlay')?.remove();

        const icons = {
            warning: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
            danger: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`,
            success: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>`,
        };

        const overlay = document.createElement('div');
        overlay.id = 'rk-modal-overlay';
        overlay.className = 'modal-overlay';
        overlay.innerHTML = `
      <div class="modal" role="dialog" aria-modal="true">
        <div class="modal-icon ${type}">${icons[type] || icons.warning}</div>
        <div class="modal-title">Konfirmasi Aksi</div>
        <div class="modal-body">${message}</div>
        <div class="modal-actions">
          <button class="btn btn-ghost" id="rk-modal-cancel">Batal</button>
          <button class="btn ${type === 'danger' ? 'btn-danger' : 'btn-primary'}" id="rk-modal-confirm">Ya, Lanjutkan</button>
        </div>
      </div>
    `;
        document.body.appendChild(overlay);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => overlay.classList.add('open'));
        });

        overlay.querySelector('#rk-modal-cancel').onclick = () => closeModal(overlay);
        overlay.querySelector('#rk-modal-confirm').onclick = () => {
            closeModal(overlay);
            _modalCallback?.();
        };
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal(overlay);
        });

        // Trap focus
        overlay.querySelector('#rk-modal-cancel').focus();
    }

    function closeModal(overlay) {
        overlay.classList.remove('open');
        overlay.addEventListener('transitionend', () => overlay.remove(), { once: true });
    }

    /**
     * confirmAction — opens confirm modal, then submits a hidden form
     * @param {string} message
     * @param {string} actionUrl
     * @param {string} method — 'PATCH' | 'DELETE' | 'POST'
     */
    function confirmAction(message, actionUrl, method = 'PATCH') {
        _modalCallback = () => {
            const form = document.getElementById('action-form');
            if (!form) return;
            form.action = actionUrl;
            // Update _method input
            let methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.value = method;
            form.submit();
        };
        createModal(message, method === 'DELETE' ? 'danger' : 'warning');
    }

    /* ── SIDEBAR MOBILE TOGGLE ── */
    function initSidebar() {
        const hamburger = document.getElementById('hamburger-btn');
        const sidebar = document.getElementById('sidebar');
        if (!hamburger || !sidebar) return;

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (sidebar.classList.contains('open')
                && !sidebar.contains(e.target)
                && !hamburger.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }

    /* ── TOPBAR DATE ── */
    function initDate() {
        const el = document.getElementById('topbar-date-text');
        if (!el) return;
        const now = new Date();
        const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        el.textContent = now.toLocaleDateString('id-ID', opts);
    }

    /* ── SCROLL ANIMATIONS ── */
    function initScrollAnimations() {
        if (!('IntersectionObserver' in window)) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('[data-animate]').forEach(el => observer.observe(el));
    }

    /* ── STAT COUNTER ANIMATION ── */
    function animateCounter(el, target, duration = 1000) {
        const start = performance.now();
        const isFloat = target % 1 !== 0;
        const formatter = new Intl.NumberFormat('id-ID');

        const update = (time) => {
            const elapsed = time - start;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out expo
            const eased = 1 - Math.pow(2, -10 * progress);
            const current = Math.round(eased * target);
            el.textContent = isFloat
                ? (eased * target).toFixed(1)
                : formatter.format(current);
            if (progress < 1) requestAnimationFrame(update);
        };

        requestAnimationFrame(update);
    }

    function initStatCounters() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const raw = el.dataset.count;
                    if (raw !== undefined) {
                        animateCounter(el, parseFloat(raw));
                        observer.unobserve(el);
                    }
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('[data-count]').forEach(el => observer.observe(el));
    }

    /* ── TABLE ROW STAGGER ── */
    function initTableAnimations() {
        document.querySelectorAll('.data-table tbody tr').forEach((row, i) => {
            row.style.animationDelay = `${i * 0.04}s`;
            row.classList.add('animate-up');
        });
    }

    /* ── PENDING ROW HIGHLIGHT ── */
    function highlightPending() {
        document.querySelectorAll('.data-table tbody tr').forEach(row => {
            if (row.querySelector('.status-warning')) {
                row.style.borderLeft = '3px solid var(--orange)';
            }
        });
    }

    /* ── ROOM SEARCH (booking/create page) ── */
    function initRoomSearch() {
        const searchInput = document.getElementById('room-search-input');
        const categoryFilter = document.getElementById('room-category-filter');
        const dateFilter = document.getElementById('room-date-filter');
        const roomsGrid = document.getElementById('rooms-grid');
        if (!roomsGrid) return;

        let selectedRoomId = null;
        const rooms = roomsGrid.querySelectorAll('.room-card');

        function filterRooms() {
            const query = searchInput?.value.toLowerCase() ?? '';
            const category = categoryFilter?.value ?? '';
            const date = dateFilter?.value ?? '';

            let visibleCount = 0;

            rooms.forEach(card => {
                const name = card.dataset.name?.toLowerCase() ?? '';
                const cat = card.dataset.category ?? '';
                const status = card.dataset.status ?? '';
                const matchQ = name.includes(query);
                const matchC = !category || cat === category;
                const matchS = status === 'tersedia';

                const show = matchQ && matchC && (matchS || !date);

                card.style.display = show ? '' : 'none';
                if (show) {
                    card.style.animation = 'none';
                    card.offsetHeight; // reflow
                    card.style.animation = '';
                    card.classList.add('animate-up');
                    visibleCount++;
                }
            });

            const empty = document.getElementById('rooms-empty');
            if (empty) empty.style.display = visibleCount === 0 ? '' : 'none';
        }

        searchInput?.addEventListener('input', debounce(filterRooms, 250));
        categoryFilter?.addEventListener('change', filterRooms);
        dateFilter?.addEventListener('change', filterRooms);

        // Room selection
        rooms.forEach(card => {
            card.addEventListener('click', () => {
                if (card.dataset.status !== 'tersedia') return;

                rooms.forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                selectedRoomId = card.dataset.id;

                // Update hidden input
                const hiddenInput = document.getElementById('selected-room-id');
                if (hiddenInput) hiddenInput.value = selectedRoomId;

                // Update summary
                updateSummaryRoom(card);

                // Scroll to form
                const formSection = document.getElementById('booking-form-section');
                if (formSection) {
                    formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                // Micro-animation: ripple
                const ripple = document.createElement('span');
                ripple.style.cssText = `
          position:absolute;inset:0;
          background:radial-gradient(circle, rgba(37,99,235,.15) 0%, transparent 70%);
          border-radius:inherit;
          animation:fadeIn .4s ease both;
          pointer-events:none;
        `;
                card.appendChild(ripple);
                setTimeout(() => ripple.remove(), 400);
            });
        });
    }

    function updateSummaryRoom(card) {
        const preview = document.getElementById('summary-room-preview');
        if (!preview) return;

        const name = card.dataset.name ?? '';
        const price = card.dataset.price ?? '0';
        const formatted = new Intl.NumberFormat('id-ID').format(parseInt(price));

        document.getElementById('summary-room-name')?.setAttribute('data-value', name);
        document.getElementById('summary-room-name')
            && (document.getElementById('summary-room-name').textContent = name);
        document.getElementById('summary-room-price')
            && (document.getElementById('summary-room-price').textContent = `Rp ${formatted}/jam`);

        preview.style.display = '';
        preview.classList.add('animate-up');

        recalcSummary(parseInt(price));
    }

    function recalcSummary(pricePerHour = 0) {
        const startEl = document.getElementById('input-start');
        const endEl = document.getElementById('input-end');
        const totalEl = document.getElementById('summary-total-value');
        const lineEl = document.getElementById('summary-duration');
        if (!startEl || !endEl || !totalEl) return;

        const start = startEl.value;
        const end = endEl.value;

        if (start && end) {
            const [sh, sm] = start.split(':').map(Number);
            const [eh, em] = end.split(':').map(Number);
            const hours = ((eh * 60 + em) - (sh * 60 + sm)) / 60;

            if (hours > 0) {
                const total = pricePerHour * hours;
                totalEl.textContent = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
                if (lineEl) lineEl.textContent = `${hours} jam`;
            }
        }
    }

    /* ── BOOKING FORM DYNAMIC ── */
    function initBookingForm() {
        const startInput = document.getElementById('input-start');
        const endInput = document.getElementById('input-end');

        const updateCalc = () => {
            const card = document.querySelector('.room-card.selected');
            const price = card ? parseInt(card.dataset.price ?? '0') : 0;
            recalcSummary(price);
        };

        startInput?.addEventListener('change', updateCalc);
        endInput?.addEventListener('change', updateCalc);

        // Form validation
        const form = document.getElementById('booking-submit-form');
        form?.addEventListener('submit', (e) => {
            let valid = true;

            form.querySelectorAll('[required]').forEach(field => {
                const errorEl = form.querySelector(`[data-error="${field.name}"]`);
                if (!field.value.trim()) {
                    field.classList.add('error');
                    if (errorEl) errorEl.textContent = 'Field ini wajib diisi';
                    valid = false;
                } else {
                    field.classList.remove('error');
                    if (errorEl) errorEl.textContent = '';
                }
            });

            const roomId = document.getElementById('selected-room-id')?.value;
            if (!roomId) {
                toast('Pilih ruangan terlebih dahulu', 'warning');
                document.getElementById('rooms-grid')?.scrollIntoView({ behavior: 'smooth' });
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
                toast('Harap lengkapi semua field', 'error');
            }
        });
    }

    /* ── KATEGORI CRUD ── */
    function initKategoriForm() {
        const form = document.getElementById('kategori-form');
        form?.addEventListener('submit', (e) => {
            let valid = true;
            form.querySelectorAll('[required]').forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('error');
                    valid = false;
                } else {
                    field.classList.remove('error');
                }
            });
            if (!valid) { e.preventDefault(); toast('Lengkapi semua field', 'error'); }
        });

        // Character counter
        const namaInput = document.getElementById('input-nama-kategori');
        const counter = document.getElementById('nama-counter');
        if (namaInput && counter) {
            namaInput.addEventListener('input', () => {
                counter.textContent = `${namaInput.value.length}/100`;
            });
        }
    }

    /* ── NOTIFICATION PANEL ── */
    function initNotifPanel() {
        const btn = document.getElementById('notif-btn');
        const panel = document.getElementById('notif-panel');
        if (!btn || !panel) return;

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            panel.classList.toggle('open');
        });

        document.addEventListener('click', () => panel.classList.remove('open'));
    }

    /* ── SEARCH DEBOUNCE (global) ── */
    function debounce(fn, delay) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => fn(...args), delay);
        };
    }

    /* ── LIVE SEARCH (booking index) ── */
    function initLiveSearch() {
        const input = document.getElementById('live-search');
        if (!input) return;

        const rows = document.querySelectorAll('.data-table tbody tr[data-searchable]');

        input.addEventListener('input', debounce(() => {
            const q = input.value.toLowerCase();
            let count = 0;
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const show = text.includes(q);
                row.style.display = show ? '' : 'none';
                if (show) count++;
            });
        }, 200));
    }

    /* ── PAGE LOADER ── */
    function initPageLoader() {
        document.body.classList.add('page-loaded');
    }

    /* ── INIT ── */
    function init() {
        initSidebar();
        initDate();
        initScrollAnimations();
        initStatCounters();
        initTableAnimations();
        highlightPending();
        initRoomSearch();
        initBookingForm();
        initKategoriForm();
        initNotifPanel();
        initLiveSearch();
        initPageLoader();
    }

    // Auto-init
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    return { toast, confirmAction, createModal };
})();

// Global export
window.RuangKita = RuangKita;
export default RuangKita;