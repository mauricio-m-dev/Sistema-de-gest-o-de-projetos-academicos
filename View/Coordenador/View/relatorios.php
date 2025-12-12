<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Model\RelatorioModel;

// Inicializa o Model
$relatorioModel = new RelatorioModel();

// Busca dados para as 3 abas
$stats = $relatorioModel->getEstatisticas();
$pendencias = $relatorioModel->getPendencias();
$logs = $relatorioModel->getLogs();
?>

<div class="table-container">
    <div class="table-header">
        <h3>Acompanhamento Detalhado</h3>
    </div>

    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab('tab1', this)">Visão Geral</button>
        <button class="tab-btn" onclick="switchTab('tab2', this)">Entregas Pendentes</button>
        <button class="tab-btn" onclick="switchTab('tab3', this)">Histórico</button>
    </div>

    <div id="tab1" class="tab-content active">
        <p style="color: var(--secondary-text); margin-bottom: 15px;">Estatísticas gerais do semestre.</p>
        <div class="overview-boxes">
            <div class="card-box">
                <div class="card-details">
                    <div class="number"><?= $stats['taxa_entrega'] ?>%</div>
                    <div class="card-name">Taxa de Aprovação</div>
                </div>
                <i class='bx bx-trending-up'></i>
            </div>
            <div class="card-box">
                <div class="card-details">
                    <div class="number"><?= $stats['sem_orientador'] ?></div>
                    <div class="card-name">Sem Orientador</div>
                </div>
                <i class='bx bx-user-x'></i>
            </div>
        </div>
    </div>

    <div id="tab2" class="tab-content">
        <table>
            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Documento Pendente</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pendencias as $item): ?>
                    <?php
                        // Calcula dias de atraso baseado na data de criação
                        $dataCriacao = new DateTime($item['criado_em']);
                        $hoje = new DateTime();
                        $diferenca = $hoje->diff($dataCriacao);
                        $dias = $diferenca->days;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['aluno_nome']) ?></td>
                        <td>Aprovação de Projeto</td>
                        <td style="color: var(--danger-color);">
                            Criado há <?= $dias ?> dias
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if(empty($pendencias)): ?>
                    <tr><td colspan="3" style="text-align:center;">Nenhuma pendência encontrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div id="tab3" class="tab-content">
        <p style="color: var(--secondary-text);">Logs de atividades recentes do sistema.</p>
        <ul style="margin-top: 10px; color: #ccc;">
            <?php foreach($logs as $log): ?>
                <?php 
                    $dataLog = date('d/m H:i', strtotime($log['created_at']));
                ?>
                <li style="padding: 10px; border-bottom: 1px solid #333;">
                    <small style="color: var(--secondary-text);"><?= $dataLog ?></small> - 
                    <?= htmlspecialchars($log['descricao']) ?>
                </li>
            <?php endforeach; ?>

            <?php if(empty($logs)): ?>
                <li style="padding: 10px;">Nenhum histórico registrado.</li>
            <?php endif; ?>
        </ul>
    </div>
</div>