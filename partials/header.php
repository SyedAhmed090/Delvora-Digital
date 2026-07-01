<?php
/**
 * Shared site header: <head> + top-of-body chrome + navbar.
 *
 * Set any of these before including this file to override the defaults:
 *   $pageTitle   — <title> + og:title/twitter:title
 *   $pageDesc    — meta description + og/twitter description
 *   $canonical   — absolute canonical URL (also used for og:url)
 *   $ogImage     — absolute OG image URL
 *   $ogType      — Open Graph type (default "website")
 *   $robots      — robots meta (default index/follow; legal pages pass "noindex, follow")
 *   $extraHead   — raw HTML injected right before </head> (page-specific JSON-LD etc.)
 *   $home        — anchor prefix for homepage sections: '' on the homepage,
 *                  '/' on every sub-page (so "#services" -> "/#services").
 *
 * All asset/page paths are root-relative ("/css/...") so they resolve the same
 * from the homepage and from /services/* and /blog/*.
 */
$pageTitle = $pageTitle ?? 'Delvora Digital Studio — Web, App & Brand Studio in Pakistan';
$pageDesc  = $pageDesc  ?? 'Delvora Digital Studio is a Pakistan-based digital agency building high-performance websites, mobile apps, UI/UX design, e-commerce and brand identities that drive real results.';
$canonical = $canonical ?? 'https://delvoradigital.com/';
// Interim OG image: reusing the existing logo PNG so social shares render
// something branded. TODO: replace with a proper 1200x630 branded og-image.jpg.
$ogImage   = $ogImage   ?? 'https://delvoradigital.com/assets/logo/delvora-logo.png';
$ogType    = $ogType    ?? 'website';
$robots    = $robots    ?? 'index, follow, max-image-preview:large, max-snippet:-1';
$extraHead = $extraHead ?? '';
$home      = isset($home) ? $home : '/';
$e = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $e($pageTitle) ?></title>
  <meta name="description" content="<?= $e($pageDesc) ?>">
  <meta name="author" content="Delvora Digital Studio">
  <meta name="robots" content="<?= $e($robots) ?>">
  <meta name="theme-color" content="#080808">
  <link rel="canonical" href="<?= $e($canonical) ?>">

  <!-- Open Graph / Social sharing -->
  <!-- NOTE: og:image/twitter:image currently point to the logo PNG as an interim
       branded image. TODO: swap in a proper 1200x630 og-image.jpg. -->
  <meta property="og:type" content="<?= $e($ogType) ?>">
  <meta property="og:url" content="<?= $e($canonical) ?>">
  <meta property="og:site_name" content="Delvora Digital Studio">
  <meta property="og:locale" content="en_PK">
  <meta property="og:title" content="<?= $e($pageTitle) ?>">
  <meta property="og:description" content="<?= $e($pageDesc) ?>">
  <meta property="og:image" content="<?= $e($ogImage) ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:image:alt" content="Delvora Digital Studio — We Build Digital Excellence">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= $e($pageTitle) ?>">
  <meta name="twitter:description" content="<?= $e($pageDesc) ?>">
  <meta name="twitter:image" content="<?= $e($ogImage) ?>">

  <link rel="icon" type="image/svg+xml" href="/assets/logo/delvora-mark.svg">
  <link rel="icon" type="image/png" href="/assets/logo/delvora-logo.png">
  <link rel="apple-touch-icon" href="/assets/logo/delvora-logo.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">

  <!-- Google Analytics 4 — paste your Measurement ID into DELVORA_GA_ID below. -->
  <!-- Until a real ID is set, nothing loads (no tracking, no junk requests). -->
  <script>
    window.DELVORA_GA_ID = 'G-XXXXXXXXXX'; // <-- replace with your GA4 ID
    (function () {
      var id = window.DELVORA_GA_ID;
      if (!id || id.indexOf('XXXX') !== -1) return; // not configured yet
      var s = document.createElement('script');
      s.async = true;
      s.src = 'https://www.googletagmanager.com/gtag/js?id=' + id;
      document.head.appendChild(s);
      window.dataLayer = window.dataLayer || [];
      window.gtag = function () { dataLayer.push(arguments); };
      gtag('js', new Date());
      gtag('config', id);
    })();
  </script>

  <!-- Calendly scheduling link — paste your URL below. Until set, "Book a Call" -->
  <!-- buttons fall back to opening the contact form. -->
  <script>
    window.DELVORA_CALENDLY_URL = 'https://calendly.com/your-handle/intro-call'; // <-- replace
  </script>

  <!-- Structured data: Organization / Local business -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ProfessionalService",
    "name": "Delvora Digital Studio",
    "image": "https://delvoradigital.com/assets/logo/delvora-logo.png",
    "logo": "https://delvoradigital.com/assets/logo/delvora-logo.png",
    "url": "https://delvoradigital.com/",
    "email": "hello@delvoradigital.com",
    "telephone": "+92-300-123-4567",
    "description": "Pakistan-based digital agency building high-performance websites, mobile apps, UI/UX design, e-commerce and brand identities.",
    "priceRange": "$$",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Karachi",
      "addressCountry": "PK"
    },
    "areaServed": { "@type": "Country", "name": "Pakistan" },
    "knowsAbout": ["Web Development", "Mobile App Development", "UI/UX Design", "E-Commerce", "Digital Marketing", "Brand Identity"]
  }
  </script>
