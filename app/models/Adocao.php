<?php

namespace App\Models;

use App\Database;
use ArrayObject;

/**
 * Classe reponsável por representar os dados de uma adocao de pet na aplicação
 */
class Adocao
{
    private $id;

    /**
     * @var int Id do adotante do pet
     */
    private $idAdotante;

    /**
     * @var int Id do doador/responsável anterior do pet
     */
    private $idDoador;

    /**
     * @var int Id do pet adotado
     */
    private $idPet;

    /**
     * @var string Data da adoção do pet
     */
    private $dataAdocao;


    /**
     * @var bool Verificar se foi registrada a devolução da adoção
     */
    private $devolvido;

    /**
     *  Contrutor da classe, responsável por inicializar os dados.
     */
    function __construct(
        int $idAdotante,
        int $idDoador,
        int $idPet,
        string $dataAdocao,
        bool $devolvido = false
    ) {
        $this->idAdotante = $idAdotante;
        $this->idDoador = $idDoador;
        $this->idPet = $idPet;
        $this->dataAdocao = $dataAdocao;
        $this->devolvido = $devolvido;

        $con = Database::getConnection();
        $stm = $con->prepare('SELECT id FROM adocao ORDER BY 1 DESC LIMIT 1');
        $stm->execute();
        $id = $stm->fetch()[0] + 1;
        $this->id = $id;
    }

    /**
     *  Método get genérico para todos os campos
     */
    public function __get($campo)
    {
        return $this->$campo;
    }

    /**
     *  Método set genérico para todos os campos
     */
    public function __set($campo, $valor)
    {
        return $this->$campo = $valor;
    }

    /**
     *  Função que salva os dados da adocao no banco de dados
     */
    public function salvar(): void
    {
        $con = Database::getConnection();
        $stm = $con->prepare
        ('INSERT INTO adocao (idAdotante, idDoador, idPet, dataAdocao, devolvido) VALUES (:idAdotante, :idDoador, :idPet, :dataAdocao, :devolvido);');
        $stm->bindValue(':idAdotante', $this->idAdotante);
        $stm->bindValue(':idDoador', $this->idDoador);
        $stm->bindValue(':idPet', $this->idPet);
        $stm->bindValue(':dataAdocao', $this->dataAdocao);
        $stm->bindValue(':devolvido', $this->devolvido);
        $stm->execute();

        $con = Database::getConnection();
        $stm = $con->prepare
        ('UPDATE pets SET disponivel = false WHERE id = :idPET;');
        $stm->bindValue(':idPet', $this->idPet);
        $stm->execute();
    }

    public function resgistrarDevolução(): void
    {
        $con = Database::getConnection();
        $stm = $con->prepare
        ('UPDATE pets SET disponivel = true WHERE id = :idPET;');
        $stm->bindValue(':idPet', $this->idPet);
        $stm->execute();

        $stm = $con->prepare
        ('UPDATE adocao SET devolvido = true WHERE id = :id;');
        $stm->bindValue(':id', $this->id);
        $stm->execute();
    }
}