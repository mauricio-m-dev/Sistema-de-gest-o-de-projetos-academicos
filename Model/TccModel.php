<?php
namespace Model;

use PDO;

class TccModel {
    private $db;

    public function __construct() {
        // Garanta que Connection.php existe na pasta Model
        $this->db = Connection::getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM tccs ORDER BY criado_em DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($dados) {
        $sql = "INSERT INTO tccs (titulo, resumo, aluno_nome, orientador_nome, area_pesquisa, tipo_trabalho, status) 
                VALUES (:titulo, :resumo, :aluno_nome, :orientador_nome, :area_pesquisa, :tipo_trabalho, 'pendente')";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo' => $dados['titulo'],
            ':resumo' => $dados['resumo'],
            ':aluno_nome' => $dados['aluno_nome'],
            ':orientador_nome' => $dados['orientador_nome'],
            ':area_pesquisa' => $dados['area_pesquisa'],
            ':tipo_trabalho' => $dados['tipo_trabalho']
        ]);
    }

    public function update($id, $titulo, $status) {
        $stmt = $this->db->prepare("UPDATE tccs SET titulo = :titulo, status = :status WHERE id = :id");
        return $stmt->execute([':titulo' => $titulo, ':status' => $status, ':id' => $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM tccs WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getUsersByType($tipo) {
        $sql = "SELECT name FROM user WHERE userType = :tipo ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':tipo' => $tipo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}