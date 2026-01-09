<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//Autenticação
$routes->post('auth/login', 'AuthController::login');

$routes->group('', ['filter' => 'jwtauth'], function($routes) {
    
    //Automoveis REST
    $routes->get('automovel', 'Automovel::listarAutomoveis');
    $routes->post('automovel/create', 'Automovel::criarAutomovel');
    $routes->put('automovel/update/(:any)', 'Automovel::atualizarAutomovel/$1');
    $routes->delete('automovel/delete/(:any)', 'Automovel::deletarAutomovel/$1');

    //Usuários REST
    $routes->post('usuario/create', 'UsuariosController::criarUsuario');
    $routes->get('usuario', 'UsuariosController::listarUsuarios');
    $routes->put('usuario/update/(:any)', 'UsuariosController::atualizarUsuario/$1');
    $routes->delete('usuario/delete/(:any)', 'UsuariosController::deletarUsuario/$1');
    
});

