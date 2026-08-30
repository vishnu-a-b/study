(function () {
  if (!window.matchMedia('(pointer: fine)').matches) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var hasGsap = typeof window.gsap !== 'undefined';
  var strength = 0.35;

  document.querySelectorAll('.btn--magnetic').forEach(function (btn) {
    btn.addEventListener('mousemove', function (e) {
      var rect = btn.getBoundingClientRect();
      var x = (e.clientX - rect.left - rect.width / 2) * strength;
      var y = (e.clientY - rect.top - rect.height / 2) * strength;
      if (hasGsap) {
        gsap.to(btn, { x: x, y: y, duration: 0.35, ease: 'power2.out' });
      } else {
        btn.style.transform = 'translate(' + x + 'px,' + y + 'px)';
      }
    });

    btn.addEventListener('mouseleave', function () {
      if (hasGsap) {
        gsap.to(btn, { x: 0, y: 0, duration: 0.5, ease: 'elastic.out(1, 0.4)' });
      } else {
        btn.style.transform = 'translate(0,0)';
      }
    });
  });
})();
