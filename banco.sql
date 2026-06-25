-- =========================================================
-- DWD STREET V2
-- PARTE 1
CREATE DATABASE dwd_street
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE dwd_street;

-- =========================================================
-- USUÁRIOS
-- =========================================================

CREATE TABLE usuarios (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100) NOT NULL,

    sobrenome VARCHAR(100),

    email VARCHAR(150) NOT NULL UNIQUE,

    senha VARCHAR(255) NOT NULL,

    telefone VARCHAR(20),

    cpf VARCHAR(14) UNIQUE,

    nascimento DATE,

    foto VARCHAR(255) DEFAULT 'perfil.png',

    nivel ENUM('admin','cliente') DEFAULT 'cliente',

    status ENUM('ativo','inativo') DEFAULT 'ativo',

    google_id VARCHAR(255),

    ultimo_login DATETIME NULL,

    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP

);

-- =========================================================
-- ENDEREÇOS
-- =========================================================

CREATE TABLE enderecos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NOT NULL,

    cep VARCHAR(10),

    rua VARCHAR(150),

    numero VARCHAR(20),

    complemento VARCHAR(120),

    bairro VARCHAR(120),

    cidade VARCHAR(120),

    estado CHAR(2),

    principal BOOLEAN DEFAULT TRUE,

    FOREIGN KEY(usuario_id)
    REFERENCES usuarios(id)
    ON DELETE CASCADE

);

-- =========================================================
-- CATEGORIAS
-- =========================================================

CREATE TABLE categorias (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(80) NOT NULL,

    slug VARCHAR(80) UNIQUE,

    imagem VARCHAR(255),

    descricao TEXT,

    ativo BOOLEAN DEFAULT TRUE

);

-- =========================================================
-- MARCAS
-- =========================================================

CREATE TABLE marcas (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(80) NOT NULL,

    logo VARCHAR(255),

    descricao TEXT,

    ativo BOOLEAN DEFAULT TRUE

);

-- =========================================================
-- CORES
-- =========================================================

CREATE TABLE cores (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(40),

    codigo_hex VARCHAR(7)

);

-- =========================================================
-- TAMANHOS
-- =========================================================

CREATE TABLE tamanhos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(10),

    ordem INT DEFAULT 0

);

-- =========================================================
-- CONFIGURAÇÕES DO SITE
-- =========================================================

CREATE TABLE configuracoes (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome_loja VARCHAR(150),

    email VARCHAR(150),

    telefone VARCHAR(20),

    whatsapp VARCHAR(20),

    instagram VARCHAR(255),

    facebook VARCHAR(255),

    tiktok VARCHAR(255),

    endereco TEXT,

    logo VARCHAR(255),

    favicon VARCHAR(255),

    banner_principal VARCHAR(255),

    banner_secundario VARCHAR(255),

    texto_rodape TEXT

);

-- =========================================================
-- NEWSLETTER
-- =========================================================

