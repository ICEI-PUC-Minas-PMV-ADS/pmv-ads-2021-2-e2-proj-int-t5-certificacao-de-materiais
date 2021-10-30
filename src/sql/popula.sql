-- Popula tabelas com valores para testes.

USE CertMat;

INSERT INTO Laboratorio (Nome, Contato) VALUES ("INMETRO", "Avenida Afonso Pena, Nº 666, CEP: 34800-000");

INSERT INTO Material (Nome) VALUES ("Aço");
INSERT INTO Material (Nome) VALUES ("Areia");
INSERT INTO Material (Nome) VALUES ("Cimento");

INSERT INTO Certificacao (Laboratorio_Nome, Material_Nome) VALUES ("INMETRO", "Aço");
INSERT INTO Certificacao (Laboratorio_Nome, Material_Nome) VALUES ("INMETRO", "Areia");
INSERT INTO Certificacao (Laboratorio_Nome, Material_Nome) VALUES ("INMETRO", "Cimento");
