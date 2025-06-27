function showSection(id) {
  document.querySelectorAll('.content section').forEach(sec => {
    sec.style.display = sec.id === id ? 'block' : 'none';
  });
}

window.addEventListener('DOMContentLoaded', () => {
  const links = document.querySelectorAll('.sidebar a[data-section]');
  const sidebar = document.querySelector('.sidebar');
  const toggle = document.querySelector('.menu-toggle');

  links.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      showSection(link.dataset.section);
      if (window.innerWidth <= 768) {
        sidebar.classList.remove('open');
      }
    });
  });
   if (toggle && sidebar) {
    toggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });
  }
  
  const first = document.querySelector('.content section');
  if (first) showSection(first.id);
});