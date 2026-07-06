// ── Token helpers ─────────────────────────────────────────────────────────────

export function getToken()       { return localStorage.getItem('auth_token'); }
export function setToken(token)  { localStorage.setItem('auth_token', token); }
export function removeToken()    { localStorage.removeItem('auth_token'); }
export function isLoggedIn()     { return !!getToken(); }

// ── Auth header ───────────────────────────────────────────────────────────────

export function authHeaders() {
    return {
        'Content-Type':  'application/json',
        'Accept':        'application/json',
        'Authorization': `Bearer ${getToken()}`,
    };
}

// ── UI state ──────────────────────────────────────────────────────────────────

function updateNavUI() {
    const loggedIn    = isLoggedIn();
    const guestEls    = document.querySelectorAll('[data-auth="guest"]');
    const authEls     = document.querySelectorAll('[data-auth="user"]');
    const manageLinks = document.querySelectorAll('[data-auth="manage"]');

    guestEls.forEach(el    => el.style.display = loggedIn ? 'none' : 'flex');
    authEls.forEach(el     => el.style.display = loggedIn ? 'flex' : 'none');
    manageLinks.forEach(el => el.style.display = loggedIn ? 'block' : 'none');
}

// ── Register ──────────────────────────────────────────────────────────────────

window.openRegisterModal = function () {
    document.getElementById('register-name').value      = '';
    document.getElementById('register-email').value     = '';
    document.getElementById('register-password').value  = '';
    document.getElementById('register-error').textContent = '';
    document.getElementById('register-modal').classList.remove('hidden');
}

window.closeRegisterModal = function () {
    document.getElementById('register-modal').classList.add('hidden');
}

window.submitRegister = async function () {
    const name     = document.getElementById('register-name').value.trim();
    const email    = document.getElementById('register-email').value.trim();
    const password = document.getElementById('register-password').value.trim();
    const errEl    = document.getElementById('register-error');
    errEl.textContent = '';

    if (!name || !email || !password) { errEl.textContent = 'All fields are required.'; return; }

    const btn = document.getElementById('register-submit');
    btn.disabled = true; btn.textContent = 'Registering...';

    try {
        const res  = await fetch('/api/register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ name, email, password }),
        });
        const json = await res.json();

        if (!res.ok) {
            errEl.textContent = json.meta?.message ?? Object.values(json.errors ?? {})[0]?.[0] ?? 'Registration failed.';
            return;
        }

        setToken(json.data.token);
        closeRegisterModal();
        updateNavUI();
    } catch (e) {
        errEl.textContent = 'Something went wrong.';
    } finally {
        btn.disabled = false; btn.textContent = 'Register';
    }
}

// ── Login ─────────────────────────────────────────────────────────────────────

window.openLoginModal = function () {
    document.getElementById('login-email').value    = '';
    document.getElementById('login-password').value = '';
    document.getElementById('login-error').textContent = '';
    document.getElementById('login-modal').classList.remove('hidden');
}

window.closeLoginModal = function () {
    document.getElementById('login-modal').classList.add('hidden');
}

window.submitLogin = async function () {
    const email    = document.getElementById('login-email').value.trim();
    const password = document.getElementById('login-password').value.trim();
    const errEl    = document.getElementById('login-error');
    errEl.textContent = '';

    if (!email || !password) { errEl.textContent = 'All fields are required.'; return; }

    const btn = document.getElementById('login-submit');
    btn.disabled = true; btn.textContent = 'Logging in...';

    try {
        const res  = await fetch('/api/login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify({ email, password }),
        });
        const json = await res.json();

        if (!res.ok) {
            errEl.textContent = json.meta?.message ?? Object.values(json.errors ?? {})[0]?.[0] ?? 'Invalid credentials.';
            return;
        }

        setToken(json.data.token);
        closeLoginModal();
        updateNavUI();
    } catch (e) {
        errEl.textContent = 'Something went wrong.';
    } finally {
        btn.disabled = false; btn.textContent = 'Login';
    }
}

// ── Logout ────────────────────────────────────────────────────────────────────

window.logout = async function () {
    try {
        await fetch('/api/logout', {
            method: 'POST',
            headers: authHeaders(),
        });
    } finally {
        removeToken();
        updateNavUI();

        if (window.location.pathname === '/blog/manage') {
            window.location.href = '/blog';
        }
    }
}

// ── Init ──────────────────────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
    updateNavUI();

    const requireAuth = document.body.dataset.requireAuth === 'true';
    if (requireAuth && !isLoggedIn()) {
        window.location.href = '/blog';
    }
});
