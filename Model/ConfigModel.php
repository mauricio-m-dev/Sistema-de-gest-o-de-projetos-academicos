<?php
namespace Model;

use PDO;

class ConfigModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    // --- CONFIGURAÇÕES DO SISTEMA ---
    
    public function getSettings() {
        // Pega a linha de ID 1 (configuração única)
        $stmt = $this->db->query("SELECT * FROM system_settings WHERE id = 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveSettings($dados) {
        $sql = "UPDATE system_settings SET 
                semestre_ativo = :semestre,
                inicio_submissao = :inicio,
                fim_submissao = :fim,
                notif_email = :email,
                notif_aluno = :aluno
                WHERE id = 1";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':semestre' => $dados['semestre'],
            ':inicio'   => $dados['inicio'],
            ':fim'      => $dados['fim'],
            ':email'    => $dados['notif_email'],
            ':aluno'    => $dados['notif_aluno']
        ]);
    }

    // --- CADASTRO DE USUÁRIOS (NOVA FUNÇÃO) ---

    public function createUser($name, $email, $password, $type) {
        // Verifica se email já existe
        $check = $this->db->prepare("SELECT id FROM user WHERE email = :email");
        $check->execute([':email' => $email]);
        if ($check->rowCount() > 0) {
            return false; // Email já cadastrado
        }

        // Criptografa a senha
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Insere na tabela 'user' (a mesma do login)
        $sql = "INSERT INTO user (name, email, password, userType) VALUES (:name, :email, :pass, :type)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            ':name'  => $name,
            ':email' => $email,
            ':pass'  => $hash,
            ':type'  => $type
        ]);
    }
}