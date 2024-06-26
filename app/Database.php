<?php

namespace App;

use PDO;

/**
 *  Classe responsável por fazer a gestão da conexão com o banco.
 */
class Database
{
    static $con;

    static public function getConnection(): PDO
    {
        if (isset(self::$con))
            return self::$con;

        self::$con = new PDO('sqlite:meu-amigo-pet-db.sqlite');
        self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$con;
    }

    static public function createSchema(): void
    {
        $con = self::getConnection();
        $con->exec('CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER NOT NULL PRIMARY KEY,
            tipo VARCHAR(60) NOT NULL,
            nome VARCHAR(60) NOT NULL,
            cpf_cnpj VARCHAR(14) NOT NULL,
            endereco VARCHAR(255) NOT NULL,
            complemento  VARCHAR(255),
            telefone INTEGER NOT NULL, 
            email VARCHAR(60) NOT NULL,
            senha TEXT NOT NULL,
            chave TEXT NOT NULL,
            confEmail BOOLEAN NOT NULL
        );
        CREATE TABLE IF NOT EXISTS pets (
            id INTEGER NOT NULL PRIMARY KEY,
            idResponsavel INTEGER NOT NULL,
            nome VARCHAR(60) NOT NULL,
            genero VARCHAR(1) NOT NULL,
            castrado VARCHAR(1) NOT NULL,
            forneceCastracao VARCHAR(1),
            especie VARCHAR(60) NOT NULL,
            dataNascimento DATE, 
            dataResgate DATE NOT NULL,
            custoMensal FLOAT,
            historia VARCHAR(255),
            foto VARCHAR(255),
            disponivel BOOLEAN NOT NULL,
            dataObito DATE,
            FOREIGN KEY (idResponsavel) REFERENCES usuarios(id)
        );
        CREATE TABLE IF NOT EXISTS doencasPet (
            idPet INTEGER NOT NULL,
            nomeDoenca INTEGER NOT NULL,
            FOREIGN KEY (idPet) REFERENCES pets(id),
            PRIMARY KEY (idPet,nomeDoenca)
        );
        CREATE TABLE IF NOT EXISTS adocao (
            id INTEGER NOT NULL,
            idDoador INTEGER NOT NULL,
            idAdotante INTEGER NOT NULL,
            idPet INTEGER NOT NULL,
            dataAdocao DATE NOT NULL,
            devolvido BOOLEAN NOT NULL,
            FOREIGN KEY (idPet) REFERENCES pets(id),
            FOREIGN KEY (idAdotante) REFERENCES usuarios(id),
            FOREIGN KEY (idDoador) REFERENCES usuarios(id),
            PRIMARY KEY (id, idPet,idAdotante,idDoador,dataAdocao)
        );
        ');

    }
}
