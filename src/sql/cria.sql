-- Começa do zero

DROP DATABASE IF EXISTS CDM;
CREATE DATABASE CDM;

-- Cria estrutura do banco

USE CDM;

CREATE TABLE Usuario (
	username VARCHAR(20),
	password VARCHAR(20) NOT NULL,

    PRIMARY KEY(username)
);

CREATE TABLE Laboratorio (
    id INT(6) AUTO_INCREMENT,
    usuario_username VARCHAR(20),
    nome VARCHAR(30) NOT NULL,
    cnpj VARCHAR(14) NOT NULL,
    uf VARCHAR(2),
    cidade VARCHAR(30),
    endereco VARCHAR(100),
    cep VARCHAR(13),
    telefone VARCHAR(100),

    PRIMARY KEY (id),
    FOREIGN KEY (usuario_username) REFERENCES Usuario(username)
);

CREATE TABLE Material (
    id INT(6) AUTO_INCREMENT,
    nome VARCHAR(30) NOT NULL, 
    
    PRIMARY KEY(id)
);

-- Junction laboratorio/material

CREATE TABLE Certificacao (
    laboratorio_id INT(6),
    material_id INT(6),
    nome VARCHAR(30),

    CONSTRAINT fk_laboratorio FOREIGN KEY (laboratorio_id) REFERENCES Laboratorio (id),
    CONSTRAINT fk_material FOREIGN KEY (material_id) REFERENCES Material (id),

    CONSTRAINT pk_certificacao PRIMARY KEY (laboratorio_id, material_id)
);

-- Usuários e permissionamento.

CREATE USER IF NOT EXISTS 'public_user'@'localhost' IDENTIFIED BY 'EEFKrc!!51NdI';
GRANT SELECT, INSERT ON CDM.* TO 'public_user'@'localhost';
GRANT UPDATE ON CDM.Laboratorio TO 'public_user'@'localhost';
GRANT DELETE ON CDM.Certificacao TO 'public_user'@'localhost';
