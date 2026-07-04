-- =========================================================
-- SOLUTECH - BANCO DE DADOS
-- Sistema de Diagnóstico Tecnológico com IA
-- =========================================================

CREATE DATABASE IF NOT EXISTS solutech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE solutech;

-- ---------------------------------------------------------
-- Tabela: usuarios (administradores do sistema)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,       -- password_hash()
    cargo VARCHAR(60) DEFAULT 'Administrador',
    ativo TINYINT(1) DEFAULT 1,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Usuário padrão (senha: admin123 - troque após o primeiro acesso)
-- Hash gerado com password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO usuarios (nome, email, senha, cargo) VALUES
('Administrador', 'admin@solutech.com', '$2y$10$LV7jY2fHY5Add66ODaVM0eV5XBD9K/3J5yePIqBtbLOJVog80TCrO', 'Administrador');

-- ---------------------------------------------------------
-- Tabela: clientes
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    empresa VARCHAR(150),
    email VARCHAR(150) NOT NULL,
    telefone VARCHAR(30),
    cidade VARCHAR(100),
    segmento VARCHAR(100),
    num_funcionarios VARCHAR(50),
    faturamento VARCHAR(50),
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabela: diagnosticos
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS diagnosticos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NOT NULL,
    problema TEXT NOT NULL,
    resposta_ia JSON NULL,             -- JSON completo retornado pela IA
    diagnostico TEXT,
    nivel_maturidade VARCHAR(50),
    pontuacao INT DEFAULT 0,
    solucao TEXT,
    beneficios TEXT,
    tecnologias TEXT,
    tempo VARCHAR(100),
    complexidade VARCHAR(50),
    prioridade VARCHAR(50),
    orcamento_estimado VARCHAR(100),
    recomendacoes TEXT,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Tabela: orcamentos
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS orcamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT NULL,
    diagnostico_id INT NULL,
    nome VARCHAR(150) NOT NULL,
    empresa VARCHAR(150),
    telefone VARCHAR(30),
    email VARCHAR(150),
    cidade VARCHAR(100),
    descricao TEXT,
    urgencia VARCHAR(50) DEFAULT 'Normal',
    orcamento_disponivel VARCHAR(100),
    observacoes TEXT,
    status ENUM('Novo','Em análise','Em negociação','Aprovado','Recusado','Concluído') DEFAULT 'Novo',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL,
    FOREIGN KEY (diagnostico_id) REFERENCES diagnosticos(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Índices úteis para pesquisa/relatórios
-- ---------------------------------------------------------
CREATE INDEX idx_clientes_nome ON clientes(nome);
CREATE INDEX idx_orcamentos_status ON orcamentos(status);
CREATE INDEX idx_diagnosticos_cliente ON diagnosticos(cliente_id);
