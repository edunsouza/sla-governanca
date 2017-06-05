CREATE DATABASE SLA_GTI;
USE SLA_GTI;

CREATE TABLE cargos (
	id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(64) NOT NULL
);

CREATE TABLE setores (
	id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(64) NOT NULL
);

CREATE TABLE usuarios (
	id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(128) NOT NULL
);

CREATE TABLE usuarios_setor (
	id INT PRIMARY KEY AUTO_INCREMENT,
    idusuario INT REFERENCES usuarios(id),
    idsetor INT REFERENCES setores(id),
    idcargo INT REFERENCES cargos(id)
);

CREATE TABLE categorias (
	id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(128) NOT NULL
);

CREATE TABLE permissoes (
	id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(64) NOT NULL
);

CREATE TABLE servicos (
	id INT PRIMARY KEY AUTO_INCREMENT,
    idcategoria INT REFERENCES categorias(id),
    descricao VARCHAR(128) NOT NULL,
    setorresponsavel INT REFERENCES setores(id),
    permissaoabertura INT REFERENCES permissoes(id),
    sla INT NOT NULL,
    prioridade ENUM('B', 'M', 'A'),
    atendimentode TIME NOT NULL,
    atendimentoate TIME NOT NULL
);

CREATE TABLE chamados (
	id INT PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(256) NULL,
    idservico INT REFERENCES servicos(id),
    usuarioabertura INT REFERENCES usuarios(id),
    usuarioencerramento INT REFERENCES usuarios(id),
    status ENUM('P', 'A', 'F') NOT NULL,
    abertura DATETIME NOT NULL,
    fechamento DATETIME NULL
);

INSERT INTO usuarios (id, nome) VALUES
(1, 'EDUARDO'),
(2, 'JOÃO'),
(3, 'MARIA'),
(4, 'JOSÉ'),
(5, 'PAULO');

INSERT INTO setores (id, titulo) VALUES
(1, 'INFORMÁTICA'),
(2, 'LOGÍSTICA'),
(3, 'ESTOQUE'),
(4, 'ATENDIMENTO'),
(5, 'ENCANAMENTO E ELÉTRICA'),
(6, 'INFRAESTRUTURA'),
(7, 'FINANCEIRO'),
(8, 'COMPRAS'),
(9, 'SEGURANÇA'),
(10, 'ALMOXARIFADO');

INSERT INTO cargos (id, titulo) VALUES
(1, 'AUXILIAR'),
(2, 'GERENTE'),
(3, 'DIRETOR'),
(4, 'ANALISTA'),
(5, 'LÍDER');

INSERT INTO usuarios_setor (id, idusuario, idsetor, idcargo) VALUES
(1,		1,1,5),
(2,		2,2,1),
(3,		3,4,4),
(4,		4,10,2);

INSERT INTO categorias (id, titulo) VALUES
(1, 'CONTAS, SENHAS E SEGURANÇA'),
(2, 'REDE E INTERNET'),
(3, 'SOFTWARE'),
(4, 'EQUIPAMENTOS MECÂNICOS / ELÉTRICOS'),
(5, 'COMPUTADORES E IMPRESSORAS'),
(6, 'DISPOSITIVOS DE COMUNICAÇÃO'),
(7, 'CRACHÁS E UNIFORMES'),
(8, 'SERVIÇOS FINANCEIROS'),
(9, 'INFRAESTRUTURA E INSTALAÇÕES'),
(10, 'TRANSPORTE'),
(11, 'ALMOXARIFADO'),
(12, 'REPOSIÇÃO DE ESTOQUE');

INSERT INTO permissoes (id, titulo) VALUES
(1, 'PÚBLICO'),
(2, 'EQUIPE'),
(3, 'LÍDER DE EQUIPE'),
(4, 'DIRETORES'),
(5, 'GERENTES');

INSERT INTO servicos (id, idcategoria, descricao, setorresponsavel, permissaoabertura, sla, prioridade, atendimentode, atendimentoate) VALUES
(1, 1, 'ALTERAÇÃO DE SENHA', 1, 1, 48, 'M', '10:00:00', '16:00:00'),
(2, 4, 'DEFEITOS DE EQUIPAMENTO', 10, 1, 48, 'A', '08:00:00', '18:00:00'),
(3, 3, 'ATUALIZAÇÃO DE SOFTWARE', 1, 3, 72, 'B', '08:00:00', '12:00:00'),
(4, 7, 'CONFECÇÃO DE CRACHÁ', 9, 1, 96, 'B', '10:00:00', '15:00:00');

INSERT INTO chamados (id, descricao, idservico, usuarioabertura, usuarioencerramento, status, abertura, fechamento) VALUES
(1, 'PRECISO DE ALTERAÇÃO DE SENHA', 1, 1, NULL, 'P', '2017-05-19 16:05:00', NULL),
(2, 'MEU COMPUTADOR ESTRAGOU', 2, 1, 4, 'F', '2017-05-23 12:15:00', '2017-05-24 16:42:00'),
(3, 'SOLICITO CRACHÁ NOVO, O MEU ESTÁ NA CAPA DA GAITA', 4, 4, NULL, 'A', '2017-05-18 12:01:03', NULL),
(4, 'MEU S.O TÁ LENTO, FORMATA PRA MIM', 3, 3, NULL, 'P', '2017-05-25 11:15:00', NULL);