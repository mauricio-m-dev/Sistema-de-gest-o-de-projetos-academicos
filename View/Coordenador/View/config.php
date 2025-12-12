<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Model\ConfigModel;

$configModel = new ConfigModel();
$settings = $configModel->getSettings(); // Busca dados do banco
?>

<?php if (isset($_SESSION['msg'])): ?>
    <div style="background: rgba(40,167,69,0.2); color: #28a745; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #28a745; text-align: center;">
        <?= $_SESSION['msg'];
        unset($_SESSION['msg']); ?>
    </div>
<?php endif; ?>

<div style="margin-top: 50px;"></div>

<div class="table-container" style="max-width: 800px; margin: 0 auto;">
    <div class="table-header">
        <h3>Cadastrar Novo Usuário</h3>
    </div>

    <form action="../../Controller/ConfigHandler.php" method="POST">
        <input type="hidden" name="action" value="register_user">

        <p style="color: var(--secondary-text); margin-bottom: 20px;">Crie contas de acesso para alunos ou novos professores orientadores.</p>

        <div class="form-group">
            <label>Nome Completo</label>
            <input type="text" name="name" class="form-control" required placeholder="Ex: Maria Silva">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>E-mail (Login)</label>
                <input type="email" name="email" class="form-control" required placeholder="usuario@instituicao.edu">
            </div>
            <div class="form-group">
                <label>Tipo de Usuário</label>
                <select name="userType" class="form-control">
                    <option value="aluno">Aluno</option>
                    <option value="orientador">Orientador</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Senha Provisória</label>
            <input type="password" name="password" class="form-control" required placeholder="Mínimo 6 caracteres">
        </div>

        <div style="margin-top: 20px; text-align: right;">
            <button type="submit" class="btn-primary">
                <i class='bx bx-user-plus'></i> Criar Conta
            </button>
        </div>
    </form>
</div>