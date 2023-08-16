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
        if (isset(self::$con)) return self::$con;

        self::$con = new PDO('sqlite:meu-amigo-pet-db.sqlite');
        self::$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$con;
    }

    static public function createSchema(): void
    {
        $con = self::getConnection();
        $con->exec('CREATE TABLE IF NOT EXISTS ong_protetora (
            ong_protetora_id SERIAL NOT NULL PRIMARY KEY,
            nome VARCHAR(60) NOT NULL,
            cpf_cnpj VARCHAR(14) NOT NULL,
            endereco VARCHAR(255) NOT NULL, 
            telefone INTEGER NOT NULL, 
            email VARCHAR(60) NOT NULL,
            senha TEXT NOT NULL
        );
        ');

        $con->exec('CREATE TABLE IF NOT EXISTS populacao (
            populacao_id SERIAL NOT NULL PRIMARY KEY,
            nome VARCHAR(60) NOT NULL,
            cpf VARCHAR(11) NOT NULL,
            endereco VARCHAR(255) NOT NULL,
            telefone INTEGER NOT NULL, 
            email VARCHAR(60) NOT NULL,
            senha TEXT NOT NULL
        );
        ');
    }
}
