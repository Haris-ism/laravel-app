window.openRegisterModal = function () {
    document.getElementById('register-name').value      = '';
    document.getElementById('register-email').value     = '';
    document.getElementById('register-password').value  = '';
    document.getElementById('register-modal').classList.remove('hidden');
}

window.closeRegisterModal = function () {
    document.getElementById('register-modal').classList.add('hidden');
}

window.openLoginModal = function () {
    document.getElementById('login-email').value    = '';
    document.getElementById('login-password').value = '';
    document.getElementById('login-modal').classList.remove('hidden');
}

window.closeLoginModal = function () {
    document.getElementById('login-modal').classList.add('hidden');
}
