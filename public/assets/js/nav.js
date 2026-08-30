(function () {
  document.documentElement.classList.remove('no-js');

  var header = document.getElementById('siteHeader');
  var hamburger = document.getElementById('hamburgerBtn');
  var lastY = window.scrollY;

  if (hamburger && header) {
    hamburger.addEventListener('click', function () {
      var open = header.classList.toggle('is-mobile-open');
      hamburger.setAttribute('aria-expanded', open ? 'true' : 'false');
      hamburger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
    });

    header.querySelectorAll('.mobile-nav a').forEach(function (link) {
      link.addEventListener('click', function () {
        header.classList.remove('is-mobile-open');
        hamburger.setAttribute('aria-expanded', 'false');
      });
    });
  }

  if (header) {
    window.addEventListener('scroll', function () {
      var y = window.scrollY;
      header.classList.toggle('is-scrolled', y > 40);

      if (!header.classList.contains('is-mobile-open')) {
        if (y > lastY && y > 200) {
          header.classList.add('is-hidden');
        } else {
          header.classList.remove('is-hidden');
        }
      }
      lastY = y;
    }, { passive: true });
  }
})();
