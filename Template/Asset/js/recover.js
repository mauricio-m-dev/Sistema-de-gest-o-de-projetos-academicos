document.getElementById('recoverForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const emailInput = document.getElementById('email');
    const btn = document.querySelector('.btn-login');
    const originalText = btn.innerText;

    // Validação Simples de formato de e-mail (regex básico)
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(emailInput.value)) {
        emailInput.classList.add('shake');
        // Usando Toast ou Alert simples
        alert("Por favor, insira um e-mail válido.");
        setTimeout(() => emailInput.classList.remove('shake'), 300);
        return;
    }

    // Estado de "Enviando"
    btn.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Enviando...";
    btn.style.opacity = '0.8';
    btn.disabled = true;

    // Simulação de API
    setTimeout(() => {
        // Sucesso
        btn.innerHTML = "<i class='bx bx-check'></i> Enviado!";
        btn.style.backgroundColor = 'var(--success-color)';
        btn.style.color = '#fff';

        // Feedback para o usuário
        alert(`Um link de recuperação foi enviado para: ${emailInput.value}`);

        // Reset do formulário após sucesso
        setTimeout(() => {
            emailInput.value = '';
            btn.innerText = originalText;
            btn.style.backgroundColor = '';
            btn.style.color = '';
            btn.style.opacity = '1';
            btn.disabled = false;
        }, 3000);

    }, 2000);
});