<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use Model\BancaModel;
use Model\TccModel;

// Carrega as bancas agendadas
$bancaModel = new BancaModel();
$listaBancas = $bancaModel->getAll();

// Carrega os TCCs para preencher o Select do formulário
$tccModel = new TccModel();
$listaTccs = $tccModel->getAll(); // Pode filtrar por status 'aprovado' se quiser depois
?>

<?php if (isset($_SESSION['msg'])): ?>
    <div style="background: rgba(40,167,69,0.2); color: #28a745; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #28a745;">
        <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
    </div>
<?php endif; ?>

<div class="overview-boxes" style="grid-template-columns: 1fr 1fr 1fr;">
    <div class="card-box" style="border-left: 4px solid var(--accent-color);">
        <div class="card-details">
            <div class="number"><?= count($listaBancas) ?></div>
            <div class="card-name">Bancas Agendadas</div>
        </div>
        <i class='bx bx-calendar-event'></i>
    </div>
    <div class="card-box">
        <div class="card-details">
            <div class="number">--</div>
            <div class="card-name">Bancas esta semana</div>
        </div>
    </div>
     <div class="card-box">
        <div class="card-details">
            <div class="number">--</div>
            <div class="card-name">Aguardando Confirmação</div>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="table-header">
        <h3>Cronograma de Defesas</h3>
        <button class="btn-primary" onclick="newBanca()">
            <i class='bx bx-calendar-plus'></i> Agendar Banca
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data / Hora</th>
                <th>Aluno / Título</th>
                <th>Banca Examinadora</th>
                <th>Local</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaBancas as $banca): ?>
                <?php 
                    // Formata a data para dia/mês/ano
                    $dataFormatada = date('d/m/Y', strtotime($banca['data_defesa']));
                    $horaFormatada = date('H:i', strtotime($banca['horario']));
                ?>
                <tr>
                    <td>
                        <strong><?= $dataFormatada ?></strong><br>
                        <span style="color: var(--secondary-text);"><?= $horaFormatada ?></span>
                    </td>
                    <td>
                        <strong><?= htmlspecialchars($banca['aluno_nome']) ?></strong><br>
                        <small><?= htmlspecialchars($banca['titulo']) ?></small>
                    </td>
                    <td>
                        <span style="font-size: 12px; color: #ccc;">
                            <?= htmlspecialchars($banca['membros_banca']) ?>
                        </span>
                    </td>
                    <td><span class="status andamento"><?= htmlspecialchars($banca['local_defesa']) ?></span></td>
                    <td>
                        <button class="btn-icon btn-delete" 
                                onclick="if(confirm('Cancelar esta banca?')) window.location.href='../../Controller/BancaHandler.php?action=delete&id=<?= $banca['id'] ?>'">
                            <i class='bx bx-trash'></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>

            <?php if(empty($listaBancas)): ?>
                <tr><td colspan="5" style="text-align:center; padding: 20px;">Nenhuma banca agendada.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div id="modalNovaBanca" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('modalNovaBanca')">&times;</span>
        <div class="modal-header">
            <h3>Agendar Nova Banca</h3>
        </div>
        
        <form action="../../Controller/BancaHandler.php" method="POST" style="margin-top: 20px;">
            <input type="hidden" name="action" value="create">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Data</label>
                    <input type="date" name="data_defesa" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Horário</label>
                    <input type="time" name="horario" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Projeto / Aluno</label>
                <select name="tcc_id" class="form-control" required>
                    <option value="">Selecione o TCC...</option>
                    <?php foreach($listaTccs as $tcc): ?>
                        <option value="<?= $tcc['id'] ?>">
                            <?= htmlspecialchars($tcc['aluno_nome']) ?> - <?= htmlspecialchars($tcc['titulo']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Membros da Banca (Separar por vírgula)</label>
                <input type="text" name="membros_banca" class="form-control" placeholder="Ex: Prof. Ana, Prof. Mario..." required>
            </div>

            <div class="form-group">
                <label>Local / Link</label>
                <input type="text" name="local_defesa" class="form-control" placeholder="Sala 302 ou Link do Meet" required>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-primary">Confirmar Agendamento</button>
            </div>
        </form>
    </div>
</div>