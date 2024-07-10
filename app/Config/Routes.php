<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/login', 'Login::login_action');
$routes->post('admin/home', 'Admin\Home::index');
$routes->post('pegawai/home', 'Pegawai\Home::index');
