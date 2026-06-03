/**
 * RuangKita — Login Page JS
 * Anti-Gravity | Magnetic Cursor | Particles | AOS | Micro-interactions
 * resources/js/auth/login.js
 */

'use strict';

/* ══════════════════════════════════════════════════════════════
   1. DOM READY BOOTSTRAP
══════════════════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  initNoise();
  initParticles();
  initAOS();
  initAntiGravity();
  initMagneticCard();
  initFormBehavior();
  initPasswordToggle();
  initCapsLock();
  initSubmitButton();
  initSocialButtons();
  initCheckboxAnimation();
  initTiltCard();
  initCounterAnimation();
  initFocusEffects();
  initTypingAnimation();
  initScrollGradient();
});


/* ══════════════════════════════════════════════════════════════
   2. NOISE CANVAS — subtle grain texture
══════════════════════════════════════════════════════════════ */
function initNoise() {
  const canvas = document.getElementById('noiseCanvas');
  if (!canvas) return;

  const ctx  = canvas.getContext('2d');
  let frame  = 0;
  let raf;

  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
  }

  function drawNoise() {
    const w = canvas.width;
    const h = canvas.height;
    const imageData = ctx.createImageData(w, h);
    const data = imageData.data;

    for (let i = 0; i < data.length; i += 4) {
      const v = Math.random() * 255 | 0;
      data[i]     = v;
      data[i + 1] = v;
      data[i + 2] = v;
      data[i + 3] = 18; // very transparent
    }

    ctx.putImageData(imageData, 0, 0);
    frame++;

    // Refresh grain every 3 frames for performance
    if (frame % 3 === 0) {
      raf = requestAnimationFrame(drawNoise);
    } else {
      raf = requestAnimationFrame(drawNoise);
    }
  }

  resize();
  window.addEventListener('resize', resize, { passive: true });
  drawNoise();
}


/* ══════════════════════════════════════════════════════════════
   3. PARTICLE CANVAS — floating glowing dots
══════════════════════════════════════════════════════════════ */
function initParticles() {
  const canvas = document.getElementById('particleCanvas');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');
  let W, H, particles = [];
  const COUNT = window.innerWidth < 768 ? 30 : 60;

  class Particle {
    constructor() { this.reset(true); }

    reset(initial = false) {
      this.x    = Math.random() * W;
      this.y    = initial ? Math.random() * H : H + 20;
      this.r    = Math.random() * 2.5 + 0.5;
      this.vx   = (Math.random() - 0.5) * 0.4;
      this.vy   = -(Math.random() * 0.6 + 0.2);
      this.life = 0;
      this.maxLife = Math.random() * 200 + 100;
      this.hue  = Math.random() > 0.5 ? 225 : 210; // blue family
      this.sat  = Math.random() * 40 + 60;
      this.lum  = Math.random() * 30 + 60;
    }

    update() {
      this.x += this.vx;
      this.y += this.vy;
      this.life++;

      // Gentle wobble
      this.x += Math.sin(this.life * 0.02) * 0.3;

      if (this.life > this.maxLife || this.y < -20) {
        this.reset();
      }
    }

    draw() {
      const alpha = Math.sin((this.life / this.maxLife) * Math.PI) * 0.7;
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);

      const grd = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.r * 3);
      grd.addColorStop(0, `hsla(${this.hue},${this.sat}%,${this.lum}%,${alpha})`);
      grd.addColorStop(1, `hsla(${this.hue},${this.sat}%,${this.lum}%,0)`);

      ctx.fillStyle = grd;
      ctx.fill();
    }
  }

  function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }

  function init() {
    resize();
    particles = Array.from({ length: COUNT }, () => new Particle());
  }

  function loop() {
    ctx.clearRect(0, 0, W, H);
    particles.forEach(p => { p.update(); p.draw(); });
    requestAnimationFrame(loop);
  }

  window.addEventListener('resize', resize, { passive: true });
  init();
  loop();
}


