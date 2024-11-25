CREATE DATABASE loja_bolos;

USE loja_bolos;

-- Tabela de Funcionários
CREATE TABLE funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(50) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL
);

-- Tabela de Bolos
CREATE TABLE bolos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    imagem_url VARCHAR(255) NOT NULL
);

insert into funcionarios (nome_usuario, senha_hash) values ('admin', '$2y$10$mQgFa3JLuXvzmq9g/Ux7yua6uytQkLPVU0NW1KsxYPZA.XcaIBSFW'); /*senha: senha123*/