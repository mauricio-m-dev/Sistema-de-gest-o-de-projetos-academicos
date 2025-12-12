<?php
session_start(); // Inicia a sessão para poder destruí-la

// Limpa todas as variáveis de sessão
$_SESSION = array();

// Se for preciso matar o cookie da sessão (garantia extra)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destrói a sessão no servidor
session_destroy();

// CORREÇÃO DO CAMINHO:
// Estamos em: View/Coordenador/logout.php
// ../ volta para View
// ../../ volta para a Raiz (onde está login.php)
header("Location: ../../login.php");
exit();
?>