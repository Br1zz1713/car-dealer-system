<?php

use App\Router;

require_once __DIR__ . '/../src/Router.php';
require_once __DIR__ . '/../src/Controller.php';

// Simple autoloader
spl_autoload_register(function ($class) {
    if (strpos($class, 'App\\') === 0) {
        $class = str_replace('App\\', '', $class);
        $file = __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

$router = new Router();

// Define routes
$router->get('/', 'PublicController@index');
$router->get('/vehicle/{id}', 'PublicController@show');
$router->get('/admin/login', 'AdminController@login');
$router->post('/admin/login', 'AdminController@authenticate');
$router->get('/admin/dashboard', 'AdminController@dashboard');
$router->get('/admin/vehicle/add', 'AdminController@add');
$router->post('/admin/vehicle/store', 'AdminController@store');
$router->get('/admin/vehicle/edit/{id}', 'AdminController@edit');
$router->post('/admin/vehicle/update/{id}', 'AdminController@update');
$router->post('/admin/vehicle/delete/{id}', 'AdminController@delete');
$router->get('/admin/logout', 'AdminController@logout');

$router->dispatch();