/* ══════════════════════════════════════════════════════════════
   4. AOS — Animate On Scroll (custom)
══════════════════════════════════════════════════════════════ */
function initAOS() {
  const els = document.querySelectorAll('[data-aos]');
  if (!els.length) return;

  const delays = {};
  els.forEach(el => {
    const delay = parseInt(el.dataset.aosDelay || 0, 10);
    delays[el] = delay;
  });

  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el    = entry.target;
        const delay = parseInt(el.dataset.aosDelay || 0, 10);

        setTimeout(() => {
          el.classList.add('aos-animate');
        }, delay);

        io.unobserve(el);
      }
    });
  }, { threshold: 0.1 });

  // Trigger immediately (elements in viewport on load)
  requestAnimationFrame(() => {
    els.forEach(el => io.observe(el));
  });
}


/* ══════════════════════════════════════════════════════════════
   5. ANTI-GRAVITY FLOATING CARDS — parallax on mouse
══════════════════════════════════════════════════════════════ */
function initAntiGravity() {
  const preview  = document.getElementById('agPreview');
  if (!preview) return;

  const cards    = preview.querySelectorAll('[data-depth]');
  const notif    = preview.querySelector('.ag-notification');

  let mx = 0, my = 0;
  let cx = 0, cy = 0;
  let rafId;

  // Initial floating animation via CSS keyframes — add them programmatically per card
  const floatConfigs = [
    { card: null, duration: 6, delay: 0, amplitude: 12 },
    { card: null, duration: 8, delay: -2, amplitude: 16 },
    { card: null, duration: 7, delay: -4, amplitude: 10 },
    { card: null, duration: 9, delay: -1, amplitude: 14 },
  ];

  cards.forEach((card, i) => {
    const cfg = floatConfigs[i] || floatConfigs[0];
    cfg.card = card;

    // Apply float animation
    card.style.animation = `agFloat${i} ${cfg.duration}s ease-in-out ${cfg.delay}s infinite alternate`;

    // Inject keyframe
    const kf = document.createElement('style');
    kf.textContent = `
      @keyframes agFloat${i} {
        from { transform: ${getBaseTransform(card)} translateY(0px) rotate(${getBaseRotation(card)}deg); }
        to   { transform: ${getBaseTransform(card)} translateY(${cfg.amplitude}px) rotate(${getBaseRotation(card) + 2}deg); }
      }
    `;
    document.head.appendChild(kf);
  });

  function getBaseTransform(card) {
    if (card.classList.contains('ag-card--main'))      return 'translate(-50%, -50%)';
    return '';
  }
  function getBaseRotation(card) {
    if (card.classList.contains('ag-card--main'))      return -3;
    if (card.classList.contains('ag-card--secondary')) return 4;
    if (card.classList.contains('ag-card--stat'))      return -2;
    return 2;
  }

  // Mouse parallax
  document.addEventListener('mousemove', (e) => {
    const rect = document.body.getBoundingClientRect();
    mx = (e.clientX / rect.width  - 0.5) * 2;
    my = (e.clientY / rect.height - 0.5) * 2;
  }, { passive: true });

  function parallaxLoop() {
    cx += (mx - cx) * 0.06;
    cy += (my - cy) * 0.06;

    cards.forEach(card => {
      const depth = parseFloat(card.dataset.depth || 0.3);
      const tx    = cx * depth * 28;
      const ty    = cy * depth * 20;
      const rz    = cx * depth * 3;
      const ry    = cx * depth * 4;

      // Preserve card base position; add mouse delta
      const isMain = card.classList.contains('ag-card--main');
      const baseX  = isMain ? '-50%' : '0';
      const baseY  = isMain ? '-50%' : '0';

      card.style.transform = `translate(calc(${baseX} + ${tx}px), calc(${baseY} + ${ty}px)) rotateY(${ry}deg) rotateZ(${rz}deg)`;
    });

    rafId = requestAnimationFrame(parallaxLoop);
  }

  parallaxLoop();
}


