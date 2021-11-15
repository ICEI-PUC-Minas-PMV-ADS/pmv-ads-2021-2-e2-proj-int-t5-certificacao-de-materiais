-- Começa do zero

DROP DATABASE IF EXISTS CDM;
CREATE DATABASE CDM;

-- Cria usuários

CREATE USER IF NOT EXISTS 'public_user'@'localhost' IDENTIFIED BY 'EEFKrc!!51NdI';
GRANT SELECT, INSERT ON CDM.* TO 'public_user'@'localhost';

-- Cria estrutura do banco

USE CDM;

CREATE TABLE Laboratorio (
    Nome varchar(255) NOT NULL, 
    Usuario varchar(30), 
    Senha varchar(30),
    Contato varchar(255),

    PRIMARY KEY (Nome)
);

CREATE TABLE Material (
    Nome varchar(255) NOT NULL, 
    
    PRIMARY KEY(Nome)
);

CREATE TABLE Usuario (
	id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(20) NOT NULL UNIQUE,
	password varchar(20) NOT NULL
);

-- Junction Laboratorio/Material

CREATE TABLE Certificacao (
    Laboratorio_Nome varchar(255),
    Material_Nome varchar(255),

    CONSTRAINT FK_Laboratorio FOREIGN KEY (Laboratorio_Nome) REFERENCES Laboratorio (Nome),
    CONSTRAINT FK_Material FOREIGN KEY (Material_Nome) REFERENCES Material (Nome),

    CONSTRAINT PK_Certificacao PRIMARY KEY (Laboratorio_Nome, Material_Nome)
);