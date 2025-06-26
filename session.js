function updateAuthLinks(basePath = '') {
  fetch(basePath + 'check_session.php')
    .then(r => r.ok ? r.json() : {loggedIn:false})
    .then(data => {
      if (data.loggedIn) {
        document.querySelectorAll('.logout-link').forEach(el => el.style.display = 'inline');
        document.querySelectorAll('.login-link').forEach(el => el.style.display = 'none');
      }
    })
    .catch(() => {});
}

document.addEventListener('DOMContentLoaded', () => updateAuthLinks());