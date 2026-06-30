<?php
/**
 * Delvora Digital Studio — Contact Form Handler
 * Works on cPanel with PHP mail()
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
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
    if ($elapsed_ms >= 0 && $elapsed_ms < 2000) {
        echo json_encode(['success' => false, 'message' => 'Please take a moment and try again.']);
        exit;
    }
}

// ---- CONFIG — Update these before going live ----
$to_email   = 'hello@delvoradigital.com';   // Change to real email
$from_email = 'noreply@delvoradigital.com';  // Change to your domain email
$site_name  = 'Delvora Digital Studio';

// ---- SANITIZE INPUTS ----
function clean($val) {
    return htmlspecialchars(strip_tags(trim($val)), ENT_QUOTES, 'UTF-8');
}

$name    = clean($_POST['name']    ?? '');
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone   = clean($_POST['phone']   ?? '');
$company = clean($_POST['company'] ?? '');
$message = clean($_POST['message'] ?? '');
$budget  = clean($_POST['budget']  ?? '');

// Services (array of checkboxes)
$services_raw = $_POST['services'] ?? [];
$services = array_map('htmlspecialchars', (array)$services_raw);
$services_str = !empty($services) ? implode(', ', $services) : 'Not specified';

// ---- VALIDATION ----
$errors = [];
if (empty($name))    $errors[] = 'Name is required';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required';
if (empty($message)) $errors[] = 'Message is required';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('. ', $errors)]);
    exit;
}

// ---- BUILD EMAIL ----
$subject = "New Project Inquiry from {$name} — {$site_name}";

$body = "
=================================================
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
Sent from: {$site_name} website contact form
=================================================
";

$headers  = "From: {$site_name} <{$from_email}>\r\n";
$headers .= "Reply-To: {$name} <{$email}>\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// ---- SEND ----
$sent = mail($to_email, $subject, $body, $headers);

if ($sent) {
    // Send auto-reply to client
    $reply_subject = "We received your message — {$site_name}";
    $reply_body = "Hi {$name},

Thank you for reaching out to Delvora Digital Studio!

We've received your inquiry and will get back to you within 24 hours.

Here's a summary of what you submitted:
- Services: {$services_str}
- Budget: " . ($budget ?: 'Not specified') . "

In the meantime, feel free to reach us on WhatsApp for a faster response.

Best regards,
The Delvora Digital Team
hello@delvoradigital.com
";
    $reply_headers  = "From: {$site_name} <{$from_email}>\r\n";
    $reply_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    mail($email, $reply_subject, $reply_body, $reply_headers);

    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send email']);
}
