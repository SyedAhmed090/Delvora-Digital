# Deploying Delvora Digital

This site is **plain HTML/CSS/vanilla JS + PHP includes** with **no build step**.
It must run on a host that **executes PHP** (cPanel shared hosting is the target).

> ⚠️ **Do not deploy to Vercel/Netlify static hosting.** They don't run PHP, so
> `.php` files are served as raw downloads instead of rendered pages (the browser
> prompts to download the file). Use a PHP host.

---

## 1. Get the files onto the server

Land the files so the document root contains `index.php` directly
(i.e. `public_html/index.php`, **not** `public_html/Delvora-Digital/index.php`).

Pick one:

- **cPanel File Manager:** download the repo as a ZIP from GitHub → File Manager →
  open `public_html` → Upload the ZIP → Extract in place.
- **Git (best for repeat deploys):** cPanel → *Git™ Version Control* → clone
  `https://github.com/SyedAhmed090/Delvora-Digital.git` into the docroot. Future
  deploys are a `git pull`.
- **FTP:** upload everything to the docroot.

## 2. Configure the contact form (required for email to send)

`php/mail-config.php` is **gitignored** (holds SMTP credentials) and is therefore
**not** in the repo/ZIP. On the server:

```
cp php/mail-config.sample.php php/mail-config.php
```

Then edit `php/mail-config.php` and fill in the SMTP host / port / username /
password (use a real mailbox on the domain for best deliverability).

Until this file exists, the form safely returns a "not configured" message
rather than erroring — so it's fine to go live and add this immediately after.

## 3. Set the PHP version

cPanel → *MultiPHP Manager* (or *Select PHP Version*) → set the domain to
**PHP 8.0+** (8.1 / 8.2 recommended). PHPMailer and the form handler work there.

## 4. Point the domain at this host

If DNS currently points elsewhere (e.g. Vercel), repoint the domain's A record /
nameservers to the cPanel host, then remove the unused deployment.

## 5. Verify

- `https://yourdomain.com/` **renders** the homepage (does not download).
- A service page loads: `/services/web-development.php`.
- The blog loads: `/blog/`.
- Legal pages load: `/privacy.php`, `/terms.php`.
- Submit the contact form once (after step 2) and confirm the email arrives.
- Optional: run `php -l` on the `.php` files on the server to lint before/after.

---

## Still-pending inputs (wire into the code, then redeploy)

| Item | Where |
|------|-------|
| GA4 Measurement ID (`G-XXXXXXXXXX`) | `partials/header.php` + legal pages |
| Calendly / Cal.com URL | `partials/header.php` (`DELVORA_CALENDLY_URL`) |
| SMTP credentials | `php/mail-config.php` (server only, step 2) |
| Real contact info (WhatsApp number, email) | header/footer/contact/schema |
| Real social + team LinkedIn URLs | `partials/footer.php`, `index.php` (marked `TODO`) |
| Proper 1200×630 `assets/og-image.jpg` | currently uses the logo PNG as interim |

See `ROADMAP.md` for full build status and phase notes.
