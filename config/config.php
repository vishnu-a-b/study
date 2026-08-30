<?php
declare(strict_types=1);

// ---- Database ----
define('DB_HOST', getenv('STUDWISE_DB_HOST') ?: '127.0.0.1');
define('DB_NAME', getenv('STUDWISE_DB_NAME') ?: 'studwise_dev');
define('DB_USER', getenv('STUDWISE_DB_USER') ?: 'root');
define('DB_PASS', getenv('STUDWISE_DB_PASS') ?: '');

// ---- Site ----
define('SITE_NAME', 'Studwise International');
define('SITE_TAGLINE', 'Best Study Abroad Consultancy in Malappuram, Kerala');
define('BASE_URL', '/');

// ---- Contact ----
define('PHONE_PRIMARY', '+91 91136 50884');
define('PHONE_SECONDARY', '+91 75106 50884');
define('EMAIL_PRIMARY', 'istudwise@gmail.com');
define('WHATSAPP_URL', 'https://wa.me/919113650884');

date_default_timezone_set('Asia/Kolkata');
