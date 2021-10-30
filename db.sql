SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- Geração de Modelo físico
-- Sql ANSI 2003

-- -----------------------------------------------------
-- Table 'ci_sessions'
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS ci_sessions (
  id VARCHAR(40) NOT NULL DEFAULT '0',
  ip_address VARCHAR(45) NOT NULL DEFAULT '0',
  user_agent VARCHAR(120) NOT NULL,
  last_activity INT(10) UNSIGNED NOT NULL DEFAULT '0',
  user_data TEXT NOT NULL,
  data datetime, 
  timestamp timestamp,
  PRIMARY KEY ('session_id'),
  INDEX 'last_activity_idx' ('last_activity' ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


CREATE TABLE IF NOT EXISTS pessoa (
	id_pessoa int auto_increment,
	email varchar(100),
	nome varchar(100),
	cep varchar(8),
	logradouro varchar(100),
	numero varchar(10),
	bairro varchar(100),
	cidade varchar(100),
	sexo char(1),
	data_nascimento date,
	PRIMARY KEY(id_pessoa))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS pessoa_fisica (
	id_pessoa_fisica int auto_increment PRIMARY KEY,
	id_pessoa int,
	cpf varchar(11))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS pessoa_juridica(
	id_pessoa_juridica int auto_increment PRIMARY KEY,
	id_pessoa int,
	cnpj varchar(14),
	nome_fantasia varchar(255),
	razao_social varchar(255))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS fornecedor(
	id_fornecedor int auto_increment PRIMARY KEY,
	id_pessoa_juridica int,
	descricao varchar(100))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS telefone (
	id_telefone int auto_increment PRIMARY KEY,
	id_pessoa int,
	ddd varchar(3),
	telefone varchar(20),
	tipo_telefone char(1))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS funcionario (
	id_funcionario int auto_increment PRIMARY KEY,
	id_pessoa_fisica int,
	cargo varchar(50),
	data_contratacao date)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS usuario (
	id_usuario int auto_increment PRIMARY KEY,
	id_funcionario int,
	tipo_usuario char(1),
	senha varchar(255),
	login varchar(20),
	nome varchar(100),
	email varchar(100)
	data_cadastro datetime
	status char(1))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS cliente (
	id_cliente int auto_increment PRIMARY KEY,
	id_pessoa_juridica int,
	id_pessoa_fisica int,
	data_cadastro datetime,
	data_alteracao datetime,
	id_pessoa int) --Retirar para apresentação
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS categoria (
	id_categoria int auto_increment PRIMARY KEY,
	descricao varchar(255),
	nome varchar(100),
	dt_cadastro datetime,
	dt_alteracao datetime)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS produto (
	id_produto int auto_increment PRIMARY KEY,
	id_categoria int,
	id_fornecedor int,
	nome varchar(100),
	preco_compra decimal(10,2),
	descricao varchar(255),
	preco_venda decimal(10,2),
	estoque_minimo int,
	cor varchar(30),
	tamanho varchar(3),
	material varchar(50),
	estoque int,
	codigo_barras varchar(20),
	dt_cadastro datetime,
	dt_alteracao datetime)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS venda(
	id_venda int auto_increment PRIMARY KEY,
	id_cliente int,
	id_usuario int,
	observacao varchar(100),
	valor_pago decimal(10,2),
	data_venda datetime,
	faturado char(1),
	valor_venda decimal(10,2),
	qtd_parcelas int)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS movimento (
	id_movimento int auto_increment PRIMARY KEY,
	id_produto int,
	id_venda_produto int,
	id_fornecedor int,
	datahora datetime,
	descricao varchar(255),
	tipo_movimentacao char(1),
	quantidade_estoque int,
	quantidade int,
	valor_unitario decimal(10,2),
	valor_total decimal(10,2))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS caixa (
	id_caixa int auto_increment PRIMARY KEY,
	data_abertura datetime,
	data_fechamento datetime,
	valor_fechamento decimal(10,2),
	valor_abertura decimal(10,2))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS caixa_movimento(
	id_caixa_movimento int auto_increment PRIMARY KEY,
	id_caixa int,
	abertura char(1),
	descricao varchar (255),
	data datetime,
	tipo_movimento char(1),
	valor decimal (10,2))
ENGINE = InnoDB;


-- Antiga tabela parcela
CREATE TABLE IF NOT EXISTS pagamento(
	id_pagamento int auto_increment PRIMARY KEY,
	id_lancamento int,
	id_caixa int,
	forma_pgto char(1),
	valor decimal(10,2),
	data_pagamento datetime)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS venda_produto (
	id_venda_produto int auto_increment PRIMARY KEY,
	id_produto int,
	id_venda int,
	quantidade int,
	subtotal decimal(10,2),
	preco_unitario decimal(10,2))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS 'lancamentos' (
  'id_lancamento' int(11) NOT NULL AUTO_INCREMENT,
  'descricao' varchar(255) DEFAULT NULL,
  'valor' varchar(15) NOT NULL,
  'valor_pago' decimal(10,2),
  'data_vencimento' date NOT NULL,
  'data_pagamento' date DEFAULT NULL,
  'baixado' tinyint(1) DEFAULT NULL,
  'cliente_fornecedor' varchar(255) DEFAULT NULL,
  'forma_pgto' varchar(100) DEFAULT NULL,
  'tipo' varchar(45) DEFAULT NULL,
  'anexo' varchar(250) DEFAULT NULL,
  'clientes_id' int(11) DEFAULT NULL,
  'parcela' int DEFAULT NULL,
  'id_venda' int DEFAULT NULL,
  'entrada' char (1))
  PRIMARY KEY ('id_lancamento')
) ENGINE=InnoDB;

ALTER TABLE pessoa_fisica ADD FOREIGN KEY(id_pessoa) REFERENCES pessoa (id_pessoa) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pessoa_juridica ADD FOREIGN KEY(id_pessoa) REFERENCES pessoa (id_pessoa) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE fornecedor ADD FOREIGN KEY(id_pessoa_juridica) REFERENCES pessoa_juridica (id_pessoa_juridica) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE telefone ADD FOREIGN KEY(id_pessoa) REFERENCES pessoa (id_pessoa) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE funcionario ADD FOREIGN KEY(id_pessoa_fisica) REFERENCES pessoa_fisica (id_pessoa_fisica) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE usuario ADD FOREIGN KEY(id_funcionario) REFERENCES funcionario (id_funcionario) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE cliente ADD FOREIGN KEY(id_pessoa_fisica) REFERENCES pessoa_fisica (id_pessoa_fisica) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE cliente ADD FOREIGN KEY(id_pessoa_juridica) REFERENCES pessoa_juridica (id_pessoa_juridica) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE produto ADD FOREIGN KEY(id_categoria) REFERENCES categoria (id_categoria) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE produto ADD FOREIGN KEY(id_fornecedor) REFERENCES fornecedor (id_fornecedor) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE movimento ADD FOREIGN KEY(id_produto) REFERENCES produto (id_produto) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE movimento ADD FOREIGN KEY(id_venda_produto) REFERENCES venda_produto (id_venda_produto) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE movimento ADD FOREIGN KEY(id_fornecedor) REFERENCES fornecedor (id_fornecedor) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE venda_produto ADD FOREIGN KEY(id_produto) REFERENCES produto (id_produto) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE venda_produto ADD FOREIGN KEY(id_venda) REFERENCES venda (id_venda) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE parcela ADD FOREIGN KEY(id_venda) REFERENCES venda (id_venda) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE venda ADD FOREIGN KEY(id_cliente) REFERENCES cliente (id_cliente) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE venda ADD FOREIGN KEY(id_usuario) REFERENCES usuario (id_usuario) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE usuario ADD FOREIGN KEY(id_permissao) REFERENCES permissoes (idPermissao) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE lancamentos ADD FOREIGN KEY(id_venda) REFERENCES venda (id_venda) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE pagamento ADD FOREIGN KEY(id_caixa) REFERENCES caixa (id_caixa) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE caixa_movimento ADD FOREIGN KEY(id_caixa) REFERENCES caixa (id_caixa) ON DELETE RESTRICT ON UPDATE CASCADE;


/*========================TRIGGERS========================*/

DELIMITER $$

CREATE TRIGGER trg_insert_movimento_estoque 
	AFTER INSERT ON movimento FOR EACH ROW
	BEGIN
		IF NEW.tipo_movimentacao =  'E' THEN
			UPDATE produto SET estoque = estoque + NEW.quantidade
				WHERE id_produto = NEW.id_produto;
		ELSE
			UPDATE produto SET estoque = estoque - NEW.quantidade
				WHERE id_produto = NEW.id_produto;
		END IF;
	END$$


CREATE TRIGGER trg_delete_movimento_estoque 
	AFTER DELETE ON movimento FOR EACH ROW
	BEGIN
		IF OLD.tipo_movimentacao =  'E' THEN
			UPDATE produto SET estoque = estoque - OLD.quantidade
				WHERE id_produto = OLD.id_produto;
		ELSE
			UPDATE produto SET estoque = estoque + OLD.quantidade
				WHERE id_produto = OLD.id_produto;
		END IF;
	END$$


CREATE TRIGGER trg_update_movimento_estoque 
	AFTER UPDATE ON movimento FOR EACH ROW
	BEGIN
		IF OLD.tipo_movimentacao =  'E' THEN
			IF NEW.tipo_movimentacao = 'S' THEN
				UPDATE produto SET estoque = OLD.quantidade_estoque - NEW.quantidade
					WHERE id_produto = OLD.id_produto;	
			ELSE
				UPDATE produto SET estoque = OLD.quantidade_estoque + NEW.quantidade
					WHERE id_produto = OLD.id_produto;
			END IF;
		ELSE
			IF NEW.tipo_movimentacao = 'E' THEN
				UPDATE produto SET estoque = OLD.quantidade_estoque + NEW.quantidade
				WHERE id_produto = OLD.id_produto;
			ELSE
				UPDATE produto SET estoque = OLD.quantidade_estoque - NEW.quantidade
					WHERE id_produto = OLD.id_produto;
			END IF;
		END IF;
	END$$

-- ==================== TRIGGERS VENDAS =============


CREATE TRIGGER trg_insert_venda_movimento 
	AFTER INSERT ON venda_produto FOR EACH ROW
	BEGIN
		DECLARE qtd_estoque INT;
		SET qtd_estoque = (select estoque from produto WHERE id_produto = NEW.id_produto);
		INSERT INTO movimento (id_produto, datahora, descricao, quantidade, quantidade_estoque, tipo_movimentacao, id_venda_produto, valor_unitario, valor_total)
			VALUES (NEW.id_produto, NOW(), 'Venda', NEW.quantidade, qtd_estoque, 'S', NEW.id_venda_produto, NEW.preco_unitario, NEW.subtotal);
	END$$


CREATE TRIGGER trg_update_venda_movimento
	AFTER UPDATE ON venda_produto FOR EACH ROW
	BEGIN
		UPDATE movimento SET datahora = NOW() and quantidade = NEW.quantidade
			WHERE id_venda_produto = OLD.id_venda_produto;
	END$$


CREATE TRIGGER trg_delete_venda_movimento
	AFTER DELETE ON venda_produto FOR EACH ROW
	BEGIN
		DELETE FROM movimento
			WHERE id_venda_produto = OLD.id_venda_produto;
		UPDATE produto SET estoque = estoque + OLD.quantidade
			WHERE id_produto = OLD.id_produto;
	END$$


DELIMITER ;






/* =====================  FAZER ==============================*/

/* TRIGGERS */
trg_insert_venda_lancamento
trg_delete_venda_lancamento
trg_update_venda_lancamento



/* CRUDS */

usuario 
caixa 
parcelas/pagamento
vendas



--
-- Estrutura para tabela 'permissoes'
--

DROP TABLE IF EXISTS 'permissoes';
CREATE TABLE IF NOT EXISTS 'permissoes' (
  'idPermissao' int(11) NOT NULL AUTO_INCREMENT,
  'nome' varchar(80) NOT NULL,
  'permissoes' text,
  'situacao' tinyint(1) DEFAULT NULL,
  'data' date DEFAULT NULL,
  PRIMARY KEY ('idPermissao')
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Estrutura para tabela 'emitente'
--

DROP TABLE IF EXISTS emitente;
CREATE TABLE IF NOT EXISTS emitente (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(255) NULL,
  cnpj varchar(45) NULL,
  ie varchar(50) NULL,
  rua varchar(70) NULL,
  numero varchar(15) NULL,
  bairro varchar(45) NULL,
  cidade varchar(45) NULL,
  estado varchar(45) NULL,
  uf varchar(20) NULL,
  telefone varchar(20) NULL,
  email varchar(255) NULL,
  url_logo varchar(225) NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela 'emitente'
--

INSERT INTO emitente (id, nome, cnpj, ie, rua, numero, bairro, cidade, uf, telefone, email, url_logo) VALUES
(1, 'Aski - Artigos esportivos', '18557644000140', 'ISENTO', 'Rua teste', '80', 'Uvaranas', 'Ponta Grossa', 'Paraná', '42999341204', 'contato@aski.com.br', 'http://academiaasato.com.br/sistemas/aski/assets/uploads/b0762ba1f2a3471865018cec77f52fe3.png');


INSERT INTO permissoes (nome, permissoes, situacao, data) VALUES
('Administrador', 'a:38:{s:8:"aCliente";s:1:"1";s:8:"eCliente";s:1:"1";s:8:"dCliente";s:1:"1";s:8:"vCliente";s:1:"1";s:8:"aProduto";s:1:"1";s:8:"eProduto";s:1:"1";s:8:"dProduto";s:1:"1";s:8:"vProduto";s:1:"1";s:8:"aServico";s:1:"1";s:8:"eServico";s:1:"1";s:8:"dServico";s:1:"1";s:8:"vServico";s:1:"1";s:3:"aOs";s:1:"1";s:3:"eOs";s:1:"1";s:3:"dOs";s:1:"1";s:3:"vOs";s:1:"1";s:6:"aVenda";s:1:"1";s:6:"eVenda";s:1:"1";s:6:"dVenda";s:1:"1";s:6:"vVenda";s:1:"1";s:8:"aArquivo";s:1:"1";s:8:"eArquivo";s:1:"1";s:8:"dArquivo";s:1:"1";s:8:"vArquivo";s:1:"1";s:11:"aLancamento";s:1:"1";s:11:"eLancamento";s:1:"1";s:11:"dLancamento";s:1:"1";s:11:"vLancamento";s:1:"1";s:8:"cUsuario";s:1:"1";s:9:"cEmitente";s:1:"1";s:10:"cPermissao";s:1:"1";s:7:"cBackup";s:1:"1";s:8:"rCliente";s:1:"1";s:8:"rProduto";s:1:"1";s:8:"rServico";s:1:"1";s:3:"rOs";s:1:"1";s:6:"rVenda";s:1:"1";s:11:"rFinanceiro";s:1:"1";}', 1, '2014-09-03'),
('Comum', 'a:38:{s:8:"aCliente";s:1:"1";s:8:"eCliente";s:1:"1";s:8:"dCliente";s:1:"1";s:8:"vCliente";s:1:"1";s:8:"aProduto";s:1:"1";s:8:"eProduto";s:1:"1";s:8:"dProduto";s:1:"1";s:8:"vProduto";s:1:"1";s:8:"aServico";s:1:"1";s:8:"eServico";s:1:"1";s:8:"dServico";s:1:"1";s:8:"vServico";s:1:"1";s:3:"aOs";N;s:3:"eOs";N;s:3:"dOs";N;s:3:"vOs";N;s:6:"aVenda";s:1:"1";s:6:"eVenda";s:1:"1";s:6:"dVenda";s:1:"1";s:6:"vVenda";s:1:"1";s:8:"aArquivo";s:1:"1";s:8:"eArquivo";s:1:"1";s:8:"dArquivo";s:1:"1";s:8:"vArquivo";s:1:"1";s:11:"aLancamento";s:1:"1";s:11:"eLancamento";s:1:"1";s:11:"dLancamento";s:1:"1";s:11:"vLancamento";s:1:"1";s:8:"cUsuario";s:1:"1";s:9:"cEmitente";s:1:"1";s:10:"cPermissao";s:1:"1";s:7:"cBackup";s:1:"1";s:8:"rCliente";s:1:"1";s:8:"rProduto";s:1:"1";s:8:"rServico";s:1:"1";s:3:"rOs";N;s:6:"rVenda";s:1:"1";s:11:"rFinanceiro";s:1:"1";}', 1, '2017-08-13'),
('vendedor', 'a:38:{s:8:"aCliente";s:1:"1";s:8:"eCliente";s:1:"1";s:8:"dCliente";s:1:"1";s:8:"vCliente";s:1:"1";s:8:"aProduto";s:1:"1";s:8:"eProduto";s:1:"1";s:8:"dProduto";s:1:"1";s:8:"vProduto";s:1:"1";s:8:"aServico";N;s:8:"eServico";N;s:8:"dServico";N;s:8:"vServico";N;s:3:"aOs";N;s:3:"eOs";N;s:3:"dOs";N;s:3:"vOs";N;s:6:"aVenda";s:1:"1";s:6:"eVenda";s:1:"1";s:6:"dVenda";s:1:"1";s:6:"vVenda";s:1:"1";s:8:"aArquivo";N;s:8:"eArquivo";N;s:8:"dArquivo";N;s:8:"vArquivo";N;s:11:"aLancamento";s:1:"1";s:11:"eLancamento";s:1:"1";s:11:"dLancamento";s:1:"1";s:11:"vLancamento";s:1:"1";s:8:"cUsuario";s:1:"1";s:9:"cEmitente";s:1:"1";s:10:"cPermissao";N;s:7:"cBackup";s:1:"1";s:8:"rCliente";s:1:"1";s:8:"rProduto";s:1:"1";s:8:"rServico";N;s:3:"rOs";N;s:6:"rVenda";s:1:"1";s:11:"rFinanceiro";s:1:"1";}', 1, '2017-08-19');

INSERT INTO pessoa (email, nome, logradouro, cep, numero, bairro, cidade, estado, sexo, data_nascimento) VALUES
('admin@admin.com', 'Bruno', 'Rua: Joanna Gorte', '84031126', '80', 'Uvaranas ', 'Ponta Grossa', 'PR', 'M', '1993-09-07');


INSERT INTO pessoa_fisica (id_pessoa, cpf) VALUES
(1, '09088507945');

INSERT INTO funcionario (id_pessoa_fisica, cargo, data_contratacao) VALUES
(1, 'Vendedora', '2016-05-02');

INSERT INTO usuario (id_funcionario, tipo_usuario, senha, login, id_permissao, data_cadastro, status, email) VALUES
(1, NULL, 'da4b9237bacccdf19c0760cab7aec4a8359010b0', 'bruno', 1, '2017-09-08 21:14:13', 1, '');










INSERT INTO produto (id_categoria, nome, preco_compra, descricao, preco_venda, estoque_minimo, cor, tamanho, estoque, dt_cadastro)
	VALUES (8, "Faixa Padrão", 14, "1,80m - 3 a 4 anos", 18, 0, 'Preta',  "0", 0, NOW());

INSERT INTO produto (id_categoria, nome, preco_compra, descricao, preco_venda, estoque_minimo, cor, tamanho, estoque, dt_cadastro)
	VALUES (8, "Faixa Padrão", 14, "2,20m - 4 a 7 anos", 18, 0, 'Preta',  "1", 0, NOW());

INSERT INTO produto (id_categoria, nome, preco_compra, descricao, preco_venda, estoque_minimo, cor, tamanho, estoque, dt_cadastro)
	VALUES (8, "Faixa Padrão", 14, "2,50m - 8 a 9 anos", 18, 0, 'Preta',  "2", 0, NOW());

INSERT INTO produto (id_categoria, nome, preco_compra, descricao, preco_venda, estoque_minimo, cor, tamanho, estoque, dt_cadastro)
	VALUES (8, "Faixa Padrão", 14, "2,70m - &gt; 10 anos", 18, 0, 'Preta',  "3", 0, NOW());		

INSERT INTO produto (id_categoria, nome, preco_compra, descricao, preco_venda, estoque_minimo, cor, tamanho, estoque, dt_cadastro)
	VALUES (8, "Faixa Padrão", 14, "2,90m - adulto", 18, 0, 'Preta',  "4", 0, NOW());

INSERT INTO produto (id_categoria, nome, preco_compra, descricao, preco_venda, estoque_minimo, cor, tamanho, estoque, dt_cadastro)
	VALUES (8, "Faixa Padrão", 14, "3,10m - adulto", 18, 0, 'Preta',  "5", 0, NOW());

