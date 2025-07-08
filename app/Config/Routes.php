<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Home;
use App\Controllers\User;
use App\Controllers\Sensor;
use App\Controllers\Auth;
use App\Controllers\Control;
use App\Controllers\Api;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index']);
$routes->get('/signup', 'Auth::signup');
$routes->post('/signup', 'User::create');
$routes->get('/login', 'Auth::showLogin');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
// Add new authentication routes
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// Protected routes (require authentication)
$routes->resource('user');
$routes->resource('sensor');
$routes->resource('pompa');
$routes->resource('histori');
$routes->get('sensor/history', 'Sensor::index');
$routes->get('sensor/getData', 'Sensor::getData');
$routes->get('control/status', 'Control::statusPompa');


$routes->group('api', function ($routes) {
	$routes->post('sensor', [Api::class, 'postSensor']);
	$routes->get('sensor/latest', [Api::class, 'getLatestSensorData']);
	$routes->get('status', [Api::class, 'status']);
	$routes->post('control/pompa', [Api::class, 'controlPompa']);
});
$routes->post('api/control/mode', [Api::class, 'updateMode']);
$routes->post('api/control/setPompa', [Api::class, 'updatePompa']);

// // app/Config/Routes.php
// $routes->get('api/status', 'Api::status');
//$routes->post('api/control/mode', 'Api::mode');
// $routes->post('api/pompa', 'Api::pompa');
// $routes->get('api/sensor/latest', 'Api::getLatestSensorData');
// $routes->get('api/history', 'Api::getHistory');
