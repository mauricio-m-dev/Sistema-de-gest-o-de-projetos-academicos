# 🎓 NOVYX SGT - Sistema de Gestão de Trabalhos Acadêmicos

![Status](https://img.shields.io/badge/Status-Funcional-brightgreen)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)
![Database](https://img.shields.io/badge/MySQL-MariaDB-orange)

## 📄 Sobre o Projeto

O **Novyx SGT** é uma plataforma web desenvolvida para otimizar o gerenciamento de Trabalhos de Conclusão de Curso (TCC), projetos de iniciação científica (PIBIC) e extensão. O sistema centraliza a comunicação e o fluxo de trabalho entre **Alunos**, **Orientadores** e **Coordenadores**.

### 🌟 Funcionalidades Principais
* **Hierarquia de Acesso:** Painéis distintos para Coordenador, Orientador e Aluno.
* **Gestão de Projetos:** Cadastro de TCCs, definição de orientadores e controle de status (Pendente, Em Andamento, Aprovado, Rejeitado).
* **Versionamento (Timeline):** O aluno pode enviar atualizações de arquivos e descrições (estilo GitHub), criando um histórico completo de progresso visualizável pelo coordenador.
* **Agendamento de Bancas:** Organização de datas, horários e membros da banca, com vínculo automático aos projetos.
* **Relatórios Inteligentes:** Gráficos de estatísticas, lista de pendências e logs de atividades do sistema.
* **Configurações Gerais:** Definição de prazos de submissão e semestres letivos.

---

## 💻 Requisitos do Ambiente

Para rodar o projeto, você precisará de:

* **Servidor Web:** Apache (XAMPP, WAMP ou Laragon).
* **Linguagem:** PHP 8.0 ou superior.
* **Banco de Dados:** MySQL ou MariaDB.
* **Gerenciador de Dependências:** Composer.

---

## 🚀 Instalação Passo a Passo

### 1. Clonar e Configurar Pastas
Coloque os arquivos do projeto na pasta pública do seu servidor (ex: `htdocs`).
Crie uma pasta chamada `uploads` na raiz do projeto para salvar os arquivos dos alunos.

```bash
mkdir uploads
````

### 2\. Configurar o Autoload (Composer)

Abra o terminal na raiz do projeto e execute:

```bash
composer dump-autoload
```

*Isso garante que as pastas `Model` e `Controller` sejam reconhecidas.*

### 3\. Configurar o Banco de Dados

1.  Abra o seu gerenciador SQL (phpMyAdmin).
2.  Crie um banco de dados chamado: `novyx_sgt`.
3.  Copie e execute o **Script SQL** fornecido abaixo na aba "SQL".

### 4\. Configurar Conexão e URL

Edite o arquivo `Config/Configuration.php` (ou `Configuration.php` na raiz):

```php
define("DB_NAME", "novyx_sgt");
define("DB_USER", "root");
define("DB_PASSWORD", ""); // Sua senha
define("BASE_URL", "http://localhost/NomeDaSuaPasta/"); // <-- IMPORTANTE: Com a barra no final
```

-----

## 🗄️ Banco de Dados (Script SQL)

Copie todo o código abaixo e execute no seu banco de dados para criar a estrutura completa e um usuário administrador inicial.

```sql
SET FOREIGN_KEY_CHECKS = 0;

-- 1. TABELA DE USUÁRIOS
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `userType` enum('aluno','orientador','coordenador') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. TABELA DE TCCS / PROJETOS
CREATE TABLE IF NOT EXISTS `tccs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `resumo` text DEFAULT NULL,
  `aluno_nome` varchar(150) NOT NULL,
  `orientador_nome` varchar(150) DEFAULT NULL,
  `area_pesquisa` varchar(100) DEFAULT NULL,
  `tipo_trabalho` varchar(50) DEFAULT 'TCC',
  `status` enum('pendente','andamento','aprovado','rejeitado') DEFAULT 'pendente',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. TABELA DE BANCAS (Relacionada ao TCC)
CREATE TABLE IF NOT EXISTS `bancas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tcc_id` int(11) NOT NULL,
  `data_defesa` date NOT NULL,
  `horario` time NOT NULL,
  `local_defesa` varchar(100) NOT NULL,
  `membros_banca` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tcc_id` (`tcc_id`),
  CONSTRAINT `bancas_ibfk_1` FOREIGN KEY (`tcc_id`) REFERENCES `tccs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. TABELA DE ATUALIZAÇÕES/VERSIONAMENTO (Histórico de Arquivos)
CREATE TABLE IF NOT EXISTS `project_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tcc_id` int(11) NOT NULL,
  `descricao` text DEFAULT NULL,
  `arquivo_nome` varchar(255) DEFAULT NULL,
  `arquivo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `tcc_id` (`tcc_id`),
  CONSTRAINT `updates_ibfk_1` FOREIGN KEY (`tcc_id`) REFERENCES `tccs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. TABELA DE LOGS DO SISTEMA
CREATE TABLE IF NOT EXISTS `system_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. TABELA DE CONFIGURAÇÕES GERAIS
CREATE TABLE IF NOT EXISTS `system_settings` (
  `id` int(11) NOT NULL DEFAULT 1,
  `semestre_ativo` varchar(10) DEFAULT '2025.1',
  `inicio_submissao` date DEFAULT NULL,
  `fim_submissao` date DEFAULT NULL,
  `notif_email` tinyint(1) DEFAULT 1,
  `notif_aluno` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- INSERIR USUÁRIO ADMINISTRADOR (Senha: 123456)
INSERT INTO `user` (`name`, `email`, `password`, `userType`) VALUES
('Coordenador Geral', 'coord@novyx.com', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1nQ.S.y', 'coordenador');

-- INSERIR CONFIGURAÇÃO PADRÃO
INSERT INTO `system_settings` (`id`, `semestre_ativo`, `inicio_submissao`, `fim_submissao`) 
VALUES (1, '2025.1', '2025-02-01', '2025-06-30')
ON DUPLICATE KEY UPDATE id=1;

SET FOREIGN_KEY_CHECKS = 1;
```

## 🔑 Acesso de Teste

Após importar o banco de dados, utilize as seguintes credenciais para acessar o painel administrativo:

  * **E-mail:** `coord@novyx.com`
  * **Senha:** `123456`
  * **Perfil:** Selecione **"Coord."** na tela de login.

-----

Desenvolvido para fins acadêmicos - **Novyx SGT**

```
```