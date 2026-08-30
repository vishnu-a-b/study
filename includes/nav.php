<?php
declare(strict_types=1);
$navServices = get_services();
$navOnDark = $navOnDark ?? false;
?>
<header class="site-header<?= $navOnDark ? ' site-header--on-dark' : '' ?>" id="siteHeader">
  <div class="site-header__inner">
    <a href="<?= h(BASE_URL) ?>" class="brand">
      <img src="<?= asset('images/logo.png') ?>" alt="<?= h(SITE_NAME) ?>" class="brand__logo">
    </a>

    <nav class="main-nav" aria-label="Primary">
      <ul class="main-nav__list">
        <li><a href="<?= h(BASE_URL) ?>index.php" class="<?= $activeNav === 'home' ? 'is-active' : '' ?>">Home</a></li>
        <li class="has-dropdown">
          <a href="<?= h(BASE_URL) ?>services.php" class="<?= $activeNav === 'services' ? 'is-active' : '' ?>">Services</a>
          <ul class="dropdown">
            <?php foreach ($navServices as $svc): ?>
              <li><a href="<?= h(BASE_URL) ?>services/<?= h($svc['slug']) ?>.php"><?= h($svc['title']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li><a href="<?= h(BASE_URL) ?>about.php" class="<?= $activeNav === 'about' ? 'is-active' : '' ?>">About Us</a></li>
        <li><a href="<?= h(BASE_URL) ?>testimonials.php" class="<?= $activeNav === 'testimonials' ? 'is-active' : '' ?>">Testimonials</a></li>
        <li><a href="<?= h(BASE_URL) ?>contact.php" class="<?= $activeNav === 'contact' ? 'is-active' : '' ?>">Contact Us</a></li>
      </ul>
    </nav>

    <a href="<?= h(WHATSAPP_URL) ?>" target="_blank" rel="noopener" class="btn btn--pill">
      <span aria-hidden="true">&rarr;</span>
      <span>Book Appointment</span>
    </a>

    <button type="button" class="hamburger" id="hamburgerBtn" aria-label="Open menu" aria-expanded="false" aria-controls="mobileNav">
      <span></span><span></span><span></span>
    </button>
  </div>

  <div class="mobile-nav" id="mobileNav">
    <ul class="mobile-nav__list">
      <li><a href="<?= h(BASE_URL) ?>index.php">Home</a></li>
      <li><a href="<?= h(BASE_URL) ?>services.php">Services</a></li>
      <li><a href="<?= h(BASE_URL) ?>about.php">About Us</a></li>
      <li><a href="<?= h(BASE_URL) ?>testimonials.php">Testimonials</a></li>
      <li><a href="<?= h(BASE_URL) ?>contact.php">Contact Us</a></li>
    </ul>
    <a href="<?= h(WHATSAPP_URL) ?>" target="_blank" rel="noopener" class="btn btn--pill btn--block">Book Appointment</a>
  </div>
</header>
