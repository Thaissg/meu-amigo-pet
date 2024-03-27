<?php

namespace App\Controllers;

use App\Models\Usuario;
use App\Models\Pet;

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
        if (isset ($_SESSION['user']))
            $this->loggedUser = $_SESSION['user'];
    }

    /** 
     * Função que coloca o usuário na home page do site
     */
    public function home(): void
    {
        if (isset ($_SESSION['user'])) {
            if ($_SESSION['user']->__get('tipo') == 'doador') {
                $this->view('homeDoador');
            } else {
                $this->view('home');
            }
        } else {
            $this->view('home');
        }
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
        $usuario = Usuario::buscarUsuarioPorEmail($_POST['email'], $_POST['tipo_cadastro']);

        if ($usuario && $usuario->igual($_POST['email'], $_POST['password'])) {
            $_SESSION['user'] = $this->loggedUser = $usuario;
            header('Location: ' . BASEPATH . 'home?' . $usuario->__get('tipo') . '&mensagem=Usuário logado!');
        } else {
            header('Location: ' . BASEPATH . 'login?email=' . $_POST['email'] . '&mensagem=Usuário e/ou senha incorreta!');
        }
    }

    /**
     *  Função que trata de cadastrar um novo usuário na base de dados (atualmente na sessão).
     *  Verifica se o email já está cadastrado, se sim, informa o usuário.
     */
    public function cadastrar(): void
    {
        try {
            $endereco = $_POST['tipoLogradouro'] . ' ' . $_POST['nomeLogradouro'] . ', ' . $_POST['num'] . ', ' . $_POST['bairro'] . ', ' . $_POST['cidade'] . '/' . $_POST['uf'];
            $user = new Usuario(
                $_POST['email'],
                $_POST['senha'],
                $_POST['nome'],
                $_POST['cpf-cnpj'],
                $endereco,
                $_POST['compl'],
                $_POST['tel'],
                $_POST['tipo_cadastro']
            );
            $salvar = $user->salvar();
            if ($salvar == 'OK') {
                header('Location: ' . BASEPATH . 'login?email=' . $_POST['email'] . '&mensagem=Usuário cadastrado com sucesso!');
            } else {
                header('Location: ' . BASEPATH . 'login?email=' . $_POST['email'] . '&mensagem=' . $salvar);
            }

        } catch (\Exception $e) {
            header('Location: ' . BASEPATH . 'login?email=' . $_POST['email'] . '&mensagem=Email ou cpf/cnpj já cadastrado!');
            echo ($e->getMessage());
        }
    }

    public function cadastrarPet(): void
    {
        if ($_SESSION['user']->__get('tipo') != 'doador') {
            header('Location: ' . BASEPATH . 'home?mensagem=Usuário não tem permissão para cadastrar pet!');
        } else {
            try {
                $dados = ['nome', 'genero', 'castrado', 'forneceCastracao', 'especie', 'dataNascimento', 'dataResgate', 'custoMensal', 'historia', 'foto'];
                for ($i = 0; $i < count($dados); $i++) {
                    if (!isset ($_POST[$dados[$i]])) {
                        $_POST[$dados[$i]] = "";
                    }
                }
                $doencas = [];
                if (isset ($_POST['doencas'])) {
                    if (is_array($_POST['doencas'])) {
                        foreach ($_POST['doencas'] as $doenca) {
                            array_push($doencas, $doenca);
                        }
                    }
                }

                $pet = new Pet(
                    $_SESSION['user']->__get('id'),
                    $_POST['nome'],
                    $_POST['genero'],
                    $_POST['castrado'],
                    $_POST['forneceCastracao'],
                    $_POST['especie'],
                    $_POST['dataNascimento'],
                    $_POST['dataResgate'],
                    $doencas,
                    $_POST['custoMensal'],
                    $_POST['historia'],
                    $_POST['foto']
                );

                $size = $_FILES["foto"]["size"];
                if ($_POST["foto"] != "") {
                    if ($_FILES["foto"]["error"] == 0) {
                        $str = '';
                        foreach ($_FILES["foto"] as $chave => $valor) {
                            $str = $str . ' &' . $chave . '=' . $valor;
                        }
                        $target_dir = "C:/wamp64/www/meu-amigo-pet/app/uploads/";
                        $target_file = strtolower($target_dir . 'pet_' . $pet->__get('id') . '_' . str_replace(' ', '_', $_POST['nome']) . '_' . date("Y-m-d"));
                        $imageFileType = strtolower(explode('.', $_FILES["foto"]['name'])[1]);
                        $pet->__set('foto', $target_file . '.' . $imageFileType);
                        $check = getimagesize($_FILES["foto"]["tmp_name"]);
                        if ($check) {
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file . '.' . $imageFileType);
                        }
                    }
                    if ($_FILES["foto"]["error"] == 0) {
                        $pet->salvar();
                        header('Location: ' . BASEPATH . 'home?mensagem=Pet cadastrado com sucesso!&id=' . $pet->__get('id') . '&size=' . $size);
                    } else {
                        if ($_FILES["foto"]["error"] == 1 || $_FILES["foto"]["error"] == 2) {
                            $msgErro = 'Arquivo de imagem muito grande!';
                        } else {
                            $msgErro = 'Erro inesperado ao fazer upload da imagem ou upload feito parcialmente!';
                        }
                        header('Location: ' . BASEPATH . 'home?mensagem=Erro no cadastro! Erro: ' . $_FILES["foto"]["error"] . ' - ' . $msgErro);
                    }
                } else {
                    $pet->salvar();
                    header('Location: ' . BASEPATH . 'home?mensagem=Pet cadastrado com sucesso!&id=' . $pet->__get('id') . '&size=' . $size);
                }


            } catch (\Exception $e) {
                header('Location: ' . BASEPATH . 'cadastroPet?email=' . $_POST['nome'] . '&mensagem=' . $e->getMessage());
                echo ($e->getMessage());
            }
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

        if (isset ($usuario)) {
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