CREATE TABLE tbl_usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    senha VARCHAR(32) NOT NULL
);

CREATE TABLE tbl_empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(40) NOT NULL
);

CREATE TABLE tbl_funcionario (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    cpf CHAR(11) NOT NULL UNIQUE,
    rg VARCHAR(20) UNIQUE,
    email VARCHAR(30) NOT NULL UNIQUE,
    id_empresa INT NOT NULL,
    data_cadastro DATE DEFAULT CURRENT_DATE NOT NULL,
    salario DOUBLE(10,2) NOT NULL,
    bonificacao DOUBLE(10,2) DEFAULT 0.00,
    FOREIGN KEY (id_empresa) REFERENCES tbl_empresa(id_empresa) ON DELETE CASCADE,
);