/* ══════════════════════════════════════════════════════════════
   6. MAGNETIC CARD — cursor glow follower
══════════════════════════════════════════════════════════════ */
function initMagneticCard() {
  const card     = document.getElementById('loginCard');
  const magnetic = document.getElementById('cardMagnetic');
  if (!card || !magnetic) return;

  let targetX = 0, targetY = 0;
  let curX = 0, curY = 0;
  let isOver = false;

  card.addEventListener('mousemove', (e) => {
    isOver = true;
    const rect = card.getBoundingClientRect();
    targetX = e.clientX - rect.left;
    targetY = e.clientY - rect.top;
  }, { passive: true });

  card.addEventListener('mouseleave', () => {
    isOver = false;
  });

  function magneticLoop() {
    if (isOver) {
      curX += (targetX - curX) * 0.08;
      curY += (targetY - curY) * 0.08;
      magnetic.style.opacity = '1';
    } else {
      magnetic.style.opacity = '0';
    }
    magnetic.style.left = `${curX}px`;
    magnetic.style.top  = `${curY}px`;
    requestAnimationFrame(magneticLoop);
  }
  magneticLoop();

  // 3D tilt on card
  card.addEventListener('mousemove', (e) => {
    const rect = card.getBoundingClientRect();
    const x    = (e.clientX - rect.left - rect.width  / 2) / (rect.width  / 2);
    const y    = (e.clientY - rect.top  - rect.height / 2) / (rect.height / 2);
    card.style.transform = `translateY(-4px) rotateX(${-y * 2.5}deg) rotateY(${x * 2.5}deg)`;
  }, { passive: true });

  card.addEventListener('mouseleave', () => {
    card.style.transform = 'translateY(0) rotateX(0) rotateY(0)';
    card.style.transition = 'transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease';
  });

  card.addEventListener('mouseenter', () => {
    card.style.transition = 'transform 0.1s linear, box-shadow 0.4s ease';
  });
}


/* ══════════════════════════════════════════════════════════════
   7. TILT EFFECT — login card on touch devices
══════════════════════════════════════════════════════════════ */
function initTiltCard() {
  const card = document.getElementById('loginCard');
  if (!card || window.matchMedia('(hover: none)').matches) return;
  // Already handled in initMagneticCard for desktop
}


/* ══════════════════════════════════════════════════════════════
   8. FORM BEHAVIOR — realtime validation + field states
══════════════════════════════════════════════════════════════ */
function initFormBehavior() {
  const emailInput    = document.getElementById('email');
  const passwordInput = document.getElementById('password');

  if (emailInput) {
    emailInput.addEventListener('input', () => validateEmail(emailInput));
    emailInput.addEventListener('blur',  () => validateEmail(emailInput, true));
  }

  if (passwordInput) {
    passwordInput.addEventListener('input', () => validatePassword(passwordInput));
  }

  // Shake on server-side error
  const invalidInputs = document.querySelectorAll('.form-input.is-invalid');
  if (invalidInputs.length > 0) {
    const card = document.getElementById('loginCard');
    setTimeout(() => {
      card && shakeElement(card);
    }, 500);
  }
}

function validateEmail(input, strict = false) {
  const val = input.value.trim();
  const icon = document.getElementById('email-validity');
  const group = document.getElementById('group-email');

  if (!val) {
    setFieldState(input, icon, group, 'neutral');
    return;
  }

  const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const valid   = emailRe.test(val);

  if (strict || val.length > 5) {
    setFieldState(input, icon, group, valid ? 'valid' : 'invalid');
  }
}

function validatePassword(input) {
  // Only check on blur for server-side login; show strength indicator if register
  // For login page: just ensure not empty
}

