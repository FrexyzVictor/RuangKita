/**
 * RUANGKITA ADMIN — USERS MODULE JS
 * resources/js/admin/users.js
 */

const UsersModule = (() => {

    /* ── Delete Modal ────────────────────────────────────────── */
    let pendingDeleteUrl = null;

    function openDeleteModal(id, nama) {
        pendingDeleteUrl = `/admin/users/${id}`;
        const el = document.getElementById('delete-modal');
        if (!el) return;
        el.querySelector('#delete-user-name').textContent = nama;
        el.classList.add('active');
    }

    function closeDeleteModal() {
        const el = document.getElementById('delete-modal');
        if (el) el.classList.remove('active');
        pendingDeleteUrl = null;
    }

    function confirmDelete() {
        if (!pendingDeleteUrl) return;
        const form = document.getElementById('delete-form');
        if (form) {
            form.action = pendingDeleteUrl;
            form.submit();
        }
    }

    /* ── Live Search ─────────────────────────────────────────── */
    function initLiveSearch() {
        const input      = document.getElementById('search-input');
        const spinner    = document.getElementById('search-spinner');
        const filterForm = document.getElementById('filter-form');
        if (!input || !filterForm) return;

        let timer;

        input.addEventListener('input', function () {
            clearTimeout(timer);
            if (spinner) spinner.style.display = 'block';

            // Submit setelah berhenti mengetik 500ms
            timer = setTimeout(() => {
                filterForm.submit();
            }, 500);
        });

        // Tekan Enter langsung submit tanpa tunggu debounce
        input.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(timer);
                filterForm.submit();
            }
        });

        // Fokus input otomatis jika ada query aktif
        if (input.value.trim()) {
            input.focus();
            // Taruh kursor di akhir
            const len = input.value.length;
            input.setSelectionRange(len, len);
        }
    }

    /* ── Password Strength ───────────────────────────────────── */
    function initPasswordStrength() {
        const pwInput = document.getElementById('password');
        const fillEl  = document.getElementById('pw-fill');
        const textEl  = document.getElementById('pw-text');
        if (!pwInput || !fillEl) return;

        pwInput.addEventListener('input', function () {
            const v = this.value;
            let score = 0;
            if (v.length >= 8)           score++;
            if (/[A-Z]/.test(v))         score++;
            if (/[0-9]/.test(v))         score++;
            if (/[^A-Za-z0-9]/.test(v))  score++;

            const levels = [
                { w: '0%',   bg: 'transparent', label: '' },
                { w: '25%',  bg: '#ef4444',     label: 'Lemah' },
                { w: '50%',  bg: '#f59e0b',     label: 'Cukup' },
                { w: '75%',  bg: '#3b82f6',     label: 'Kuat' },
                { w: '100%', bg: '#10b981',     label: 'Sangat Kuat' },
            ];
            const lvl = v.length === 0 ? levels[0] : (levels[score] || levels[1]);
            fillEl.style.width      = lvl.w;
            fillEl.style.background = lvl.bg;
            if (textEl) {
                textEl.textContent = lvl.label;
                textEl.style.color = lvl.bg;
            }
        });
    }

    /* ── Role Color Preview ──────────────────────────────────── */
    function initRolePreview() {
        const sel         = document.getElementById('role');
        const dotEl       = document.getElementById('role-preview-dot');
        const textEl      = document.getElementById('role-preview-text');
        if (!sel) return;

        const colors = {
            admin:      '#4f46e5',
            guru:       '#059669',
            siswa:      '#2563eb',
            pengunjung: '#d97706',
            guest:      '#6b7280',
        };
        const labels = {
            admin:      'Akses penuh ke semua fitur',
            guru:       'Dapat membuat & melihat booking',
            siswa:      'Dapat booking fasilitas',
            pengunjung: 'Akses terbatas, pembayaran wajib',
            guest:      'Belum diverifikasi',
        };

        const update = () => {
            const v = sel.value;
            if (dotEl)  dotEl.style.background = colors[v] || '#6b7280';
            if (textEl) textEl.textContent      = labels[v] || '';
        };

        sel.addEventListener('change', update);
        update();
    }

    /* ── Klik baris → ke halaman detail ─────────────────────── */
    function initRowActions() {
        document.querySelectorAll('tbody tr[data-user-id]').forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', function (e) {
                // Abaikan klik pada tombol/link/form
                if (e.target.closest('button, a, form')) return;
                const id = this.dataset.userId;
                if (id) window.location.href = `/admin/users/${id}`;
            });
        });
    }

    /* ── Copy to clipboard ───────────────────────────────────── */
    function copyText(text) {
        navigator.clipboard.writeText(text).then(() => {
            window.RuangKita?.toast('Disalin ke clipboard', 'success');
        }).catch(() => {
            // Fallback untuk browser lama
            const ta = document.createElement('textarea');
            ta.value = text;
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            ta.remove();
            window.RuangKita?.toast('Disalin ke clipboard', 'success');
        });
    }

    /* ── Toggle lihat/sembunyikan password ──────────────────── */
    function initPasswordToggle() {
        document.querySelectorAll('[data-pw-toggle]').forEach(btn => {
            btn.addEventListener('click', function () {
                const target = document.getElementById(this.dataset.pwToggle);
                if (!target) return;
                const isText = target.type === 'text';
                target.type = isText ? 'password' : 'text';
                const icon = this.querySelector('svg');
                if (icon) {
                    icon.innerHTML = isText
                        ? `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`
                        : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
                }
            });
        });
    }

    /* ── Validasi form (create & edit) ──────────────────────── */
    function initFormValidation() {
        const form = document.getElementById('user-form');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            let valid = true;

            // Required fields
            form.querySelectorAll('[required]').forEach(field => {
                const errEl = document.getElementById(`err-${field.name}`);
                if (!field.value.trim()) {
                    field.classList.add('input-has-error');
                    if (errEl) errEl.style.display = 'flex';
                    valid = false;
                } else {
                    field.classList.remove('input-has-error');
                    if (errEl) errEl.style.display = 'none';
                }
            });

            // Format email
            const email = form.querySelector('[type="email"]');
            if (email && email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                email.classList.add('input-has-error');
                const errEl = document.getElementById('err-email');
                if (errEl) { errEl.textContent = 'Format email tidak valid'; errEl.style.display = 'flex'; }
                valid = false;
            }

            // Konfirmasi password
            const pw     = document.getElementById('password');
            const pwConf = document.getElementById('password_confirmation');
            if (pw && pwConf && pw.value && pw.value !== pwConf.value) {
                pwConf.classList.add('input-has-error');
                const errEl = document.getElementById('err-password_confirmation');
                if (errEl) { errEl.textContent = 'Password tidak cocok'; errEl.style.display = 'flex'; }
                valid = false;
            }

            if (!valid) e.preventDefault();
        });

        // Hapus error saat field diubah
        form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('input', function () {
                this.classList.remove('input-has-error');
                const errEl = document.getElementById(`err-${this.name}`);
                if (errEl) errEl.style.display = 'none';
            });
        });
    }

    /* ── Init ────────────────────────────────────────────────── */
    function init() {
        initLiveSearch();
        initPasswordStrength();
        initRolePreview();
        initRowActions();
        initPasswordToggle();
        initFormValidation();

        // Tutup modal klik di luar box
        document.getElementById('delete-modal')?.addEventListener('click', function (e) {
            if (e.target === this) closeDeleteModal();
        });

        // Tutup modal tekan Escape
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeDeleteModal();
        });
    }

    document.addEventListener('DOMContentLoaded', init);

    return { openDeleteModal, closeDeleteModal, confirmDelete, copyText };
})();

window.UsersModule = UsersModule;