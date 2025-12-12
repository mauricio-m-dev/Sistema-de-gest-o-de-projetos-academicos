<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Coordenador | Novyx</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Asset/css/dashboard.css">
</head>
<body>

    <?php include 'components/sidebar.php'; ?>

    <section class="home-section">
        <nav class="top-navbar">
            <div style="display: flex; align-items: center;">
                <i class='bx bx-menu menu-toggle'></i> <div class="breadcrumb">
                    <h3 style="font-weight: 500; margin-left: 10px;">
                        <?php 
                            $page_title = isset($_GET['page']) ? ucfirst($_GET['page']) : 'Dashboard';
                            $titles = [
                                'tccs' => 'Gerenciamento de TCCs',
                                'bancas' => 'Agendamento de Bancas',
                                'config' => 'Configurações do Sistema',
                                'home' => 'Visão Geral'
                            ];
                            echo isset($titles[$page]) ? $titles[$page] : $page_title;
                        ?>
                    </h3>
                </div>
            </div>
            
            <div class="user-profile">
                <div style="text-align: right; display: none; @media(min-width: 768px){display:block;}"> 
                    <span style="font-size: 14px; display: block;">Olá, <strong>Coordenador</strong></span>
                    <small style="color: var(--secondary-text);">Ciência da Computação</small>
                </div>
            </div>
        </nav>

        <div class="main-content">
            <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                
                switch ($page) {
                    case 'home': include 'View/home.php'; break;
                    case 'tccs': include 'View/tccs.php'; break;
                    case 'tcc_cadastro': include 'View/tcc_register.php'; break;
                    case 'bancas': include 'View/bank.php'; break;
                    case 'relatorios': include 'View/relatorios.php'; break; // <-- Adicionado/Verificado
                    case 'config': include 'View/config.php'; break;
                    default: include 'View/home.php';
                }
            ?>
        </div>
    </section>

    <script src="Asset/js/dashboard.js"></script> </body>
</html>