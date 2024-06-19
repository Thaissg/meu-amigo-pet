<?php

namespace App\Models;

use App\Database;
use ArrayObject;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

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
     * @var string Tipo de cadastro fornecido pelo usuário
     */
    private $chave;

    /**
     * @var bool Tipo de cadastro fornecido pelo usuário
     */
    private $confEmail;


    /**
     *  Contrutor da classe, responsável por inicializar os dados.
     *  A senha é codificada usando sha256.
     */
    function __construct(string $email, string $senha, string $nome, string $documento, string $endereco, string $complemento, string $telefone, string $tipo, bool $confEmail = false)
    {
        $this->email = $email;
        $this->senha = hash('sha256', $senha);
        $this->nome = $nome;
        $this->documento = $documento;
        $this->endereco = $endereco;
        $this->complemento = $complemento;
        $this->telefone = $telefone;
        $this->tipo = $tipo;
        $this->confEmail = $confEmail;

        $con = Database::getConnection();
        $stm = $con->prepare('SELECT id FROM usuarios ORDER BY 1 DESC LIMIT 1');
        $stm->execute();
        $id = $stm->fetch()[0] + 1;
        $this->id = $id;

        $this->chave = hash('sha256', $email . $id . date("Y-m-d"));
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
        if ($this->buscarUsuario($this->email, $this->tipo, $this->documento) == null) {
            $con = Database::getConnection();
            $stm = $con->prepare
            ('INSERT INTO usuarios (nome, tipo, cpf_cnpj, endereco, complemento,  telefone, email, senha, chave, confEmail) 
            VALUES (:nome, :tipo, :documento, :endereco, :complemento, :telefone, :email, :senha, :chave, :confEmail)');
            $stm->bindValue(':nome', $this->nome);
            $stm->bindValue(':tipo', $this->tipo);
            $stm->bindValue(':documento', $this->documento);
            $stm->bindValue(':endereco', $this->endereco);
            $stm->bindValue(':complemento', $this->complemento);
            $stm->bindValue(':telefone', $this->telefone);
            $stm->bindValue(':email', $this->email);
            $stm->bindValue(':senha', $this->senha);
            $stm->bindValue(':chave', $this->chave);
            $stm->bindValue(':confEmail', $this->confEmail);
            $stm->execute();
            return 'OK';
        } else {
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
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado['cpf_cnpj'], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo'], $resultado['confEmail']);
            $usuario->senha = $resultado['senha'];
            return $usuario;
        } else {
            $stm = $con->prepare('SELECT * FROM usuarios WHERE cpf_cnpj = :documento AND tipo = :tipo');
            $stm->bindParam(':documento', $documento);
            $stm->bindParam(':tipo', $tipo);


            $stm->execute();
            $resultado = $stm->fetch();
            if ($resultado) {
                $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado['cpf_cnpj'], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo'], $resultado['confEmail']);
                $usuario->senha = $resultado['senha'];
                return $usuario;
            } else {
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
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado['cpf_cnpj'], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo'], $resultado['confEmail']);
            $usuario->id = $resultado['id'];
            $usuario->senha = $resultado['senha'];
            return $usuario;
        } else {
            return NULL;
        }
    }


    static public function buscarUsuarioPorDocumento($documento, $tipo): ?Usuario
    {
        $con = Database::getConnection();
        $stm = $con->prepare('SELECT * FROM usuarios WHERE cpf_cnpj = :cpf_cnpj AND tipo = :tipo');
        $stm->bindParam(':cpf_cnpj', $documento);
        $stm->bindParam(':tipo', $tipo);


        $stm->execute();
        $resultado = $stm->fetch();

        if ($resultado) {
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado['cpf_cnpj'], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo'], $resultado['confEmail']);
            $usuario->id = $resultado['id'];
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
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado[$documento], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo'], $resultado['confEmail']);
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
            $usuario = new Usuario($resultado['email'], $resultado['senha'], $resultado['nome'], $resultado[$documento], $resultado['endereco'], $resultado['complemento'], $resultado['telefone'], $resultado['tipo'], $resultado['confEmail']);
            $usuario->id = $user['id'];
            $usuario->senha = $user['senha'];

            array_push($usuarios, $usuario);
        }

        return $usuarios;
    }

    public function enviarEmailConfirmação(): void
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->CharSet = "UTF-8";
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'cc2790016b4e20';
            $mail->Password = '301307f6b0f9d8';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 2525;

            //Recipients
            $mail->setFrom('thais@meu-amigo-pet.com.br', 'Mailer');
            $mail->addAddress($this->email);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Confirmar cadastro no Meu Amigo Pet';
            $mail->Body = "Prezado (a) " . $this->nome . ",<br><br>
            Obrigada por se cadastrar em nosso sistema!<br><br>
            Para que possamos liberar o seu cadastro, solicitamos a confirmação do e-mail clicando no link abaixo: <br><br>
            <a href='http://localhost/meu-amigo-pet/confirmarEmail?email=". $this->email ."&tipo=". $this->tipo."&chave=" . $this->chave . "'>Clique aqui</a><br><br>
            Esta mensagem foi enviada a você por está cadastrado em nosso banco de dados. Não enviamos emails com arquivos anexados 
            ou solicitando preenchimento de senhas e informações cadastrais.<br><br>";
            $mail->AltBody = "Prezado (a) " . $this->nome . "\n\n
            Obrigada por se cadastrar em nosso sistema!\n\n
            Para que possamos liberar o seu cadastro, solicitamos a confirmação do e-mail clicando no link abaixo: \n\n
            'http://localhost/meu-amigo-pet/confirmarEmail?email=". $this->email ."&tipo=". $this->tipo."&chave=" . $this->chave . "' \n\n
            Esta mensagem foi enviada a você por estar cadastrado em nosso banco de dados. Não enviamos emails com arquivos anexados 
            ou solicitando preenchimento de senhas e informações cadastrais.\n\n";

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    static public function confirmarEmail($chave, $email, $tipo): void
    {

        $con = Database::getConnection();
        $stm = $con->prepare('UPDATE usuarios SET confEmail = true WHERE chave = :chave AND email = :email AND tipo = :tipo');
        $stm->bindValue(':chave', $chave);
        $stm->bindValue(':email', $email);
        $stm->bindValue(':tipo', $tipo);
        $stm->execute();
        header('Location: ' . BASEPATH . 'login?mensagem=Teste!');
    }
}