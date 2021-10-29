-- Cria Base e Tabelas

CREATE DATABASE CertMat;
USE CertMat;

CREATE TABLE Laboratorio (
    CodLaboratorio int(3) NOT NULL AUTO_INCREMENT,
    Nome varchar(255), 
    Usuario vachar(30), 
    Senha varchar(30),

    PRIMARY KEY (CodLaboratorio)
);

CREATE TABLE Material (
    CodigoMaterial int(3) NOT NULL AUTO_INCREMENT,
    Nome varchar(255), 
    
    PRIMARY KEY(CodMaterial)
);

CREATE TABLE Certificacao (
    Nome varchar(255)
);
