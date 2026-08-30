(function () {
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var counters = document.querySelectorAll('.js-count');
  if (!counters.length) return;

  function animateCount(el) {
    var target = parseFloat(el.getAttribute('data-target'), 10) || 0;
    var prefix = el.getAttribute('data-prefix') || '';
    var suffix = el.getAttribute('data-suffix') || '';

    if (reduceMotion) {
      el.textContent = prefix + target + suffix;
      return;
    }

    var duration = 1400;
    var start = null;

    function step(timestamp) {
      if (start === null) start = timestamp;
      var progress = Math.min((timestamp - start) / duration, 1);
      var eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
      var current = Math.round(target * eased);
      el.textContent = prefix + current + suffix;
      if (progress < 1) {
        window.requestAnimationFrame(step);
      }
    }
    window.requestAnimationFrame(step);
  }

  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCount(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.6 });

    counters.forEach(function (el) { observer.observe(el); });
  } else {
    counters.forEach(animateCount);
  }
})();
