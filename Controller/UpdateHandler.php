<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

use Model\UpdateModel;

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $tccId = $_POST['tcc_id'];
    $descricao = $_POST['descricao'];
    $arquivo = $_FILES['arquivo'];

    // Configuração de Upload
    $uploadDir = __DIR__ . '/../uploads/'; 
    
    // Verificação de segurança: Cria a pasta se não existir
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = null;
    $filePath = null;

    // Se houve envio de arquivo
    if ($arquivo['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        // Gera nome único para não sobrescrever: ID_TCC + TIMESTAMP + EXT
        $novoNome = "TCC_" . $tccId . "_" . time() . "." . $extensao;
        
        if (move_uploaded_file($arquivo['tmp_name'], $uploadDir . $novoNome)) {
            $fileName = $arquivo['name']; // Nome original para exibição
            $filePath = $novoNome;       // Nome salvo
        } else {
            $_SESSION['msg'] = "Erro ao salvar o arquivo no servidor.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    // Salva no Banco
    $updateModel = new UpdateModel();
    if ($updateModel->addUpdate($tccId, $descricao, $fileName, $filePath)) {
        $_SESSION['msg'] = "Atualização enviada com sucesso!";
    } else {
        $_SESSION['msg'] = "Erro ao registrar atualização.";
    }

    // Volta para a página anterior
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}