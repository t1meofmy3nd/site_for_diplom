function showSection(id) {
  document.querySelectorAll('.content section').forEach(sec => {
    sec.style.display = sec.id === id ? 'block' : 'none';
  });
}

window.addEventListener('DOMContentLoaded', () => {
  const links = document.querySelectorAll('.sidebar a[data-section]');
  const sidebar = document.querySelector('.sidebar');
  const toggle = document.querySelector('.menu-toggle');
  function applyStatusClass(select) {
    select.className = 'status-select status-' + select.value;
  }

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

  document.querySelectorAll('select[name="status"]').forEach(sel => {
    applyStatusClass(sel);
    sel.addEventListener('change', () => applyStatusClass(sel));
  });
  
  const first = document.querySelector('.content section');
  if (first) showSection(first.id);
});