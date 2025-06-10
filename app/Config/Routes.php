<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Clientes::index');
$routes->get('clientes', 'Clientes::index');
$routes->get('clientes/criar', 'Clientes::criar');
$routes->post('clientes/salvar', 'Clientes::salvar');
$routes->get('clientes/editar/(:num)', 'Clientes::editar/$1');
$routes->post('clientes/atualizar/(:num)', 'Clientes::atualizar/$1');
$routes->get('clientes/excluir/(:num)', 'Clientes::excluir/$1');
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('clientes/cidades/(:num)', 'Clientes::getCidades/$1');
$routes->get('pedidos/adicionar', 'Pedidos::adicionar');
$routes->post('pedidos/salvar', 'Pedidos::salvar');
$routes->get('clientes/historico/(:num)', 'Clientes::historico/$1');
$routes->get('pedidos/editar/(:num)', 'Pedidos::editar/$1');
$routes->post('pedidos/atualizar/(:num)', 'Pedidos::atualizar/$1');
$routes->get('pedidos/excluir/(:num)', 'Pedidos::excluir/$1');
$routes->get('/configuracoes', 'Configuracoes::index');
$routes->post('configuracoes/salvar', 'Configuracoes::salvar');
$routes->get('clientes/(:num)/painel', 'Clientes::painel/$1');





