<?php
require_once __DIR__ . '/../../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se é aluno mesmo
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'aluno') {
    header("Location: ../../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal do Aluno | Novyx</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="asset/css/dashboard.css">
</head>
<body>

    <?php include 'components/sidebar.php'; ?>

    <section class="home-section">
        <nav class="top-navbar">
            <div style="display: flex; align-items: center;">
                <div class="breadcrumb">
                    <h3 style="font-weight: 500; margin-left: 10px;">
                        <?php 
                            $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                            $titles = [
                                'home' => 'Visão Geral',
                                'meu_projeto' => 'Detalhes do Projeto',
                                'minha_banca' => 'Agendamento de Defesa'
                            ];
                            echo isset($titles[$page]) ? $titles[$page] : 'Dashboard';
                        ?>
                    </h3>
                </div>
            </div>
            
            <div class="user-profile">
                <div style="text-align: right;"> 
                    <span style="font-size: 14px; display: block;">Olá, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Aluno') ?></strong></span>
                    <small style="color: var(--secondary-text);">Estudante</small>
                </div>
            </div>
        </nav>

        <div class="main-content">
            <?php
                switch ($page) {
                    case 'home': include 'View/home.php'; break;
                    case 'meu_projeto': include 'View/meu_projeto.php'; break;
                    case 'minha_banca': include 'View/minha_banca.php'; break;
                    default: include 'View/home.php';
                }
            ?>
        </div>
    </section>
</body>
</html>