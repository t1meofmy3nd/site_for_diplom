function highlightActiveLink() {
  const path = location.pathname.split('/').pop();
  document.querySelectorAll('header nav a').forEach(link => {
    const href = link.getAttribute('href');
    if (href === path) {
      link.classList.add('active');
    }
  });
}

function updateCartCount() {
  const items = JSON.parse(localStorage.getItem('cart') || '[]');
  const count = items.reduce((sum, i) => sum + (i.quantity || 0), 0);
  document.querySelectorAll('.cart-count').forEach(el => el.textContent = count);
}

document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('header nav');
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      nav.classList.toggle('open');
    });
  }
  highlightActiveLink();
  updateCartCount();
});