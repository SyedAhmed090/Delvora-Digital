<?php
/**
 * Delvora Digital Studio — Contact Form Handler
 * Sends via SMTP using PHPMailer (php/lib/PHPMailer).
 * SMTP credentials live in php/mail-config.php (copy from mail-config.sample.php).
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// ---- SPAM GUARDS ----
// 1. Honeypot: the "website" field is hidden from users; only bots fill it.
//    Pretend success so bots don't probe further.
if (!empty($_POST['website'])) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
    exit;
}
// 2. Time-trap: reject submissions completed in under 2s (clock-skew safe —
//    only rejects a positive, implausibly-small elapsed time).
if (isset($_POST['form_ts']) && is_numeric($_POST['form_ts'])) {
    $elapsed_ms = (microtime(true) * 1000) - (float) $_POST['form_ts'];
    // reject if submitted in <2s (2000 ms) — humans can't fill the form that fast; bots submit near-instantly.
    if ($elapsed_ms >= 0 && $elapsed_ms < 2000) {
        echo json_encode(['success' => false, 'message' => 'Please take a moment and try again.']);
        exit;
    }
}

// ---- LOAD SMTP CONFIG ----
$config_file = __DIR__ . '/mail-config.php';
if (!file_exists($config_file)) {
    error_log('contact.php: missing php/mail-config.php (copy from mail-config.sample.php).');
    echo json_encode(['success' => false, 'message' => 'Mail is not configured yet. Please reach us on WhatsApp or email directly.']);
    exit;
}
$cfg = require $config_file;
$site_name = $cfg['from_name'] ?? 'Delvora Digital Studio';

// ---- SANITIZE INPUTS ----
function clean($val) {
    return htmlspecialchars(strip_tags(trim($val)), ENT_QUOTES, 'UTF-8');
}

$form_type = clean($_POST['form_type'] ?? 'project');

$name    = clean($_POST['name']    ?? '');
$email   = trim($_POST['email'] ?? ''); // validated below with FILTER_VALIDATE_EMAIL (FILTER_SANITIZE_EMAIL deprecated in PHP 8.1)
$phone   = clean($_POST['phone']   ?? '');
$company = clean($_POST['company'] ?? '');
$message = clean($_POST['message'] ?? '');
$budget  = clean($_POST['budget']  ?? '');
// Website URL (FILTER_SANITIZE_URL deprecated in PHP 8.1). Accept a well-formed URL
// as-is; otherwise keep it as a cleaned plain string — a prospect may type
// "example.com" without a scheme, and we don't want to reject the audit request.
$site_url = trim($_POST['site_url'] ?? '');
if ($site_url !== '' && !filter_var($site_url, FILTER_VALIDATE_URL)) {
    $site_url = clean($site_url);
}

// Services (array of checkboxes)
$services_raw = $_POST['services'] ?? [];
$services = array_map('htmlspecialchars', (array) $services_raw);
$services_str = !empty($services) ? implode(', ', $services) : 'Not specified';

if ($form_type === 'audit') {
    // ---- FREE AUDIT REQUEST ----
    $errors = [];
    if (empty($name))  $errors[] = 'Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($site_url)) $errors[] = 'Website URL is required';
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
        exit;
    }

    $subject = "New Free Audit Request from {$name} — {$site_name}";
    $body = "=================================================
   NEW FREE AUDIT REQUEST — {$site_name}
=================================================

Name:     {$name}
Email:    {$email}
Phone:    " . ($phone ?: 'Not provided') . "
Website:  {$site_url}

=================================================
Sent from the {$site_name} free-audit form
=================================================
";
    $reply_body = "Hi {$name},

Thanks for requesting a free website audit from Delvora Digital Studio!

We'll review {$site_url} — design, speed, SEO, and conversion — and email
you a clear, no-obligation report within 2–3 business days.

If you'd like to talk it through sooner, just reply or reach us on WhatsApp.

Best regards,
The Delvora Digital Team
{$cfg['to_email']}
";
} else {
    // ---- PROJECT INQUIRY ----
    $errors = [];
    if (empty($name))    $errors[] = 'Name is required';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
    if (empty($message)) $errors[] = 'Message is required';
    if (!empty($errors)) {
        echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
        exit;
    }

    $subject = "New Project Inquiry from {$name} — {$site_name}";
    $body = "=================================================
   NEW PROJECT INQUIRY — {$site_name}
=================================================

Name:     {$name}
Email:    {$email}
Phone:    " . ($phone ?: 'Not provided') . "
Company:  " . ($company ?: 'Not provided') . "

Services: {$services_str}
Budget:   " . ($budget ?: 'Not specified') . "

Message:
---------
{$message}

=================================================
Sent from the {$site_name} website contact form
=================================================
";
    $reply_body = "Hi {$name},

Thank you for reaching out to Delvora Digital Studio!

We've received your inquiry and will get back to you within 24 hours.

Here's a summary of what you submitted:
- Services: {$services_str}
- Budget: " . ($budget ?: 'Not specified') . "

In the meantime, feel free to reach us on WhatsApp for a faster response.

Best regards,
The Delvora Digital Team
{$cfg['to_email']}
";
}

// ---- SEND VIA SMTP (PHPMailer) ----
require __DIR__ . '/lib/PHPMailer/Exception.php';
require __DIR__ . '/lib/PHPMailer/PHPMailer.php';
require __DIR__ . '/lib/PHPMailer/SMTP.php';

try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $cfg['smtp_host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $cfg['smtp_user'];
    $mail->Password   = $cfg['smtp_pass'];
    $mail->SMTPSecure = $cfg['smtp_secure'] ?: PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = (int) $cfg['smtp_port'];
    $mail->CharSet    = 'UTF-8';
    if (!empty($cfg['debug'])) {
        $mail->SMTPDebug   = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = 'error_log';
    }

    // Notification to the studio
    $mail->setFrom($cfg['from_email'], $site_name);
    $mail->addAddress($cfg['to_email']);
    $mail->addReplyTo($email, $name);
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->send();

    // Auto-reply to the client (failure here shouldn't fail the request)
    try {
        $reply = new PHPMailer(true);
        $reply->isSMTP();
        $reply->Host       = $cfg['smtp_host'];
        $reply->SMTPAuth   = true;
        $reply->Username   = $cfg['smtp_user'];
        $reply->Password   = $cfg['smtp_pass'];
        $reply->SMTPSecure = $cfg['smtp_secure'] ?: PHPMailer::ENCRYPTION_STARTTLS;
        $reply->Port       = (int) $cfg['smtp_port'];
        $reply->CharSet    = 'UTF-8';
        $reply->setFrom($cfg['from_email'], $site_name);
        $reply->addAddress($email, $name);
        $reply->addReplyTo($cfg['to_email'], $site_name);
        $reply->Subject = "We received your message — {$site_name}";
        $reply->Body    = $reply_body;
        $reply->send();
    } catch (Exception $e) {
        error_log('contact.php auto-reply failed: ' . $e->getMessage());
    }

    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} catch (Exception $e) {
    error_log('contact.php send failed: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Failed to send. Please try WhatsApp or email us directly.']);
}
