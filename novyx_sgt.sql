-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/12/2025 às 20:30
-- Versão do servidor: 11.3.0-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `novyx_sgt`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `bancas`
--

CREATE TABLE `bancas` (
  `id` int(11) NOT NULL,
  `tcc_id` int(11) NOT NULL,
  `data_defesa` date NOT NULL,
  `horario` time NOT NULL,
  `local_defesa` varchar(100) NOT NULL,
  `membros_banca` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL DEFAULT 1,
  `semestre_ativo` varchar(10) DEFAULT '2025.1',
  `inicio_submissao` date DEFAULT NULL,
  `fim_submissao` date DEFAULT NULL,
  `notif_email` tinyint(1) DEFAULT 1,
  `notif_aluno` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tccs`
--

CREATE TABLE `tccs` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resumo` text DEFAULT NULL,
  `aluno_nome` varchar(150) NOT NULL,
  `orientador_nome` varchar(150) DEFAULT NULL,
  `area_pesquisa` varchar(100) DEFAULT NULL,
  `curso` varchar(100) DEFAULT 'Ciência da Computação',
  `tipo_trabalho` varchar(50) DEFAULT 'TCC',
  `status` enum('pendente','andamento','aprovado','rejeitado') DEFAULT 'pendente',
  `criado_em` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `userType` enum('aluno','orientador','coordenador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `bancas`
--
ALTER TABLE `bancas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tcc_id` (`tcc_id`);

--
-- Índices de tabela `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tccs`
--
ALTER TABLE `tccs`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bancas`
--
ALTER TABLE `bancas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tccs`
--
ALTER TABLE `tccs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `bancas`
--
ALTER TABLE `bancas`
  ADD CONSTRAINT `bancas_ibfk_1` FOREIGN KEY (`tcc_id`) REFERENCES `tccs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
