<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Model\AlunoModel;
$alunoModel = new AlunoModel();
$tcc = $alunoModel->getMeuTCC($_SESSION['user_name']);
$banca = null;

if ($tcc) {
    $banca = $alunoModel->getMinhaBanca($tcc['id']);
}
?>

<div class="table-container">
    <div class="table-header">
        <h3>Informações da Banca Examinadora</h3>
    </div>

    <?php if ($banca): ?>
        <?php 
            $data = date('d/m/Y', strtotime($banca['data_defesa']));
            $hora = date('H:i', strtotime($banca['horario']));
        ?>
        
        <div class="overview-boxes" style="margin-top: 0;">
            <div class="card-box" style="border-left: 4px solid var(--accent-color);">
                <div class="card-details">
                    <div class="card-name">Data da Defesa</div>
                    <div class="number"><?= $data ?></div>
                </div>
                <i class='bx bx-calendar'></i>
            </div>
            
            <div class="card-box">
                <div class="card-details">
                    <div class="card-name">Horário</div>
                    <div class="number"><?= $hora ?></div>
                </div>
                <i class='bx bx-time'></i>
            </div>
            
            <div class="card-box">
                <div class="card-details">
                    <div class="card-name">Local</div>
                    <div class="number" style="font-size: 18px;"><?= htmlspecialchars($banca['local_defesa']) ?></div>
                </div>
                <i class='bx bx-map'></i>
            </div>
        </div>

        <div style="margin-top: 30px; background: #222; padding: 20px; border-radius: 8px;">
            <h4 style="margin-bottom: 10px; color: var(--secondary-text);">Membros da Banca</h4>
            <p style="font-size: 16px; line-height: 1.6;">
                <?= htmlspecialchars($banca['membros_banca']) ?>
            </p>
        </div>

    <?php elseif ($tcc): ?>
        <div style="padding: 30px; text-align: center;">
            <p>Sua banca ainda não foi agendada pela coordenação.</p>
        </div>
    <?php else: ?>
        <div style="padding: 30px; text-align: center;">
            <p>Você precisa ter um TCC cadastrado para visualizar a banca.</p>
        </div>
    <?php endif; ?>
</div>