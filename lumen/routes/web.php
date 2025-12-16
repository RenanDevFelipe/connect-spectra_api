<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


// Rotas Publicas
$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');

// Rotas privadas - protegidas por autenticação JWT
$router->group(['middleware' => 'api'], function () use ($router) {

    // Rotas de Usuários
    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->post('logout', 'AuthController@logout'); // Logout do usuário

        $router->get('/', 'UserController@index'); // Listar todos os usuários
        $router->get('/{id}', 'UserController@show'); // Mostrar detalhes de um usuário específico
        $router->put('/{id}', 'UserController@update'); // Atualizar informações de um usuário
        $router->delete('/{id}', 'UserController@destroy'); // Deletar um usuário

    });

});
