<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Model\BancaModel;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bancaModel = new BancaModel();
    $action = $_POST['action'] ?? '';

    // AGENDAR NOVA BANCA
    if ($action === 'create') {
        $dados = [
            'tcc_id' => $_POST['tcc_id'],
            'data_defesa' => $_POST['data_defesa'],
            'horario' => $_POST['horario'],
            'local_defesa' => $_POST['local_defesa'],
            'membros_banca' => $_POST['membros_banca']
        ];

        if ($bancaModel->create($dados)) {
            $_SESSION['msg'] = "Banca agendada com sucesso!";
        } else {
            $_SESSION['msg'] = "Erro ao agendar banca.";
        }
    }
}

// EXCLUIR BANCA
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $bancaModel = new BancaModel();
    $id = $_GET['id'];

    if ($bancaModel->delete($id)) {
        $_SESSION['msg'] = "Banca cancelada/excluída!";
    } else {
        $_SESSION['msg'] = "Erro ao excluir banca.";
    }
}

header("Location: ../View/Coordenador/dashboard.php?page=bancas");
exit;