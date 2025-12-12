<?php
// Importa o Model para buscar a lista de pessoas cadastradas
use Model\TccModel;

$tccModel = new TccModel();

// Busca as listas no banco de dados
$listaAlunos = $tccModel->getUsersByType('aluno');
$listaOrientadores = $tccModel->getUsersByType('orientador');
?>

<div class="table-container" style="max-width: 800px; margin: 0 auto;">
    <div class="table-header">
        <h3>Cadastrar Novo TCC / Projeto</h3>
        <a href="?page=tccs" style="color: var(--secondary-text);">Voltar</a>
    </div>

    <form action="../../Controller/TccHandler.php" method="POST">
        
        <input type="hidden" name="action" value="create">

        <div class="form-group">
            <label>Título do Trabalho</label>
            <input type="text" name="titulo" class="form-control" required placeholder="Ex: Análise de Dados com Python">
        </div>

        <div class="form-group">
            <label>Resumo</label>
            <textarea name="resumo" rows="4" class="form-control" placeholder="Breve descrição do projeto..."></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Área / Linha de Pesquisa</label>
                <input type="text" name="area_pesquisa" class="form-control" placeholder="Ex: Inteligência Artificial">
            </div>
            <div class="form-group">
                <label>Tipo de Trabalho</label>
                <select name="tipo_trabalho" class="form-control">
                    <option value="TCC">TCC</option>
                    <option value="PIBIC">PIBIC</option>
                    <option value="Extensão">Projeto de Extensão</option>
                    <option value="Estágio">Relatório de Estágio</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            
            <div class="form-group">
                <label>Aluno Responsável</label>
                <select name="aluno_nome" class="form-control" required>
                    <option value="">Selecione um aluno...</option>
                    <?php foreach ($listaAlunos as $aluno): ?>
                        <option value="<?= htmlspecialchars($aluno['name']) ?>">
                            <?= htmlspecialchars($aluno['name']) ?>
                        </option>
                    <?php endforeach; ?>
                    
                    <?php if(empty($listaAlunos)): ?>
                        <option value="" disabled>Nenhum aluno cadastrado</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Orientador Desejado</label>
                <select name="orientador_nome" class="form-control" required>
                    <option value="">Selecione um professor...</option>
                    <?php foreach ($listaOrientadores as $prof): ?>
                        <option value="<?= htmlspecialchars($prof['name']) ?>">
                            <?= htmlspecialchars($prof['name']) ?>
                        </option>
                    <?php endforeach; ?>

                    <?php if(empty($listaOrientadores)): ?>
                        <option value="" disabled>Nenhum orientador cadastrado</option>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-top: 20px;">
            <button type="submit" class="btn-primary" style="width: 100%;">Cadastrar Projeto</button>
        </div>
    </form>
</div>