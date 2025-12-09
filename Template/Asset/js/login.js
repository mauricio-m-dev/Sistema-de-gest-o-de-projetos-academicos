// Função para mostrar/ocultar senha
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.querySelector('.toggle-password i');

    if (!passwordInput || !toggleIcon) return; // Segurança contra erros

    if (passwordInput.type === 'password') {
        // Mostrar Senha
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bx-show');
        toggleIcon.classList.add('bx-hide');
    } else {
        // Ocultar Senha
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bx-hide');
        toggleIcon.classList.add('bx-show');
    }
}

// Lógica de Submit e Validação Simples
document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Impede o envio real do formulário para teste

    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const userType = document.querySelector('input[name="userType"]:checked').value;
    const btn = document.querySelector('.btn-login');

    // Simulação de validação básica
    if (password.value.length < 6) {
        password.classList.add('shake');
        alert("A senha deve ter no mínimo 6 caracteres.");
        setTimeout(() => password.classList.remove('shake'), 300);
        return;
    }

    // Efeito de "Carregando"
    const originalText = btn.innerText;
    btn.innerText = 'Autenticando...';
    btn.style.opacity = '0.7';
    btn.disabled = true;

    // Simulação de atraso de rede (API)
    setTimeout(() => {
        btn.innerText = 'Sucesso!';
        btn.style.backgroundColor = '#4CAF50'; // Verde sucesso
        btn.style.color = '#fff';

        console.log(`Login efetuado:\nUser: ${userType}\nEmail: ${email.value}`);

        alert(`Bem-vindo, ${userType.charAt(0).toUpperCase() + userType.slice(1)}!`);

        // Reset (opcional)
        setTimeout(() => {
            btn.innerText = originalText;
            btn.style.backgroundColor = '';
            btn.style.color = '';
            btn.style.opacity = '1';
            btn.disabled = false;
        }, 2000);

    }, 1500);
});