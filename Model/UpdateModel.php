<?php
namespace Model;

use PDO;

class UpdateModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    // Cria uma nova atualização (Commit)
    public function addUpdate($tccId, $descricao, $arquivoNome, $arquivoPath) {
        $sql = "INSERT INTO project_updates (tcc_id, descricao, arquivo_nome, arquivo_path) 
                VALUES (:tcc_id, :desc, :nome, :path)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':tcc_id' => $tccId,
            ':desc'   => $descricao,
            ':nome'   => $arquivoNome,
            ':path'   => $arquivoPath
        ]);
    }

    // Busca todo o histórico de um TCC
    public function getUpdatesByTcc($tccId) {
        $sql = "SELECT * FROM project_updates WHERE tcc_id = :id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $tccId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Conta quantas atualizações existem (Para o dashboard do coordenador)
    public function countUpdates($tccId) {
        $sql = "SELECT COUNT(*) as total FROM project_updates WHERE tcc_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $tccId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}