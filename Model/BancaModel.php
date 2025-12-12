<?php
namespace Model;

use PDO;

class BancaModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    // Busca bancas misturando com dados da tabela de TCCs (Nome do aluno e Título)
    public function getAll() {
        $sql = "SELECT b.*, t.titulo, t.aluno_nome, t.orientador_nome 
                FROM bancas b
                INNER JOIN tccs t ON b.tcc_id = t.id
                ORDER BY b.data_defesa ASC, b.horario ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($dados) {
        $sql = "INSERT INTO bancas (tcc_id, data_defesa, horario, local_defesa, membros_banca) 
                VALUES (:tcc_id, :data_defesa, :horario, :local_defesa, :membros_banca)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':tcc_id' => $dados['tcc_id'],
            ':data_defesa' => $dados['data_defesa'],
            ':horario' => $dados['horario'],
            ':local_defesa' => $dados['local_defesa'],
            ':membros_banca' => $dados['membros_banca']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM bancas WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}