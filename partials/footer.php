<?php
/**
 * Shared site footer: footer + WhatsApp float + contact form modal + scripts.
 * Relies on $home (set by header.php) for homepage-anchor links.
 */
$home = isset($home) ? $home : '/';
?>
<footer class="footer">
  <div class="footer-bg">
    <div class="footer-orb"></div>
  </div>
  <div class="container footer-inner">
    <div class="footer-top">
      <div class="footer-brand">
        <a href="<?= $home ?: '#' ?>" class="footer-logo">
          <img src="/assets/logo/delvora-logo.png" alt="Delvora Digital Studio" class="logo-img" width="51" height="36">
          <span class="logo-text">DELVORA</span>
        </a>
        <p class="footer-tagline">Building digital brands that drive real results across Pakistan.</p>
        <div class="footer-socials">
          <!-- TODO: real social/LinkedIn URL -->
          <a class="social-link" aria-label="WhatsApp">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413A11.824 11.824 0 0012.05 0z"/></svg>
          </a>
          <!-- TODO: real social/LinkedIn URL -->
          <a class="social-link" aria-label="Instagram">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
          </a>
          <!-- TODO: real social/LinkedIn URL -->
          <a class="social-link" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14m-.5 15.5v-5.3a3.26 3.26 0 00-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 011.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 001.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 00-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
          </a>
          <!-- TODO: real social/LinkedIn URL -->
          <a class="social-link" aria-label="Facebook">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
          </a>
        </div>
      </div>
      <div class="footer-links-group">
        <h4>Services</h4>
        <ul>
          <li><a href="/services/web-development.php">Web Development</a></li>
          <li><a href="/services/mobile-apps.php">Mobile Apps</a></li>
          <li><a href="/services/ui-ux-design.php">UI/UX Design</a></li>
          <li><a href="/services/ecommerce.php">E-Commerce</a></li>
          <li><a href="/services/digital-marketing.php">Digital Marketing</a></li>
          <li><a href="/services/brand-identity.php">Brand Identity</a></li>
        </ul>
      </div>
      <div class="footer-links-group">
        <h4>Company</h4>
        <ul>
          <li><a href="<?= $home ?>#about">About Us</a></li>
          <li><a href="<?= $home ?>#projects">Our Work</a></li>
          <li><a href="<?= $home ?>#process">How We Work</a></li>
          <li><a href="<?= $home ?>#team">Team</a></li>
          <li><a href="<?= $home ?>#testimonials">Testimonials</a></li>
          <li><a href="/blog/">Blog</a></li>
          <li><a href="<?= $home ?>#faq">FAQ</a></li>
          <li><a href="<?= $home ?>#contact">Contact</a></li>
        </ul>
      </div>
      <div class="footer-links-group">
        <h4>Contact</h4>
        <ul>
          <li><a href="mailto:hello@delvoradigital.com">hello@delvoradigital.com</a></li>
          <li><a href="https://wa.me/923001234567" target="_blank" rel="noopener">+92 300 123 4567</a></li>
          <li><span>Karachi, Pakistan</span></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; <?= date('Y') ?> Delvora Digital Studio. All rights reserved.</p>
      <div class="footer-bottom-links">
        <a href="/privacy.php">Privacy Policy</a>
        <a href="/terms.php">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>

<!-- WhatsApp Float Button -->
<a href="https://wa.me/923001234567" class="wa-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <div class="wa-pulse"></div>
  <svg viewBox="0 0 24 24" fill="currentColor">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
    <path d="M12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413A11.824 11.824 0 0012.05 0z"/>
  </svg>
  <span class="wa-label">Chat with us</span>
</a>

