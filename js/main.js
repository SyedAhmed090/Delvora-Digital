/* =====================================================
   DELVORA DIGITAL STUDIO — Enhanced Animations
   ===================================================== */

document.addEventListener('DOMContentLoaded', () => {

  const isMobile = window.matchMedia('(max-width: 768px)').matches;
  const isTouch  = window.matchMedia('(hover: none)').matches;


  /* =====================================================
     1. LENIS SMOOTH SCROLL
     ===================================================== */
  let lenis;
  if (typeof Lenis !== 'undefined') {
    lenis = new Lenis({
      duration: 1.25,
      easing: t => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smooth: true,
      smoothTouch: false,
    });

    if (typeof ScrollTrigger !== 'undefined') {
      lenis.on('scroll', ScrollTrigger.update);
      gsap.ticker.add(time => lenis.raf(time * 1000));
      gsap.ticker.lagSmoothing(0);
    } else {
      function rafLoop(time) { lenis.raf(time); requestAnimationFrame(rafLoop); }
      requestAnimationFrame(rafLoop);
    }
  }


  /* =====================================================
     2. GSAP + SCROLLTRIGGER SETUP
     ===================================================== */
  if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
    gsap.registerPlugin(ScrollTrigger);
  }


  /* =====================================================
     3. CUSTOM CURSOR
     ===================================================== */
  if (!isTouch) {
    const dot  = document.getElementById('cursorDot');
    const ring = document.getElementById('cursorRing');

    let mouseX = 0, mouseY = 0;

    window.addEventListener('mousemove', e => {
      mouseX = e.clientX;
      mouseY = e.clientY;
      gsap.to(dot,  { x: mouseX, y: mouseY, duration: 0.08, ease: 'none' });
      gsap.to(ring, { x: mouseX, y: mouseY, duration: 0.28, ease: 'power2.out' });
    });

    document.querySelectorAll('a, button, .service-card, .project-card, .faq-q, .team-card').forEach(el => {
      el.addEventListener('mouseenter', () => {
        dot?.classList.add('hovering');
        ring?.classList.add('hovering');
      });
      el.addEventListener('mouseleave', () => {
        dot?.classList.remove('hovering');
        ring?.classList.remove('hovering');
      });
    });

    document.addEventListener('mouseleave', () => {
      dot?.classList.add('hidden');
      ring?.classList.add('hidden');
    });
    document.addEventListener('mouseenter', () => {
      dot?.classList.remove('hidden');
      ring?.classList.remove('hidden');
    });
  }


  /* =====================================================
     4. SCROLL PROGRESS BAR
     ===================================================== */
  const progressBar = document.getElementById('scrollProgress');
  window.addEventListener('scroll', () => {
    const scrolled = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight);
    if (progressBar) progressBar.style.transform = `scaleX(${scrolled})`;
  }, { passive: true });


  /* =====================================================
     5. NAVBAR
     ===================================================== */
  const navbar    = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');

  window.addEventListener('scroll', () => {
    navbar?.classList.toggle('scrolled', window.scrollY > 50);
  }, { passive: true });

  hamburger?.addEventListener('click', () => {
    hamburger.classList.toggle('open');
    mobileMenu?.classList.toggle('open');
  });

  document.querySelectorAll('.mobile-link, .mobile-cta').forEach(link => {
    link.addEventListener('click', () => {
      hamburger?.classList.remove('open');
      mobileMenu?.classList.remove('open');
    });
  });

  document.addEventListener('click', e => {
    if (!navbar?.contains(e.target)) {
      hamburger?.classList.remove('open');
      mobileMenu?.classList.remove('open');
    }
  });


  /* =====================================================
     6. SMOOTH ANCHOR SCROLL (via Lenis)
     ===================================================== */
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const id = a.getAttribute('href');
      if (id === '#') return;
      const target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      if (lenis) {
        lenis.scrollTo(target, { offset: -80, duration: 1.4 });
      } else {
        const top = target.getBoundingClientRect().top + window.scrollY - 80;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });


  /* =====================================================
     7. HERO CANVAS — PARTICLE CONSTELLATION
     ===================================================== */
  (function initHeroCanvas() {
    const canvas  = document.getElementById('heroCanvas');
    const heroEl  = document.getElementById('home');
    const glowEl  = document.getElementById('heroCursorGlow');
    if (!canvas || !heroEl) return;

    const ctx = canvas.getContext('2d');
    const dpr = window.devicePixelRatio || 1;

    function resize() {
      const w = heroEl.offsetWidth;
      const h = heroEl.offsetHeight;
      canvas.width  = w * dpr;
      canvas.height = h * dpr;
      canvas.style.width  = w + 'px';
      canvas.style.height = h + 'px';
      ctx.scale(dpr, dpr);
      W = w; H = h;
    }

    let W, H;
    resize();
    window.addEventListener('resize', resize, { passive: true });

    // --- Particle ---
    const COUNT = window.innerWidth < 768 ? 38 : 72;
    const CONN  = 140;   // max distance for particle–particle lines
    const MDIST = 210;   // max distance for cursor–particle interaction

    class Dot {
      constructor() { this.spawn(); }
      spawn() {
        this.x  = Math.random() * W;
        this.y  = Math.random() * H;
        this.r  = Math.random() * 1.6 + 0.5;
        this.base = Math.random() * 0.35 + 0.12;
        this.o  = this.base;
        this.vx = (Math.random() - 0.5) * 0.38;
        this.vy = (Math.random() - 0.5) * 0.38;
      }
      update(mx, my) {
        this.x += this.vx;
        this.y += this.vy;
        if (this.x < 0)  { this.x = 0;  this.vx *= -1; }
        if (this.x > W)  { this.x = W;  this.vx *= -1; }
        if (this.y < 0)  { this.y = 0;  this.vy *= -1; }
        if (this.y > H)  { this.y = H;  this.vy *= -1; }

        const dx = mx - this.x, dy = my - this.y;
        const d  = Math.sqrt(dx * dx + dy * dy);
        if (d < MDIST) {
          const f = (MDIST - d) / MDIST;
          this.x += dx * f * 0.028;
          this.y += dy * f * 0.028;
          this.o  = Math.min(0.95, this.base + f * 0.55);
        } else {
          this.o += (this.base - this.o) * 0.06;
        }
      }
      draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(232,73,122,${this.o})`;
        ctx.fill();
      }
    }

    const dots = Array.from({ length: COUNT }, () => new Dot());

    // Mouse position — off-screen by default
    let mx = -9999, my = -9999;
    let glowX = W / 2, glowY = H / 2, tGlowX = W / 2, tGlowY = H / 2;
    let mouseInHero = false;

    heroEl.addEventListener('mousemove', e => {
      const r = heroEl.getBoundingClientRect();
      mx = e.clientX - r.left;
      my = e.clientY - r.top;
      tGlowX = e.clientX - r.left;
      tGlowY = e.clientY - r.top;
      mouseInHero = true;
      glowEl?.classList.add('active');
    }, { passive: true });

    heroEl.addEventListener('mouseleave', () => {
      mx = -9999; my = -9999;
      mouseInHero = false;
      glowEl?.classList.remove('active');
    });

    function drawLines() {
      for (let i = 0; i < dots.length; i++) {
        const a = dots[i];

        // Dot ↔ dot
        for (let j = i + 1; j < dots.length; j++) {
          const b  = dots[j];
          const dx = a.x - b.x, dy = a.y - b.y;
          const d  = Math.sqrt(dx * dx + dy * dy);
          if (d < CONN) {
            ctx.beginPath();
            ctx.strokeStyle = `rgba(232,73,122,${(1 - d / CONN) * 0.16})`;
            ctx.lineWidth = 0.55;
            ctx.moveTo(a.x, a.y);
            ctx.lineTo(b.x, b.y);
            ctx.stroke();
          }
        }

        // Cursor ↔ dot
        if (mouseInHero) {
          const dx = mx - a.x, dy = my - a.y;
          const d  = Math.sqrt(dx * dx + dy * dy);
          if (d < MDIST) {
            ctx.beginPath();
            ctx.strokeStyle = `rgba(232,73,122,${(1 - d / MDIST) * 0.6})`;
            ctx.lineWidth = 0.9;
            ctx.moveTo(mx, my);
            ctx.lineTo(a.x, a.y);
            ctx.stroke();
          }
        }
      }

      // Draw cursor dot on canvas
      if (mouseInHero) {
        ctx.beginPath();
        ctx.arc(mx, my, 3, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(232,73,122,0.8)';
        ctx.fill();
        // Outer ring
        ctx.beginPath();
        ctx.arc(mx, my, 12, 0, Math.PI * 2);
        ctx.strokeStyle = 'rgba(232,73,122,0.2)';
        ctx.lineWidth = 1;
        ctx.stroke();
      }
    }

    let rafId;
    function animate() {
      ctx.clearRect(0, 0, W, H);
      dots.forEach(d => { d.update(mx, my); d.draw(); });
      drawLines();

      // Lazy glow follow
      glowX += (tGlowX - glowX) * 0.07;
      glowY += (tGlowY - glowY) * 0.07;
      if (glowEl) {
        glowEl.style.left = glowX + 'px';
        glowEl.style.top  = glowY + 'px';
      }

      rafId = requestAnimationFrame(animate);
    }

    animate();
    setTimeout(() => canvas.classList.add('ready'), 400);

    // Pause when hero is off-screen (performance)
    const pauseObserver = new IntersectionObserver(([e]) => {
      if (e.isIntersecting) {
        if (!rafId) animate();
      } else {
        cancelAnimationFrame(rafId);
        rafId = null;
      }
    }, { threshold: 0 });
    pauseObserver.observe(heroEl);
  })();


  /* =====================================================
     8. HERO TEXT ANIMATIONS (mask reveal on load)
     ===================================================== */
  const heroEyebrow = document.getElementById('heroEyebrow');
  const heroSub     = document.getElementById('heroSub');
  const heroActions = document.getElementById('heroActions');
  const heroScroll  = document.getElementById('heroScroll');

  // Eyebrow fades in
  setTimeout(() => heroEyebrow?.classList.add('visible'), 100);

  // Headline lines — mask reveal with stagger
  const hLines = ['hLine1', 'hLine2', 'hLine3'];
  hLines.forEach((id, i) => {
    setTimeout(() => document.getElementById(id)?.classList.add('visible'), 350 + i * 180);
  });

  // Sub and buttons fade in
  setTimeout(() => heroSub?.classList.add('visible'), 1000);
  setTimeout(() => heroActions?.classList.add('visible'), 1150);
  setTimeout(() => heroScroll?.classList.add('visible'), 1400);

  // ---- Hero orb parallax on scroll ----
  if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
    gsap.to('.orb-1', {
      yPercent: -40,
      xPercent: -10,
      ease: 'none',
      scrollTrigger: {
        trigger: '.hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 1.5,
      }
    });
    gsap.to('.orb-2', {
      yPercent: -25,
      xPercent: 10,
      ease: 'none',
      scrollTrigger: {
        trigger: '.hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 2,
      }
    });
    gsap.to('.orb-3', {
      yPercent: -60,
      ease: 'none',
      scrollTrigger: {
        trigger: '.hero',
        start: 'top top',
        end: 'bottom top',
        scrub: 1,
      }
    });

    // Hero content slow upward drift as you scroll
    gsap.to('.hero-content', {
      yPercent: 18,
      ease: 'none',
      scrollTrigger: {
        trigger: '.hero',
        start: 'top top',
        end: 'bottom top',
        scrub: true,
      }
    });
  }


  /* =====================================================
     8. SECTION HEADING WORD SPLIT + ANIMATE
     ===================================================== */
  function splitWords(el) {
    if (!el || el.dataset.split) return;
    el.dataset.split = true;
    const words = el.textContent.trim().split(/\s+/);
    el.innerHTML = words
      .map(w => `<span class="word-wrap"><span class="word-inner">${w}</span></span>`)
      .join(' ');
  }

  const headings = document.querySelectorAll('.section-heading');

  if (typeof IntersectionObserver !== 'undefined') {
    const headingObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        splitWords(el);
        const words = el.querySelectorAll('.word-inner');
        words.forEach((w, i) => {
          setTimeout(() => w.classList.add('visible'), i * 60);
        });
        headingObserver.unobserve(el);
      });
    }, { threshold: 0.2 });

    headings.forEach(h => headingObserver.observe(h));
  }


  /* =====================================================
     9. SCROLL REVEAL (staggered, varied delays)
     ===================================================== */
  const revealEls = document.querySelectorAll('.reveal');

  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const siblings = [...(el.parentElement?.querySelectorAll('.reveal') || [])];
      const idx = siblings.indexOf(el);
      setTimeout(() => el.classList.add('visible'), Math.min(idx * 90, 400));
      revealObserver.unobserve(el);
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });

  revealEls.forEach(el => revealObserver.observe(el));


  /* =====================================================
     10. NUMBER COUNTER (GSAP)
     ===================================================== */
  const counts = document.querySelectorAll('.count');

  const countObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const target = parseInt(el.dataset.target, 10);

      if (typeof gsap !== 'undefined') {
        gsap.fromTo(el, { innerText: 0 }, {
          innerText: target,
          duration: 2,
          ease: 'power2.out',
          snap: { innerText: 1 },
          onUpdate() { el.textContent = Math.round(parseFloat(el.innerText)); }
        });
      } else {
        let current = 0;
        const step = Math.ceil(target / 100);
        const t = setInterval(() => {
          current = Math.min(current + step, target);
          el.textContent = current;
          if (current >= target) clearInterval(t);
        }, 18);
      }
      countObserver.unobserve(el);
    });
  }, { threshold: 0.5 });

  counts.forEach(el => countObserver.observe(el));


  /* =====================================================
     11. 3D TILT EFFECT (service cards, project cards, why cards)
     ===================================================== */
  if (!isTouch) {
    function addTilt(selector, strength = 8) {
      document.querySelectorAll(selector).forEach(card => {
        card.addEventListener('mousemove', e => {
          const rect  = card.getBoundingClientRect();
          const x     = e.clientX - rect.left;
          const y     = e.clientY - rect.top;
          const cx    = rect.width  / 2;
          const cy    = rect.height / 2;
          const rotX  = ((y - cy) / cy) * -strength;
          const rotY  = ((x - cx) / cx) *  strength;

          if (typeof gsap !== 'undefined') {
            gsap.to(card, {
              rotateX: rotX,
              rotateY: rotY,
              transformPerspective: 900,
              duration: 0.35,
              ease: 'power2.out',
            });
          }
        });

        card.addEventListener('mouseleave', () => {
          if (typeof gsap !== 'undefined') {
            gsap.to(card, {
              rotateX: 0,
              rotateY: 0,
              duration: 0.6,
              ease: 'elastic.out(1, 0.4)',
            });
          }
        });
      });
    }

    addTilt('.service-card', 6);
    addTilt('.project-card', 5);
    addTilt('.why-card', 7);
    addTilt('.team-card', 8);
  }


  /* =====================================================
     12. CARD SPOTLIGHT (cursor-tracked gradient)
     ===================================================== */
  if (!isTouch) {
    document.querySelectorAll('.service-card, .why-card').forEach(card => {
      card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width)  * 100;
        const y = ((e.clientY - rect.top)  / rect.height) * 100;
        card.style.setProperty('--mouse-x', `${x}%`);
        card.style.setProperty('--mouse-y', `${y}%`);
      });
    });
  }


  /* =====================================================
     13. MAGNETIC BUTTONS
     ===================================================== */
  if (!isTouch && typeof gsap !== 'undefined') {
    document.querySelectorAll('.btn-primary, .btn-outline').forEach(btn => {
      btn.addEventListener('mousemove', e => {
        const rect = btn.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width  / 2;
        const y = e.clientY - rect.top  - rect.height / 2;
        gsap.to(btn, { x: x * 0.28, y: y * 0.28, duration: 0.3, ease: 'power2.out' });
      });

      btn.addEventListener('mouseleave', () => {
        gsap.to(btn, { x: 0, y: 0, duration: 0.6, ease: 'elastic.out(1, 0.4)' });
      });
    });
  }


  /* =====================================================
     14. PROJECT CAROUSEL DRAG
     ===================================================== */
  const carousel = document.getElementById('carousel');

  if (carousel) {
    let isDown = false, startX = 0, scrollLeft = 0;
    let velocity = 0, lastX = 0, animId;

    carousel.addEventListener('mousedown', e => {
      isDown = true;
      carousel.classList.add('grabbing');
      startX = e.pageX - carousel.offsetLeft;
      scrollLeft = carousel.scrollLeft;
      lastX = e.pageX;
      cancelAnimationFrame(animId);
    });

    document.addEventListener('mouseup', () => {
      if (!isDown) return;
      isDown = false;
      carousel.classList.remove('grabbing');
      // momentum scroll
      const momentum = () => {
        velocity *= 0.92;
        carousel.scrollLeft -= velocity;
        if (Math.abs(velocity) > 0.5) animId = requestAnimationFrame(momentum);
      };
      animId = requestAnimationFrame(momentum);
    });

    document.addEventListener('mousemove', e => {
      if (!isDown) return;
      e.preventDefault();
      const x    = e.pageX - carousel.offsetLeft;
      const walk = (x - startX) * 1.4;
      velocity = e.pageX - lastX;
      lastX = e.pageX;
      carousel.scrollLeft = scrollLeft - walk;
    });

    // Touch
    let tStartX = 0, tScrollLeft = 0;
    carousel.addEventListener('touchstart', e => {
      tStartX = e.touches[0].pageX;
      tScrollLeft = carousel.scrollLeft;
    }, { passive: true });
    carousel.addEventListener('touchmove', e => {
      const walk = (e.touches[0].pageX - tStartX) * 1.4;
      carousel.scrollLeft = tScrollLeft - walk;
    }, { passive: true });
  }


  /* =====================================================
     15. FAQ ACCORDION
     ===================================================== */
  document.querySelectorAll('.faq-item').forEach(item => {
    const btn = item.querySelector('.faq-q');
    const ans = item.querySelector('.faq-a');
    if (!btn || !ans) return;

    btn.addEventListener('click', () => {
      const open = btn.getAttribute('aria-expanded') === 'true';

      document.querySelectorAll('.faq-item').forEach(i => {
        i.querySelector('.faq-q')?.setAttribute('aria-expanded', 'false');
        i.querySelector('.faq-a')?.classList.remove('open');
      });

      if (!open) {
        btn.setAttribute('aria-expanded', 'true');
        ans.classList.add('open');
      }
    });
  });


  /* =====================================================
     16. GSAP PARALLAX ON SECTION BACKGROUNDS
     ===================================================== */
  if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined' && !isMobile) {
    // Mid-page CTA orb parallax
    gsap.to('.cta-orb', {
      yPercent: -30,
      ease: 'none',
      scrollTrigger: {
        trigger: '.cta-mid',
        start: 'top bottom',
        end: 'bottom top',
        scrub: 2,
      }
    });

    // Footer orb parallax
    gsap.to('.footer-orb', {
      yPercent: 30,
      ease: 'none',
      scrollTrigger: {
        trigger: '.footer',
        start: 'top bottom',
        end: 'bottom top',
        scrub: 2,
      }
    });

    // Stats block pop in
    gsap.from('.stat-card', {
      scale: 0.92,
      opacity: 0,
      duration: 0.7,
      stagger: 0.12,
      ease: 'back.out(1.5)',
      scrollTrigger: {
        trigger: '.stats-block',
        start: 'top 80%',
      }
    });

    // Service cards pop in with stagger
    gsap.from('.service-card', {
      y: 40,
      opacity: 0,
      duration: 0.65,
      stagger: 0.08,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: '.services-grid',
        start: 'top 85%',
      }
    });

    // Process steps slide in alternating sides
    gsap.utils.toArray('.process-step').forEach((step, i) => {
      gsap.from(step, {
        x: i % 2 === 0 ? -50 : 50,
        opacity: 0,
        duration: 0.7,
        ease: 'power3.out',
        scrollTrigger: {
          trigger: step,
          start: 'top 88%',
        }
      });
    });

    // Why cards bounce in
    gsap.from('.why-card', {
      scale: 0.88,
      opacity: 0,
      duration: 0.6,
      stagger: 0.1,
      ease: 'back.out(1.8)',
      scrollTrigger: {
        trigger: '.why-grid',
        start: 'top 85%',
      }
    });

    // Team cards stagger up
    gsap.from('.team-card', {
      y: 50,
      opacity: 0,
      duration: 0.6,
      stagger: 0.1,
      ease: 'power3.out',
      scrollTrigger: {
        trigger: '.team-grid',
        start: 'top 85%',
      }
    });
  }


  /* =====================================================
     17. CONTACT FORM
     ===================================================== */
  const form      = document.getElementById('contactForm');
  const submitBtn = document.getElementById('submitBtn');
  const btnText   = submitBtn?.querySelector('.btn-text');
  const btnLoad   = submitBtn?.querySelector('.btn-loading');
  const success   = document.getElementById('formSuccess');
  const error     = document.getElementById('formError');

  form?.addEventListener('submit', async e => {
    e.preventDefault();

    if (btnText) btnText.style.display = 'none';
    if (btnLoad) btnLoad.style.display = 'inline';
    if (submitBtn) submitBtn.disabled = true;
    if (success) success.style.display = 'none';
    if (error)   error.style.display   = 'none';

    try {
      const res  = await fetch('php/contact.php', { method: 'POST', body: new FormData(form) });
      const data = await res.json();

      if (data.success) {
        form.reset();
        if (success) success.style.display = 'flex';
      } else {
        if (error) error.style.display = 'flex';
      }
    } catch {
      if (error) error.style.display = 'flex';
    } finally {
      if (btnText) btnText.style.display = 'inline';
      if (btnLoad) btnLoad.style.display = 'none';
      if (submitBtn) submitBtn.disabled  = false;
    }
  });


  /* =====================================================
     18. ACTIVE NAV LINK ON SCROLL
     ===================================================== */
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-link');

  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const id = entry.target.getAttribute('id');
      navLinks.forEach(link => {
        link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
      });
    });
  }, { threshold: 0.4, rootMargin: '-10% 0px -50% 0px' });

  sections.forEach(s => sectionObserver.observe(s));

});
