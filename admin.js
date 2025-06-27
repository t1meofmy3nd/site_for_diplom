function showSection(id) {
  document.querySelectorAll('.content section').forEach(sec => {
    sec.style.display = sec.id === id ? 'block' : 'none';
  });
}

window.addEventListener('DOMContentLoaded', () => {
  const links = document.querySelectorAll('.sidebar a[data-section]');
  links.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      showSection(link.dataset.section);
    });
  });
  const first = document.querySelector('.content section');
  if (first) showSection(first.id);
});