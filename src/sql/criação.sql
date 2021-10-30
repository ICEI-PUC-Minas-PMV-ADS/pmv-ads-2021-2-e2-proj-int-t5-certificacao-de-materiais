-- Cria Base e Tabelas

CREATE DATABASE CertMat;
USE CertMat;

CREATE TABLE Laboratorio (
    ID int(3) NOT NULL AUTO_INCREMENT,
    Nome varchar(255), 
    Usuario vachar(30), 
    Senha varchar(30),

    PRIMARY KEY (ID)
);

CREATE TABLE Material (
    ID int(3) NOT NULL AUTO_INCREMENT,
    Nome varchar(255), 
    
    PRIMARY KEY(ID)
);

-- Junction Laboratorio/Material

CREATE TABLE Certificacao (
    Laboratorio_ID int NOT NULL,
    Material_ID int NOT NULL,
    Nome varchar(255),

    CONSTRAINT Certificacao_Laboratorio FOREIGN KEY (Laboratorio_ID) REFERENCES Laboratorio(ID),
    CONSTRAINT Certificacao_Material FOREIGN KEY (Material_ID) REFERENCES Material(ID),
    CONSTRAINT Certificacao_ID UNIQUE (Laboratorio_ID, Material_ID)
);

