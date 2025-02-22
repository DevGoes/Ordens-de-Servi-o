CREATE DATABASE ordem_servico_db;

USE ordem_servico_db;

-- Tabela de Clientes
CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    endereco VARCHAR(255) NOT NULL
);

-- Tabela de Produtos
CREATE TABLE produtos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    descricao VARCHAR(255) NOT NULL,
    status ENUM('Ativo', 'Inativo') NOT NULL
);

-- Tabela de Ordens de Serviço
CREATE TABLE ordens (
    id INT PRIMARY KEY AUTO_INCREMENT,
    numero_ordem VARCHAR(20) NOT NULL UNIQUE,
    data_abertura DATE NOT NULL,
    nome_consumidor VARCHAR(100) NOT NULL,
    cpf_consumidor VARCHAR(14) NOT NULL,
    produto_id INT NOT NULL,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);