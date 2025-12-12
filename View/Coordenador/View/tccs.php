<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Model\TccModel;
use Model\UpdateModel; // <--- IMPORTANTE: Model de Updates

$tccModel = new TccModel();
$updateModel = new UpdateModel(); // <--- Instância

$listaTccs = $tccModel->getAll();
?>

<?php if (isset($_SESSION['msg'])): ?>
    <div
        style="background: rgba(40,167,69,0.2); color: #28a745; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #28a745;">
        <?= $_SESSION['msg'];
        unset($_SESSION['msg']); ?>
    </div>
<?php endif; ?>

<div class="table-container">
    <div class="table-header">
        <h3>Gerenciar TCCs e Projetos</h3>
        <button class="btn-primary" onclick="newTCC()">
            <i class='bx bx-plus'></i> Novo Projeto
        </button>
    </div>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Aluno</th>
                <th>Status</th>
                <th>Updates</th>
                <th style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaTccs as $tcc): ?>
                <?php
                // Busca o histórico deste TCC específico
                $historico = $updateModel->getUpdatesByTcc($tcc['id']);
                $qtdUpdates = count($historico);
                ?>
                <tr>
                    <td><?= htmlspecialchars($tcc['titulo']) ?></td>
                    <td><?= htmlspecialchars($tcc['aluno_nome']) ?></td>
                    <td>
                        <span class="status <?= strtolower($tcc['status']) ?>">
                            <?= ucfirst($tcc['status']) ?>
                        </span>
                    </td>
                    <td>
                        <span
                            style="background: #333; padding: 4px 8px; border-radius: 12px; font-size: 12px; font-weight: bold;">
                            <i class='bx bx-git-branch'></i> <?= $qtdUpdates ?>
                        </span>
                    </td>
                    <td style="text-align: center;">

                        <button class="btn-icon btn-view" onclick="openHistoryModal(<?= $tcc['id'] ?>)"
                            title="Ver Histórico e Arquivos" style="color: #4facfe; border-color: #4facfe;">
                            <i class='bx bx-history'></i>
                        </button>

                        <button class="btn-icon btn-view" onclick="viewTCC(this)"
                            data-titulo="<?= htmlspecialchars($tcc['titulo']) ?>"
                            data-aluno="<?= htmlspecialchars($tcc['aluno_nome']) ?>"
                            data-orientador="<?= htmlspecialchars($tcc['orientador_nome']) ?>"
                            data-status="<?= $tcc['status'] ?>" data-area="<?= htmlspecialchars($tcc['area_pesquisa']) ?>"
                            data-resumo="<?= htmlspecialchars($tcc['resumo']) ?>" title="Ver Detalhes">
                            <i class='bx bx-show'></i>
                        </button>

                        <button class="btn-icon btn-edit" onclick="editTCC(this)" data-id="<?= $tcc['id'] ?>"
                            data-titulo="<?= htmlspecialchars($tcc['titulo']) ?>" data-status="<?= $tcc['status'] ?>"
                            title="Editar">
                            <i class='bx bx-edit'></i>
                        </button>

                        <button class="btn-icon btn-delete" onclick="confirmDelete(<?= $tcc['id'] ?>)" title="Excluir">
                            <i class='bx bx-trash'></i>
                        </button>
                    </td>
                </tr>

                <div id="history-content-<?= $tcc['id'] ?>" style="display: none;">
                    <?php if (empty($historico)): ?>
                        <div style="text-align: center; padding: 20px; color: #999;">
                            <i class='bx bx-ghost' style="font-size: 30px;"></i>
                            <p>Nenhuma atualização enviada pelo aluno ainda.</p>
                        </div>
                    <?php else: ?>
                        <div class="timeline" style="border-left: 2px solid #444; padding-left: 20px; margin-left: 10px;">
                            <?php foreach ($historico as $update): ?>
                                <div style="margin-bottom: 25px; position: relative;">
                                    <div
                                        style="width: 12px; height: 12px; background: #fff; border-radius: 50%; position: absolute; left: -27px; top: 2px; border: 2px solid #111;">
                                    </div>

                                    <small style="color: #888; font-size: 12px;">
                                        <?= date('d/m/Y \à\s H:i', strtotime($update['created_at'])) ?>
                                    </small>

                                    <p style="margin: 5px 0; color: #fff; font-size: 14px; line-height: 1.4;">
                                        <?= nl2br(htmlspecialchars($update['descricao'])) ?>
                                    </p>

                                    <?php if (!empty($update['arquivo_path'])): ?>
                                        <div style="margin-top: 8px;">
                                            <a href="<?= defined('BASE_URL') ? BASE_URL : '../../' ?>uploads/<?= $update['arquivo_path'] ?>"
                                                target="_blank"
                                                style="display: inline-flex; align-items: center; gap: 5px; background: #222; padding: 5px 10px; border-radius: 5px; color: #4facfe; text-decoration: none; font-size: 13px; border: 1px solid #333;">
                                                <i class='bx bx-download'></i>
                                                <?= htmlspecialchars($update['arquivo_nome']) ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>

            <?php if (empty($listaTccs)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Nenhum projeto cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div id="modalHistory" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close-modal" onclick="closeModal('modalHistory')">&times;</span>
        <div class="modal-header">
            <h3><i class='bx bx-git-branch'></i> Histórico de Atualizações</h3>
        </div>
        <div id="modalHistoryBody" style="margin-top: 20px; max-height: 500px; overflow-y: auto;">
        </div>
    </div>
</div>

<div id="modalNovoTCC" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('modalNovoTCC')">&times;</span>
        <div class="modal-header">
            <h3>Cadastrar Novo Projeto</h3>
        </div>
        <form action="../../Controller/TccHandler.php" method="POST" style="margin-top: 20px;">
            <input type="hidden" name="action" value="create">
            <div class="form-group">
                <label>Título</label><input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Resumo</label><textarea name="resumo" rows="3" class="form-control"></textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Aluno</label>
                    <select name="aluno_nome" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($listaAlunos as $aluno): ?>
                            <option value="<?= htmlspecialchars($aluno['name']) ?>"><?= htmlspecialchars($aluno['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Orientador</label>
                    <select name="orientador_nome" class="form-control" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($listaOrientadores as $prof): ?>
                            <option value="<?= htmlspecialchars($prof['name']) ?>"><?= htmlspecialchars($prof['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group"><label>Área</label><input type="text" name="area_pesquisa" class="form-control">
                </div>
                <div class="form-group">
                    <label>Tipo</label>
                    <select name="tipo_trabalho" class="form-control">
                        <option value="TCC">TCC</option>
                        <option value="PIBIC">PIBIC</option>
                        <option value="Extensão">Extensão</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn-primary">Salvar Projeto</button></div>
        </form>
    </div>
</div>

<div id="modalVisualizar" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('modalVisualizar')">&times;</span>
        <div class="modal-header">
            <h3>Detalhes do Projeto</h3>
        </div>
        <div style="margin-top: 20px;">
            <h4 id="viewTitulo" style="color: var(--accent-color); margin-bottom: 5px;">-</h4>
            <p style="font-size: 14px; margin-bottom: 20px;"><span id="viewStatus" class="status">Status</span></p>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div><label style="color: #aaa; font-size: 12px;">Aluno</label>
                    <p id="viewAluno" style="font-weight: 500;">-</p>
                </div>
                <div><label style="color: #aaa; font-size: 12px;">Orientador</label>
                    <p id="viewOrientador" style="font-weight: 500;">-</p>
                </div>
            </div>
            <div class="form-group"><label>Área</label>
                <p id="viewArea" class="form-control" style="border: none; background: #222;">-</p>
            </div>
            <div class="form-group"><label>Resumo</label>
                <p id="viewResumo"
                    style="font-size: 14px; line-height: 1.6; color: #ddd; background: #222; padding: 10px; border-radius: 6px;">
                    -</p>
            </div>
        </div>
    </div>
</div>

<div id="modalEditar" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal('modalEditar')">&times;</span>
        <div class="modal-header">
            <h3>Editar Projeto</h3>
        </div>
        <form action="../../Controller/TccHandler.php" method="POST" style="margin-top: 20px;">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" id="editId">
            <div class="form-group"><label>Título</label><input type="text" name="titulo" id="editTitulo"
                    class="form-control"></div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="editStatus" class="form-control">
                    <option value="pendente">Pendente</option>
                    <option value="andamento">Em Andamento</option>
                    <option value="aprovado">Aprovado</option>
                    <option value="rejeitado">Rejeitado</option>
                </select>
            </div>
            <div class="modal-footer"><button type="submit" class="btn-primary">Salvar Alterações</button></div>
        </form>
    </div>
</div>

<script>
    // --- LÓGICA DO HISTÓRICO ---
    function openHistoryModal(id) {
        // Pega o HTML oculto específico daquele ID
        var content = document.getElementById('history-content-' + id).innerHTML;
        // Joga dentro do corpo do modal de histórico
        document.getElementById('modalHistoryBody').innerHTML = content;
        // Abre o modal
        openModal('modalHistory');
    }

    // --- FUNÇÕES CRUD EXISTENTES ---
    function newTCC() {
        const form = document.querySelector('#modalNovoTCC form');
        if (form) form.reset();
        openModal('modalNovoTCC');
    }

    function editTCC(element) {
        document.getElementById('editId').value = element.getAttribute('data-id');
        document.getElementById('editTitulo').value = element.getAttribute('data-titulo');
        document.getElementById('editStatus').value = element.getAttribute('data-status');
        openModal('modalEditar');
    }

    function viewTCC(element) {
        document.getElementById('viewTitulo').innerText = element.getAttribute('data-titulo');
        document.getElementById('viewAluno').innerText = element.getAttribute('data-aluno');
        document.getElementById('viewOrientador').innerText = element.getAttribute('data-orientador');
        document.getElementById('viewArea').innerText = element.getAttribute('data-area');
        document.getElementById('viewResumo').innerText = element.getAttribute('data-resumo');

        const status = element.getAttribute('data-status');
        const statusBadge = document.getElementById('viewStatus');
        statusBadge.innerText = status;
        statusBadge.className = 'status ' + status;

        openModal('modalVisualizar');
    }

    // --- UTILITÁRIOS MODAL ---
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = "block";
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = "none";
    }

    function confirmDelete(id) {
        if (confirm("Tem certeza que deseja excluir este projeto?")) {
            window.location.href = '../../Controller/TccHandler.php?action=delete&id=' + id;
        }
    }

    window.onclick = function (event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = "none";
        }
    }
</script>