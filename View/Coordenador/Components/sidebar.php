<?php
// Lógica simples para marcar menu ativo
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<div class="sidebar">
    <div class="logo-details">
        <i class='bx bxl-codepen'></i>
        <span class="logo_name">NOVYX SGT</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="?page=home" class="<?= $page == 'home' ? 'active' : '' ?>">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="?page=tccs" class="<?= $page == 'tccs' || $page == 'tcc_cadastro' ? 'active' : '' ?>">
                <i class='bx bx-book'></i>
                <span class="links_name">TCCs e Projetos</span>
            </a>
        </li>
        <li>
            <a href="?page=bancas" class="<?= $page == 'bancas' ? 'active' : '' ?>">
                <i class='bx bx-group'></i>
                <span class="links_name">Bancas</span>
            </a>
        </li>
        <li>
            <a href="?page=relatorios" class="<?= $page == 'relatorios' ? 'active' : '' ?>">
                <i class='bx bx-pie-chart-alt-2'></i>
                <span class="links_name">Relatórios</span>
            </a>
        </li>
        <li>
            <a href="?page=config" class="<?= $page == 'config' ? 'active' : '' ?>">
                <i class='bx bx-cog'></i>
                <span class="links_name">Configurações</span>
            </a>
        </li>
        <li style="margin-top: auto;">
            <a href="logout.php">
                <i class="bx bx-log-out"></i>
                <span class="links_name">Sair</span>
            </a>
        </li>

    </ul>
</div>