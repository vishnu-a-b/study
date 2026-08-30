<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Method Not Allowed');
}

$isFetch = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch';

function respond(bool $isFetch, int $httpCode, array $payload, string $redirectQuery = ''): void
{
    if ($isFetch) {
        http_response_code($httpCode);
        header('Content-Type: application/json');
        echo json_encode($payload);
        exit;
    }
    header('Location: contact.php' . $redirectQuery);
    exit;
}

// ---- CSRF ----
if (!verify_csrf($_POST['csrf_token'] ?? null)) {
    respond($isFetch, 403, ['status' => 'error', 'message' => 'Your session expired — please reload the page and try again.'], '?error=csrf');
}

// ---- Honeypot: silently accept but flag as spam, never tip off the bot ----
$isSpam = !empty($_POST['website']);

// ---- Validation ----
$firstName = trim((string) ($_POST['first_name'] ?? ''));
$lastName  = trim((string) ($_POST['last_name'] ?? ''));
$email     = trim((string) ($_POST['email'] ?? ''));
$phone     = trim((string) ($_POST['phone'] ?? ''));
$message   = trim((string) ($_POST['message'] ?? ''));

$errors = [];
if ($firstName === '' || mb_strlen($firstName) > 100) {
    $errors['first_name'] = 'Please enter your first name.';
}
if ($lastName === '' || mb_strlen($lastName) > 100) {
    $errors['last_name'] = 'Please enter your last name.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Please enter a valid email address.';
}
if ($phone === '' || !preg_match('/^[0-9+\-()\s]{7,20}$/', $phone)) {
    $errors['phone'] = 'Please enter a valid phone number.';
}
if (mb_strlen($message) < 10 || mb_strlen($message) > 2000) {
    $errors['message'] = 'Please enter a message between 10 and 2000 characters.';
}

if (!empty($errors)) {
    respond($isFetch, 422, ['status' => 'error', 'message' => 'Please fix the highlighted fields.', 'errors' => $errors], '?error=validation');
}

// ---- Insert ----
try {
    $stmt = get_pdo()->prepare(
        'INSERT INTO contact_messages (first_name, last_name, email, phone, message, source_page, ip_address, user_agent, is_spam)
         VALUES (:first_name, :last_name, :email, :phone, :message, :source_page, :ip_address, :user_agent, :is_spam)'
    );
    $stmt->execute([
        'first_name'  => $firstName,
        'last_name'   => $lastName,
        'email'       => $email,
        'phone'       => $phone,
        'message'     => $message,
        'source_page' => 'contact.php',
        'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? null,
        'user_agent'  => substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255),
        'is_spam'     => $isSpam ? 1 : 0,
    ]);
} catch (PDOException $e) {
    respond($isFetch, 500, ['status' => 'error', 'message' => 'Something went wrong on our end — please try again shortly.'], '?error=server');
}

respond($isFetch, 200, ['status' => 'ok', 'message' => "Thanks — we'll get back to you shortly."], '?sent=1');
