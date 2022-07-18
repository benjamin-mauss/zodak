# drop database zodak;
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
    dia_semana INT
);


CREATE TABLE faces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    face BLOB(2048),
    imagem BLOB(1048576)
);

CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(256),
    matricula VARCHAR(32),
    id_turma INT,
    id_face INT,
    FOREIGN KEY (id_turma)
        REFERENCES turmas (id),
    FOREIGN KEY (id_face)
        REFERENCES faces (id)
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
    dia date,
    materia varchar(100)
);





