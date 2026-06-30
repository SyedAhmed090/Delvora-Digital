# Delvora Digital — Build Roadmap

Plan for points 5, 6, 7, 8, 9, 10, 12, 13. Grouped into phases by dependency
and by how much input is needed from the client. Each item lists **what**,
**files touched**, and **inputs needed**.

Stack reminder: plain HTML/CSS/vanilla JS on cPanel shared hosting, PHP available
(`php/contact.php`). No build step.

---

## Phase 0 — Quick wins (no input needed, do first)   ✅ DONE

### 13. SVG mark as favicon
- **What:** Use the new vector mark as the favicon (sharper than the PNG at all
  sizes; crisp on retina + browser tabs).
- **Files:** `index.html` `<head>` (and every new page) — add
  `<link rel="icon" type="image/svg+xml" href="assets/logo/delvora-mark.svg">`
  before the existing PNG icon (PNG stays as fallback for old browsers).
- **Inputs:** none.

### 12. Performance / Core Web Vitals pass
- **What:**
  1. Add `defer` to the GSAP / Lenis / ScrollTrigger / main.js script tags so
     they stop blocking parse.
  2. Trim font payload: Inter currently loads **7 weights** (300–900). Audit
     actual usage and cut to ~4 (likely 400/500/600/700/800). Keep Space
     Grotesk at 500/600/700.
  3. Add explicit `width`/`height` to the logo `<img>` and (later) project/team
     images to kill layout shift (CLS).
  4. Confirm the particle canvas is gated correctly on mobile/low-power (it
     already drops to 38 particles <768px and is off under reduced-motion).
  5. Verify with Lighthouse after; target 90+ mobile performance.
- **Files:** `index.html` (head + script tags), possibly `js/main.js`.
- **Inputs:** none. (Verification needs a Lighthouse run.)

---

## Phase 1 — Legal + measurement   ✅ BUILT (waiting on your inputs to activate)

> Status: privacy.html + terms.html live and linked; GA4 wired (paste your ID
> into `DELVORA_GA_ID`); honeypot + time-trap active on both forms.
> Point 7 = **option B (PHPMailer + SMTP)** is implemented — PHPMailer v6.9.1
> bundled in `php/lib/PHPMailer/`, sending logic in `php/contact.php`.
>
> Still need to go live:
> 1. **GA4 Measurement ID** — replace `G-XXXXXXXXXX` in index/privacy/terms.
> 2. **SMTP credentials** — on the server, copy `php/mail-config.sample.php`
>    to `php/mail-config.php` and fill in host/port/user/pass (gitignored).


### 5. Privacy Policy & Terms pages
- **What:** Create `privacy.html` and `terms.html` using the same nav/footer/CSS
  shell. Privacy covers: what the form collects (name, email, phone, company,
  message), purpose (responding to inquiries only), no selling of data, GA4 /
  cookies disclosure, data-request contact, retention. Terms: site use, IP
  ownership on delivered work, no-warranty, governing law = Pakistan.
- **Then:** wire the footer links (currently `href="#"`) to the new pages.
- **Files:** new `privacy.html`, `terms.html`; `index.html` (footer links).
- **Inputs:** legal business name, jurisdiction (assume Karachi, Pakistan),
  contact email. ⚠️ Templates only — recommend a lawyer skims them.
- **Why first:** required once we add analytics, and **mandatory** before
  running Google/Meta ads.

### 6. GA4 + event tracking
- **What:** Add the GA4 `gtag` snippet to every page `<head>`. Add a small
  `track(name, params)` helper in `main.js`. Fire events on the moments that
  matter: WhatsApp clicks (float, contact, footer), form-modal opens, form
  submit success (both forms), Book-a-Call clicks, primary CTA clicks.
- **Files:** `index.html` + new pages (head), `js/main.js`.
- **Inputs:** GA4 Measurement ID (`G-XXXXXXXXXX`).
- **Depends on:** 5 (privacy must disclose tracking).

### 7. Form spam protection + reliable delivery
- **What:**
  1. **Honeypot** hidden field on both forms (`#contactForm`, `#popupContactForm`)
     — bots fill it, `contact.php` silently rejects.
  2. **Time-trap** — reject submissions under ~3s (bots submit instantly).
  3. Harden `contact.php`: keep existing sanitisation, add honeypot/time checks,
     tighten From/Reply-To headers for deliverability.
  4. **Delivery decision (pick one):**
     - **A. Web3Forms / FormSubmit** — free third-party endpoint, very reliable,
       no server mail config. *(Recommended — least likely to land in spam.)*
     - **B. PHPMailer + SMTP** — send via a real mailbox; reliable but needs SMTP
       credentials and a library.
     - **C. Keep `mail()`** — improve headers + set up SPF/DKIM on the domain.
       Cheapest, least reliable on shared hosting.
