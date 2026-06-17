CREATE DATABASE IF NOT EXISTS dwd_street;
USE dwd_street;

-- ==========================================
-- TABELA DE USUÁRIOS
-- ==========================================

CREATE TABLE usuarios (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100) NOT NULL,
sobrenome VARCHAR(100) NOT NULL,
cpf VARCHAR(14) NOT NULL UNIQUE,
email VARCHAR(150) NOT NULL UNIQUE,
senha VARCHAR(255) NOT NULL,
data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- TABELA DE PRODUTOS
-- ==========================================

CREATE TABLE produtos (
id INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(150) NOT NULL,
descricao TEXT,
preco DECIMAL(10,2) NOT NULL,
estoque INT NOT NULL DEFAULT 0,
imagem VARCHAR(255),
categoria VARCHAR(50),
data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- TABELA DE PEDIDOS
-- ==========================================

CREATE TABLE pedidos (
id INT AUTO_INCREMENT PRIMARY KEY,
usuario_id INT NOT NULL,
codigo_rastreio VARCHAR(30) NOT NULL UNIQUE,
cep VARCHAR(10),
endereco VARCHAR(255),
numero VARCHAR(20),
bairro VARCHAR(100),
forma_pagamento VARCHAR(30),
subtotal DECIMAL(10,2),
frete DECIMAL(10,2),
total DECIMAL(10,2),
status_pedido VARCHAR(50) DEFAULT 'Pedido Recebido',
data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

CONSTRAINT fk_pedido_usuario
FOREIGN KEY (usuario_id)
REFERENCES usuarios(id)

);

-- ==========================================
-- TABELA DE ITENS DOS PEDIDOS
-- ==========================================

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

);

CREATE TABLE carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    produto_nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255),
    quantidade INT DEFAULT 1,
    data_adicionado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id)
    REFERENCES usuarios(id)
    ON DELETE CASCADE
);
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cep VARCHAR(20),
    numero VARCHAR(20),
    endereco VARCHAR(255),
    bairro VARCHAR(100),
    forma_pagamento VARCHAR(50),
    valor_total DECIMAL(10,2),
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT NOT NULL,

    FOREIGN KEY (pedido_id)
    REFERENCES pedidos(id)
);

-- ==========================================
-- PRODUTOS INICIAIS DA DWD STREET
-- ==========================================

INSERT INTO produtos
(nome, descricao, preco, estoque, imagem, categoria)
VALUES

(
'Camisa Block Core JEC',
'Camiseta streetwear oversized DWD Street',
199.90,
50,
'assets/css/img/produto1.png',
'Masculino'
),

(
'Moletom DWD Street Black',
'Moletom premium DWD Street',
249.90,
30,
'assets/css/img/produto2.png',
'Masculino'
),

(
'Boné Snapback DWD',
'Boné oficial DWD Street',
89.90,
100,
'assets/css/img/produto3.png',
'Acessórios'
);

-- ==========================================
-- USUÁRIO ADMIN PARA TESTE
-- SENHA: 123456
-- ==========================================

INSERT INTO usuarios
(nome, sobrenome, cpf, email, senha)
VALUES
(
'Administrador',
'DWD',
'00000000000',
'admin@dwdstreet.com',
'$2y$10$kJ3jN6rI5J7V4cLr4hQ3fO0J6YhY6y4rI6Vw5lNw1Gf6g4N6Q7x7W'
);
UPDATE pedidos
SET status_pedido='Preparando'
WHERE id=1;

UPDATE pedidos
SET status_pedido='Enviado'
WHERE id=1;

UPDATE pedidos
SET status_pedido='Entregue'
WHERE id=1;

ALTER TABLE usuarios
ADD COLUMN nivel VARCHAR(20) DEFAULT 'cliente';

UPDATE usuarios
SET nivel = 'admin'
WHERE id = 1;

SELECT *
FROM usuarios
WHERE nivel = 'admin';

UPDATE usuarios
SET senha = '$2y$10$8j8x5JjYh6o8Z4Jj0v6j2eKj1Z3vLQw6n6nK7m7xV4b8mD5yHf2mW'
WHERE email = 'admin@dwdstreet.com';

UPDATE usuarios
SET senha = '$2y$10$22b4.hrVuUaiE/kI3hY8ee9CDyO.v4Rz1qr2SHTKSufOxQ12vaMQy'
WHERE id = 1;