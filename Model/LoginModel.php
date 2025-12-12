<?php

namespace Model;

use PDO;

class LoginModel
{
    private $db;

    public function __construct()
    {
        // Garante que a conexão existe
        $this->db = Connection::getConnection();
    }

    public function findByEmail($email)
    {
        $query = "SELECT id, name, email, password, userType 
                  FROM `user` 
                  WHERE email = :email 
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
