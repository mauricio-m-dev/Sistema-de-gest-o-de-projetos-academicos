<?php
session_start();

// AJUSTE DO CAMINHO: Sai da pasta Controller (../) e entra em vendor
require_once __DIR__ . '/../vendor/autoload.php';

use Model\TccModel;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $tccModel = new TccModel();
    $action = $_POST['action'] ?? '';

    // CADASTRAR
    if ($action === 'create') {
        $dados = [
            'titulo' => $_POST['titulo'],
            'resumo' => $_POST['resumo'],
            'aluno_nome' => $_POST['aluno_nome'],
            'orientador_nome' => $_POST['orientador_nome'],
            'area_pesquisa' => $_POST['area_pesquisa'],
            'tipo_trabalho' => $_POST['tipo_trabalho']
        ];

        if ($tccModel->create($dados)) {
            $_SESSION['msg'] = "Projeto cadastrado com sucesso!";
        } else {
            $_SESSION['msg'] = "Erro ao cadastrar projeto.";
        }

        $conn = \Model\Connection::getConnection();
        $logStmt = $conn->prepare("INSERT INTO system_logs (descricao) VALUES (:desc)");
        $logStmt->execute([':desc' => "Novo projeto cadastrado: " . $_POST['titulo']]);
    }

    // EDITAR
    elseif ($action === 'update') {
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $status = $_POST['status'];

        if ($tccModel->update($id, $titulo, $status)) {
            $_SESSION['msg'] = "Projeto atualizado!";
        } else {
            $_SESSION['msg'] = "Erro ao atualizar.";
        }
    }
}

// EXCLUIR
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $tccModel = new TccModel();
    $id = $_GET['id'];

    if ($tccModel->delete($id)) {
        $_SESSION['msg'] = "Projeto excluído com sucesso!";
    } else {
        $_SESSION['msg'] = "Erro ao excluir projeto.";
    }

    // Volta para o painel
    header("Location: ../View/Coordenador/dashboard.php?page=tccs");
    exit;
}

// AJUSTE DO REDIRECIONAMENTO:
// Sai de Controller (../), entra em View/Coordenador/
header("Location: ../View/Coordenador/dashboard.php?page=tccs");
exit;
