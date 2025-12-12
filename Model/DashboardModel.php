<?php
namespace Model;

use PDO;

class DashboardModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    // Busca os totais para os Cards do topo
    public function getEstatísticas() {
        // Usamos SUM(CASE...) para contar condicionalmente em uma única ida ao banco
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'pendente' THEN 1 ELSE 0 END) as pendentes,
                    SUM(CASE WHEN status = 'aprovado' THEN 1 ELSE 0 END) as aprovados,
                    SUM(CASE WHEN status = 'rejeitado' THEN 1 ELSE 0 END) as rejeitados
                FROM tccs";
        
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se a tabela estiver vazia, retorna 0 em tudo para não dar erro
        return $result ?: ['total' => 0, 'pendentes' => 0, 'aprovados' => 0, 'rejeitados' => 0];
    }

    // Busca os 5 últimos projetos modificados ou criados
    public function getUltimasAtualizacoes() {
        $sql = "SELECT titulo, aluno_nome, status, criado_em 
                FROM tccs 
                ORDER BY criado_em DESC 
                LIMIT 5";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}