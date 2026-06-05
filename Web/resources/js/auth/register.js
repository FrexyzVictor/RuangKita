/**
 * RuangKita — Register Page JS
 * resources/js/auth/register.js
 * Vite entry point
 */

'use strict';

/* ══════════════════════════════════════════════════════════
   BOOT
══════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  initLeftPanelBg();
  initNoise();
  initParticles();
  initAOS();
  initMagneticCard();
  initFormValidation();
  initPasswordToggle('password',              'togglePassword');
  initPasswordToggle('password_confirmation', 'toggleConfirm');
  initPasswordStrength();
  initPasswordMatch();
  initCheckboxAnimations();
  initSubmitButton();
  initProgressBar();
  initSocialButtons();
  initQrScanner();
  initTermsModal();
  initFocusEffects();
  initPageTransitions();
  initClock();
});

/* ══════════════════════════════════════════════════════════
   0. LEFT PANEL BACKGROUND — set via CSS custom property
      so background-size:cover works correctly (no loop)
══════════════════════════════════════════════════════════ */
function initLeftPanelBg() {
  const panel = document.getElementById('panelLeft');
  if (!panel) return;

  // Inject the bg image url from the inline style data-attribute or a known path
  // The image path is set here so CSS can apply cover sizing properly
  const imgEl = panel.querySelector('.left-bg-img');
  if (!imgEl) return;

  // Read from a data attribute on the panel if provided, else use default
  const src = panel.dataset.bgSrc || '/storage/login/Neper.jpg';
  imgEl.style.backgroundImage = `url('${src}')`;
}

/* ══════════════════════════════════════════════════════════
   1. NOISE CANVAS
══════════════════════════════════════════════════════════ */
function initNoise() {
  const canvas = document.getElementById('noiseCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');

  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
  }

  function drawNoise() {
    const { width: w, height: h } = canvas;
    const img  = ctx.createImageData(w, h);
    const data = img.data;
    for (let i = 0; i < data.length; i += 4) {
      const v = (Math.random() * 255) | 0;
      data[i] = data[i+1] = data[i+2] = v;
      data[i+3] = 18;
    }
    ctx.putImageData(img, 0, 0);
    requestAnimationFrame(drawNoise);
  }

  resize();
  window.addEventListener('resize', resize, { passive: true });
  drawNoise();
}

/* ══════════════════════════════════════════════════════════
   2. PARTICLES
══════════════════════════════════════════════════════════ */
function initParticles() {
  const canvas = document.getElementById('particleCanvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  let W, H;
  const COUNT = window.innerWidth < 768 ? 20 : 50;

  class Particle {
    constructor() { this.reset(true); }
    reset(init = false) {
      this.x    = Math.random() * W;
      this.y    = init ? Math.random() * H : H + 20;
      this.r    = Math.random() * 2.4 + 0.5;
      this.vx   = (Math.random() - 0.5) * 0.4;
      this.vy   = -(Math.random() * 0.55 + 0.2);
      this.life = 0;
      this.max  = Math.random() * 200 + 100;
      this.hue  = Math.random() > 0.5 ? 225 : 210;
    }
    update() {
      this.x += this.vx + Math.sin(this.life * 0.02) * 0.3;
      this.y += this.vy;
      this.life++;
      if (this.life > this.max || this.y < -20) this.reset();
    }
    draw() {
      const alpha = Math.sin((this.life / this.max) * Math.PI) * 0.7;
      const grd = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.r * 3);
      grd.addColorStop(0, `hsla(${this.hue},80%,75%,${alpha})`);
      grd.addColorStop(1, `hsla(${this.hue},80%,75%,0)`);
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
      ctx.fillStyle = grd;
      ctx.fill();
    }
  }

  let particles;
  function init() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
    particles = Array.from({ length: COUNT }, () => new Particle());
  }
  function loop() {
    ctx.clearRect(0, 0, W, H);
    particles.forEach(p => { p.update(); p.draw(); });
    requestAnimationFrame(loop);
  }

  window.addEventListener('resize', () => {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }, { passive: true });

  init();
  loop();
}

