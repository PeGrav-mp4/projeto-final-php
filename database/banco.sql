-- =============================================
-- Gerenciador de Tarefas Colaborativo
-- Script de criação do banco de dados
-- =============================================

-- Cria o banco de dados caso não exista
CREATE DATABASE IF NOT EXISTS gerenciador_tarefas;
USE gerenciador_tarefas;

-- Tabela de Usuários: armazena os membros da equipe
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,       -- Identificador único do usuário
    nome VARCHAR(100) NOT NULL,              -- Nome completo
    cpf VARCHAR(14) UNIQUE NOT NULL,         -- CPF do usuário para validação e recuperação de senha
    data_nascimento DATE NOT NULL,           -- Data de nascimento para validação e recuperação de senha
    email VARCHAR(100) UNIQUE NOT NULL,      -- E-mail único (usado no login)
    senha VARCHAR(255) NOT NULL              -- Senha criptografada com password_hash()
);

-- Tabela de Tarefas: armazena as atividades do sistema
CREATE TABLE tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,                                      -- Identificador único da tarefa
    titulo VARCHAR(255) NOT NULL,                                           -- Título da tarefa
    descricao TEXT,                                                         -- Descrição detalhada
    data_limite DATE,                                                       -- Prazo de entrega
    status ENUM('pendente','andamento','concluida') DEFAULT 'pendente',     -- Status com valores fixos (ENUM)
    usuario_id INT NOT NULL,                                                -- FK: responsável pela tarefa
    criado_por INT NOT NULL,                                                -- FK: quem criou a tarefa
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                         -- Data de criação automática
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),                       -- Relacionamento com usuários
    FOREIGN KEY (criado_por) REFERENCES usuarios(id)                        -- Relacionamento com usuários
);

-- Tabela de Histórico: registra toda alteração feita em uma tarefa
CREATE TABLE historico (
    id INT AUTO_INCREMENT PRIMARY KEY,                                      -- Identificador do registro
    tarefa_id INT NOT NULL,                                                 -- FK: qual tarefa foi alterada
    usuario_id INT NOT NULL,                                                -- FK: quem fez a alteração
    campo_alterado VARCHAR(50),                                             -- Nome do campo (ex: 'status', 'titulo')
    valor_antigo TEXT,                                                      -- Valor antes da mudança
    valor_novo TEXT,                                                        -- Valor depois da mudança
    data_alteracao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                     -- Quando aconteceu
    FOREIGN KEY (tarefa_id) REFERENCES tarefas(id) ON DELETE CASCADE,       -- Apaga histórico se a tarefa for excluída
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de Comentários: permite que membros discutam sobre cada tarefa
CREATE TABLE comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,                                      -- Identificador do comentário
    tarefa_id INT NOT NULL,                                                 -- FK: em qual tarefa está o comentário
    usuario_id INT NOT NULL,                                                -- FK: quem comentou
    comentario TEXT NOT NULL,                                               -- Texto do comentário
    data_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,                    -- Quando foi postado
    FOREIGN KEY (tarefa_id) REFERENCES tarefas(id) ON DELETE CASCADE,       -- Apaga comentários se a tarefa for excluída
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);