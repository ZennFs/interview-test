<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Auth\Authentication::index');
$routes->get('/login', 'Auth\Authentication::index');
$routes->post('/authenticate', 'Auth\Authentication::auth');
$routes->get('/register', 'Auth\Register::index');
$routes->post('/registered', 'Auth\Register::register');




// $routes->group('admin', function ($routes) {

$routes->get('dashboard', 'Home::index');

// product
$routes->get('products', 'ProductController::index');
$routes->get('addProduct', 'ProductController::new');
$routes->post('products/create', 'ProductController::create');
$routes->get('products/edit/(:num)', 'ProductController::edit/$1');
$routes->put('products/update/(:num)', 'ProductController::update/$1');
$routes->delete('products/delete/(:num)', 'ProductController::delete/$1');


// transaction



// });
