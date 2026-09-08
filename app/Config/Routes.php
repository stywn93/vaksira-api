<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// API
$routes->post('api/registrations', 'Api\Registrations::store');
$routes->get('api/check-redundancy', 'Api\Registrations::checkRedundancy');
// $routes->get('api/get-schedule', 'Api\Registrations::getSchedule');

$routes->get('api/get-schedule/(:num)','Api\Registrations::getSchedule/$1');

$routes->group('api/wilayah', static function ($routes) {
    $routes->get('provinsi', 'Api\Wilayah::provinsi');
    $routes->get('anak', 'Api\Wilayah::anak');
});