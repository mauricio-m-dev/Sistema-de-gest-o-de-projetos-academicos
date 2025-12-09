<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="../Template/Asset/css/recover.css">
</head>

<body>

    <div class="login-container">
        <div class="header-icon">
            <i class='bx bx-lock-open-alt'></i>
        </div>

        <h2>Recuperar Senha</h2>
        <p class="subtitle">Informe seu e-mail para receber as instruções de redefinição.</p>

        <form id="recoverForm">
            <div class="input-group">
                <i class='bx bx-envelope input-icon'></i>
                <input type="email" id="email" required placeholder=" ">
                <label for="email">E-mail Institucional</label>
            </div>

            <button type="submit" class="btn-login">Enviar</button>

            <div class="footer-links">
                <a href="../login.php">
                    <i class='bx bx-arrow-back'></i> Voltar para Login
                </a>
            </div>
        </form>
    </div>

    <script src="../Template/Asset/js/recover.js"></script>
</body>

</html>