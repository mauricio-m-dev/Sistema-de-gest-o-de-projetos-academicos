<?php
namespace Model;

use PDO;

class RelatorioModel {
    private $db;

    public function __construct() {
        $this->db = Connection::getConnection();
    }

    // TAB 1: Estatísticas Gerais
    public function getEstatisticas() {
        // 1. Taxa de Aprovação (Projetos Aprovados / Total)
        $sqlTotal = "SELECT COUNT(*) as total FROM tccs";
        $sqlAprovados = "SELECT COUNT(*) as total FROM tccs WHERE status = 'aprovado'";
        
        $total = $this->db->query($sqlTotal)->fetch(PDO::FETCH_ASSOC)['total'];
        $aprovados = $this->db->query($sqlAprovados)->fetch(PDO::FETCH_ASSOC)['total'];

        // Evita divisão por zero
        $taxa = ($total > 0) ? round(($aprovados / $total) * 100) : 0;

        // 2. Alunos sem orientador (considerando NULL, vazio ou "Indefinido")
        $sqlSemOrientador = "SELECT COUNT(*) as total FROM tccs 
                             WHERE orientador_nome IS NULL 
                             OR orientador_nome = '' 
                             OR orientador_nome LIKE '%Indefinido%'";
        $semOrientador = $this->db->query($sqlSemOrientador)->fetch(PDO::FETCH_ASSOC)['total'];

        return [
            'taxa_entrega' => $taxa,
            'sem_orientador' => $semOrientador
        ];
    }

    // TAB 2: Pendências (Alunos com status 'pendente')
    public function getPendencias() {
        // Vamos considerar que se o status é 'pendente', a "Aprovação de Projeto" está atrasada
        $sql = "SELECT aluno_nome, criado_em 
                FROM tccs 
                WHERE status = 'pendente' 
                ORDER BY criado_em ASC";
        
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // TAB 3: Histórico (Logs do Sistema)
    public function getLogs() {
        $sql = "SELECT descricao, created_at FROM system_logs ORDER BY created_at DESC LIMIT 10";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}