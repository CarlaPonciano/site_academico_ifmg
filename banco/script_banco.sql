/*CRIAÇÃO DAS TABELAS*/
CREATE TABLE tipo_perfil(
    id INT NOT NULL AUTO_INCREMENT,
    tipo VARCHAR(25) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE usuario(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    cpf VARCHAR(20) NOT NULL,
    tipo INT NOT NULL,
    email VARCHAR(60) NOT NULL,
    login VARCHAR(50) NOT NULL,
    senha VARCHAR(50) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (tipo) REFERENCES tipo_perfil(id)
);

CREATE TABLE secao_pagina(
    id INT NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(45) NOT NULL,
    exibir TINYINT(1) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE pagina(
    id INT NOT NULL AUTO_INCREMENT,
    id_secao_pag INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    conteudo LONGTEXT,
    id_autor INT NOT NULL,
    id_autor_aprovacao INT NOT NULL,
    data_alteracao DATETIME NOT NULL,
    data_aprovacao DATETIME NOT NULL,
    exibir TINYINT(1) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_secao_pag) REFERENCES secao_pagina(id),
    FOREIGN KEY (id_autor) REFERENCES usuario(id),
    FOREIGN KEY (id_autor_aprovacao) REFERENCES usuario(id)
);

CREATE TABLE pagina_pendente(
    id INT NOT NULL AUTO_INCREMENT,
    id_secao_pag INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    conteudo LONGTEXT,
    id_autor INT NOT NULL,
    data_alteracao DATETIME NOT NULL,
    aprovacao TINYINT(0) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_secao_pag) REFERENCES secao_pagina(id),
    FOREIGN KEY (id_autor) REFERENCES usuario(id)
);

CREATE TABLE contato(
    id INT NOT NULL AUTO_INCREMENT,
    endereco VARCHAR(150) NOT NULL,
    email VARCHAR(60) NOT NULL,
    hor_funcionamento VARCHAR(300) NOT NULL,
    id_autor INT NOT NULL,
    id_autor_aprovacao INT NOT NULL,
    data_alteracao DATETIME NOT NULL,
    data_aprovacao DATETIME,
    PRIMARY KEY (id),
    FOREIGN KEY (id_autor) REFERENCES usuario(id),
    FOREIGN KEY (id_autor_aprovacao) REFERENCES usuario(id)
);

CREATE TABLE contato_pendente(
    id INT NOT NULL AUTO_INCREMENT,
    endereco VARCHAR(150) NOT NULL,
    email VARCHAR(60) NOT NULL,
    hor_funcionamento VARCHAR(300) NOT NULL,
    id_autor INT NOT NULL,
    data_alteracao DATETIME NOT NULL,
    aprovacao TINYINT(0) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_autor) REFERENCES usuario(id)
);

CREATE TABLE telefone(
    id INT NOT NULL AUTO_INCREMENT,
    numero VARCHAR(20) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE telefone_contato(
    id_telefone INT NOT NULL,
    id_contato INT NOT NULL,
    PRIMARY KEY (id_telefone, id_contato),
    FOREIGN KEY (id_telefone) REFERENCES telefone(id),
    FOREIGN KEY (id_contato) REFERENCES contato(id),
    FOREIGN KEY (id_contato) REFERENCES contato_pendente(id)
);

CREATE TABLE corpo_docente(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(60) NOT NULL,
    descricao VARCHAR(500),
    link_lattes VARCHAR(60),
    cargo VARCHAR(60),
    img VARCHAR(200),
    id_autor INT NOT NULL,
    id_autor_aprovacao INT NOT NULL,
    data_alteracao DATETIME NOT NULL,
    data_aprovacao DATETIME NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_autor) REFERENCES usuario(id),
    FOREIGN KEY (id_autor_aprovacao) REFERENCES usuario(id)
);

CREATE TABLE corpo_docente_pendente(
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(60) NOT NULL,
    descricao VARCHAR(500),
    link_lattes VARCHAR(60),
    cargo VARCHAR(60),
    img VARCHAR(200),
    id_autor INT NOT NULL,
    data_alteracao DATETIME NOT NULL,
    aprovacao TINYINT(0) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_autor) REFERENCES usuario(id)
);

/*INSERÇÃO DOS TIPOS DE PERFIL*/
INSERT INTO tipo_perfil(tipo) VALUES ("Professor"), ("Administrador");