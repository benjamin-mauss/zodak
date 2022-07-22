drop database zodak;
create database zodak;

use zodak;
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nome VARCHAR(256) NOT NULL,
    matricula VARCHAR(256),
    hash_senha VARCHAR(256)
);

CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    grade INT,
    nome VARCHAR(256)
);

CREATE TABLE horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_turma INT,
    FOREIGN KEY (id_turma)
        REFERENCES turmas (id),
    periodo INT,
    dia_semana INT,
    inicio TIME,
    fim TIME
);

CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(256),
    matricula VARCHAR(32),
    id_turma INT,
    FOREIGN KEY (id_turma)
        REFERENCES turmas (id)
);
CREATE TABLE presencas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno INT,
    FOREIGN KEY (id_aluno)
        REFERENCES alunos (id),
    id_horario INT,
    FOREIGN KEY (id_horario)
        REFERENCES horarios (id),
    present BOOL DEFAULT FALSE,
    _data date
);
use zodak;
SHOW TABLE STATUS where name="alunos";


SELECT a.id, a.nome, a.matricula, t.nome as turma FROM zodak.alunos as a INNER JOIN zodak.turmas as t on a.id_turma = t.id ;
drop table horarios;
SET FOREIGN_KEY_CHECKS=1;




SELECT 
    p.id AS id_p,
    p.id_aluno AS id_a,
    t.id AS id_t,
    p._data AS _date,
    a.matricula AS matricula,
    p.present AS present,
    a.nome AS nome,
    h.periodo AS periodo,
    h.inicio as inicio,
    h.fim as fim,
    t.nome AS turma
FROM
    zodak.presencas AS p
        JOIN
    zodak.alunos AS a ON p.id_aluno = a.id
        JOIN
    zodak.horarios AS h ON p.id_horario = h.id
        JOIN
    zodak.turmas AS t ON a.id_turma = t.id