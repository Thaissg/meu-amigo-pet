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
    function __construct(string $email, string $senha, string $nome, string $documento, string $endereco, string $telefone, string $tipo)
    {
        $this->email = $email;
        $this->senha = hash('sha256', $senha);
        $this->nome = $nome;
        $this->documento = $documento;
        $this->endereco = $endereco;
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
    public function salvar(): void
    {
        $con = Database::getConnection();
        if ($this->tipo == 'ong_protetor'){
            $stm = $con->prepare
            ('INSERT INTO ong_protetora (nome, cpf-cpnj, endereco, telefone, email, senha) 
            VALUES (:nome, :documento, :endereco, :telefone, :email, :senha)');
            $stm->bindValue(':nome', $this->nome);
            $stm->bindValue(':documento', $this->documento);
            $stm->bindValue(':endereco', $this->endereco);
            $stm->bindValue(':telefone', $this->telefone);
            $stm->bindValue(':email', $this->email);
            $stm->bindValue(':senha', $this->senha);
            
        } else if ($this->tipo == 'adotante'){
            $stm = $con->prepare
            ('INSERT INTO populacao (nome, cpf, endereco, telefone, email, senha) 
            VALUES (:nome, :documento, :endereco, :telefone, :email, :senha)');
            $stm->bindValue(':nome', $this->nome);
            $stm->bindValue(':documento', $this->documento);
            $stm->bindValue(':endereco', $this->endereco);
            $stm->bindValue(':telefone', $this->telefone);
            $stm->bindValue(':email', $this->email);
            $stm->bindValue(':senha', $this->senha);
        }
        $stm->execute();
        
    }


    /**
     *  Função que busca por um usuário a partir do email fornecido.
     *  Se não existir, emite um erro.
     */
    static public function buscarUsuario($email,$tipo): ?Usuario
    {
        $con = Database::getConnection();
        if($tipo=='adotante'){
            $stm = $con->prepare('SELECT * FROM populacao WHERE email = :email');
            $stm->bindParam(':email', $email);
        } else {
            $stm = $con->prepare('SELECT * FROM ong_protetora WHERE email = :email');
            $stm->bindParam(':email', $email);
        }
        

        $stm->execute();
        $resultado = $stm->fetch();

        if ($resultado) {
            if($tipo=='adotante'){
                $documento=$resultado['cpf'];
            } else {
                $documento=$resultado['cpf-cnpj'];
            }
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado[$documento], $resultado['endereco'],$resultado['telefone'],$resultado['tipo']);
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
    static public function buscarUsuarioPorId($id,$tipo): ?Usuario
    {
        $con = Database::getConnection();
        $stm = $con->prepare('SELECT id, email, nome, senha FROM Usuarios WHERE id = :id');
        $stm->bindParam(':id', $id);

        $stm->execute();
        $resultado = $stm->fetch();

        if ($resultado) {
            if($tipo=='adotante'){
                $documento=$resultado['cpf'];
            } else {
                $documento=$resultado['cpf-cnpj'];
            }
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado[$documento], $resultado['endereco'],$resultado['telefone'],$resultado['tipo']);
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
        if($tipo=='adotante'){
            $stm = $con->prepare('SELECT * FROM populacao');
        } else {
            $stm = $con->prepare('SELECT * FROM ong_protetora');
        }
        
        $stm->execute();
        
        $resultado = $stm->fetchAll();
        if (!$resultado){
            return NULL;
        }

        $usuarios = array();
        
        foreach ($resultado as $user) {
            if($tipo=='adotante'){
                $documento=$resultado['cpf'];
            } else {
                $documento=$resultado['cpf-cnpj'];
            }
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado[$documento], $resultado['endereco'],$resultado['telefone'],$resultado['tipo']);
            $usuario->id = $user['id'];
            $usuario->senha = $user['senha'];

            array_push($usuarios, $usuario);
        }
        
        return $usuarios;
    }
}
