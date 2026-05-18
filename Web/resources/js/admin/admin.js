/**
 * RuangKita Admin — Main JavaScript
 * Handles: toast notifications, confirm actions, sidebar, charts, modals, animations
 */

// =========================================
// GLOBAL NAMESPACE
// =========================================
window.RuangKita = (function () {

    // ---- Toast Notification ----
    function toast(message, type = 'info', duration = 4000) {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const icons = {
            success: `<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M20 6 9 17l-5-5"/>
                      </svg>`,
            error: `<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                      </svg>`,
            warning: `<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                      </svg>`,
            info: `<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                      </svg>`,
        };

        const el = document.createElement('div');
        el.className = `toast ${type}`;
        el.innerHTML = `${icons[type] || icons.info}<span class="toast-msg">${message}</span>`;
        container.appendChild(el);

        setTimeout(() => {
            el.style.animation = 'toastOut 0.3s ease forwards';
            setTimeout(() => el.remove(), 300);
        }, duration);
    }

    // ---- Confirm Action (POST form) ----
    function confirmAction(message, url, method = 'PATCH') {
        openModal('confirm-modal');
        const msgEl = document.getElementById('confirm-message');
        if (msgEl) msgEl.textContent = message;

        const confirmBtn = document.getElementById('confirm-ok-btn');
        if (!confirmBtn) return;

        // Clone to remove old listeners
        const newBtn = confirmBtn.cloneNode(true);
        confirmBtn.parentNode.replaceChild(newBtn, confirmBtn);

        newBtn.addEventListener('click', function () {
            const form = document.getElementById('action-form');
            if (!form) return;
            form.action = url;
            // set method override
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = method;
            closeModal('confirm-modal');
            form.submit();
        });
    }

    // ---- Modal ----
    function openModal(id) {
        const overlay = document.getElementById(id);
        if (overlay) overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        const overlay = document.getElementById(id);
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    // ---- Delete Confirm ----
    function deleteConfirm(url, label = 'data ini') {
        confirmAction(`Hapus ${label}? Tindakan ini tidak dapat dibatalkan.`, url, 'DELETE');
    }

    return { toast, confirmAction, openModal, closeModal, deleteConfirm };
})();


// =========================================
// DOM READY
// =========================================
document.addEventListener('DOMContentLoaded', function () {

    // ----- Topbar live date -----
    const dateEl = document.getElementById('topbar-date-text');
    if (dateEl) {
        const now = new Date();
        const opts = { day: 'numeric', month: 'long', year: 'numeric' };
        dateEl.textContent = now.toLocaleDateString('id-ID', opts);
    }

    // ----- Modal: close on overlay click -----
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            }
        });
    });

    // ----- Modal: close button -----
    document.querySelectorAll('[data-modal-close]').forEach(btn => {
        btn.addEventListener('click', function () {
            const modalId = btn.dataset.modalClose;
            RuangKita.closeModal(modalId);
        });
    });

    // ----- Modal: open button -----
    document.querySelectorAll('[data-modal-open]').forEach(btn => {
        btn.addEventListener('click', function () {
            RuangKita.openModal(btn.dataset.modalOpen);
        });
    });

    // ----- Confirm Modal (built-in) -----
    injectConfirmModal();

    // ----- Sidebar active link animation -----
    animateSidebarEntrance();

    // ----- Staggered card animations -----
    staggerCards();

    // ----- Topbar avatar dropdown -----
    setupAvatarDropdown();

    // ----- Notification bell mock -----
    setupNotifBtn();

    // ----- Auto-dismiss alerts -----
    autoDismissAlerts();

    // ----- Counter animation on stat cards -----
    animateCounters();

    // ----- Search input enhancement -----
    enhanceSearchInput();

    // ----- Data table row hover ripple -----
    setupTableInteractions();

    // ----- Chart initializer (if Chart.js loaded) -----
    initCharts();
});


// =========================================
// CONFIRM MODAL (auto-inject if absent)
// =========================================
function injectConfirmModal() {
    if (document.getElementById('confirm-modal')) return;

    const modal = document.createElement('div');
    modal.id = 'confirm-modal';
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal" style="max-width:400px">
            <div class="modal-header">
                <div class="modal-title">Konfirmasi</div>
                <button class="modal-close" data-modal-close="confirm-modal">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div style="display:flex;align-items:flex-start;gap:14px">
                    <div style="width:44px;height:44px;border-radius:50%;background:var(--orange-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--orange)" stroke-width="2.5">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                    </div>
                    <div>
                        <p id="confirm-message" style="font-size:.9rem;color:var(--gray-700);font-weight:500;line-height:1.5">
                            Apakah Anda yakin melakukan tindakan ini?
                        </p>
                        <p style="font-size:.78rem;color:var(--gray-400);margin-top:4px">
                            Tindakan ini akan segera diproses.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-ghost" data-modal-close="confirm-modal">Batal</button>
                <button id="confirm-ok-btn" class="btn btn-primary">Ya, Lanjutkan</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);

    // Re-bind close buttons
    modal.querySelectorAll('[data-modal-close]').forEach(btn => {
        btn.addEventListener('click', () => RuangKita.closeModal('confirm-modal'));
    });
    modal.addEventListener('click', e => {
        if (e.target === modal) RuangKita.closeModal('confirm-modal');
    });
}


