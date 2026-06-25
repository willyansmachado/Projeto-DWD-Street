CREATE DATABASE IF NOT EXISTS dwd_street
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE dwd_street;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nivel VARCHAR(20) DEFAULT 'cliente',
    telefone VARCHAR(20),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NULL,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    estoque INT DEFAULT 0,
    imagem VARCHAR(255),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produto_categoria
        FOREIGN KEY (categoria_id)
        REFERENCES categorias(id)
        ON DELETE SET NULL
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Pendente',
    total DECIMAL(10,2) NOT NULL,
    forma_pagamento VARCHAR(50),
    CONSTRAINT fk_pedido_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
);

CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_item_pedido
        FOREIGN KEY (pedido_id)
        REFERENCES pedidos(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_item_produto
        FOREIGN KEY (produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE
);

INSERT INTO usuarios (nome, email, senha, nivel)
VALUES (
    'Admin DWD',
    'admin@dwdstreet.com',
    '$2y$10$wBskvX76b8XW9oXWw3tYIeuuOa3D9r.eXF2Ew3M5hZ1e9e/Z5eGqK',
    'admin'
);

INSERT INTO categorias (nome, slug) VALUES
('Agasalhos', 'agasalhos'),
('Bonés', 'bones'),
('Calças Femininas', 'calcasf'),
('Camisas', 'camisas'),
('Joias', 'joias'),
('Shorts', 'shorts'),
('Plus Size', 'plus'),
('Relógios', 'relogios'),
('T-shirts', 't-shirts');

SHOW TABLES;

USE dwd_street;
SHOW TABLES;

SELECT * FROM usuarios;