<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Home;
use App\Controllers\User;
use App\Controllers\Sensor;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);
$routes->get('/login', [Home::class, 'index']);
$routes->get('/signup', 'Auth::signup');
$routes->post('/signup', 'Auth::store');
$routes->post('auth/store', 'Auth::store');
$routes->resource('user');
$routes->resource('sensor');
$routes->resource('pompa');
$routes->resource('histori');

$routes->group('api', function ($routes) {
	$routes->post('sensor', 'Api::postSensor');
	$routes->get('status', 'Api::getStatus');
	$routes->post('pompa', 'Api::updatePompa');
});
