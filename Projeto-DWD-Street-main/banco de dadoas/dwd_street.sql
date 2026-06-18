CREATE DATABASE dwd_street;
USE dwd_street;

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(150),
    senha VARCHAR(255),
    nivel VARCHAR(20)
);

CREATE TABLE produtos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_produto VARCHAR(50),
    nome VARCHAR(150),
    descricao TEXT,
    estoque INT,
    preco DECIMAL(10,2),
    imagem VARCHAR(255)
);

CREATE TABLE pedidos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    codigo_rastreio VARCHAR(50),
    status_pedido VARCHAR(100),
    valor_total DECIMAL(10,2),
    data_pedido DATETIME
);

CREATE TABLE itens_pedido(
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT,
    produto_id INT,
    quantidade INT,
    valor_unitario DECIMAL(10,2)
);