/* ══════════════════════════════════════════════════════════
   3. AOS
══════════════════════════════════════════════════════════ */
function initAOS() {
  const els = document.querySelectorAll('[data-aos]');
  if (!els.length) return;

  const io = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el    = entry.target;
      const delay = parseInt(el.dataset.aosDelay || 0, 10);
      setTimeout(() => el.classList.add('aos-animate'), delay);
      io.unobserve(el);
    });
  }, { threshold: 0.08 });

  requestAnimationFrame(() => els.forEach(el => io.observe(el)));
}

/* ══════════════════════════════════════════════════════════
   4. MAGNETIC CARD + 3D TILT
══════════════════════════════════════════════════════════ */
function initMagneticCard() {
  const card     = document.getElementById('registerCard');
  const magnetic = document.getElementById('cardMagnetic');
  if (!card || !magnetic) return;

  // Disable tilt on mobile (touch devices)
  if (window.innerWidth <= 768) return;

  let tx = 0, ty = 0, cx = 0, cy = 0, isOver = false;

  card.addEventListener('mousemove', e => {
    isOver = true;
    const r  = card.getBoundingClientRect();
    tx = e.clientX - r.left;
    ty = e.clientY - r.top;
    const nx = (tx / r.width  - 0.5) * 2;
    const ny = (ty / r.height - 0.5) * 2;
    card.style.transform  = `translateY(-4px) rotateX(${-ny * 2}deg) rotateY(${nx * 2}deg)`;
    card.style.transition = 'transform 0.08s linear, box-shadow 0.3s ease';
  }, { passive: true });

  card.addEventListener('mouseleave', () => {
    isOver = false;
    card.style.transform  = 'translateY(0) rotateX(0) rotateY(0)';
    card.style.transition = 'transform 0.6s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.4s ease';
  });

  (function magLoop() {
    if (isOver) {
      cx += (tx - cx) * 0.08;
      cy += (ty - cy) * 0.08;
      magnetic.style.left    = `${cx}px`;
      magnetic.style.top     = `${cy}px`;
      magnetic.style.opacity = '1';
    } else {
      magnetic.style.opacity = '0';
    }
    requestAnimationFrame(magLoop);
  })();
}

/* ══════════════════════════════════════════════════════════
   5. FORM VALIDATION
      Note: role is hidden/default pengunjung — skip role check
══════════════════════════════════════════════════════════ */
function initFormValidation() {
  const namaInput = document.getElementById('nama');
  if (namaInput) {
    namaInput.addEventListener('blur', () => {
      const v    = namaInput.value.trim();
      const icon = document.getElementById('nama-validity');
      if (!v) { setValidity(namaInput, icon, 'neutral'); return; }
      setValidity(namaInput, icon, v.length >= 2 ? 'valid' : 'invalid');
    });
    namaInput.addEventListener('input', () => namaInput.classList.remove('is-invalid'));
  }

  const emailInput = document.getElementById('email');
  if (emailInput) {
    emailInput.addEventListener('input', () => validateEmailField(emailInput));
    emailInput.addEventListener('blur',  () => validateEmailField(emailInput, true));
  }

  // Shake card on server errors
  if (document.querySelectorAll('.is-invalid, .alert--error').length > 0) {
    setTimeout(() => shakeElement(document.getElementById('registerCard')), 400);
  }
}

function validateEmailField(input, strict = false) {
  const val  = input.value.trim();
  const icon = document.getElementById('email-validity');
  const re   = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!val) { setValidity(input, icon, 'neutral'); return; }
  if (strict || val.length > 5) setValidity(input, icon, re.test(val) ? 'valid' : 'invalid');
}

function setValidity(input, icon, state) {
  input.classList.remove('is-invalid', 'is-valid');
  if (icon) { icon.classList.remove('valid', 'invalid'); icon.innerHTML = ''; }

  if (state === 'valid') {
    input.classList.add('is-valid');
    if (icon) { icon.classList.add('valid'); icon.innerHTML = svgCheck(16); }
  } else if (state === 'invalid') {
    input.classList.add('is-invalid');
    if (icon) { icon.classList.add('invalid'); icon.innerHTML = svgX(16); }
  }
}

function svgCheck(s) {
  return `<svg width="${s}" height="${s}" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>`;
}
function svgX(s) {
  return `<svg width="${s}" height="${s}" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`;
}

