<?php
/**
 * SMTP configuration template for Delvora Digital contact form.
 *
 * SETUP (do this on the server, once):
 *   1. Copy this file to "mail-config.php" in the same folder.
 *   2. Fill in your real SMTP credentials below.
 *   3. mail-config.php is gitignored, so your password never enters the repo.
 *
 * Where to get these values:
 *   - In cPanel, create an email account (e.g. noreply@delvoradigital.com),
 *     then open "Connect Devices" / "Mail Client Configuration" to see the
 *     outgoing (SMTP) host, port, and security settings.
 *   - Gmail/Google Workspace, Hostinger, Zoho, SendGrid, etc. also work —
 *     use the SMTP details they provide (and an app password if required).
 */

return [
    // Outgoing mail server
    'smtp_host'   => 'mail.delvoradigital.com', // e.g. smtp.hostinger.com, smtp.gmail.com
    'smtp_port'   => 587,                        // 587 for TLS/STARTTLS, 465 for SSL
    'smtp_secure' => 'tls',                      // 'tls' for port 587, 'ssl' for port 465

    // Mailbox the form authenticates as
    'smtp_user'   => 'noreply@delvoradigital.com',
    'smtp_pass'   => 'YOUR_SMTP_PASSWORD_HERE',

    // The "From" shown on emails (should match smtp_user's domain for deliverability)
    'from_email'  => 'noreply@delvoradigital.com',
    'from_name'   => 'Delvora Digital Studio',

    // Where inquiries are delivered
    'to_email'    => 'hello@delvoradigital.com',

    // Set true temporarily to print SMTP debug output to the PHP error log
    'debug'       => false,
];