// =========================================
// SIDEBAR ENTRANCE ANIMATION
// =========================================
function animateSidebarEntrance() {
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach((item, i) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-16px)';
        setTimeout(() => {
            item.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, 80 + i * 45);
    });
}


// =========================================
// STAGGERED CARD ANIMATIONS
// =========================================
function staggerCards() {
    const cards = document.querySelectorAll('.stat-card, .card');
    cards.forEach((card, i) => {
        if (!card.style.animation) {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 + i * 60);
        }
    });
}


// =========================================
// AVATAR DROPDOWN
// =========================================
function setupAvatarDropdown() {
    const avatar = document.getElementById('avatar-btn');
    if (!avatar) return;

    let dropdown = document.createElement('div');
    dropdown.style.cssText = `
        position:absolute; top:calc(100% + 8px); right:0;
        background:var(--white); border:1px solid var(--gray-200);
        border-radius:var(--radius-lg); box-shadow:var(--shadow-lg);
        min-width:200px; padding:8px; z-index:300;
        opacity:0; pointer-events:none; transform:translateY(-8px);
        transition:all 0.22s cubic-bezier(0.4,0,0.2,1);
    `;
    dropdown.innerHTML = `
        <div style="padding:10px 12px 8px;border-bottom:1px solid var(--gray-100);margin-bottom:4px">
            <div style="font-size:.82rem;font-weight:700;color:var(--gray-800)">Admin Panel</div>
            <div style="font-size:.72rem;color:var(--gray-400)">RuangKita School</div>
        </div>
        <a href="#" style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:var(--radius-sm);color:var(--gray-600);font-size:.82rem;font-weight:500;transition:var(--transition);" onmouseover="this.style.background='var(--gray-50)'" onmouseout="this.style.background=''">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
            Profil Saya
        </a>
        <a href="#" style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:var(--radius-sm);color:var(--gray-600);font-size:.82rem;font-weight:500;transition:var(--transition);" onmouseover="this.style.background='var(--gray-50)'" onmouseout="this.style.background=''">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Pengaturan
        </a>
    `;

    avatar.style.position = 'relative';
    avatar.appendChild(dropdown);

    avatar.addEventListener('click', (e) => {
        e.stopPropagation();
        const open = dropdown.style.opacity === '1';
        dropdown.style.opacity = open ? '0' : '1';
        dropdown.style.pointerEvents = open ? 'none' : 'all';
        dropdown.style.transform = open ? 'translateY(-8px)' : 'translateY(0)';
    });

    document.addEventListener('click', () => {
        dropdown.style.opacity = '0';
        dropdown.style.pointerEvents = 'none';
        dropdown.style.transform = 'translateY(-8px)';
    });
}


// =========================================
// NOTIFICATION BUTTON
// =========================================
function setupNotifBtn() {
    const btn = document.getElementById('notif-btn');
    if (!btn) return;

    btn.addEventListener('click', function () {
        RuangKita.toast('Tidak ada notifikasi baru saat ini.', 'info');
    });
}


// =========================================
// AUTO DISMISS ALERTS
// =========================================
function autoDismissAlerts() {
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s, transform 0.5s';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
}


// =========================================
// COUNTER ANIMATION (stat cards)
// =========================================
function animateCounters() {
    const counters = document.querySelectorAll('[data-count]');
    counters.forEach(el => {
        const target = parseInt(el.dataset.count, 10);
        if (isNaN(target)) return;
        let start = 0;
        const duration = 1200;
        const stepTime = Math.max(16, Math.floor(duration / target));
        const isCurrency = el.dataset.currency === 'true';

        const timer = setInterval(() => {
            start += Math.ceil(target / (duration / 16));
            if (start >= target) {
                start = target;
                clearInterval(timer);
            }
            el.textContent = isCurrency
                ? 'Rp ' + start.toLocaleString('id-ID')
                : start.toLocaleString('id-ID');
        }, 16);
    });
}