<!-- ===================== FORM MODAL ===================== -->
<div class="form-modal-overlay" id="formModalOverlay" role="dialog" aria-modal="true" aria-labelledby="formModalTitle">
  <div class="form-modal" id="formModal">
    <button class="modal-close" id="formModalClose" aria-label="Close">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>

    <!-- Left identity panel -->
    <div class="fml-panel">
      <div class="fml-icon" id="formModalIcon"></div>
      <div class="fml-text">
        <p class="fml-pre">Starting your</p>
        <h2 class="fml-title" id="formModalTitle"></h2>
        <p class="fml-post">project</p>
      </div>
      <div class="fml-divider"></div>
      <div class="fml-contacts">
        <a href="mailto:hello@delvoradigital.com" class="fml-contact">
          <span class="fml-contact-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </span>
          hello@delvoradigital.com
        </a>
        <a href="https://wa.me/923001234567" class="fml-contact" target="_blank" rel="noopener">
          <span class="fml-contact-icon">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413A11.824 11.824 0 0012.05 0z"/></svg>
          </span>
          +92 300 123 4567
        </a>
      </div>
    </div>

    <!-- Right form panel -->
    <div class="fml-form-panel">
      <form id="popupContactForm" action="/php/contact.php" method="POST">
        <div class="form-row">
          <div class="form-group">
            <label for="pp_name">Full Name *</label>
            <input type="text" id="pp_name" name="name" placeholder="Your full name" required>
          </div>
          <div class="form-group">
            <label for="pp_email">Email Address *</label>
            <input type="email" id="pp_email" name="email" placeholder="your@email.com" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="pp_phone">WhatsApp Number</label>
            <input type="tel" id="pp_phone" name="phone" placeholder="+92 300 000 0000">
          </div>
          <div class="form-group">
            <label for="pp_company">Company / Brand Name</label>
            <input type="text" id="pp_company" name="company" placeholder="Your company">
          </div>
        </div>
        <div class="form-group">
          <label>Services Needed</label>
          <div class="checkbox-grid">
            <label class="checkbox-label"><input type="checkbox" name="services[]" value="Web Development" id="pp_svc_web"><span>Web Development</span></label>
            <label class="checkbox-label"><input type="checkbox" name="services[]" value="Mobile App" id="pp_svc_mobile"><span>Mobile App</span></label>
            <label class="checkbox-label"><input type="checkbox" name="services[]" value="UI/UX Design" id="pp_svc_uiux"><span>UI/UX Design</span></label>
            <label class="checkbox-label"><input type="checkbox" name="services[]" value="E-Commerce" id="pp_svc_ecom"><span>E-Commerce</span></label>
            <label class="checkbox-label"><input type="checkbox" name="services[]" value="Digital Marketing" id="pp_svc_marketing"><span>Digital Marketing</span></label>
            <label class="checkbox-label"><input type="checkbox" name="services[]" value="Brand Identity" id="pp_svc_brand"><span>Brand Identity</span></label>
          </div>
        </div>
        <div class="form-group">
          <label>Project Budget</label>
          <div class="radio-grid">
            <label class="radio-label"><input type="radio" name="budget" value="Under 50K PKR"><span>Under 50K PKR</span></label>
            <label class="radio-label"><input type="radio" name="budget" value="50K–150K PKR"><span>50K–150K PKR</span></label>
            <label class="radio-label"><input type="radio" name="budget" value="150K–300K PKR"><span>150K–300K PKR</span></label>
            <label class="radio-label"><input type="radio" name="budget" value="300K+ PKR"><span>300K+ PKR</span></label>
          </div>
        </div>
        <div class="form-group">
          <label for="pp_message">Tell Us About Your Project *</label>
          <textarea id="pp_message" name="message" rows="3" placeholder="What are you looking to build? Share any details, deadlines, or ideas..." required></textarea>
        </div>

        <!-- Spam guards: humans never touch these -->
        <div class="hp-field" aria-hidden="true">
          <label>Leave this field empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        </div>
        <input type="hidden" name="form_ts" value="">

        <button type="submit" class="btn btn-primary btn-lg btn-full" id="ppSubmitBtn">
          <span class="pp-btn-text">Send Message →</span>
          <span class="pp-btn-loading" style="display:none">Sending...</span>
        </button>
        <div class="pp-success" id="ppSuccess" style="display:none">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 13.01 9 10.01"/></svg>
          <p>Sent! We'll be in touch within 24 hours.</p>
        </div>
        <div class="pp-error" id="ppError" style="display:none">
          <p>Something went wrong — please try again or WhatsApp us directly.</p>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts (deferred so they don't block parsing; order preserved) -->
<script defer src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script defer src="/js/main.js"></script>
</body>
</html>
