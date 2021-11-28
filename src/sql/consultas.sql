-- Consulta por certificacão através do nome do Material.

SELECT
Certificacao.nome AS cer_nome,
Material.nome AS mat_nome,
Laboratorio.cnpj AS lab_cnpj,
Laboratorio.nome AS lab_nome,
Laboratorio.uf AS lab_uf,
Laboratorio.cidade AS lab_cidade,
Laboratorio.endereco AS lab_end,
Laboratorio.cep AS lab_cep,
Laboratorio.telefone AS lab_tel
FROM Certificacao
JOIN Laboratorio ON Laboratorio.id = Certificacao.laboratorio_id
JOIN Material ON Material.id = Certificacao.material_id
WHERE Material.nome = ?;