CREATE TABLE newsletter (

    id INT AUTO_INCREMENT PRIMARY KEY,

    email VARCHAR(150) UNIQUE,

    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- =========================================================
-- CONTATO
-- =========================================================

CREATE TABLE contato (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(120),

    email VARCHAR(150),

    assunto VARCHAR(150),

    mensagem TEXT,

    respondido BOOLEAN DEFAULT FALSE,

    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- =========================================================
-- BANNERS
-- =========================================================

CREATE TABLE banners (

    id INT AUTO_INCREMENT PRIMARY KEY,

    titulo VARCHAR(150),

    subtitulo VARCHAR(255),

    imagem VARCHAR(255),

    link VARCHAR(255),

    ativo BOOLEAN DEFAULT TRUE,

    ordem INT DEFAULT 1

);

-- =========================================================
-- ADMINISTRADOR
-- =========================================================

INSERT INTO usuarios (

nome,
sobrenome,
email,
senha,
nivel

)

VALUES(

'Administrador',

'DWD',

'admin@dwdstreet.com',

'$2y$10$wBskvX76b8XW9oXWw3tYIeuuOa3D9r.eXF2Ew3M5hZ1e9e/Z5eGqK',

'admin'

);

-- =========================================================
-- CATEGORIAS
-- =========================================================

INSERT INTO categorias(nome,slug) VALUES

('Camisetas','camisetas'),
('Calças','calcas'),
('Shorts','shorts'),
('Bermudas','bermudas'),
('Moletons','moletons'),
('Jaquetas','jaquetas'),
('Bonés','bones'),
('Tênis','tenis'),
('Acessórios','acessorios'),
('Relógios','relogios'),
('Joias','joias'),
('Plus Size','plus-size'),
('Feminino','feminino'),
('Masculino','masculino');

-- =========================================================
-- MARCAS
-- =========================================================

INSERT INTO marcas(nome)

VALUES

('DWD Street'),
('Nike'),
('Adidas'),
('Puma'),
('New Era'),
('Oakley');

-- =========================================================
-- CORES
-- =========================================================

INSERT INTO cores(nome,codigo_hex)

VALUES

('Preto','#000000'),
('Branco','#FFFFFF'),
('Cinza','#808080'),
('Azul','#0055FF'),
('Vermelho','#FF0000'),
('Verde','#00AA00');

-- =========================================================
-- TAMANHOS
-- =========================================================

INSERT INTO tamanhos(nome,ordem)

VALUES

('PP',1),
('P',2),
('M',3),
('G',4),
('GG',5),
('XGG',6);

-- =========================================================
-- DWD STREET V2
-- PARTE 2 - PRODUTOS
-- =========================================================

CREATE TABLE produtos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    categoria_id INT NOT NULL,

    marca_id INT,

    nome VARCHAR(180) NOT NULL,

    slug VARCHAR(180) UNIQUE,

    descricao TEXT,

    descricao_curta VARCHAR(255),

    sku VARCHAR(50) UNIQUE,

    codigo_barras VARCHAR(50),

    preco DECIMAL(10,2) NOT NULL,

    preco_promocional DECIMAL(10,2),

    custo DECIMAL(10,2),

    peso DECIMAL(8,2),

    largura DECIMAL(8,2),

    altura DECIMAL(8,2),

    comprimento DECIMAL(8,2),

    destaque BOOLEAN DEFAULT FALSE,

    lancamento BOOLEAN DEFAULT FALSE,

    ativo BOOLEAN DEFAULT TRUE,

    visualizacoes INT DEFAULT 0,

    vendas INT DEFAULT 0,

    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (categoria_id)
        REFERENCES categorias(id),

    FOREIGN KEY (marca_id)
        REFERENCES marcas(id)

);

-- =========================================================
-- IMAGENS DOS PRODUTOS
-- =========================================================

CREATE TABLE imagens_produto (

    id INT AUTO_INCREMENT PRIMARY KEY,

    produto_id INT NOT NULL,

    imagem VARCHAR(255) NOT NULL,

    principal BOOLEAN DEFAULT FALSE,

    ordem INT DEFAULT 1,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE

);

-- =========================================================
-- ESTOQUE
-- =========================================================

CREATE TABLE estoque (

    id INT AUTO_INCREMENT PRIMARY KEY,

    produto_id INT NOT NULL,

    quantidade INT DEFAULT 0,

    estoque_minimo INT DEFAULT 5,

    ultima_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE

);

-- =========================================================
-- MOVIMENTAÇÃO DE ESTOQUE
-- =========================================================

CREATE TABLE movimentacao_estoque (

    id INT AUTO_INCREMENT PRIMARY KEY,

    produto_id INT NOT NULL,

    tipo ENUM('entrada','saida','ajuste'),

    quantidade INT,

    observacao TEXT,

    usuario_id INT,

    data_movimentacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE,

    FOREIGN KEY(usuario_id)
        REFERENCES usuarios(id)
        ON DELETE SET NULL

);

-- =========================================================
-- PRODUTO X TAMANHOS
-- =========================================================

CREATE TABLE produto_tamanhos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    produto_id INT NOT NULL,

    tamanho_id INT NOT NULL,

    quantidade INT DEFAULT 0,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE,

    FOREIGN KEY(tamanho_id)
        REFERENCES tamanhos(id)
        ON DELETE CASCADE

);

-- =========================================================
-- PRODUTO X CORES
-- =========================================================

CREATE TABLE produto_cores (

    id INT AUTO_INCREMENT PRIMARY KEY,

    produto_id INT NOT NULL,

    cor_id INT NOT NULL,

    quantidade INT DEFAULT 0,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE,

    FOREIGN KEY(cor_id)
        REFERENCES cores(id)
        ON DELETE CASCADE

);

-- =========================================================
-- FAVORITOS
-- =========================================================

CREATE TABLE favoritos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NOT NULL,

    produto_id INT NOT NULL,

    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE

);

