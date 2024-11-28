<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('', function($routes) {
    $routes->get('/', 'AuthController::login');
    $routes->get('/login', 'AuthController::login');
    $routes->post('/loginSubmit', 'AuthController::loginSubmit');
    $routes->get('/register', 'AuthController::register');
    $routes->post('/registerSubmit', 'AuthController::registerSubmit');
    $routes->get('/logout', 'AuthController::logout');
});

$routes->group('admin', ['filter' => 'auth:admin'], function($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('manageUsers', 'AdminController::manageUsers');
    $routes->get('addUser', 'AdminController::addUser');
    $routes->post('storeUser', 'AdminController::storeUser');
    $routes->get('editUser/(:num)', 'AdminController::editUser/$1');
    $routes->post('updateUser/(:num)', 'AdminController::updateUser/$1');
    $routes->get('deleteUser/(:num)', 'AdminController::deleteUser/$1');
    $routes->get('manageMobil', 'AdminController::manageMobil');
    $routes->get('addMobil', 'AdminController::addMobil');
    $routes->post('storeMobil', 'AdminController::storeMobil');
    $routes->get('editMobil/(:num)', 'AdminController::editMobil/$1');
    $routes->post('updateMobil/(:num)', 'AdminController::updateMobil/$1');
    $routes->post('updateStatusTransaksi/(:num)', 'AdminController::updateStatusTransaksi/$1');
    $routes->post('pembayaran/updateStatus', 'AdminController::updateStatus');
    
    $routes->get('deleteTransaksi/(:num)', 'AdminController::deleteTransaksi/$1');
    $routes->delete('deleteMobil/(:num)', 'AdminController::deleteMobil/$1');
    $routes->get('manageTransaksi', 'AdminController::manageTransaksi');
    $routes->get('managePembayaran', 'AdminController::managePembayaran');
    $routes->get('viewReports', 'AdminController::viewReports');
    $routes->get('view_reports', 'AdminController::viewReports');
});

$routes->group('user', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'UserController::dashboard');
    $routes->get('mobil', 'UserController::mobil');
    $routes->get('mobil/(:num)', 'UserController::detailMobil/$1');
    $routes->get('transaksi/(:num)', 'UserController::transaksi/$1');
    $routes->post('transaksi/(:num)', 'UserController::confirmTransaction/$1');
    $routes->post('confirmTransaction', 'UserController::confirmTransaction');
    $routes->get('pembayaran/(:num)', 'UserController::pembayaran/$1');
    $routes->post('makePayment', 'UserController::makePayment');
    $routes->get('riwayatTransaksi', 'UserController::riwayatTransaksi');
});