<?= $extraHead ?>
</head>
<body>

<!-- Reusable Delvora mark (symbol + gradient) for inline <use> references -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
  <defs>
    <linearGradient id="delvoraGrad" x1="0" y1="0" x2="0" y2="1">
      <stop offset="0" stop-color="#F8A0C0"/>
      <stop offset="0.55" stop-color="#E8497A"/>
      <stop offset="1" stop-color="#B81E5B"/>
    </linearGradient>
    <symbol id="delvoraMark" viewBox="0 0 100 100">
      <g fill="none" stroke-linecap="butt">
        <path stroke-width="13" d="M52.65 12.09 A38 38 0 0 1 87.91 47.35"/>
        <path stroke-width="13" d="M87.91 52.65 A38 38 0 0 1 52.65 87.91"/>
        <path stroke-width="13" d="M47.35 87.91 A38 38 0 0 1 12.09 52.65"/>
        <path stroke-width="13" d="M12.09 47.35 A38 38 0 0 1 47.35 12.09"/>
        <path stroke-width="9" d="M52.51 26.13 A24 24 0 0 1 52.51 73.87"/>
        <path stroke-width="9" d="M47.49 73.87 A24 24 0 0 1 47.49 26.13"/>
      </g>
    </symbol>
  </defs>
</svg>

<!-- Custom Cursor -->
<div class="cursor-dot" id="cursorDot"></div>
<div class="cursor-ring" id="cursorRing"></div>

<!-- Scroll Progress Bar -->
<div class="scroll-progress" id="scrollProgress"></div>

<!-- ===================== NAVBAR ===================== -->
<nav class="navbar" id="navbar">
  <div class="container nav-inner">
    <a href="<?= $home ?: '#' ?>" class="nav-logo">
      <img src="/assets/logo/delvora-logo.png" alt="Delvora Digital Studio" class="logo-img" width="51" height="36">
      <span class="logo-text">DELVORA</span>
    </a>
    <ul class="nav-links" id="navLinks">
      <li><a href="<?= $home ?>#projects" class="nav-link">Projects</a></li>
      <li><a href="<?= $home ?>#services" class="nav-link">Services</a></li>
      <li><a href="<?= $home ?>#process" class="nav-link">How We Work</a></li>
      <li><a href="<?= $home ?>#audit" class="nav-link">Free Audit</a></li>
      <li><a href="<?= $home ?>#contact" class="nav-link">Contact</a></li>
    </ul>
    <a href="<?= $home ?>#contact" class="btn btn-primary nav-cta" data-open-form>Get a Quote</a>
    <button class="hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobileMenu">
      <span></span><span></span><span></span>
    </button>
  </div>
  <!-- Mobile Menu -->
  <div class="mobile-menu" id="mobileMenu">
    <ul>
      <li><a href="<?= $home ?>#projects" class="mobile-link">Projects</a></li>
      <li><a href="<?= $home ?>#services" class="mobile-link">Services</a></li>
      <li><a href="<?= $home ?>#process" class="mobile-link">How We Work</a></li>
      <li><a href="<?= $home ?>#audit" class="mobile-link">Free Audit</a></li>
      <li><a href="<?= $home ?>#contact" class="mobile-link">Contact</a></li>
    </ul>
    <a href="<?= $home ?>#contact" class="btn btn-primary mobile-cta" data-open-form>Get a Quote</a>
  </div>
</nav>
