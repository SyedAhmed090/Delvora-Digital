/* =====================================================
   DELVORA DIGITAL STUDIO — Main JavaScript
   ===================================================== */

document.addEventListener('DOMContentLoaded', () => {

  // ---- GSAP SETUP ----
  if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
    gsap.registerPlugin(ScrollTrigger);
  }


  // ---- NAVBAR ----
  const navbar  = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');
  const mobileLinks = document.querySelectorAll('.mobile-link, .mobile-cta');

  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
  }, { passive: true });

  hamburger?.addEventListener('click', () => {
    hamburger.classList.toggle('open');
    mobileMenu.classList.toggle('open');
  });

  mobileLinks.forEach(link => {
    link.addEventListener('click', () => {
      hamburger.classList.remove('open');
      mobileMenu.classList.remove('open');
    });
  });

  // Close mobile menu on outside click
  document.addEventListener('click', e => {
    if (!navbar.contains(e.target)) {
      hamburger?.classList.remove('open');
      mobileMenu?.classList.remove('open');
    }
  });


  // ---- HERO ANIMATIONS ----
  const trigger = (el, delay = 0) => {
    if (!el) return;
    setTimeout(() => el.classList.add('visible'), delay);
  };

  trigger(document.getElementById('heroEyebrow'), 100);
  trigger(document.getElementById('hLine1'), 300);
  trigger(document.getElementById('hLine2'), 500);
  trigger(document.getElementById('hLine3'), 700);
  trigger(document.getElementById('heroSub'), 900);
  trigger(document.getElementById('heroActions'), 1050);
  trigger(document.getElementById('heroScroll'), 1400);


  // ---- SCROLL REVEAL (Intersection Observer) ----
  const revealEls = document.querySelectorAll('.reveal');

  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const siblings = [...el.parentElement.querySelectorAll('.reveal')];
        const idx = siblings.indexOf(el);
        setTimeout(() => el.classList.add('visible'), idx * 80);
        revealObserver.unobserve(el);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  revealEls.forEach(el => revealObserver.observe(el));


  // ---- COUNTING ANIMATION ----
  const counts = document.querySelectorAll('.count');

  const countObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const target = parseInt(el.dataset.target, 10);
      const duration = 1800;
      const step = Math.ceil(target / (duration / 16));
      let current = 0;

      const timer = setInterval(() => {
        current = Math.min(current + step, target);
        el.textContent = current;
        if (current >= target) clearInterval(timer);
      }, 16);

      countObserver.unobserve(el);
    });
  }, { threshold: 0.5 });

  counts.forEach(el => countObserver.observe(el));


  // ---- PROJECT CAROUSEL DRAG ----
  const carousel = document.getElementById('carousel');
  const track    = document.getElementById('carouselTrack');

  if (carousel && track) {
    let isDown = false;
    let startX, scrollLeft;

    carousel.addEventListener('mousedown', e => {
      isDown = true;
      carousel.classList.add('grabbing');
      startX = e.pageX - carousel.offsetLeft;
      scrollLeft = carousel.scrollLeft;
    });

    document.addEventListener('mouseup', () => {
      isDown = false;
      carousel?.classList.remove('grabbing');
    });

    carousel.addEventListener('mousemove', e => {
      if (!isDown) return;
      e.preventDefault();
      const x    = e.pageX - carousel.offsetLeft;
      const walk = (x - startX) * 1.5;
      carousel.scrollLeft = scrollLeft - walk;
    });

    // Touch support
    let touchStartX, touchScrollLeft;
    carousel.addEventListener('touchstart', e => {
      touchStartX = e.touches[0].pageX;
      touchScrollLeft = carousel.scrollLeft;
    }, { passive: true });

    carousel.addEventListener('touchmove', e => {
      const x = e.touches[0].pageX;
      const walk = (x - touchStartX) * 1.5;
      carousel.scrollLeft = touchScrollLeft - walk;
    }, { passive: true });
  }


  // ---- FAQ ACCORDION ----
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const btn = item.querySelector('.faq-q');
    const ans = item.querySelector('.faq-a');
    if (!btn || !ans) return;

    btn.addEventListener('click', () => {
      const isOpen = btn.getAttribute('aria-expanded') === 'true';

      // Close all
      faqItems.forEach(i => {
        i.querySelector('.faq-q')?.setAttribute('aria-expanded', 'false');
        i.querySelector('.faq-a')?.classList.remove('open');
      });

      // Open clicked if it was closed
      if (!isOpen) {
        btn.setAttribute('aria-expanded', 'true');
        ans.classList.add('open');
      }
    });
  });


  // ---- CONTACT FORM ----
  const form      = document.getElementById('contactForm');
  const submitBtn = document.getElementById('submitBtn');
  const btnText   = submitBtn?.querySelector('.btn-text');
  const btnLoad   = submitBtn?.querySelector('.btn-loading');
  const success   = document.getElementById('formSuccess');
  const error     = document.getElementById('formError');

  form?.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Show loading state
    if (btnText) btnText.style.display = 'none';
    if (btnLoad) btnLoad.style.display = 'inline';
    submitBtn.disabled = true;

    try {
      const formData = new FormData(form);
      const res = await fetch('php/contact.php', {
        method: 'POST',
        body: formData
      });

      const data = await res.json();

      if (data.success) {
        form.reset();
        if (success) success.style.display = 'flex';
        if (error)   error.style.display   = 'none';
      } else {
        if (error)   error.style.display   = 'flex';
        if (success) success.style.display = 'none';
      }
    } catch (err) {
      if (error)   error.style.display = 'flex';
      if (success) success.style.display = 'none';
    } finally {
      if (btnText) btnText.style.display = 'inline';
      if (btnLoad) btnLoad.style.display = 'none';
      submitBtn.disabled = false;
    }
  });


  // ---- SMOOTH ANCHOR SCROLL ----
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const id = a.getAttribute('href');
      if (id === '#') return;
      const target = document.querySelector(id);
      if (!target) return;
      e.preventDefault();
      const offset = target.getBoundingClientRect().top + window.scrollY - 80;
      window.scrollTo({ top: offset, behavior: 'smooth' });
    });
  });


  // ---- ACTIVE NAV LINK ON SCROLL ----
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-link');

  const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const id = entry.target.getAttribute('id');
        navLinks.forEach(link => {
          link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
        });
      }
    });
  }, { threshold: 0.4 });

  sections.forEach(s => sectionObserver.observe(s));

});
