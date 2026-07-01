<?php
/**
 * Shared service-page template. A service file (e.g. services/web-development.php)
 * defines the $svc array, then includes this file. This renders the full page
 * using the shared header/footer partials, plus Service + FAQ + Breadcrumb JSON-LD.
 *
 * Expected $svc keys:
 *   slug        string  URL slug (e.g. 'web-development')
 *   name        string  Service name for schema (e.g. 'Web Development')
 *   metaTitle   string  <title>
 *   metaDesc    string  meta description
 *   eyebrow     string  section tag above H1
 *   h1          string  hero headline (may contain a {highlight} you split yourself; plain text here)
 *   heroSub     string  hero sub-paragraph
 *   intro       string[] paragraphs for the intro column
 *   features    string[] "what's included" bullet items
 *   tech        string[] tech / tools tags
 *   process     array of ['n'=>'01','title'=>..,'desc'=>..]
 *   faqs        array of ['q'=>..,'a'=>..]
 */
$base = dirname(__DIR__);

$home      = '/';
$pageTitle = $svc['metaTitle'];
$pageDesc  = $svc['metaDesc'];
$canonical = 'https://delvoradigital.com/services/' . $svc['slug'] . '.php';
$e = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };

// ---- JSON-LD ----
$serviceLd = [
  '@context' => 'https://schema.org',
  '@type'    => 'Service',
  'serviceType' => $svc['name'],
  'name'     => $svc['metaTitle'],
  'description' => $svc['metaDesc'],
  'url'      => $canonical,
  'provider' => [
    '@type' => 'ProfessionalService',
    'name'  => 'Delvora Digital Studio',
    'url'   => 'https://delvoradigital.com/',
    'areaServed' => ['@type' => 'Country', 'name' => 'Pakistan'],
    'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Karachi', 'addressCountry' => 'PK'],
  ],
  'areaServed' => ['@type' => 'Country', 'name' => 'Pakistan'],
];
$breadcrumbLd = [
  '@context' => 'https://schema.org',
  '@type'    => 'BreadcrumbList',
  'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://delvoradigital.com/'],
    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Services', 'item' => 'https://delvoradigital.com/#services'],
    ['@type' => 'ListItem', 'position' => 3, 'name' => $svc['name'], 'item' => $canonical],
  ],
];
$faqLd = [
  '@context' => 'https://schema.org',
  '@type'    => 'FAQPage',
  'mainEntity' => array_map(function ($f) {
    return [
      '@type' => 'Question',
      'name'  => $f['q'],
      'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
    ];
  }, $svc['faqs']),
];
$json = function ($ld) {
  return json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
};
$extraHead = "  <script type=\"application/ld+json\">\n  " . $json($serviceLd) . "\n  </script>\n"
           . "  <script type=\"application/ld+json\">\n  " . $json($breadcrumbLd) . "\n  </script>\n"
           . "  <script type=\"application/ld+json\">\n  " . $json($faqLd) . "\n  </script>";

include $base . '/partials/header.php';
?>

<!-- ===================== SERVICE HERO ===================== -->
<section class="svc-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>/</span><a href="/#services">Services</a><span>/</span><?= $e($svc['name']) ?>
    </nav>
    <span class="section-tag"><?= $e($svc['eyebrow']) ?></span>
    <h1><?= $e($svc['h1']) ?></h1>
    <p class="svc-hero-sub"><?= $e($svc['heroSub']) ?></p>
    <div class="svc-hero-actions">
      <a href="#contact" class="btn btn-primary btn-lg" data-open-form>Get a Free Quote</a>
      <button type="button" class="btn btn-outline btn-lg" data-book-call>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Book a Call
      </button>
    </div>
  </div>
</section>

<!-- ===================== INTRO + TECH ===================== -->
<section class="section-pad">
  <div class="container">
    <div class="svc-split">
      <div class="svc-intro">
        <span class="section-tag">Overview</span>
        <h2 class="section-heading">What we <span class="gradient-text">deliver.</span></h2>
        <?php foreach ($svc['intro'] as $p): ?>
        <p><?= $e($p) ?></p>
        <?php endforeach; ?>
      </div>
      <div>
        <span class="section-tag">Tools &amp; Tech</span>
        <h2 class="section-heading" style="font-size:1.5rem">Built with the <span class="gradient-text">right stack.</span></h2>
        <div class="svc-tags">
          <?php foreach ($svc['tech'] as $t): ?><span><?= $e($t) ?></span><?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== WHAT'S INCLUDED ===================== -->
<section class="section-pad" style="background:var(--bg-2)">
  <div class="container">
    <span class="section-tag">What's Included</span>
    <h2 class="section-heading">Everything you get with <span class="gradient-text"><?= $e($svc['name']) ?>.</span></h2>
    <div class="feature-grid">
      <?php foreach ($svc['features'] as $f): ?>
      <div class="feature-item">
        <span class="feature-check">&#10003;</span>
        <p><?= $e($f) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== PROCESS ===================== -->
<section class="section-pad">
  <div class="container">
    <span class="section-tag">How We Work</span>
    <h2 class="section-heading">A clear, proven <span class="gradient-text">process.</span></h2>
    <div class="svc-process">
      <?php foreach ($svc['process'] as $step): ?>
      <div class="svc-step">
        <div class="step-n"><?= $e($step['n']) ?></div>
        <h3><?= $e($step['title']) ?></h3>
        <p><?= $e($step['desc']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== FAQ ===================== -->
<section class="section-pad" style="background:var(--bg-2)">
  <div class="container">
    <span class="section-tag">FAQ</span>
    <h2 class="section-heading">Questions, <span class="gradient-text">answered.</span></h2>
    <div class="svc-faq">
      <?php foreach ($svc['faqs'] as $f): ?>
      <div class="svc-faq-item">
        <h3><?= $e($f['q']) ?></h3>
        <p><?= $e($f['a']) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== CTA ===================== -->
<section class="cta-mid" id="contact">
  <div class="cta-mid-bg"><div class="cta-orb"></div></div>
  <div class="container cta-mid-inner">
    <span class="section-tag">Let's Talk</span>
    <h2 class="cta-mid-heading">Ready to start your <span class="gradient-text"><?= $e($svc['name']) ?> project?</span></h2>
    <p class="cta-mid-sub">Tell us what you're building. We'll reply within 24 hours with clear next steps and a no-pressure quote.</p>
    <div class="cta-mid-actions">
      <a href="#contact" class="btn btn-primary btn-lg" data-open-form>Get a Free Quote</a>
      <button type="button" class="btn btn-outline btn-lg" data-book-call>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Book a Call
      </button>
    </div>
  </div>
</section>

<?php include $base . '/partials/footer.php'; ?>
