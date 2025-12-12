<?php
namespace Model;

use PDO;

class AlunoModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    // Busca o TCC baseado no nome do aluno (Logado na sessão)
    public function getMeuTCC($nomeAluno) {
        $sql = "SELECT * FROM tccs WHERE aluno_nome = :nome LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':nome' => $nomeAluno]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Busca a banca vinculada ao ID do TCC
    public function getMinhaBanca($tccId) {
        $sql = "SELECT * FROM bancas WHERE tcc_id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $tccId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}