<?php
// Define o basepath globalmente
define('BASEPATH', '/meu-amigo-pet/');
error_reporting(E_ALL ^ E_DEPRECATED);

include_once __DIR__ . '/app/Database.php';
include_once __DIR__ . '/libs/Route.php';
include_once __DIR__ . '/libs/vendor/autoload.php';
include_once __DIR__ . '/app/controllers/Controller.php';
include_once __DIR__ . '/app/controllers/Login.php';
include_once __DIR__ . '/app/models/Usuario.php';
include_once __DIR__ . '/app/models/Pet.php';
include_once __DIR__ . '/app/models/Adocao.php';

use App\Database;
use Steampixel\Route;
use App\Controllers\LoginController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

Database::createSchema();

if (!file_exists('app/uploads')) {
    $path = 'app/uploads';
    mkdir($path);
    copy('public/images/foto_padrao.png', "$path/foto_padrao.png");
}

$controller = new LoginController();

Route::add('/home', fn() => $controller->home(), ['get']);
Route::add('/adote', fn() => $controller->visualizar('adote'), ['get']);
Route::add('/ongs-e-protetoras', fn() => $controller->visualizar('ongs-e-protetoras'), ['get']);
Route::add('/login', fn() => $controller->visualizar('login'), ['get']);
Route::add('/cadastro', fn() => $controller->visualizar('cadastro'), ['get']);
Route::add('/cadastroPet', fn() => $controller->visualizar('cadastroPet'), ['get']);
Route::add('/editarPet', fn() => $controller->visualizar('editarPet'), ['get']);
Route::add('/excluirPet', fn() => $controller->visualizar('excluirPet'), ['get']);
Route::add('/registrarAdocao', fn() => $controller->visualizar('registrarAdocao'), ['get']);

Route::add('/confirmarEmail', fn() => $controller->confirmarEmail(), ['get']);

Route::add('/home', fn() => $controller->home(), ['post']);

Route::add('/editarPet', fn() => $controller->atualizarPet(), ['post']);
Route::add('/excluirPet', fn() => $controller->excluirPet(), ['post']);
Route::add('/cadastroPet', fn() => $controller->cadastrarPet(), ['post']);
Route::add('/cadastro', fn() => $controller->cadastrar(), ['post']);
Route::add('/login', fn() => $controller->login(), ['post']);
Route::add('/logout', fn() => $controller->sair(), ['get']);
Route::add('/registrarAdocao', fn() => $controller->registrarAdocao(), ['post']);
Route::add('/queroadotar', fn() => $controller->queroadotar(), ['post']);

// Rota auxiliar para redirecionar o usuário.
Route::add('/', function () {
    header('Location: ' . BASEPATH . 'home');
}, ['get']);

Route::add('/.*', function () {
    http_response_code(404);
    echo "Page not found!";
}, ['get']);


// Inicia o router
Route::run(BASEPATH);