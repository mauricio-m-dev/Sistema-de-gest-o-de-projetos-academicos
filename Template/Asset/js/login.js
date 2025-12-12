// Função para mostrar/ocultar senha
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.querySelector('.toggle-password i');

    if (!passwordInput || !toggleIcon) return;

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bx-show');
        toggleIcon.classList.add('bx-hide');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bx-hide');
        toggleIcon.classList.add('bx-show');
    }
}