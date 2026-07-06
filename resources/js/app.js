import './auth.js';

document.addEventListener('click', (e) => {
    const fn = e.target.dataset.close;
    if (fn && typeof window[fn] === 'function') window[fn]();
});
