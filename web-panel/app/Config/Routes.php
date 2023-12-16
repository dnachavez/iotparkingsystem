<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Index::index');

$routes->get('signin', 'SignIn::index');
$routes->post('signin/authorize', 'SignIn::authorize');
$routes->get('signout', 'SignOut::index');

$routes->get('dashboard', 'Dashboard::index');

$routes->get('parking/space/(:num)', 'ParkingSpace::index/$1');

$routes->post('parking/space/(:num)/reserve', 'ParkingSpace::reserve/$1');
$routes->get('parking/space/(:num)/reserve/cancel', 'ParkingSpace::cancelReservation/$1');

$routes->get('parking/space/(:num)/mark/unavailable', 'ParkingSpace::markUnavailable/$1');
$routes->get('parking/space/(:num)/mark/available', 'ParkingSpace::markAvailable/$1');

$routes->get('parking/tollgate', 'Tollgate::index');

$routes->get('parking/reservation', 'ParkingReservation::index');

$routes->get('parking/history', 'ParkingHistory::index');

$routes->get('api/parking/space/status', 'ParkingSpaceApi::parkingSpaceStatus');
$routes->get('api/parking/status', 'ParkingSpaceApi::parkingStatus');
$routes->post('api/parking/status', 'ParkingSpaceApi::updateParkingStatus');
