<?php
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
                <span class="links_name">Visão Geral</span>
            </a>
        </li>
        <li>
            <a href="?page=meu_projeto" class="<?= $page == 'meu_projeto' ? 'active' : '' ?>">
                <i class='bx bx-book-content'></i>
                <span class="links_name">Meu Projeto</span>
            </a>
        </li>
        <li>
            <a href="?page=minha_banca" class="<?= $page == 'minha_banca' ? 'active' : '' ?>">
                <i class='bx bx-group'></i>
                <span class="links_name">Minha Banca</span>
            </a>
        </li>
        <li style="margin-top: auto;">
            <a href="../Coordenador/logout.php">
                <i class='bx bx-log-out'></i>
                <span class="links_name">Sair</span>
            </a>
        </li>
    </ul>
</div>