function setFieldState(input, icon, group, state) {
  input.classList.remove('is-invalid', 'is-valid');
  icon && icon.classList.remove('valid', 'invalid');

  if (state === 'valid') {
    input.classList.add('is-valid');
    if (icon) {
      icon.classList.add('valid');
      icon.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16"><polyline points="20 6 9 17 4 12"/></svg>`;
    }
  } else if (state === 'invalid') {
    input.classList.add('is-invalid');
    if (icon) {
      icon.classList.add('invalid');
      icon.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`;
    }
  } else {
    if (icon) icon.innerHTML = '';
  }
}

function shakeElement(el) {
  el.classList.remove('shake');
  void el.offsetWidth; // reflow
  el.classList.add('shake');
  el.addEventListener('animationend', () => el.classList.remove('shake'), { once: true });
}


/* ══════════════════════════════════════════════════════════════
   9. PASSWORD TOGGLE — show/hide + icon swap
══════════════════════════════════════════════════════════════ */
function initPasswordToggle() {
  const btn   = document.getElementById('togglePassword');
  const input = document.getElementById('password');
  if (!btn || !input) return;

  const eyeOpen  = btn.querySelector('.eye-open');
  const eyeClose = btn.querySelector('.eye-close');

  btn.addEventListener('click', () => {
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';

    if (eyeOpen)  eyeOpen.style.display  = isText ? 'block' : 'none';
    if (eyeClose) eyeClose.style.display = isText ? 'none'  : 'block';

    btn.setAttribute('aria-label', isText ? 'Tampilkan password' : 'Sembunyikan password');

    // Micro bounce
    btn.style.transform = 'scale(1.3)';
    setTimeout(() => btn.style.transform = '', 200);
  });
}


/* ══════════════════════════════════════════════════════════════
   10. CAPS LOCK DETECTION
══════════════════════════════════════════════════════════════ */
function initCapsLock() {
  const input = document.getElementById('password');
  const warn  = document.getElementById('capslock-warn');
  if (!input || !warn) return;

  input.addEventListener('keydown', (e) => {
    const caps = e.getModifierState?.('CapsLock');
    if (caps !== undefined) {
      if (caps) {
        warn.removeAttribute('hidden');
        warn.style.animation = 'alertIn 0.3s ease';
      } else {
        warn.setAttribute('hidden', '');
      }
    }
  });

  input.addEventListener('keyup', (e) => {
    const caps = e.getModifierState?.('CapsLock');
    if (caps !== undefined && !caps) {
      warn.setAttribute('hidden', '');
    }
  });
}


/* ══════════════════════════════════════════════════════════════
   11. SUBMIT BUTTON — ripple + loading + validation
══════════════════════════════════════════════════════════════ */
function initSubmitButton() {
  const btn    = document.getElementById('btnSubmit');
  const form   = document.getElementById('loginForm');
  const ripple = document.getElementById('btnRipple');
  if (!btn) return;

  // Ripple on click
  btn.addEventListener('click', (e) => {
    const rect = btn.getBoundingClientRect();
    const size = Math.max(rect.width, rect.height) * 2;
    const x    = e.clientX - rect.left - size / 2;
    const y    = e.clientY - rect.top  - size / 2;

    if (ripple) {
      ripple.style.cssText = `
        width: ${size}px;
        height: ${size}px;
        left: ${x}px;
        top: ${y}px;
      `;
      ripple.classList.remove('ripple-animate');
      void ripple.offsetWidth;
      ripple.classList.add('ripple-animate');
    }
  });

  // Loading state on submit
  if (form) {
    form.addEventListener('submit', (e) => {
      const email = document.getElementById('email')?.value.trim();
      const pass  = document.getElementById('password')?.value;

      // Basic client-side check
      if (!email || !pass) {
        e.preventDefault();
        shakeElement(document.getElementById('loginCard'));
        highlightEmptyFields();
        return;
      }

      btn.classList.add('loading');
      btn.disabled = true;

      // Safety: re-enable after 10s (network timeout fallback)
      setTimeout(() => {
        btn.classList.remove('loading');
        btn.disabled = false;
      }, 10000);
    });
  }
}

function highlightEmptyFields() {
  const email    = document.getElementById('email');
  const password = document.getElementById('password');

  [email, password].forEach(input => {
    if (input && !input.value.trim()) {
      input.classList.add('is-invalid');
      input.addEventListener('input', () => input.classList.remove('is-invalid'), { once: true });

      // Flash animation
      input.style.transform = 'scale(1.02)';
      setTimeout(() => input.style.transform = '', 200);
    }
  });
}


/* ══════════════════════════════════════════════════════════════
   12. SOCIAL BUTTONS — tooltip + press effect
══════════════════════════════════════════════════════════════ */
function initSocialButtons() {
  const btns = document.querySelectorAll('.btn-social');

  btns.forEach(btn => {
    btn.addEventListener('mousedown', () => {
      btn.style.transform = 'translateY(1px) scale(0.97)';
    });
    btn.addEventListener('mouseup', () => {
      btn.style.transform = '';
    });
    btn.addEventListener('mouseleave', () => {
      btn.style.transform = '';
    });

    btn.addEventListener('click', () => {
      // Show toast: OAuth not configured
      showToast('Fitur SSO belum dikonfigurasi', 'info');
    });
  });
}


/* ══════════════════════════════════════════════════════════════
   13. TOAST NOTIFICATION
══════════════════════════════════════════════════════════════ */
function showToast(message, type = 'info') {
  const existing = document.getElementById('rkToast');
  if (existing) existing.remove();

  const colors = {
    info:    { bg: '#EFF6FF', border: '#BFDBFE', text: '#1D4ED8', icon: '#3B82F6' },
    success: { bg: '#F0FDF4', border: '#BBF7D0', text: '#15803D', icon: '#22C55E' },
    error:   { bg: '#FEF2F2', border: '#FECACA', text: '#DC2626', icon: '#EF4444' },
  };
  const c = colors[type] || colors.info;

  const icons = {
    info:    `<circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>`,
    success: `<polyline points="20 6 9 17 4 12"/>`,
    error:   `<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>`,
  };

  const toast = document.createElement('div');
  toast.id = 'rkToast';
  toast.style.cssText = `
    position: fixed;
    bottom: 28px;
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    background: ${c.bg};
    border: 1px solid ${c.border};
    color: ${c.text};
    padding: 12px 18px;
    border-radius: 14px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.85rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    z-index: 9999;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    opacity: 0;
    transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    white-space: nowrap;
  `;

  toast.innerHTML = `
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="${c.icon}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      ${icons[type]}
    </svg>
    ${message}
  `;

  document.body.appendChild(toast);

  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      toast.style.opacity = '1';
      toast.style.transform = 'translateX(-50%) translateY(0)';
    });
  });

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(-50%) translateY(10px)';
    setTimeout(() => toast.remove(), 400);
  }, 3000);
}


/* ══════════════════════════════════════════════════════════════
   14. CHECKBOX ANIMATION — spring bounce
══════════════════════════════════════════════════════════════ */
function initCheckboxAnimation() {
  const native = document.querySelector('.checkbox-native');
  const custom = document.querySelector('.checkbox-custom');
  if (!native || !custom) return;

  native.addEventListener('change', () => {
    custom.style.animation = 'none';
    void custom.offsetWidth;
    custom.style.animation = 'checkboxPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
  });

  // Inject animation
  const style = document.createElement('style');
  style.textContent = `
    @keyframes checkboxPop {
      0%   { transform: scale(1); }
      40%  { transform: scale(1.3); }
      100% { transform: scale(1); }
    }
  `;
  document.head.appendChild(style);
}


/* ══════════════════════════════════════════════════════════════
   15. COUNTER ANIMATION — stat card number
══════════════════════════════════════════════════════════════ */
function initCounterAnimation() {
  const statEl = document.querySelector('.ag-stat__number');
  if (!statEl) return;

  const target = parseInt(statEl.textContent, 10);
  let current  = 0;
  let rafId;

  // Trigger when panel is visible
  const io = new IntersectionObserver(([entry]) => {
    if (entry.isIntersecting) {
      animateCounter();
      io.disconnect();
    }
  }, { threshold: 0.3 });

  io.observe(statEl);

  function animateCounter() {
    const duration = 1500;
    const start    = performance.now();

    function step(now) {
      const progress = Math.min((now - start) / duration, 1);
      const eased    = 1 - Math.pow(1 - progress, 3); // ease-out cubic
      statEl.textContent = Math.round(eased * target);

      if (progress < 1) {
        rafId = requestAnimationFrame(step);
      } else {
        statEl.textContent = target;
      }
    }

    rafId = requestAnimationFrame(step);
  }
}


/* ══════════════════════════════════════════════════════════════
   16. FOCUS EFFECTS — input icon color sync
══════════════════════════════════════════════════════════════ */
function initFocusEffects() {
  const groups = document.querySelectorAll('.form-group');

  groups.forEach(group => {
    const input = group.querySelector('.form-input');
    const icon  = group.querySelector('.input-icon--left');
    if (!input || !icon) return;

    input.addEventListener('focus', () => {
      icon.style.color = 'var(--rk-primary-500)';
      icon.style.transform = 'scale(1.1)';
      icon.style.transition = 'all 0.2s ease';
    });

    input.addEventListener('blur', () => {
      icon.style.color = '';
      icon.style.transform = '';
    });
  });
}


/* ══════════════════════════════════════════════════════════════
   17. TYPING ANIMATION — hero headline accent word
══════════════════════════════════════════════════════════════ */
function initTypingAnimation() {
  const accent = document.querySelector('.panel-hero__accent');
  if (!accent) return;

  const words = ['RuangKita', 'Booking Mudah', 'Terorganisir', 'RuangKita'];
  let wordIndex = 0;
  let charIndex = 0;
  let isDeleting = false;
  let isPaused   = false;

  function type() {
    const currentWord = words[wordIndex];

    if (!isDeleting) {
      accent.textContent = currentWord.slice(0, charIndex + 1);
      charIndex++;

      if (charIndex === currentWord.length) {
        isPaused = true;
        setTimeout(() => {
          isPaused = false;
          isDeleting = true;
          type();
        }, 2400);
        return;
      }
    } else {
      accent.textContent = currentWord.slice(0, charIndex - 1);
      charIndex--;

      if (charIndex === 0) {
        isDeleting = false;
        wordIndex  = (wordIndex + 1) % words.length;
      }
    }

    const speed = isDeleting ? 60 : 90;
    setTimeout(type, speed);
  }

  // Start after AOS entrance
  setTimeout(type, 1200);
}


/* ══════════════════════════════════════════════════════════════
   18. SCROLL GRADIENT — subtle bg shift on mobile
══════════════════════════════════════════════════════════════ */
function initScrollGradient() {
  if (window.innerWidth > 768) return;

  const body = document.querySelector('.auth-body');
  if (!body) return;

  window.addEventListener('scroll', () => {
    const progress = Math.min(window.scrollY / 300, 1);
    const lightness = 96 + progress * 2;
    body.style.background = `hsl(220, 60%, ${lightness}%)`;
  }, { passive: true });
}


/* ══════════════════════════════════════════════════════════════
   19. PAGE TRANSITION — smooth exit on link clicks
══════════════════════════════════════════════════════════════ */
document.querySelectorAll('a[href]:not([target="_blank"])').forEach(link => {
  link.addEventListener('click', (e) => {
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript')) return;

    e.preventDefault();
    document.body.style.opacity    = '0';
    document.body.style.transform  = 'translateY(-8px)';
    document.body.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

    setTimeout(() => {
      window.location.href = href;
    }, 300);
  });
});


/* ══════════════════════════════════════════════════════════════
   20. KEYBOARD SHORTCUTS
══════════════════════════════════════════════════════════════ */
document.addEventListener('keydown', (e) => {
  // Alt + L → focus email
  if (e.altKey && e.key === 'l') {
    e.preventDefault();
    document.getElementById('email')?.focus();
  }
});


/* ══════════════════════════════════════════════════════════════
   21. NOTIFICATION CHIP — live pulse
══════════════════════════════════════════════════════════════ */
(function initNotifPulse() {
  const notif = document.querySelector('.ag-notification');
  if (!notif) return;

  let count = 1;
  const badge = document.createElement('span');
  badge.style.cssText = `
    margin-left: auto;
    background: #EF4444;
    color: white;
    border-radius: 99px;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 1px 6px;
    min-width: 18px;
    text-align: center;
  `;
  badge.textContent = count;
  notif.appendChild(badge);

  // Simulate new notifications occasionally
  setInterval(() => {
    count = Math.min(count + 1, 9);
    badge.textContent = count;
    badge.style.animation = 'none';
    void badge.offsetWidth;
    badge.style.animation = 'checkboxPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
  }, 8000);
})();


/* ══════════════════════════════════════════════════════════════
   22. WINDOW LOAD — final reveal
══════════════════════════════════════════════════════════════ */
window.addEventListener('load', () => {
  document.body.style.opacity = '0';
  document.body.style.transform = 'translateY(8px)';
  document.body.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      document.body.style.opacity   = '1';
      document.body.style.transform = 'translateY(0)';
    });
  });

  // Force AOS on all visible elements
  setTimeout(() => {
    document.querySelectorAll('[data-aos]').forEach(el => {
      el.classList.add('aos-animate');
    });
  }, 100);
});