/* ══════════════════════════════════════════════════════════
   6. PASSWORD TOGGLE
══════════════════════════════════════════════════════════ */
function initPasswordToggle(inputId, btnId) {
  const btn   = document.getElementById(btnId);
  const input = document.getElementById(inputId);
  if (!btn || !input) return;

  const eyeO = btn.querySelector('.eye-open');
  const eyeC = btn.querySelector('.eye-close');

  btn.addEventListener('click', () => {
    const isText     = input.type === 'text';
    input.type       = isText ? 'password' : 'text';
    if (eyeO) eyeO.style.display = isText ? 'block' : 'none';
    if (eyeC) eyeC.style.display = isText ? 'none'  : 'block';
    btn.setAttribute('aria-label', isText ? 'Tampilkan password' : 'Sembunyikan password');
    btn.style.transform = 'scale(1.3)';
    setTimeout(() => btn.style.transform = '', 200);
  });
}

/* ══════════════════════════════════════════════════════════
   7. PASSWORD STRENGTH METER
══════════════════════════════════════════════════════════ */
function initPasswordStrength() {
  const input = document.getElementById('password');
  const rules = document.getElementById('passwordRules');
  const label = document.getElementById('strengthLabel');
  const bars  = [
    document.getElementById('sbar1'),
    document.getElementById('sbar2'),
    document.getElementById('sbar3'),
    document.getElementById('sbar4'),
  ];

  if (!input) return;

  input.addEventListener('focus', () => rules && rules.classList.add('visible'));
  input.addEventListener('input', () => {
    const val = input.value;
    const checks = {
      len:   val.length >= 8,
      upper: /[A-Z]/.test(val),
      lower: /[a-z]/.test(val),
      num:   /[0-9]/.test(val),
    };

    updateRule('rule-len',   checks.len);
    updateRule('rule-upper', checks.upper);
    updateRule('rule-lower', checks.lower);
    updateRule('rule-num',   checks.num);

    const score = Object.values(checks).filter(Boolean).length;
    updateStrengthBars(score, bars, label);

    if (!val) rules && rules.classList.remove('visible');
    else      rules && rules.classList.add('visible');
  });
  input.addEventListener('blur', () => {
    if (!input.value) rules && rules.classList.remove('visible');
  });
}

function updateRule(id, met) {
  const el = document.getElementById(id);
  if (!el) return;
  el.classList.toggle('ok', met);
}

function updateStrengthBars(score, bars, label) {
  const levels   = ['', 'Lemah', 'Cukup', 'Baik', 'Kuat'];
  const colors   = ['', '#EF4444', '#F59E0B', '#3563F6', '#22C55E'];

  bars.forEach((bar, i) => {
    if (!bar) return;
    bar.style.background = i < score ? colors[score] : '';
    bar.style.transition = 'background 0.3s ease';
  });

  if (label) {
    label.textContent = score > 0 ? levels[score] : '';
    label.style.color = score > 0 ? colors[score] : '';
  }
}

/* ══════════════════════════════════════════════════════════
   8. PASSWORD MATCH
══════════════════════════════════════════════════════════ */
function initPasswordMatch() {
  const pass    = document.getElementById('password');
  const confirm = document.getElementById('password_confirmation');
  const errEl   = document.getElementById('confirm-error');
  if (!pass || !confirm || !errEl) return;

  function check() {
    if (!confirm.value) { errEl.hidden = true; return; }
    const match   = pass.value === confirm.value;
    errEl.hidden  = match;
    setValidity(confirm, null, match ? 'valid' : 'invalid');
  }

  confirm.addEventListener('input', check);
  confirm.addEventListener('blur',  check);
}

/* ══════════════════════════════════════════════════════════
   9. CHECKBOX ANIMATIONS
══════════════════════════════════════════════════════════ */
function initCheckboxAnimations() {
  const style = document.createElement('style');
  style.textContent = `
    @keyframes checkPop {
      0%   { transform: scale(1); }
      40%  { transform: scale(1.35); }
      100% { transform: scale(1); }
    }
  `;
  document.head.appendChild(style);

  document.querySelectorAll('.checkbox-native').forEach(native => {
    const custom = native.parentElement?.querySelector('.checkbox-custom');
    if (!custom) return;
    native.addEventListener('change', () => {
      custom.style.animation = 'none';
      void custom.offsetWidth;
      custom.style.animation = 'checkPop 0.3s cubic-bezier(0.34,1.56,0.64,1)';
    });
  });
}

