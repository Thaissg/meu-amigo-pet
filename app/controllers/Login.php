<?php

namespace App\Controllers;

use App\Models\Usuario;

class LoginController extends Controller
{

    /**
     * @var Usuario Variável que indica se um usuário está logado.
     */
    private $loggedUser;

    /**
     *  Método construtor da classe.
     *  Ao ser instanciado, inicia a seção e verifica se já existe um usuário logado.
     */
    function __construct()
    {
        session_start();
        if (isset($_SESSION['user']))
            $this->loggedUser = $_SESSION['user'];
    }

    /** 
     * Função que coloca o usuário na home page do site
     */
    public function home(): void
    {   
        $this->view('home');
    }

    /**
     *  Função que renderiza a página (visão) de login
     *  Se estiver logado, redireciona para a página do usuário.
     */
    public function loginIndex(): void
    {
        if (!$this->loggedUser) {
            $this->view('user/login');
        } else {
            header('Location: ' . BASEPATH . 'home');
        }
    }


    public function login(): void
    {
        $usuario = Usuario::buscarUsuario($_POST['email'], $_POST['tipo']);

        if ($usuario && $usuario->igual($_POST['email'], $_POST['password'])) {
            $_SESSION['user'] = $this->loggedUser = $usuario;
            $this->view('home');
        } else {
            header('Location: ' . BASEPATH . 'login?email=' . $_POST['email'] . '&mensagem=Usuário e/ou senha incorreta!');
        }
    }

    /**
     *  Função que renderiza a página (visão) de cadastro
     */
    public function cadastroUsuario(): void
    {
        $this->view('cadastro');
    }

    /**
     *  Função que trata de cadastrar um novo usuário na base de dados (atualmente na sessão).
     *  Verifica se o email já está cadastrado, se sim, informa o usuário.
     */
    public function cadastrar(): void
    {
        try {
            $endereco = $_POST['rua'] . ', ' .  $_POST['num'] . ', ' . $_POST['compl'] . ', ' . $_POST['bairro'] . ', ' . $_POST['cidade'] . '/' . $_POST['uf'];
            $user = new Usuario(
                $_POST['email'], $_POST['senha'], $_POST['nome'],
                $_POST['cpf-cnpj'], $endereco , $_POST['tel'], $_POST['tipo_cadastro']
            );
            $user->salvar();
            header('Location: ' . BASEPATH . 'login?email=' . $_POST['email'] . '&mensagem=Usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            //header('Location: ' . BASEPATH . 'user/register?email=' . $_POST['email'] . '&mensagem=Email já cadastrado!');
            echo($e->getMessage());
            //var_dump($th);
        }
    }

    /**
     *  Função responsável por renderizar as informações do usuário (se estiver logado).
     */
    public function info(): void
    {
        if (!$this->loggedUser) {
            header('Location: ' . BASEPATH . 'login?mensagem=Você precisa se identificar primeiro');
            return;
        }
        $this->view('users/info', $this->loggedUser);
    }

    /**
     *  Função responsável por renderizar as informações de qualquer usuário.
     */
    public function publicInfo($id, $tipo): void
    {
        $usuario = Usuario::buscarUsuarioPorId($id, $tipo);

        if (isset($usuario)) {
            $this->view('users/info', [$usuario]);
        } else {
            header('Location: ' . BASEPATH . 'login?mensagem=Usuario no encontrado');
        }
    }

    /**
     *  Função que remove o usuário da seção (deslogar)
     */
    public function sair(): void
    {
        if (!$this->loggedUser) {
            header('Location: ' . BASEPATH . 'login?mensagem=Você precisa se identificar primeiro');
            return;
        }
        unset($_SESSION['user']);
        header('Location: ' . BASEPATH . 'login?mensagem=Usuário deslogado com sucesso!');
    }

    public function visualizar($view): void
    {
        $this->view($view);
    }
}