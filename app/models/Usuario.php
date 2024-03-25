<?php

namespace App\Models;

use App\Database;
use ArrayObject;

/**
 * Classe reponsável por representar os dados de um usuário na aplicação
 */
class Usuario
{

    private $id;

    /**
     * @var string Email do usuário
     */
    private $email;

    /**
     * @var string Senha (codificada) do usuário
     */
    private $senha;

    /**
     * @var string Nome fornecido pelo usuário
     */
    private $nome;

    /**
     * @var string Documento fornecido pelo usuário
     */
    private $documento;

    /**
     * @var string Telefone fornecido pelo usuário
     */
    private $telefone;

    /**
     * @var string Tipo de cadastro fornecido pelo usuário
     */
    private $tipo;

    /**
     *  Contrutor da classe, responsável por inicializar os dados.
     *  A senha é codificada usando sha256.
     */
    function __construct(string $email, string $senha, string $nome, string $documento, string $endereco, string $complemento, string $telefone, string $tipo)
    {
        $this->email = $email;
        $this->senha = hash('sha256', $senha);
        $this->nome = $nome;
        $this->documento = $documento;
        $this->endereco = $endereco;
        $this->complemento = $complemento;
        $this->telefone = $telefone;
        $this->tipo = $tipo;
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
     *  Função que auxilia na verificação da identidade fornecida.
     *  Para isso, os dados providos são comparados com a instância atual.
     */
    public function igual(string $email, string $senha): bool
    {
        return $this->email === $email && $this->senha === hash('sha256', $senha);
    }


    /**
     *  Função que salva os dados do usuário no banco de dados
     */
    public function salvar(): string
    {
        if ($this->buscarUsuario($this->email, $this->tipo, $this->documento)==null){
            $con = Database::getConnection();
            $stm = $con->prepare
            ('INSERT INTO usuarios (nome, tipo, cpf_cnpj, endereco, complemento,  telefone, email, senha) 
            VALUES (:nome, :tipo, :documento, :endereco, :complemento, :telefone, :email, :senha)');
            $stm->bindValue(':nome', $this->nome);
            $stm->bindValue(':tipo', $this->tipo);
            $stm->bindValue(':documento', $this->documento);
            $stm->bindValue(':endereco', $this->endereco);
            $stm->bindValue(':complemento', $this->complemento);
            $stm->bindValue(':telefone', $this->telefone);
            $stm->bindValue(':email', $this->email);
            $stm->bindValue(':senha', $this->senha);
            $stm->execute();
            return 'OK';
        } else{
            return 'Email ou CPF/CNPJ já cadastrado para esse tipo de usuário!';
        }
    }


    /**
     *  Função que busca por um usuário a partir do email fornecido.
     *  Se não existir, emite um erro.
     */
    static public function buscarUsuario($email, $tipo, $documento): ?Usuario
    {
        $con = Database::getConnection();
        $stm = $con->prepare('SELECT * FROM usuarios WHERE email = :email AND tipo = :tipo');
        $stm->bindParam(':email', $email);
        $stm->bindParam(':tipo', $tipo);


        $stm->execute();
        $resultado = $stm->fetch();

        if ($resultado) {
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado['cpf_cnpj'], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo']);
            $usuario->senha = $resultado['senha'];
            return $usuario;
        } else {
            $stm = $con->prepare('SELECT * FROM usuarios WHERE cpf_cnpj = :documento AND tipo = :tipo');
            $stm->bindParam(':documento', $documento);
            $stm->bindParam(':tipo', $tipo);


            $stm->execute();
            $resultado = $stm->fetch();
            if ($resultado) {
                $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado['cpf_cnpj'], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo']);
                $usuario->senha = $resultado['senha'];
                return $usuario;
            } else{
                return NULL;
            }
            
        }
    }

    static public function buscarUsuarioPorEmail($email, $tipo): ?Usuario
    {
        $con = Database::getConnection();
        $stm = $con->prepare('SELECT * FROM usuarios WHERE email = :email AND tipo = :tipo');
        $stm->bindParam(':email', $email);
        $stm->bindParam(':tipo', $tipo);


        $stm->execute();
        $resultado = $stm->fetch();

        if ($resultado) {
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado['cpf_cnpj'], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo']);
            $usuario->senha = $resultado['senha'];
            return $usuario;
        } else {
            return NULL;
        }
    }

    /**
     *  Função que busca por um usuário a partir do id fornecido.
     *  Se não existir, emite um erro.
     */
    static public function buscarUsuarioPorId($id, $tipo): ?Usuario
    {
        $con = Database::getConnection();
        $stm = $con->prepare('SELECT id, email, nome, senha FROM Usuarios WHERE id = :id');
        $stm->bindParam(':id', $id);

        $stm->execute();
        $resultado = $stm->fetch();

        if ($resultado) {
            if ($tipo == 'adotante') {
                $documento = $resultado['cpf'];
            } else {
                $documento = $resultado['cpf_cnpj'];
            }
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado[$documento], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo']);
            $usuario->id = $resultado['id'];
            $usuario->senha = $resultado['senha'];
            return $usuario;
        } else {
            return NULL;
        }
    }

    /**
     * Função para buscar todos os usuários cadastrados
     */
    static public function buscarTodosUsuarios($tipo): array
    {
        $con = Database::getConnection();
        $stm = $con->prepare('SELECT * FROM usuarios');

        $stm->execute();

        $resultado = $stm->fetchAll();
        if (!$resultado) {
            return [];
        }

        $usuarios = array();

        foreach ($resultado as $user) {
            $documento = $resultado['cpf_cnpj'];
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado[$documento], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo']);
            $usuario->id = $user['id'];
            $usuario->senha = $user['senha'];

            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }
}