/**
 * utils.js — Shared frontend utilities
 */

/** Show a toast notification */
function showToast(message, type = 'info') {
  const toast = document.createElement('div');
  toast.className = `toast toast--${type}`;
  toast.textContent = message;
  document.body.appendChild(toast);
  requestAnimationFrame(() => toast.classList.add('toast--visible'));
  setTimeout(() => {
    toast.classList.remove('toast--visible');
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}

/** Format ISO date string to human-readable */
function formatDate(iso) {
  return new Date(iso).toLocaleDateString('en-US', {
    year: 'numeric', month: 'short', day: 'numeric'
  });
}

/** Debounce a function */
function debounce(fn, wait = 300) {
  let timer;
  return (...args) => {
    clearTimeout(timer);
    timer = setTimeout(() => fn(...args), wait);
  };
}

/** Get query param from URL */
function getParam(name) {
  return new URLSearchParams(window.location.search).get(name);
}

/** Confirm dialog wrapper returning a Promise */
function confirm(message) {
  return new Promise(resolve => resolve(window.confirm(message)));
}