// =========================================
// SEARCH INPUT ENHANCEMENT
// =========================================
function enhanceSearchInput() {
    document.querySelectorAll('input[type="text"][name="search"]').forEach(input => {
        // Debounced live search hint
        input.addEventListener('input', debounce(function () {
            if (input.value.length > 0 && input.value.length < 2) {
                input.style.borderColor = 'var(--orange)';
            } else {
                input.style.borderColor = '';
            }
        }, 300));

        // Clear on Escape
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                input.value = '';
                input.style.borderColor = '';
                input.dispatchEvent(new Event('input'));
            }
        });
    });
}


// =========================================
// TABLE INTERACTIONS
// =========================================
function setupTableInteractions() {
    document.querySelectorAll('.data-table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', function () {
            row.style.transition = 'background 0.15s ease';
        });
    });

    // Row click → navigate to detail if data-href set
    document.querySelectorAll('.data-table tbody tr[data-href]').forEach(row => {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function (e) {
            if (!e.target.closest('button') && !e.target.closest('a')) {
                window.location.href = row.dataset.href;
            }
        });
    });
}


// =========================================
// CHART INITIALIZATION (Chart.js)
// =========================================
function initCharts() {
    if (typeof Chart === 'undefined') return;

    Chart.defaults.font.family = "'DM Sans', sans-serif";
    Chart.defaults.color = '#64748B';

    // Booking trend chart
    const bookingCtx = document.getElementById('bookingChart');
    if (bookingCtx && bookingCtx.dataset.labels) {
        try {
            const labels = JSON.parse(bookingCtx.dataset.labels);
            const values = JSON.parse(bookingCtx.dataset.values);
            new Chart(bookingCtx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Booking',
                        data: values,
                        borderColor: '#2563EB',
                        backgroundColor: 'rgba(37,99,235,0.08)',
                        tension: 0.42,
                        fill: true,
                        pointBackgroundColor: '#2563EB',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        borderWidth: 2.5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1E293B',
                            titleColor: '#F1F5F9',
                            bodyColor: '#94A3B8',
                            padding: 12,
                            cornerRadius: 10,
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { font: { size: 11 } },
                        },
                        y: {
                            grid: { color: 'rgba(226,232,240,0.6)', drawBorder: false },
                            border: { display: false, dash: [4, 4] },
                            ticks: { font: { size: 11 }, precision: 0 },
                        },
                    },
                }
            });
        } catch (e) { /* skip if data invalid */ }
    }

    // Donut status chart
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx && statusCtx.dataset.values) {
        try {
            const values = JSON.parse(statusCtx.dataset.values);
            const labels = JSON.parse(statusCtx.dataset.labels || '[]');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        data: values,
                        backgroundColor: ['#F59E0B', '#3B82F6', '#10B981', '#EF4444'],
                        borderWidth: 0,
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 10,
                                boxHeight: 10,
                                borderRadius: 99,
                                padding: 14,
                                font: { size: 11 },
                                usePointStyle: true,
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1E293B',
                            titleColor: '#F1F5F9',
                            bodyColor: '#94A3B8',
                            padding: 12,
                            cornerRadius: 10,
                        },
                    },
                }
            });
        } catch (e) { /* skip if data invalid */ }
    }

    // Revenue / pendapatan bar chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx && revenueCtx.dataset.labels) {
        try {
            const labels = JSON.parse(revenueCtx.dataset.labels);
            const values = JSON.parse(revenueCtx.dataset.values);
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: values,
                        backgroundColor: 'rgba(37,99,235,0.15)',
                        borderColor: '#2563EB',
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                        hoverBackgroundColor: 'rgba(37,99,235,0.28)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1E293B',
                            titleColor: '#F1F5F9',
                            bodyColor: '#94A3B8',
                            padding: 12,
                            cornerRadius: 10,
                            callbacks: {
                                label: ctx => ' Rp ' + ctx.parsed.y.toLocaleString('id-ID'),
                            }
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { font: { size: 11 } },
                        },
                        y: {
                            grid: { color: 'rgba(226,232,240,0.6)' },
                            border: { display: false, dash: [4, 4] },
                            ticks: {
                                font: { size: 11 },
                                callback: val => 'Rp ' + (val / 1000).toFixed(0) + 'K',
                            },
                        },
                    },
                }
            });
        } catch (e) { /* skip if data invalid */ }
    }
}


// =========================================
// UTILITY: DEBOUNCE
// =========================================
function debounce(fn, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
}


// =========================================
// TOAST KEYFRAME (add if CSS missing it)
// =========================================
(function ensureToastOutKeyframe() {
    const id = 'ruangkita-toast-keyframes';
    if (document.getElementById(id)) return;
    const style = document.createElement('style');
    style.id = id;
    style.textContent = `
        @keyframes toastOut {
            to { transform: translateX(110%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
})();