- **Files:** `index.html` (both forms), `php/contact.php`, `css/style.css`
  (hide honeypot).
- **Inputs:** delivery choice above (+ Web3Forms key or SMTP creds if A/B).

---

## Phase 2 — Conversion paths   ✅ BUILT (waiting on your Calendly URL)

> Status: Free Audit section live (`#audit`, in nav) with its own form →
> `contact.php` (form_type=audit) + honeypot/time-trap + GA4 lead event.
> "Book a Call" button added to the mid-page CTA; opens a Calendly popup once
> you paste your URL into `DELVORA_CALENDLY_URL` — until then it falls back to
> opening the contact form so the click is never wasted.


### 8. "Book a Call" (Calendly / Cal.com)
- **What:** Add a "Book a Call" CTA (hero secondary action + contact section).
  Use the Calendly popup widget so it opens in an overlay instead of leaving the
  site. Track the click as a GA4 event.
- **Files:** `index.html` (button + widget script), `css/style.css`, maybe
  `js/main.js`.
- **Inputs:** Calendly (or Cal.com) scheduling URL.

### 9. "Free Website Audit" lead magnet
- **What:** A dedicated offer band (above Contact) — "Get a free website audit."
  Short form: name, email, **website URL**. Posts to `contact.php` flagged as an
  audit request (distinct subject). Captures prospects who aren't ready to buy.
  Add an entry CTA in nav/hero. Track as a conversion event.
- **Files:** `index.html` (new section + nav link), `css/style.css`,
  `php/contact.php` (handle audit flag), `js/main.js`.
- **Inputs:** none (uses same delivery as 7). Optional: confirm the offer wording.
- **Depends on:** 7 (shares the form pipeline), 6 (event tracking).

---

## Phase 3 — SEO / content engine (largest; architecture decision)

### 10. Service pages + blog (single-page → multi-page)
- **What:**
  1. **Service pages (6):** `/services/web-development.html`, `mobile-apps.html`,
     `ui-ux-design.html`, `ecommerce.html`, `digital-marketing.html`,
     `brand-identity.html`. Each: focused hero, what's included, process, FAQ,
     CTA — written to target local search ("web development company in Karachi").
     Add `Service` JSON-LD per page, link from the homepage service cards/modals,
     and add all URLs to `sitemap.xml`.
  2. **Blog:** `/blog/` index + individual post pages for content marketing /
     organic traffic. Hand-authored static posts (no CMS).
- **Architecture decision:** to avoid copy-pasting the nav/footer into ~10+
  pages, use **PHP includes** (`<?php include 'partials/header.php' ?>`) since
  cPanel runs PHP. Alternative is duplicating the shell per page (simpler, more
  maintenance). **Recommend PHP includes.**
- **Files:** new `services/*.html` (or `.php`), `blog/*`, shared
  `partials/header.php` + `footer.php`, refactor `index.html` to use them,
  `sitemap.xml`.
- **Inputs:** keyword priorities, PHP-includes approval, blog scope (how many
  seed posts, who writes them). This is ongoing content work — I scaffold the
  structure + templates + 1 sample; articles are an ongoing effort.

---

## Consolidated inputs needed from you

| # | Item | Input |
|---|------|-------|
| 6 | GA4 | Measurement ID (`G-XXXXXXXXXX`) |
| 8 | Book a Call | Calendly / Cal.com URL |
| 7 | Form delivery | A (Web3Forms key) / B (SMTP creds) / C (keep mail) |
| 5 | Legal pages | Business name, jurisdiction, contact email |
| 10 | Service/blog | Keyword targets, PHP-includes OK?, blog scope |

## Recommended execution order
**Phase 0** (today, no input) → **Phase 1** (legal + GA4 + spam) →
**Phase 2** (Calendly + audit) → **Phase 3** (service pages + blog, scoped
separately).

Phases 0–2 are achievable quickly and turn the site from "looks ready" into
"actually captures and measures leads." Phase 3 is the longer-term growth engine.
