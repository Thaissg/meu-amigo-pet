<?php


// Desabilita warnings
error_reporting(E_ALL ^ E_WARNING);

// Define o basepath globalmente
define('BASEPATH', '/meu-amigo-pet/');

include_once __DIR__ . '/app/Database.php';
include_once __DIR__ . '/libs/Route.php';
include_once __DIR__ . '/app/controllers/Controller.php';
include_once __DIR__ . '/app/controllers/Login.php';
include_once __DIR__ . '/app/models/Usuario.php';

use App\Database;
use Steampixel\Route;
use App\Controllers\LoginController;


Database::createSchema();

$controller = new LoginController();

Route::add('/home', fn () => $controller->home(), ['get']);
Route::add('/adote', fn () => $controller->visualizar('adote'), ['get']);
Route::add('/ongs-e-protetoras', fn () => $controller->visualizar('ongs-e-protetoras'), ['get']);
Route::add('/login', fn () => $controller->visualizar('login'), ['get']);
Route::add('/cadastro', fn() => $controller->cadastroUsuario(), ['get']);

Route::add('/cadastro', fn() => $controller->cadastrar(), ['post']);
Route::add('/login', fn() => $controller->login(), ['post']);

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