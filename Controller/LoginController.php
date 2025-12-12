<?php

namespace Controller;

use Model\LoginModel;

class LoginController
{

    private $LoginModel;

    public function __construct()
    {
        $this->LoginModel = new LoginModel();
    }

    public function authUser($email, $password, $userTypeForm)
    {
        // Limpeza extra por segurança
        $email = trim($email);

        // 1. Busca usuário
        $user = $this->LoginModel->findByEmail($email);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Verifica se o tipo no banco bate com o selecionado no form
        if ($user['userType'] !== $userTypeForm) {
            return false;
        }

        // Cria Sessão
        if (session_status() === PHP_SESSION_NONE) session_start();

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['userType'] = $user['userType']; 
        $_SESSION['logged_in'] = true;

        return true;
    }
}