-- =========================================================
-- AVALIAÇÕES
-- =========================================================

CREATE TABLE avaliacoes (

    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NOT NULL,

    produto_id INT NOT NULL,

    nota INT NOT NULL CHECK (nota >=1 AND nota <=5),

    titulo VARCHAR(150),

    comentario TEXT,

    aprovado BOOLEAN DEFAULT FALSE,

    data_avaliacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE

);

-- =========================================================
-- CUPONS
-- =========================================================

CREATE TABLE cupons (

    id INT AUTO_INCREMENT PRIMARY KEY,

    codigo VARCHAR(50) UNIQUE,

    descricao VARCHAR(255),

    tipo ENUM('valor','porcentagem'),

    desconto DECIMAL(10,2),

    valor_minimo DECIMAL(10,2) DEFAULT 0,

    validade DATE,

    quantidade INT DEFAULT 0,

    utilizado INT DEFAULT 0,

    ativo BOOLEAN DEFAULT TRUE

);

-- =========================================================
-- PRODUTOS RELACIONADOS
-- =========================================================

CREATE TABLE produtos_relacionados (

    id INT AUTO_INCREMENT PRIMARY KEY,

    produto_id INT NOT NULL,

    relacionado_id INT NOT NULL,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE,

    FOREIGN KEY(relacionado_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE

);

-- =========================================================
-- TAGS
-- =========================================================

CREATE TABLE tags (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(80) UNIQUE

);

CREATE TABLE produto_tags (

    id INT AUTO_INCREMENT PRIMARY KEY,

    produto_id INT NOT NULL,

    tag_id INT NOT NULL,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE,

    FOREIGN KEY(tag_id)
        REFERENCES tags(id)
        ON DELETE CASCADE

);

-- =========================================================
-- ÍNDICES
-- =========================================================

CREATE INDEX idx_produto_nome
ON produtos(nome);

CREATE INDEX idx_produto_categoria
ON produtos(categoria_id);

CREATE INDEX idx_produto_marca
ON produtos(marca_id);

CREATE INDEX idx_produto_preco
ON produtos(preco);

CREATE INDEX idx_produto_destaque
ON produtos(destaque);

CREATE INDEX idx_produto_lancamento
ON produtos(lancamento);

CREATE INDEX idx_produto_ativo
ON produtos(ativo);

-- =========================================================
-- DWD STREET V2
-- PARTE 3 - PEDIDOS, CARRINHO E PAGAMENTOS
-- =========================================================

-- =====================================
-- CARRINHO
-- =====================================

CREATE TABLE carrinho (

    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NOT NULL,

    produto_id INT NOT NULL,

    tamanho_id INT NULL,

    cor_id INT NULL,

    quantidade INT NOT NULL DEFAULT 1,

    preco DECIMAL(10,2) NOT NULL,

    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE,

    FOREIGN KEY (produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE,

    FOREIGN KEY (tamanho_id)
        REFERENCES tamanhos(id)
        ON DELETE SET NULL,

    FOREIGN KEY (cor_id)
        REFERENCES cores(id)
        ON DELETE SET NULL

);

-- =====================================
-- PEDIDOS
-- =====================================

CREATE TABLE pedidos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    codigo VARCHAR(30) UNIQUE NOT NULL,

    usuario_id INT NOT NULL,

    endereco_id INT NOT NULL,

    subtotal DECIMAL(10,2) NOT NULL,

    desconto DECIMAL(10,2) DEFAULT 0,

    frete DECIMAL(10,2) DEFAULT 0,

    total DECIMAL(10,2) NOT NULL,

    forma_pagamento ENUM(
        'PIX',
        'Cartão de Crédito',
        'Cartão de Débito',
        'Boleto'
    ) NOT NULL,

    status ENUM(
        'Aguardando Pagamento',
        'Pagamento Aprovado',
        'Separando Pedido',
        'Enviado',
        'Saiu para Entrega',
        'Entregue',
        'Cancelado'
    ) DEFAULT 'Aguardando Pagamento',

    observacoes TEXT,

    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY(usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE,

    FOREIGN KEY(endereco_id)
        REFERENCES enderecos(id)
        ON DELETE RESTRICT

);

-- =====================================
-- ITENS DO PEDIDO
-- =====================================

CREATE TABLE itens_pedido (

    id INT AUTO_INCREMENT PRIMARY KEY,

    pedido_id INT NOT NULL,

    produto_id INT NOT NULL,

    tamanho_id INT,

    cor_id INT,

    quantidade INT NOT NULL,

    preco_unitario DECIMAL(10,2) NOT NULL,

    subtotal DECIMAL(10,2) NOT NULL,

    FOREIGN KEY(pedido_id)
        REFERENCES pedidos(id)
        ON DELETE CASCADE,

    FOREIGN KEY(produto_id)
        REFERENCES produtos(id)
        ON DELETE CASCADE,

    FOREIGN KEY(tamanho_id)
        REFERENCES tamanhos(id)
        ON DELETE SET NULL,

    FOREIGN KEY(cor_id)
        REFERENCES cores(id)
        ON DELETE SET NULL

);

-- =====================================
-- PAGAMENTOS
-- =====================================

CREATE TABLE pagamentos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    pedido_id INT NOT NULL,

    metodo ENUM(
        'PIX',
        'Cartão',
        'Boleto'
    ),

    valor DECIMAL(10,2) NOT NULL,

    status ENUM(
        'Pendente',
        'Pago',
        'Recusado',
        'Estornado'
    ) DEFAULT 'Pendente',

    codigo_transacao VARCHAR(255),

    comprovante VARCHAR(255),

    data_pagamento DATETIME,

    FOREIGN KEY(pedido_id)
        REFERENCES pedidos(id)
        ON DELETE CASCADE

);

-- =====================================
-- RASTREAMENTO
-- =====================================

CREATE TABLE rastreamento (

    id INT AUTO_INCREMENT PRIMARY KEY,

    pedido_id INT NOT NULL,

    codigo_rastreio VARCHAR(50) UNIQUE,

    transportadora VARCHAR(100),

    status_atual VARCHAR(100),

    previsao_entrega DATE,

    ultima_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(pedido_id)
        REFERENCES pedidos(id)
        ON DELETE CASCADE

);

-- =====================================
-- HISTÓRICO DO PEDIDO
-- =====================================

CREATE TABLE historico_pedidos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    pedido_id INT NOT NULL,

    status VARCHAR(100),

    descricao TEXT,

    usuario_admin INT NULL,

    data_evento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(pedido_id)
        REFERENCES pedidos(id)
        ON DELETE CASCADE,

    FOREIGN KEY(usuario_admin)
        REFERENCES usuarios(id)
        ON DELETE SET NULL

);

