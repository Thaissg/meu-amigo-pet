<?php


// Desabilita warnings
error_reporting(E_ALL ^ E_WARNING);

// Define o basepath globalmente
define('BASEPATH', '/meu-amigo-pet/');

include_once __DIR__ . '/app/Database.php';
include_once __DIR__ . '/app/controllers/Controller.php';
include_once __DIR__ . '/app/controllers/Login.php';
include_once __DIR__ . '/libs/Route.php';
include_once __DIR__ . '/app/models/Usuario.php';

use App\Database;
use App\Controllers\LoginController;
use Steampixel\Route;

Database::createSchema();

$controller = new LoginController();

Route::add('/home', fn() => $controller->home(), ['get']);



Route::add('/login', fn() => $controller->loginIndex(), ['get']);
Route::add('/user/register', fn() => $controller->cadastroUsuario(), ['get']);
Route::add('/user/info', fn() => $controller->info(), ['get']);
Route::add('/user/info/([0-9]+)', fn($id) => $controller->publicInfo($id), ['get']);

Route::add('/login', fn() => $controller->login(), ['post']);
Route::add('/user/register', fn() => $controller->cadastrar(), ['post']);
Route::add('/logout', fn() => $controller->sair(), ['get']);

// Rota auxiliar para redirecionar o usuário.
Route::add('/', function () {
    header('Location: ' . BASEPATH . 'app/views/home.php');
}, ['get']);

Route::add('/.*', function () {
    http_response_code(404);
    echo "Page not found!";
}, ['get']);


// Inicia o router
Route::run(BASEPATH);