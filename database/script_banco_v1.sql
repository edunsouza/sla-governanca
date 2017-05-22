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

INSERT INTO usuarios (nome) VALUES ('EDUARDO'), ('JOÃO'), ('MARIA'), ('JOSÉ'), ('PAULO');
INSERT INTO setores (titulo) VALUES ('INFORMÁTICA'), ('LOGÍSTICA'), ('ESTOQUE'), ('ATENDIMENTO'), ('ENCANAMENTO E ELÉTRICA'), ('INFRAESTRUTURA'), ('FINANCEIRO'), ('COMPRAS'), ('SEGURANÇA'), ('ALMOXARIFADO');
INSERT INTO cargos (titulo) VALUES ('AUXILIAR'), ('GERENTE'), ('DIRETOR'), ('ANALISTA'), ('LÍDER');
INSERT INTO usuarios_setor (idusuario, idsetor, idcargo) VALUES (1,1,5), (2,2,1), (3,4,4), (4,10,2);
INSERT INTO categorias (titulo) VALUES ('CONTAS, SENHAS E SEGURANÇA'), ('REDE E INTERNET'), ('SOFTWARE'), ('EQUIPAMENTOS MECÂNICOS / ELÉTRICOS'), ('COMPUTADORES E IMPRESSORAS'), ('DISPOSITIVOS DE COMUNICAÇÃO'), ('CRACHÁS E UNIFORMES'), ('SERVIÇOS FINANCEIROS'), ('INFRAESTRUTURA E INSTALAÇÕES'), ('TRANSPORTE'), ('ALMOXARIFADO'), ('REPOSIÇÃO DE ESTOQUE');
INSERT INTO permissoes (titulo) VALUES ('PÚBLICO'), ('EQUIPE'), ('LÍDER DE EQUIPE'), ('DIRETORES'), ('GERENTES');
INSERT INTO servicos (idcategoria, descricao, setorresponsavel, permissaoabertura, sla, prioridade, atendimentode, atendimentoate) VALUES (1, 'ALTERAÇÃO DE SENHA', 1, 1, 48, 'M', '10:00:00', '16:00:00'), (4, 'DEFEITOS DE EQUIPAMENTO', 10, 1, 48, 'A', '08:00:00', '18:00:00'), (3, 'ATUALIZAÇÃO DE SOFTWARE', 1, 3, 72, 'B', '08:00:00', '12:00:00'), (7, 'CONFECÇÃO DE CRACHÁ', 9, 1, 96, 'B', '10:00:00', '15:00:00');

