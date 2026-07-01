<?php
/**
 * Blog index. Add new posts by dropping a file in /blog/ and adding one entry
 * to $posts below (newest first). Each post file is a standalone .php page.
 */
$home      = '/';
$pageTitle = 'Blog — Web, App & Marketing Insights | Delvora Digital Studio';
$pageDesc  = 'Practical guides on web development, mobile apps, design, e-commerce and digital marketing for businesses in Karachi and across Pakistan, from the Delvora Digital team.';
$canonical = 'https://delvoradigital.com/blog/';

$posts = [
  [
    'slug'    => 'how-to-choose-web-development-company-karachi',
    'title'   => 'How to Choose a Web Development Company in Karachi (2026 Guide)',
    'excerpt' => 'Hiring the right web development partner can make or break your project. Here are the questions to ask, the red flags to avoid, and how to compare quotes fairly.',
    'tag'     => 'Web Development',
    'date'    => '2026-07-01',
    'dateHuman' => 'July 1, 2026',
    'read'    => '7 min read',
  ],
];

$e = function ($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };

// Blog listing schema
$blogLd = [
  '@context' => 'https://schema.org',
  '@type'    => 'Blog',
  'name'     => 'Delvora Digital Studio Blog',
  'url'      => $canonical,
  'publisher'=> ['@type' => 'Organization', 'name' => 'Delvora Digital Studio', 'url' => 'https://delvoradigital.com/'],
  'blogPost' => array_map(function ($p) {
    return [
      '@type'         => 'BlogPosting',
      'headline'      => $p['title'],
      'url'           => 'https://delvoradigital.com/blog/' . $p['slug'] . '.php',
      'datePublished' => $p['date'],
      'description'   => $p['excerpt'],
    ];
  }, $posts),
];
$extraHead = "  <script type=\"application/ld+json\">\n  "
  . json_encode($blogLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
  . "\n  </script>";

include __DIR__ . '/../partials/header.php';
?>

<!-- ===================== BLOG HERO ===================== -->
<section class="svc-hero">
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="/">Home</a><span>/</span>Blog
    </nav>
    <span class="section-tag">The Delvora Blog</span>
    <h1>Ideas that help your <span class="gradient-text">brand grow.</span></h1>
    <p class="svc-hero-sub">Practical, no-fluff guides on web development, apps, design, e-commerce and marketing — written for business owners in Karachi and across Pakistan.</p>
  </div>
</section>

<!-- ===================== POSTS ===================== -->
<section class="section-pad">
  <div class="container">
    <div class="blog-grid">
      <?php foreach ($posts as $p): ?>
      <a class="blog-card" href="/blog/<?= $e($p['slug']) ?>.php">
        <div class="blog-card-media">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
        </div>
        <div class="blog-card-body">
          <span class="blog-tag"><?= $e($p['tag']) ?></span>
          <h3><?= $e($p['title']) ?></h3>
          <p><?= $e($p['excerpt']) ?></p>
          <div class="blog-meta"><span><?= $e($p['dateHuman']) ?></span> &middot; <span><?= $e($p['read']) ?></span></div>
          <span class="blog-readmore">Read article →</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../partials/footer.php'; ?>
