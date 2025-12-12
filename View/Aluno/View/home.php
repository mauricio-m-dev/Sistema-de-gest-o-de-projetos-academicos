<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Model\AlunoModel;

$alunoModel = new AlunoModel();
// Busca TCC pelo nome salvo na sessão (conforme lógica do seu banco atual)
$meuTcc = $alunoModel->getMeuTCC($_SESSION['user_name']);
?>

<div class="overview-boxes">
    <div class="card-box">
        <div class="card-details">
            <div class="card-name">Situação do Projeto</div>
            <div class="number" style="font-size: 20px; margin-top: 5px;">
                <?php
                if ($meuTcc) {
                    echo ucfirst($meuTcc['status']);
                } else {
                    echo "Não cadastrado";
                }
                ?>
            </div>
        </div>
        <i class='bx bx-file'></i>
    </div>

    <div class="card-box">
        <div class="card-details">
            <div class="card-name">Orientador</div>
            <div class="number" style="font-size: 18px; margin-top: 5px;">
                <?= $meuTcc['orientador_nome'] ?? 'Pendente' ?>
            </div>
        </div>
        <i class='bx bx-user-voice'></i>
    </div>
</div>

<div class="table-container" style="margin-top: 20px;">
    <div class="table-header">
        <h3>Avisos Importantes</h3>
    </div>
    <div style="padding: 20px; color: #ccc;">
        <?php if (!$meuTcc): ?>
            <p style="color: var(--warning-color);">⚠ Você ainda não possui um projeto cadastrado. Entre em contato com seu
                orientador ou coordenador.</p>
        <?php else: ?>
            <?php if ($meuTcc['status'] == 'pendente'): ?>
                <p> seu projeto está <strong>Pendente</strong>. Aguarde a aprovação do coordenador.</p>
            <?php elseif ($meuTcc['status'] == 'aprovado'): ?>
                <p style="color: var(--success-color);">✔ Seu projeto foi <strong>Aprovado</strong>! Verifique a aba "Minha
                    Banca" para datas de defesa.</p>
            <?php elseif ($meuTcc['status'] == 'rejeitado'): ?>
                <p style="color: var(--danger-color);">✖ Seu projeto foi <strong>Rejeitado</strong>. Verifique as correções
                    necessárias.</p>
            <?php else: ?>
                <p>Trabalho em andamento. Mantenha seus envios em dia.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>