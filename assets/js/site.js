const toggle = document.querySelector('.menu-toggle');
const menu = document.querySelector('.main-menu');
if (toggle && menu) toggle.addEventListener('click', () => { const open = menu.classList.toggle('is-open'); toggle.setAttribute('aria-expanded', String(open)); });
