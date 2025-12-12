<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Model\DashboardModel;

// Instancia o Model e busca os dados
$dashboardModel = new DashboardModel();
$stats = $dashboardModel->getEstatísticas();
$recentes = $dashboardModel->getUltimasAtualizacoes();
?>

<div class="overview-boxes">
    <div class="card-box">
        <div class="card-details">
            <div class="number"><?= $stats['total'] ?></div>
            <div class="card-name">Total de TCCs</div>
        </div>
        <i class='bx bx-book-bookmark'></i>
    </div>
    
    <div class="card-box">
        <div class="card-details">
            <div class="number"><?= $stats['pendentes'] ?></div>
            <div class="card-name">Pendentes</div>
        </div>
        <i class='bx bx-time-five'></i>
    </div>
    
    <div class="card-box">
        <div class="card-details">
            <div class="number"><?= $stats['aprovados'] ?></div>
            <div class="card-name">Aprovados</div>
        </div>
        <i class='bx bx-check-circle'></i>
    </div>
    
    <div class="card-box">
        <div class="card-details">
            <div class="number"><?= $stats['rejeitados'] ?></div>
            <div class="card-name">Reprovados</div>
        </div>
        <i class='bx bx-x-circle'></i>
    </div>
</div>

<div class="table-container">
    <div class="table-header">
        <h3>Últimas Atualizações</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Aluno</th>
                <th>Título do Projeto</th>
                <th>Status</th>
                <th>Data Cadastro</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($recentes as $tcc): ?>
                <?php 
                    // Formata a data (ex: 2025-12-10 -> 10/12/2025)
                    $data = date('d/m/Y', strtotime($tcc['criado_em']));
                    
                    // Lógica para cor do badge (status)
                    $classeStatus = '';
                    $textoStatus = ucfirst($tcc['status']); // Primeira letra maiúscula

                    switch($tcc['status']) {
                        case 'pendente': $classeStatus = 'pendente'; break;
                        case 'andamento': $classeStatus = 'andamento'; break;
                        case 'aprovado': $classeStatus = 'aprovado'; break;
                        case 'rejeitado': $classeStatus = 'rejeitado'; break;
                        default: $classeStatus = 'pendente';
                    }
                ?>
                <tr>
                    <td><?= htmlspecialchars($tcc['aluno_nome']) ?></td>
                    <td><?= htmlspecialchars($tcc['titulo']) ?></td>
                    <td>
                        <span class="status <?= $classeStatus ?>">
                            <?= $textoStatus ?>
                        </span>
                    </td>
                    <td><?= $data ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if(empty($recentes)): ?>
                <tr>
                    <td colspan="4" style="text-align:center; padding: 20px; color: #aaa;">
                        Nenhuma atividade recente encontrada.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>