/* ══════════════════════════════════════════════════════════
   10. SUBMIT BUTTON — ripple + loading + validation
       Role is hidden (always pengunjung), excluded from validation
══════════════════════════════════════════════════════════ */
function initSubmitButton() {
  const btn    = document.getElementById('btnSubmit');
  const form   = document.getElementById('registerForm');
  const ripple = document.getElementById('btnRipple');
  if (!btn) return;

  btn.addEventListener('click', e => {
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height) * 2;
    if (ripple) {
      ripple.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX - rect.left - size/2}px;top:${e.clientY - rect.top - size/2}px`;
      ripple.classList.remove('ripple-animate');
      void ripple.offsetWidth;
      ripple.classList.add('ripple-animate');
    }
  });

  form && form.addEventListener('submit', e => {
    const errors = validateAll();
    if (errors.length > 0) {
      e.preventDefault();
      shakeElement(document.getElementById('registerCard'));
      errors.forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.classList.add('is-invalid'); setTimeout(() => el.classList.remove('is-invalid'), 2000); }
      });
      showToast('Lengkapi semua field yang diperlukan', 'error');
      return;
    }

    btn.classList.add('loading');
    btn.disabled = true;
    setTimeout(() => { btn.classList.remove('loading'); btn.disabled = false; }, 10000);
  });
}

function validateAll() {
  const errors = [];

  const nama = document.getElementById('nama');
  if (!nama?.value.trim() || nama.value.trim().length < 2) errors.push('nama');

  const email = document.getElementById('email');
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!email?.value.trim() || !re.test(email.value)) errors.push('email');

  // role is hidden/fixed — skip validation

  const pass = document.getElementById('password');
  if (!pass?.value || pass.value.length < 8) errors.push('password');

  const conf = document.getElementById('password_confirmation');
  if (!conf?.value || conf.value !== pass?.value) errors.push('password_confirmation');

  const terms = document.getElementById('terms');
  if (!terms?.checked) {
    const termsErr = document.getElementById('terms-error');
    if (termsErr) { termsErr.hidden = false; setTimeout(() => termsErr.hidden = true, 3000); }
    errors.push('terms');
  }

  return errors;
}

/* ══════════════════════════════════════════════════════════
   11. PROGRESS BAR
       5 fields: nama, email, no_hp (optional, skip), password, confirm
══════════════════════════════════════════════════════════ */
function initProgressBar() {
  const fill  = document.getElementById('progressFill');
  const label = document.getElementById('progressLabel');
  if (!fill || !label) return;

  // Only required fields for progress
  const fields = ['nama', 'email', 'password', 'password_confirmation'];
  // no_hp is optional — exclude from progress count
  // role is hidden/fixed — exclude

  function update() {
    let filled = 0;
    fields.forEach(id => {
      const el = document.getElementById(id);
      if (el && el.value && el.value.trim()) filled++;
    });

    // Also count terms checkbox
    const terms = document.getElementById('terms');
    const total = fields.length + 1;
    if (terms?.checked) filled++;

    const pct = Math.round((filled / total) * 100);
    fill.style.width  = `${pct}%`;
    label.textContent = `${filled} / ${total} field terisi`;

    if (pct === 100) {
      fill.style.background = 'linear-gradient(90deg, #22C55E, #4ade80)';
      label.style.color = '#16A34A';
    } else {
      fill.style.background = '';
      label.style.color = '';
    }
  }

  fields.forEach(id => {
    const el = document.getElementById(id);
    el && el.addEventListener('input', update);
    el && el.addEventListener('change', update);
  });

  const terms = document.getElementById('terms');
  terms && terms.addEventListener('change', update);

  update();
}

/* ══════════════════════════════════════════════════════════
   12. SOCIAL BUTTONS
══════════════════════════════════════════════════════════ */
function initSocialButtons() {
  document.querySelectorAll('.btn-social').forEach(btn => {
    btn.addEventListener('mousedown',  () => btn.style.transform = 'translateY(1px) scale(0.97)');
    btn.addEventListener('mouseup',    () => btn.style.transform = '');
    btn.addEventListener('mouseleave', () => btn.style.transform = '');
    btn.addEventListener('click', () => showToast('Fitur SSO belum dikonfigurasi', 'info'));
  });
}

/* ══════════════════════════════════════════════════════════
   13. QR SCANNER
══════════════════════════════════════════════════════════ */
function initQrScanner() {
  const btnQr    = document.getElementById('btnQr');
  const qrReader = document.getElementById('qrReader');
  if (!btnQr || !qrReader) return;

  let scannerStarted = false;
  let isOpen = false;

  btnQr.addEventListener('click', () => {
    isOpen = !isOpen;
    qrReader.style.display = isOpen ? 'block' : 'none';

    if (isOpen && !scannerStarted) {
      scannerStarted = true;

      if (typeof Html5QrcodeScanner === 'undefined') {
        qrReader.innerHTML = `<div style="padding:16px;text-align:center;color:#6B7280;font-size:0.83rem">QR Scanner library belum dimuat</div>`;
        return;
      }

      const scanner = new Html5QrcodeScanner('qrReader', { fps: 10, qrbox: 220 });
      scanner.render(
        (decodedText) => {
          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
          fetch('/qr-login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify({ qr_code: decodedText }),
          })
          .then(r => r.json())
          .then(data => {
            if (data.success) {
              showToast('QR berhasil! Mengalihkan...', 'success');
              setTimeout(() => window.location.href = data.redirect, 800);
            } else {
              showToast('QR tidak valid', 'error');
            }
          })
          .catch(() => showToast('Gagal memproses QR', 'error'));
        },
        (_err) => { /* silent */ }
      );
    }

    btnQr.textContent = isOpen ? 'Tutup Scanner' : '⊞  Scan QR untuk Masuk';
  });
}

/* ══════════════════════════════════════════════════════════
   14. TERMS MODAL
══════════════════════════════════════════════════════════ */
function initTermsModal() {
  const openBtn   = document.getElementById('openTerms');
  const modal     = document.getElementById('termsModal');
  const backdrop  = document.getElementById('termsBackdrop');
  const closeBtn  = document.getElementById('termsClose');
  const acceptBtn = document.getElementById('termsAccept');
  const terms     = document.getElementById('terms');
  if (!modal) return;

  function openModal() {
    modal.hidden = false;
    document.body.style.overflow = 'hidden';
    setTimeout(() => modal.querySelector('.terms-modal__box')?.focus?.(), 100);
  }
  function closeModal() {
    modal.hidden = true;
    document.body.style.overflow = '';
  }

  openBtn   && openBtn.addEventListener('click',   e => { e.preventDefault(); openModal(); });
  backdrop  && backdrop.addEventListener('click',   closeModal);
  closeBtn  && closeBtn.addEventListener('click',   closeModal);
  acceptBtn && acceptBtn.addEventListener('click', () => {
    if (terms) {
      terms.checked = true;
      terms.dispatchEvent(new Event('change'));
    }
    closeModal();
    showToast('Syarat & ketentuan disetujui', 'success');
  });

  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && !modal.hidden) closeModal();
  });
}

/* ══════════════════════════════════════════════════════════
   15. FOCUS EFFECTS
══════════════════════════════════════════════════════════ */
function initFocusEffects() {
  document.querySelectorAll('.form-group').forEach(grp => {
    const input = grp.querySelector('.form-input');
    const icon  = grp.querySelector('.input-icon--left');
    if (!input || !icon) return;
    input.addEventListener('focus', () => {
      icon.style.color     = 'var(--rk-primary-500)';
      icon.style.transform = 'scale(1.1)';
    });
    input.addEventListener('blur', () => {
      icon.style.color     = '';
      icon.style.transform = '';
    });
  });
}

/* ══════════════════════════════════════════════════════════
   16. PAGE TRANSITIONS
══════════════════════════════════════════════════════════ */
function initPageTransitions() {
  document.querySelectorAll('a[href]:not([target="_blank"])').forEach(link => {
    link.addEventListener('click', e => {
      const href = link.getAttribute('href');
      if (!href || href.startsWith('#') || href.startsWith('javascript')) return;
      e.preventDefault();
      document.body.style.opacity   = '0';
      document.body.style.transform = 'translateY(-8px)';
      document.body.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
      setTimeout(() => window.location.href = href, 300);
    });
  });
}

/* ══════════════════════════════════════════════════════════
   17. LIVE CLOCK — desktop left panel
       Shown only on desktop (CSS hides .panel-clock on mobile)
══════════════════════════════════════════════════════════ */
function initClock() {
  const timeEl = document.getElementById('clockTime');
  const dateEl = document.getElementById('clockDate');
  if (!timeEl && !dateEl) return;

  const DAYS  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
  const MONTHS = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

  function tick() {
    const now = new Date();
    const hh  = String(now.getHours()).padStart(2, '0');
    const mm  = String(now.getMinutes()).padStart(2, '0');
    const ss  = String(now.getSeconds()).padStart(2, '0');

    if (timeEl) timeEl.textContent = `${hh}:${mm}:${ss}`;

    if (dateEl) {
      const day  = DAYS[now.getDay()];
      const date = now.getDate();
      const mon  = MONTHS[now.getMonth()];
      const yr   = now.getFullYear();
      dateEl.textContent = `${day}, ${date} ${mon} ${yr}`;
    }
  }

  tick();
  setInterval(tick, 1000);
}

/* ══════════════════════════════════════════════════════════
   18. TOAST NOTIFICATION
══════════════════════════════════════════════════════════ */
function showToast(message, type = 'info') {
  const existing = document.getElementById('rkToast');
  if (existing) existing.remove();

  const map = {
    info:    { bg:'#EFF6FF', border:'#BFDBFE', text:'#1D4ED8', icon:'#3B82F6', svg: `<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>` },
    success: { bg:'#F0FDF4', border:'#BBF7D0', text:'#15803D', icon:'#22C55E', svg: `<polyline points="20 6 9 17 4 12"/>` },
    error:   { bg:'#FEF2F2', border:'#FECACA', text:'#DC2626', icon:'#EF4444', svg: `<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>` },
  };
  const c = map[type] || map.info;

  const t = document.createElement('div');
  t.id = 'rkToast';
  t.style.cssText = `
    position:fixed;bottom:28px;left:50%;
    transform:translateX(-50%) translateY(20px);
    background:${c.bg};border:1px solid ${c.border};color:${c.text};
    padding:11px 18px;border-radius:14px;
    font-family:'DM Sans',sans-serif;font-size:0.83rem;font-weight:500;
    display:flex;align-items:center;gap:8px;
    z-index:9999;box-shadow:0 8px 24px rgba(0,0,0,0.08);
    opacity:0;transition:all 0.35s cubic-bezier(0.34,1.56,0.64,1);white-space:nowrap;
  `;
  t.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="${c.icon}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">${c.svg}</svg>${message}`;
  document.body.appendChild(t);

  requestAnimationFrame(() => requestAnimationFrame(() => {
    t.style.opacity   = '1';
    t.style.transform = 'translateX(-50%) translateY(0)';
  }));

  setTimeout(() => {
    t.style.opacity   = '0';
    t.style.transform = 'translateX(-50%) translateY(10px)';
    setTimeout(() => t.remove(), 400);
  }, 3000);
}

/* ══════════════════════════════════════════════════════════
   HELPERS
══════════════════════════════════════════════════════════ */
function shakeElement(el) {
  if (!el) return;
  el.classList.remove('shake');
  void el.offsetWidth;
  el.classList.add('shake');
  el.addEventListener('animationend', () => el.classList.remove('shake'), { once: true });
}

/* ══════════════════════════════════════════════════════════
   WINDOW LOAD — page reveal
══════════════════════════════════════════════════════════ */
window.addEventListener('load', () => {
  document.body.style.opacity   = '0';
  document.body.style.transform = 'translateY(8px)';
  document.body.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

  requestAnimationFrame(() => requestAnimationFrame(() => {
    document.body.style.opacity   = '1';
    document.body.style.transform = 'translateY(0)';
  }));

  setTimeout(() => {
    document.querySelectorAll('[data-aos]').forEach(el => el.classList.add('aos-animate'));
  }, 120);
});