<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="Template/Asset/css/login.css">
</head>

<body>

    <div class="login-container">
        <h2>NOVYX SGT</h2>
        <p class="subtitle">Acesse sua conta institucional</p>

        <form id="loginForm">
            <div class="user-type-selector">
                <input type="radio" name="userType" id="type-aluno" value="aluno" checked>
                <label for="type-aluno">Aluno</label>

                <input type="radio" name="userType" id="type-orientador" value="orientador">
                <label for="type-orientador">Orientador</label>

                <input type="radio" name="userType" id="type-coordenador" value="coordenador">
                <label for="type-coordenador">Coord.</label>

                <div class="selection-indicator"></div>
            </div>

            <div class="input-group">
                <input type="email" id="email" required placeholder=" ">
                <label for="email">E-mail Institucional</label>
            </div>

            <div class="input-group">
                <input type="password" id="password" required placeholder=" ">
                <label for="password">Senha</label>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class='bx bx-show'></i>
                </span>
            </div>

            <button type="submit" class="btn-login">Entrar</button>

            <div class="footer-links">
                <a href="View/recover.php">Esqueceu a senha?</a>
            </div>
        </form>
    </div>

    <script src="Template/Asset/js/login.js"></script>
</body>

</html>