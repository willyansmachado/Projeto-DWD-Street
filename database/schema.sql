-- DWD Street: schema inicial limpo para MySQL 8+ / MariaDB 10.5+.
CREATE DATABASE IF NOT EXISTS dwd_street CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dwd_street;

CREATE TABLE IF NOT EXISTS usuarios (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(100) NOT NULL, sobrenome VARCHAR(100) NULL,
 email VARCHAR(150) NOT NULL, senha VARCHAR(255) NOT NULL, telefone VARCHAR(20) NULL, cpf VARCHAR(14) NULL,
 nascimento DATE NULL, foto VARCHAR(255) NOT NULL DEFAULT 'perfil.png', nivel ENUM('admin','cliente') NOT NULL DEFAULT 'cliente',
 status ENUM('ativo','inativo') NOT NULL DEFAULT 'ativo', google_id VARCHAR(255) NULL, ultimo_login DATETIME NULL,
 criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 UNIQUE KEY uq_usuario_email (email), UNIQUE KEY uq_usuario_cpf (cpf), UNIQUE KEY uq_usuario_google (google_id), KEY idx_usuario_status (nivel,status)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS enderecos (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, usuario_id INT UNSIGNED NOT NULL, cep VARCHAR(10) NULL, rua VARCHAR(150) NULL,
 numero VARCHAR(20) NULL, complemento VARCHAR(120) NULL, bairro VARCHAR(120) NULL, cidade VARCHAR(120) NULL, estado CHAR(2) NULL,
 principal BOOLEAN NOT NULL DEFAULT TRUE, criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_endereco_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE, KEY idx_endereco_usuario (usuario_id,principal)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS categorias (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(80) NOT NULL, slug VARCHAR(80) NOT NULL, imagem VARCHAR(255) NULL,
 descricao TEXT NULL, ativo BOOLEAN NOT NULL DEFAULT TRUE, UNIQUE KEY uq_categoria_slug (slug), KEY idx_categoria_ativo (ativo,nome)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS marcas (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(80) NOT NULL, logo VARCHAR(255) NULL, descricao TEXT NULL,
 ativo BOOLEAN NOT NULL DEFAULT TRUE, UNIQUE KEY uq_marca_nome (nome)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS tamanhos (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(10) NOT NULL, ordem SMALLINT UNSIGNED NOT NULL DEFAULT 0, UNIQUE KEY uq_tamanho_nome (nome)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS cores (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(40) NOT NULL, codigo_hex CHAR(7) NULL, UNIQUE KEY uq_cor_nome (nome)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS produtos (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, categoria_id INT UNSIGNED NOT NULL, marca_id INT UNSIGNED NULL,
 nome VARCHAR(180) NOT NULL, slug VARCHAR(180) NOT NULL, descricao TEXT NULL, descricao_curta VARCHAR(255) NULL,
 sku VARCHAR(50) NULL, codigo_barras VARCHAR(50) NULL, preco DECIMAL(10,2) NOT NULL, preco_promocional DECIMAL(10,2) NULL,
 custo DECIMAL(10,2) NULL, peso DECIMAL(8,3) NOT NULL DEFAULT 0.300, largura DECIMAL(8,2) NULL, altura DECIMAL(8,2) NULL,
 comprimento DECIMAL(8,2) NULL, imagem VARCHAR(255) NULL, estoque INT NOT NULL DEFAULT 0,
 genero ENUM('masculino','feminino','infantil','unissex') NOT NULL DEFAULT 'unissex', colecao VARCHAR(50) NULL,
 destaque BOOLEAN NOT NULL DEFAULT FALSE, lancamento BOOLEAN NOT NULL DEFAULT FALSE, oferta BOOLEAN NOT NULL DEFAULT FALSE,
 ativo BOOLEAN NOT NULL DEFAULT TRUE, visualizacoes INT UNSIGNED NOT NULL DEFAULT 0, vendas INT UNSIGNED NOT NULL DEFAULT 0,
 criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT chk_preco CHECK (preco >= 0), CONSTRAINT fk_produto_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id),
 CONSTRAINT fk_produto_marca FOREIGN KEY (marca_id) REFERENCES marcas(id) ON DELETE SET NULL,
 UNIQUE KEY uq_produto_slug (slug), UNIQUE KEY uq_produto_sku (sku), KEY idx_produto_catalogo (ativo,genero,categoria_id),
 KEY idx_produto_destaque (ativo,destaque,criado_em), KEY idx_produto_oferta (ativo,oferta,preco_promocional)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS imagens_produto (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, produto_id INT UNSIGNED NOT NULL, imagem VARCHAR(255) NOT NULL,
 principal BOOLEAN NOT NULL DEFAULT FALSE, ordem SMALLINT UNSIGNED NOT NULL DEFAULT 1,
 CONSTRAINT fk_imagem_produto FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE, KEY idx_imagem_principal (produto_id,principal,ordem)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS estoque (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, produto_id INT UNSIGNED NOT NULL, quantidade INT NOT NULL DEFAULT 0, estoque_minimo INT NOT NULL DEFAULT 5,
 ultima_movimentacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_estoque_produto FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE, UNIQUE KEY uq_estoque_produto (produto_id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS produto_tamanhos (
 produto_id INT UNSIGNED NOT NULL, tamanho_id INT UNSIGNED NOT NULL, quantidade INT NOT NULL DEFAULT 0, PRIMARY KEY (produto_id,tamanho_id),
 CONSTRAINT fk_pt_produto FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE, CONSTRAINT fk_pt_tamanho FOREIGN KEY (tamanho_id) REFERENCES tamanhos(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS produto_cores (
 produto_id INT UNSIGNED NOT NULL, cor_id INT UNSIGNED NOT NULL, quantidade INT NOT NULL DEFAULT 0, PRIMARY KEY (produto_id,cor_id),
 CONSTRAINT fk_pc_produto FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE, CONSTRAINT fk_pc_cor FOREIGN KEY (cor_id) REFERENCES cores(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS cupons (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, codigo VARCHAR(40) NOT NULL, descricao VARCHAR(255) NULL, tipo ENUM('porcentagem','fixo') NOT NULL,
 valor_desconto DECIMAL(10,2) NOT NULL, valor_minimo DECIMAL(10,2) NOT NULL DEFAULT 0, data_inicio DATETIME NULL, data_fim DATETIME NULL,
 limite_uso INT UNSIGNED NULL, usos INT UNSIGNED NOT NULL DEFAULT 0, ativo BOOLEAN NOT NULL DEFAULT TRUE,
 UNIQUE KEY uq_cupom_codigo (codigo), KEY idx_cupom_validade (ativo,data_inicio,data_fim)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS carrinho (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, usuario_id INT UNSIGNED NOT NULL, produto_id INT UNSIGNED NOT NULL, tamanho_id INT UNSIGNED NULL, cor_id INT UNSIGNED NULL,
 produto_nome VARCHAR(255) NULL, imagem VARCHAR(255) NULL, preco DECIMAL(10,2) NOT NULL, peso DECIMAL(8,3) NOT NULL DEFAULT 0.300,
 quantidade INT UNSIGNED NOT NULL DEFAULT 1, criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT chk_carrinho_quantidade CHECK (quantidade > 0), CONSTRAINT fk_carrinho_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
 CONSTRAINT fk_carrinho_produto FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE, CONSTRAINT fk_carrinho_tamanho FOREIGN KEY (tamanho_id) REFERENCES tamanhos(id) ON DELETE SET NULL,
 CONSTRAINT fk_carrinho_cor FOREIGN KEY (cor_id) REFERENCES cores(id) ON DELETE SET NULL, UNIQUE KEY uq_carrinho_item (usuario_id,produto_id,tamanho_id,cor_id), KEY idx_carrinho_usuario (usuario_id,criado_em)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS pedidos (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, codigo VARCHAR(30) NOT NULL, usuario_id INT UNSIGNED NOT NULL, endereco_id INT UNSIGNED NULL, endereco VARCHAR(255) NULL,
 subtotal DECIMAL(10,2) NOT NULL, desconto DECIMAL(10,2) NOT NULL DEFAULT 0, frete DECIMAL(10,2) NOT NULL DEFAULT 0, total DECIMAL(10,2) NOT NULL,
 forma_pagamento VARCHAR(40) NOT NULL, status VARCHAR(50) NOT NULL DEFAULT 'Aguardando Pagamento', observacoes TEXT NULL,
 criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_pedido_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE, CONSTRAINT fk_pedido_endereco FOREIGN KEY (endereco_id) REFERENCES enderecos(id) ON DELETE SET NULL,
 UNIQUE KEY uq_pedido_codigo (codigo), KEY idx_pedido_usuario_data (usuario_id,criado_em), KEY idx_pedido_status_data (status,criado_em)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS itens_pedido (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, pedido_id INT UNSIGNED NOT NULL, produto_id INT UNSIGNED NULL, tamanho_id INT UNSIGNED NULL, cor_id INT UNSIGNED NULL,
 quantidade INT UNSIGNED NOT NULL, preco_unitario DECIMAL(10,2) NOT NULL, subtotal DECIMAL(10,2) NOT NULL,
 CONSTRAINT fk_item_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE, CONSTRAINT fk_item_produto FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE SET NULL,
 CONSTRAINT fk_item_tamanho FOREIGN KEY (tamanho_id) REFERENCES tamanhos(id) ON DELETE SET NULL, CONSTRAINT fk_item_cor FOREIGN KEY (cor_id) REFERENCES cores(id) ON DELETE SET NULL, KEY idx_item_pedido (pedido_id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS pagamentos (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, pedido_id INT UNSIGNED NOT NULL, metodo VARCHAR(40) NOT NULL, valor DECIMAL(10,2) NOT NULL,
 status ENUM('Pendente','Pago','Recusado','Estornado') NOT NULL DEFAULT 'Pendente', codigo_transacao VARCHAR(255) NULL, comprovante VARCHAR(255) NULL, data_pagamento DATETIME NULL,
 CONSTRAINT fk_pagamento_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE, KEY idx_pagamento_pedido_status (pedido_id,status)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS rastreamento (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, pedido_id INT UNSIGNED NOT NULL, codigo_rastreio VARCHAR(50) NULL, transportadora VARCHAR(100) NULL,
 status_atual VARCHAR(100) NULL, previsao_entrega DATE NULL, ultima_atualizacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_rastreamento_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE, UNIQUE KEY uq_rastreamento_codigo (codigo_rastreio)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS historico_pedidos (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, pedido_id INT UNSIGNED NOT NULL, status VARCHAR(100) NOT NULL, descricao TEXT NULL, usuario_admin INT UNSIGNED NULL,
 data_evento TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, CONSTRAINT fk_historico_pedido FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
 CONSTRAINT fk_historico_admin FOREIGN KEY (usuario_admin) REFERENCES usuarios(id) ON DELETE SET NULL, KEY idx_historico_pedido_data (pedido_id,data_evento)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS newsletter (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, email VARCHAR(150) NOT NULL, ativo BOOLEAN NOT NULL DEFAULT TRUE, criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uq_newsletter_email (email)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS contato (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, assunto VARCHAR(150) NULL, mensagem TEXT NOT NULL,
 lido BOOLEAN NOT NULL DEFAULT FALSE, criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, KEY idx_contato_lido_data (lido,criado_em)
) ENGINE=InnoDB;

INSERT IGNORE INTO categorias (nome,slug) VALUES ('Masculino','masculino'),('Feminino','feminino'),('Infantil','infantil'),('Acessórios','acessorios');
INSERT IGNORE INTO tamanhos (nome,ordem) VALUES ('PP',1),('P',2),('M',3),('G',4),('GG',5);
-- Desenvolvimento apenas: admin@dwdstreet.com / admin123. Altere antes de produção.
INSERT IGNORE INTO usuarios (nome,email,senha,nivel) VALUES ('Administrador','admin@dwdstreet.com','$2y$10$bzChUYajQeIMWTZn.0o1juSnWIba9yg3Ji2jVYWN3AT2bGCBOzq2O','admin');
