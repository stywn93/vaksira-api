<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// API
$routes->post('api/registrations', 'Api\Registrations::store');
$routes->get('api/check-redundancy', 'Api\Registrations::checkRedundancy');
$routes->post('api/generate-immunization-schedule', 'Api\Registrations::generateImmunizationSchedule');