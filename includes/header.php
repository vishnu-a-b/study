<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/seo.php';

$pageTitle       = $pageTitle ?? SITE_NAME;
$pageDescription = $pageDescription ?? SITE_TAGLINE;
$activeNav       = $activeNav ?? '';
?><!doctype html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php render_seo($pageTitle, $pageDescription); ?>
<link rel="icon" href="<?= asset('images/logo.png') ?>" type="image/png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="<?= asset('css/base.css') ?>">
<link rel="stylesheet" href="<?= asset('css/layout.css') ?>">
<link rel="stylesheet" href="<?= asset('css/components.css') ?>">
<link rel="stylesheet" href="<?= asset('css/animations.css') ?>">
</head>
<body>

<div class="page-loader" id="pageLoader" aria-hidden="true">
  <span class="page-loader__word">Studwise</span>
</div>

<div class="cursor-dot" id="cursorDot" aria-hidden="true">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
    <line x1="2" y1="2" x2="13" y2="13"></line>
    <polygon points="2 2 9 22 13 13 22 9 2 2" fill="currentColor"></polygon>
  </svg>
</div>

<a class="skip-link" href="#main">Skip to content</a>

<?php require __DIR__ . '/nav.php'; ?>

<main id="main">
