<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Model\AlunoModel;
use Model\UpdateModel;

if (session_status() === PHP_SESSION_NONE) session_start();

$alunoModel = new AlunoModel();
$updateModel = new UpdateModel();

$nomeAluno = $_SESSION['user_name'] ?? '';
$tcc = $alunoModel->getMeuTCC($nomeAluno);

// Busca o histórico se tiver TCC
$historico = $tcc ? $updateModel->getUpdatesByTcc($tcc['id']) : [];
?>

<div class="table-container" style="max-width: 800px; margin: 0 auto;">
    <div class="table-header">
        <h3>Meu TCC / Projeto</h3>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div style="background: rgba(40,167,69,0.2); color: #28a745; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #28a745;">
            <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
        </div>
    <?php endif; ?>

    <?php if ($tcc): ?>
        <form style="margin-top: 20px; border-bottom: 1px solid #333; padding-bottom: 30px;">
            <div class="form-group">
                <label>Título</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($tcc['titulo']) ?>" readonly>
            </div>
            <div class="form-group">
                <label>Status</label>
                <span class="status <?= strtolower($tcc['status']) ?>"><?= ucfirst($tcc['status']) ?></span>
            </div>
        </form>

        <div style="margin-top: 30px;">
            <h3>Nova Atualização</h3>
            <p style="color: var(--secondary-text); font-size: 14px; margin-bottom: 15px;">Envie uma nova versão do documento ou descreva seu progresso.</p>
            
            <form action="../../Controller/UpdateHandler.php" method="POST" enctype="multipart/form-data" style="background: #222; padding: 20px; border-radius: 8px;">
                <input type="hidden" name="tcc_id" value="<?= $tcc['id'] ?>">
                
                <div class="form-group">
                    <label>Descrição do Progresso</label>
                    <textarea name="descricao" rows="3" class="form-control" placeholder="Ex: Adicionado capítulo 2 e corrigido referências..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Anexar Arquivo (PDF, DOCX)</label>
                    <input type="file" name="arquivo" class="form-control">
                </div>

                <div style="text-align: right;">
                    <button type="submit" class="btn-primary"><i class='bx bx-upload'></i> Enviar Atualização</button>
                </div>
            </form>
        </div>

        <div style="margin-top: 40px;">
            <h3>Histórico de Atualizações</h3>
            
            <?php if (empty($historico)): ?>
                <p style="color: var(--secondary-text); margin-top: 10px;">Nenhuma atualização registrada ainda.</p>
            <?php else: ?>
                <div class="timeline" style="margin-top: 20px; border-left: 2px solid #333; padding-left: 20px; margin-left: 10px;">
                    <?php foreach($historico as $update): ?>
                        <div style="position: relative; margin-bottom: 30px;">
                            <div style="position: absolute; left: -26px; top: 0; width: 10px; height: 10px; background: #fff; border-radius: 50%;"></div>
                            
                            <small style="color: var(--secondary-text);">
                                <?= date('d/m/Y H:i', strtotime($update['created_at'])) ?>
                            </small>
                            
                            <p style="margin-top: 5px; color: #fff;">
                                <?= nl2br(htmlspecialchars($update['descricao'])) ?>
                            </p>

                            <?php if($update['arquivo_path']): ?>
                                <div style="margin-top: 10px;">
                                    <a href="../../uploads/<?= $update['arquivo_path'] ?>" target="_blank" style="color: #4facfe; text-decoration: underline; font-size: 14px;">
                                        <i class='bx bx-file'></i> <?= htmlspecialchars($update['arquivo_nome']) ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <p style="text-align:center; padding: 40px;">Você ainda não possui um projeto vinculado.</p>
    <?php endif; ?>
</div>