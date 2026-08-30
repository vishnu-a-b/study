<?php
declare(strict_types=1);
$footerBranches = get_branches();
$footerServices = get_services(true);
$year = date('Y');
?>
</main>

<footer class="site-footer">
  <div class="site-footer__inner">
    <div class="footer-col footer-col--about">
      <img src="<?= asset('images/logo.png') ?>" alt="<?= h(SITE_NAME) ?>" class="footer-logo">
      <p><?= h(SITE_NAME) ?> is one of the leading study abroad education consultants in Kerala, with its branches extending to Manjeri, Valanchery, and Calicut. We operate to serve the students who dream of pursuing education from abroad countries.</p>
    </div>

    <div class="footer-col">
      <h3>Services</h3>
      <ul>
        <?php foreach ($footerServices as $s): ?>
          <li><a href="<?= h(BASE_URL) ?>services/<?= h($s['slug']) ?>.php"><?= h($s['title']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="footer-col">
      <h3>Company</h3>
      <ul>
        <li><a href="<?= h(BASE_URL) ?>about.php">About Us</a></li>
        <li><a href="<?= h(BASE_URL) ?>testimonials.php">Testimonials</a></li>
        <li><a href="<?= h(BASE_URL) ?>contact.php">Contact Us</a></li>
      </ul>
    </div>

    <div class="footer-col">
      <h3>Get In Touch</h3>
      <p>Need help or have a question?</p>
      <p><a href="tel:<?= h(str_replace(' ', '', PHONE_PRIMARY)) ?>"><?= h(PHONE_PRIMARY) ?></a><br>
         <a href="tel:<?= h(str_replace(' ', '', PHONE_SECONDARY)) ?>"><?= h(PHONE_SECONDARY) ?></a></p>
      <p><a href="mailto:<?= h(EMAIL_PRIMARY) ?>"><?= h(EMAIL_PRIMARY) ?></a></p>
    </div>
  </div>

  <div class="site-footer__inner" style="padding-top:0; border-top:1px solid var(--line-on-navy); margin-top:8px;">
    <?php foreach ($footerBranches as $b): ?>
      <div class="footer-col">
        <h3><?= h($b['name']) ?><?= $b['is_head_office'] ? ' (Head Office)' : '' ?></h3>
        <p><?= $b['address'] ? nl2br(h($b['address'])) : 'Address coming soon' ?></p>
        <p><a href="mailto:<?= h($b['email']) ?>"><?= h($b['email']) ?></a><br>
           <a href="tel:<?= h(str_replace(' ', '', $b['phone'])) ?>"><?= h($b['phone']) ?></a></p>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="site-footer__bottom">
    <p>&copy; <?= h((string) $year) ?> All Rights Reserved. Studwise Pvt Ltd.</p>
  </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
<script src="https://unpkg.com/lenis@1.1.13/dist/lenis.min.js" defer></script>
<script src="<?= asset('js/nav.js') ?>" defer></script>
<script src="<?= asset('js/main.js') ?>" defer></script>
<script src="<?= asset('js/counters.js') ?>" defer></script>
<script src="<?= asset('js/marquee.js') ?>" defer></script>
<script src="<?= asset('js/magnetic-button.js') ?>" defer></script>
<script src="<?= asset('js/service-tabs.js') ?>" defer></script>
<?php if (!empty($includeContactFormJs)): ?>
<script src="<?= asset('js/contact-form.js') ?>" defer></script>
<?php endif; ?>
<?php if (!empty($includeHeroStoryJs)): ?>
<script src="<?= asset('js/hero-story.js') ?>" defer></script>
<?php endif; ?>
<?php if (!empty($includeStudyGlobeJs)): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" defer></script>
<script src="<?= asset('js/study-globe.js') ?>" defer></script>
<?php endif; ?>
</body>
</html>
