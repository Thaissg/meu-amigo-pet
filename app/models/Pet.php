<?php

namespace App\Models;

use App\Database;
use ArrayObject;

/**
 * Classe reponsável por representar os dados de um usuário na aplicação
 */
class Pet
{

    private $id;

    /**
     * @var int Id do responsável pelo cadastro e administração do pet
     */
    private $idResponsavel;

    /**
     * @var string Nome do pet
     */
    private $nome;

    /**
     * @var string Genero do pet
     */
    private $genero;

    /**
     * @var string Se o pet é castrado ou não
     */
    private $castrado;

    /**
     * @var string Se o usuário fornece a castração do pet (caso o mesmo não for castrado)
     */
    private $forneceCastracao;

    /**
     * @var string Especie do pet
     */
    private $especie;

    /**
     * @var string Data de nascimento do pet
     */
    private $dataNascimento;

    /**
     * @var string Data de resgate do pet
     */
    private $dataResgate;

    /**
     * @var array Doenças do pet
     */
    private $doencas;

    /**
     * @var double Custo mensal do pet
     */
    private $custoMensal;

    /**
     * @var string Historia do pet
     */
    private $historia;

    /**
     * @var string Foto do pet
     */
    private $foto;


    /**
     *  Contrutor da classe, responsável por inicializar os dados.
     */
    function __construct(int $idResponsavel,string $nome, string $genero, string $castrado, string $forneceCastracao, string $especie, string $dataNascimento,
    string $dataResgate, array $doencas, string $custoMensal, string $historia, string $foto)
    {
        $this->idResponsavel = $idResponsavel;
        $this->nome = $nome;
        $this->genero = $genero;
        $this->castrado = $castrado;
        $this->forneceCastracao = $forneceCastracao;
        $this->especie = $especie;
        $this->dataNascimento = $dataNascimento;
        $this->dataResgate = $dataResgate;
        $this->doencas = $doencas;
        $this->custoMensal = $custoMensal;
        $this->historia = $historia;
        $this->foto = $foto;

        $con = Database::getConnection();
        $stm = $con->prepare('SELECT id FROM pets ORDER BY 1 DESC LIMIT 1');
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
     *  Função que auxilia na verificação do pet.
     *  Para isso, os dados providos são comparados com a instância atual.
     */
    public function igual(string $idResponsavel, string $id): bool
    {
        return $this->idResponsavel === $idResponsavel && $this->id === $id;
    }


    /**
     *  Função que salva os dados do pet no banco de dados
     */
    public function salvar(): void
    {
        $con = Database::getConnection();
        $stm = $con->prepare
        ('INSERT INTO pets (nome, genero, castrado, forneceCastracao, especie, dataNascimento, dataResgate, custoMensal, historia, foto, idResponsavel) 
        VALUES (:nome, :genero, :castrado, :forneceCastracao, :especie, :dataNascimento, :dataResgate, :custoMensal, :historia, :foto, :idResponsavel)');
        $stm->bindValue(':nome', $this->nome);
        $stm->bindValue(':genero', $this->genero);
        $stm->bindValue(':castrado', $this->castrado);
        $stm->bindValue(':forneceCastracao', $this->forneceCastracao);
        $stm->bindValue(':especie', $this->especie);
        $stm->bindValue(':dataNascimento', $this->dataNascimento);
        $stm->bindValue(':dataResgate', $this->dataResgate);
        $stm->bindValue(':custoMensal', $this->custoMensal);
        $stm->bindValue(':historia', $this->historia);
        $stm->bindValue(':foto', $this->foto);
        $stm->bindValue(':idResponsavel', $this->idResponsavel);
        $stm->execute();

        $stm = $con->prepare
        ('SELECT id FROM pets WHERE nome = :nome 
        AND genero = :genero 
        AND castrado = :castrado
        AND forneceCastracao = :forneceCastracao
        AND especie = :especie
        AND dataNascimento = :dataNascimento
        AND dataResgate = :dataResgate
        AND custoMensal = :custoMensal
        AND historia = :historia
        AND foto = :foto
        AND idResponsavel = :idResponsavel');
        $stm->bindValue(':nome', $this->nome);
        $stm->bindValue(':genero', $this->genero);
        $stm->bindValue(':castrado', $this->castrado);
        $stm->bindValue(':forneceCastracao', $this->forneceCastracao);
        $stm->bindValue(':especie', $this->especie);
        $stm->bindValue(':dataNascimento', $this->dataNascimento);
        $stm->bindValue(':dataResgate', $this->dataResgate);
        $stm->bindValue(':custoMensal', $this->custoMensal);
        $stm->bindValue(':historia', $this->historia);
        $stm->bindValue(':foto', $this->foto);
        $stm->bindValue(':idResponsavel', $this->idResponsavel);
        $stm->execute();
        $this->id = $stm->fetch()[0];

        foreach ($this->doencas as $i => $value){
            $nomeDoenca = $this->doencas[$i];
            $stm = $con->prepare
            ('INSERT INTO doencasPet (idPet, nomeDoenca) 
            VALUES (:idPet, :nomeDoenca)');
            $stm->bindValue(':idPet', $this->id);
            $stm->bindValue(':nomeDoenca', $nomeDoenca);
            $stm->execute();
        }       
    }


    /**
     *  Função que busca por um pet a partir do email fornecido.
     *  Se não existir, emite um erro.
     */
    static public function buscarPet($idResponsavel, $id): ?Pet
    {
        $con = Database::getConnection();
        $stm = $con->prepare('SELECT * FROM pets WHERE idResponsavel = :idResponsavel AND id = :id');
        $stm->bindParam(':idResponsavel', $idResponsavel);
        $stm->bindParam(':id', $id);


        $stm->execute();
        $resultadoPet = $stm->fetch();

        if ($resultadoPet) {
            $stm = $con->prepare('SELECT * FROM doencasPet WHERE idPet = :id');
            $stm->bindParam(':id', $id);
            $stm->execute();
            $resultadoDoencas = $stm->fetch();
            $pet = new Pet($resultadoPet['idResponsavel'], $resultadoPet['nome'], $resultadoPet['genero'], $resultadoPet['castrado'], $resultadoPet['forneceCastracao'],
            $resultadoPet['especie'], $resultadoPet['dataNascimento'],  $resultadoPet['dataResgate'], $resultadoDoencas['nomeDoenca'], $resultadoPet['cutoMensal'],
            $resultadoPet['historia'], $resultadoPet['foto']);
            return $pet;
        } else {
            return NULL;
        }
    }

    /**
     *  Função que busca por um pet a partir do id fornecido.
     *  Se não existir, emite um erro.
     */
    static public function buscarPetPorId($id): ?Pet
    {
        $con = Database::getConnection();
        $stm = $con->prepare('SELECT * FROM pets WHERE id = :id');
        $stm->bindParam(':id', $id);

        $stm->execute();
        $resultadoPet = $stm->fetch();

        if ($resultadoPet) {
            $stm = $con->prepare('SELECT * FROM doencasPet WHERE idPet = :id');
            $stm->bindParam(':id', $id);
            $stm->execute();
            $resultadoDoencas = $stm->fetch();
            $pet = new Pet($resultadoPet['idResponsavel'], $resultadoPet['nome'], $resultadoPet['genero'], $resultadoPet['castrado'], $resultadoPet['forneceCastracao'],
            $resultadoPet['especie'], $resultadoPet['dataNascimento'],  $resultadoPet['dataResgate'], $resultadoDoencas['nomeDoenca'], $resultadoPet['cutoMensal'],
            $resultadoPet['historia'], $resultadoPet['foto']);
            return $pet;
        } else {
            return NULL;
        }
    }

    /**
     * Função para buscar todos os pets cadastrados
     */
    static public function buscarTodosPets(): array
    {
        $con = Database::getConnection();
        $stm = $con->prepare('SELECT * FROM pets');

        $stm->execute();

        $resultadoPet = $stm->fetchAll();
        if (!$resultadoPet) {
            return [];
        }

        $pets = array();

        foreach ($resultadoPet as $animal) {

            $stm = $con->prepare('SELECT * FROM doencasPet WHERE idPet = :id');
            $stm->bindParam(':id', $id);
            $stm->execute();
            $resultadoDoencas = $stm->fetch();
            $pet = new Pet($resultadoPet['idResponsavel'], $resultadoPet['nome'], $resultadoPet['genero'], $resultadoPet['castrado'], $resultadoPet['forneceCastracao'],
            $resultadoPet['especie'], $resultadoPet['dataNascimento'],  $resultadoPet['dataResgate'], $resultadoDoencas['nomeDoenca'], $resultadoPet['cutoMensal'],
            $resultadoPet['historia'], $resultadoPet['foto']);
            $pet->id = $animal['id'];

            array_push($pets, $pet);
        }

        return $pets;
    }
}