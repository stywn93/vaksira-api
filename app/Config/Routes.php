<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// API
$routes->post('api/registrations', 'Api\Registrations::store');
