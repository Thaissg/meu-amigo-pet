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
            $this->view('homeLogado');
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
            $this->view('home');
            header('Location: ' . BASEPATH . 'home?email=' . $_POST['email'] . '&mensagem=Usuário logado!');
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
        try {
            $dados = ['nome', 'genero', 'castrado', 'forneceCastracao', 'especie', 'dataNascimento', 'dataResgate', 'custoMensal', 'historia', 'foto'];
            for ($i = 0; $i < count($dados); $i++) {
                if ($_POST[$dados[$i]] == null) {
                    $_POST[$dados[$i]] = "";
                }
            }
            $doencas = [];
            if (is_array($_POST['doencas'])) {
                foreach ($_POST['doencas'] as $doenca) {
                    array_push($doencas, $doenca);
                }
            }
            // if ($_FILES["foto"]["tmp_name"] != '' ) {
            //     $target_dir = BASEPATH . "uploads/";
            //     $target_file = $target_dir . basename('pet_' . $_POST['nome'] . '_' . date("Y-m-d"));
            //     $uploadOk = 1;
            //     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            //     $check = getimagesize($_FILES["foto"]["tmp_name"]);
            //     if ($check) {
            //         if ($_FILES["foto"]["size"] > 500000) {
            //             header('Location: ' . BASEPATH . 'home?foto=muito_grande');
            //         } else {
            //             if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            //                 header('Location: ' . BASEPATH . 'home?foto=carregada');
            //             } else{
            //                 header('Location: ' . BASEPATH . 'home?foto=nao_carregada&fileType=' . $imageFileType);
            //             }
            //         }
            //     } else {
            //         header('Location: ' . BASEPATH . 'home?fotos=nok');
            //     }
            // } else {
            //     header('Location: ' . BASEPATH . 'home?foto=vazio');
            // }

            $pet = new Pet(
                1,
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
                $_POST['foto']);
            $pet->salvar();
            $str = '';
            foreach($_POST['doencas'] as $doenca){
                $str = $str . $doenca . ' ';
            }
            header('Location: ' . BASEPATH . 'home?id='. $pet->__get('id') . '&mensagem=Pet cadastrado com sucesso!' . '&doencas=' . $str);
        } catch (\Exception $e) {
            header('Location: ' . BASEPATH . 'cadastroPet?email=' . $_POST['nome'] . '&mensagem=' . $e->getMessage());
            echo ($e->getMessage());
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