-- =====================================
-- CUPONS UTILIZADOS
-- =====================================

CREATE TABLE cupons_utilizados (

    id INT AUTO_INCREMENT PRIMARY KEY,

    cupom_id INT NOT NULL,

    usuario_id INT NOT NULL,

    pedido_id INT NOT NULL,

    desconto DECIMAL(10,2),

    utilizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(cupom_id)
        REFERENCES cupons(id)
        ON DELETE CASCADE,

    FOREIGN KEY(usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE,

    FOREIGN KEY(pedido_id)
        REFERENCES pedidos(id)
        ON DELETE CASCADE

);

-- =====================================
-- NOTIFICAÇÕES
-- =====================================

CREATE TABLE notificacoes (

    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT,

    titulo VARCHAR(150),

    mensagem TEXT,

    lida BOOLEAN DEFAULT FALSE,

    criada_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE

);

-- =====================================
-- LOGS DO ADMIN
-- =====================================

CREATE TABLE logs_admin (

    id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT,

    acao VARCHAR(255),

    tabela_afetada VARCHAR(100),

    registro_id INT,

    ip VARCHAR(50),

    navegador VARCHAR(255),

    data_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(usuario_id)
        REFERENCES usuarios(id)
        ON DELETE SET NULL

);

-- =====================================
-- ÍNDICES
-- =====================================

CREATE INDEX idx_carrinho_usuario
ON carrinho(usuario_id);

CREATE INDEX idx_pedido_usuario
ON pedidos(usuario_id);

CREATE INDEX idx_pedido_status
ON pedidos(status);

CREATE INDEX idx_rastreio_codigo
ON rastreamento(codigo_rastreio);

CREATE INDEX idx_pagamento_status
ON pagamentos(status);

CREATE INDEX idx_notificacao_usuario
ON notificacoes(usuario_id);

-- =========================================================
-- DWD STREET V2
-- PARTE 4 - DADOS INICIAIS
-- =========================================================

-- =====================================
-- CONFIGURAÇÕES DO SITE
-- =====================================

INSERT INTO configuracoes (

nome_loja,
email,
telefone,
whatsapp,
instagram,
facebook,
tiktok,
endereco,
logo,
favicon,
banner_principal,
banner_secundario,
texto_rodape

)

VALUES(

'DWD Street',

'contato@dwdstreet.com',

'(11) 99999-9999',

'5511999999999',

'https://instagram.com/dwdstreet',

'https://facebook.com/dwdstreet',

'https://tiktok.com/@dwdstreet',

'São Paulo - SP',

'logo.png',

'favicon.ico',

'banner1.jpg',

'banner2.jpg',

'DWD Street © Todos os direitos reservados.'

);

-- =====================================
-- BANNERS
-- =====================================

INSERT INTO banners(titulo,subtitulo,imagem,link,ordem)

VALUES

('Nova Coleção','Streetwear 2026','banner1.jpg','produtos.php',1),

('Promoções','Até 50% OFF','banner2.jpg','ofertas.php',2),

('Lançamentos','Confira as novidades','banner3.jpg','novidades.php',3);

-- =====================================
-- CUPONS
-- =====================================

INSERT INTO cupons
(codigo,descricao,tipo,desconto,valor_minimo,validade,quantidade)

VALUES

('BEMVINDO10','10% de desconto','porcentagem',10,0,'2030-12-31',999),

('DWD20','20% OFF','porcentagem',20,150,'2030-12-31',500),

('FRETEGRATIS','Frete grátis','valor',30,250,'2030-12-31',999);

-- =====================================
-- PRODUTOS
-- =====================================

INSERT INTO produtos

(categoria_id,marca_id,nome,slug,descricao,descricao_curta,sku,preco,preco_promocional,destaque,lancamento)

VALUES

(1,1,'Camiseta DWD Essential','camiseta-dwd-essential','Camiseta premium em algodão.','Linha Essential','DWD001',89.90,69.90,1,1),

(1,1,'Camiseta Oversized Black','camiseta-oversized-black','Modelo oversized.','Oversized','DWD002',119.90,NULL,1,0),

(5,1,'Moletom DWD Black','moletom-dwd-black','Moletom premium.','Moletom','DWD003',229.90,199.90,1,1),

(2,3,'Calça Adidas Cargo','calca-adidas-cargo','Calça cargo Adidas.','Cargo','ADD001',259.90,NULL,0,0),

(7,5,'Boné New Era','bone-new-era','Boné aba curva.','Boné','NE001',149.90,NULL,1,0),

(8,2,'Tênis Nike Air','tenis-nike-air','Tênis Nike Air.','Nike Air','NK001',699.90,649.90,1,1);

-- =====================================
-- IMAGENS
-- =====================================

INSERT INTO imagens_produto(produto_id,imagem,principal)

VALUES

(1,'camiseta_dwd_1.jpg',1),

(2,'camiseta_dwd_2.jpg',1),

(3,'moletom_black.jpg',1),

(4,'calca_adidas.jpg',1),

(5,'bone_newera.jpg',1),

(6,'nike_air.jpg',1);

-- =====================================
-- ESTOQUE
-- =====================================

INSERT INTO estoque(produto_id,quantidade,estoque_minimo)

VALUES

(1,50,5),

(2,30,5),

(3,20,5),

(4,15,3),

(5,40,5),

(6,12,2);

-- =====================================
-- PRODUTOS X TAMANHOS
-- =====================================

INSERT INTO produto_tamanhos(produto_id,tamanho_id,quantidade)

VALUES

(1,2,10),(1,3,15),(1,4,15),(1,5,10),

(2,3,10),(2,4,10),(2,5,10),

(3,3,8),(3,4,6),(3,5,6);

-- =====================================
-- PRODUTOS X CORES
-- =====================================

INSERT INTO produto_cores(produto_id,cor_id,quantidade)

VALUES

(1,1,25),

(1,2,25),

(2,1,30),

(3,1,20),

(4,3,15),

(5,1,40),

(6,2,12);

-- =====================================
-- NEWSLETTER
-- =====================================

INSERT INTO newsletter(email)

VALUES

('cliente1@email.com'),

('cliente2@email.com'),

('cliente3@email.com');

-- =====================================
-- CONTATOS
-- =====================================

INSERT INTO contato(nome,email,assunto,mensagem)

VALUES

('João','joao@email.com','Entrega','Qual o prazo de entrega?'),

('Maria','maria@email.com','Produto','Quando volta ao estoque?');

-- =====================================
-- FIM DO BANCO
-- =====================================

SHOW TABLES;
