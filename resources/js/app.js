import './auth.js';

document.addEventListener('click', (e) => {
    const fn = e.target.dataset.close;
    if (fn && typeof window[fn] === 'function') window[fn]();
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-autoopen="true"]').forEach((modal) => {
        modal.classList.remove('hidden');
    });

    const snackbar = document.getElementById('snackbar');
    if (snackbar) {
        setTimeout(() => {
            snackbar.classList.add('opacity-0');
            setTimeout(() => snackbar.remove(), 500);
        }, 2000);
    }
});
