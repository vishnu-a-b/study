<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/functions.php';

$pageTitle       = 'Contact Us';
$pageDescription = 'Get in touch with Studwise International — Manjeri, Valanchery, and Calicut. Book a free appointment or ask us anything about studying abroad.';
$activeNav       = 'contact';
$includeContactFormJs = true;
require __DIR__ . '/../includes/header.php';

$branches = get_branches();
$faqs = get_faqs();
$token = csrf_token();
$sent = isset($_GET['sent']);
?>

<section class="page-hero">
  <div class="wrap">
    <div class="eyebrow-row reveal"><span class="marker"></span><p class="eyebrow">Financial Consultant Expert</p></div>
    <h1 class="reveal">Contact Us</h1>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap two-col">
    <div class="reveal">
      <h2>Book Appointment</h2>
      <p>Have a question or ready to start your study abroad journey? Fill in the form and our team will get in touch.</p>

      <div class="form-status<?= $sent ? ' is-success' : '' ?>" id="formStatus"><?= $sent ? "Thanks — we'll get back to you shortly." : '' ?></div>

      <form class="contact-form" id="contactForm" action="contact-submit.php" method="post" novalidate>
        <input type="hidden" name="csrf_token" value="<?= h($token) ?>">
        <div class="honeypot-field" aria-hidden="true">
          <label for="website">Leave this field empty</label>
          <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="form-row">
          <div class="field" data-field="first_name">
            <label for="first_name">First Name *</label>
            <input type="text" id="first_name" name="first_name" required>
          </div>
          <div class="field" data-field="last_name">
            <label for="last_name">Last Name *</label>
            <input type="text" id="last_name" name="last_name" required>
          </div>
        </div>
        <div class="form-row">
          <div class="field" data-field="email">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="field" data-field="phone">
            <label for="phone">Phone *</label>
            <input type="tel" id="phone" name="phone" required>
          </div>
        </div>
        <div class="field" data-field="message">
          <label for="message">Message *</label>
          <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit" class="btn btn--pill btn--magnetic" style="justify-self:start;"><span>Get in touch now</span></button>
      </form>
    </div>

    <div class="reveal">
      <div class="eyebrow-row"><span class="marker"></span><p class="eyebrow">Frequently Asked Questions</p></div>
      <h2>Find out more</h2>
      <p>Do you still get questions in your mind? Leave your worries. Our team has always got your back.</p>

      <div class="faq-list">
        <?php foreach ($faqs as $faq): ?>
          <div class="faq-item" data-open="false">
            <button type="button" class="faq-item__question">
              <?= h($faq['question']) ?>
              <span class="faq-item__icon">+</span>
            </button>
            <div class="faq-item__answer">
              <p><?= h($faq['answer']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="section" style="padding-top:0;">
  <div class="wrap">
    <div class="section-head section-head--center">
      <div class="eyebrow-row reveal" style="justify-content:center;"><span class="marker"></span><p class="eyebrow">Find us</p></div>
      <h2 class="reveal">Our Offices</h2>
    </div>
    <div class="cards-grid reveal-stagger">
      <?php foreach ($branches as $b): ?>
        <div class="office-card">
          <span class="office-card__badge"><?= $b['is_head_office'] ? 'Head Office' : 'Branch Office' ?></span>
          <h3><?= h($b['name']) ?></h3>
          <address>
            <?= $b['address'] ? nl2br(h($b['address'])) : 'Address coming soon' ?>
          </address>
          <p><a href="tel:<?= h(str_replace(' ', '', $b['phone'])) ?>"><?= h($b['phone']) ?></a></p>
          <p><a href="mailto:<?= h($b['email']) ?>"><?= h($b['email']) ?></a></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
$ctaTagline = 'One last step';
$ctaHeadingDark = 'Dreaming to go';
$ctaHeadingLight = 'abroad to study?';
$ctaSubtext = 'Studwise will guide you for all your needs in the best way this industry offers.';
$ctaButtonText = "Let's get started";
require __DIR__ . '/../includes/cta-band.php';

require __DIR__ . '/../includes/footer.php';
?>
