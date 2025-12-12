<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Model\ConfigModel;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $configModel = new ConfigModel();
    $action = $_POST['action'] ?? '';

    // === SALVAR CONFIGURAÇÕES ===
    if ($action === 'save_settings') {
        $dados = [
            'semestre'    => $_POST['semestre_ativo'],
            'inicio'      => $_POST['inicio_submissao'],
            'fim'         => $_POST['fim_submissao'],
            'notif_email' => isset($_POST['notif_email']) ? 1 : 0, // Checkbox retorna 'on' ou nada
            'notif_aluno' => isset($_POST['notif_aluno']) ? 1 : 0
        ];

        if ($configModel->saveSettings($dados)) {
            $_SESSION['msg'] = "Configurações salvas com sucesso!";
        } else {
            $_SESSION['msg'] = "Erro ao salvar configurações.";
        }
    }

    // === CADASTRAR NOVO USUÁRIO ===
    elseif ($action === 'register_user') {
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $password = $_POST['password'];
        $type     = $_POST['userType']; // 'aluno' ou 'orientador'

        if ($configModel->createUser($name, $email, $password, $type)) {
            $_SESSION['msg'] = "Usuário cadastrado com sucesso!";
        } else {
            $_SESSION['msg'] = "Erro: E-mail já cadastrado ou falha no sistema.";
        }
    }
}

// Redireciona de volta
header("Location: ../View/Coordenador/dashboard.php?page=config");
exit;