<?php
/*
 * Autores:
 * Pedro Henrique POliceno41829964
 * Gustavo Henrique Garcia Cavalli43635563
 * Pedro Henrique Frason Jorge42851360
 */
session_start();

require_once __DIR__ . '/App/Config/Database.php';
require_once __DIR__ . '/App/Core/Router.php';
require_once __DIR__ . '/App/Core/Controller.php';
require_once __DIR__ . '/App/Core/Security.php';
require_once __DIR__ . '/App/Models/Usuario.php';
require_once __DIR__ . '/App/Models/Tarefa.php';
require_once __DIR__ . '/App/Models/Comentario.php';
require_once __DIR__ . '/App/Controllers/AuthController.php';
require_once __DIR__ . '/App/Controllers/PageController.php';
require_once __DIR__ . '/App/Controllers/TarefaController.php';

use App\Core\Router;
use App\Controllers\PageController;
use App\Controllers\AuthController;
use App\Controllers\TarefaController;

$router = new Router();

// Páginas Públicas (3 páginas)
$router->get('/', [PageController::class, 'home']);
$router->get('/sobre', [PageController::class, 'sobre']);
$router->get('/contato', [PageController::class, 'contato']);

// Autenticação
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'postLogin']);
$router->get('/cadastro', [AuthController::class, 'cadastro']);
$router->post('/cadastro', [AuthController::class, 'postCadastro']);
$router->get('/recuperar_senha', [AuthController::class, 'recuperarSenha']);
$router->post('/recuperar_senha', [AuthController::class, 'postRecuperarSenha']);
$router->get('/logout', [AuthController::class, 'logout']);

// Área Logada
$router->get('/dashboard', [TarefaController::class, 'dashboard']);
$router->get('/tarefa/criar', [TarefaController::class, 'criar']);
$router->post('/tarefa/criar', [TarefaController::class, 'postCriar']);
$router->get('/tarefa/editar', [TarefaController::class, 'editar']);
$router->post('/tarefa/editar', [TarefaController::class, 'postEditar']);
$router->post('/tarefa/excluir', [TarefaController::class, 'excluir']);
$router->get('/tarefa', [TarefaController::class, 'detalhes']); // Detalhes e comentários
$router->post('/comentario/criar', [TarefaController::class, 'postComentario']);

$router->resolve();
