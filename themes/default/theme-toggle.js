// Lightweight theme toggle script
(function() {
  const root = document.body;
  const btn = document.getElementById('themeToggle');
  const storageKey = 'site-theme';
  function setTheme(theme) {
    root.setAttribute('data-theme', theme);
    localStorage.setItem(storageKey, theme);
  }
  function toggleTheme() {
    const current = root.getAttribute('data-theme') || 'light';
    setTheme(current === 'dark' ? 'light' : 'dark');
  }
  // Init
  const saved = localStorage.getItem(storageKey);
  if (saved) setTheme(saved);
  btn && btn.addEventListener('click', toggleTheme);
})();
