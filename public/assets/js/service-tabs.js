(function () {
  const list = document.getElementById('serviceTabList');
  if (!list) return;

  const buttons = [...list.querySelectorAll('.tab-list__item')];
  const images = [...document.querySelectorAll('.tab-list-media__img')];
  const headingEl = document.getElementById('tabListHeading');
  const bodyEl = document.getElementById('tabListBody');
  const linkEl = document.getElementById('tabListLink');

  function activate(button) {
    buttons.forEach((b) => b.classList.toggle('is-active', b === button));
    images.forEach((img) => img.classList.toggle('is-active', img.dataset.index === button.dataset.index));
    if (headingEl) headingEl.textContent = button.dataset.title;
    if (bodyEl) bodyEl.textContent = button.dataset.body;
    if (linkEl && button.dataset.href) linkEl.setAttribute('href', button.dataset.href);
  }

  buttons.forEach((button) => {
    button.addEventListener('click', () => activate(button));
  });

  if (window.location.hash) {
    const target = buttons.find((b) => '#' + b.id === window.location.hash);
    if (target) activate(target);
  }
})();
