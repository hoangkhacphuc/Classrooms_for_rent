<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');
$routes->get('login', 'HomeController::Login_Page');
$routes->get('logout', 'UserController::logout');
$routes->get('rent', 'RoomController::index');
$routes->get('pay', 'HomeController::Pay_Page');

$routes->group('admin', function($routes) {
    $routes->get('/', 'UserController::Statistical_Page');
    $routes->get('rooms', 'RoomController::Rooms_Manager_Page');
    $routes->get('accounts', 'UserController::Accounts_Manager_Page');
    $routes->group('api', function($routes) {
        $routes->post('deleteRoom', 'RoomController::deleteRoom');
        $routes->post('updateRoom', 'RoomController::updateRoom');
        $routes->post('addRoom', 'RoomController::addRoom');
        $routes->post('deleteUser', 'UserController::deleteUser');
        $routes->post('register', 'UserController::register');
    });    
});

$routes->group('api', function($routes) {
    $routes->post('login', 'UserController::login');
    $routes->post('updateProfile', 'UserController::updateProfile');
    $routes->post('getListShiftRent', 'ShiftController::getListShiftRent');
    $routes->post('deleteRoomRent', 'RoomController::deleteRoomRent');
    $routes->post('rentRoom', 'RoomController::rentRoom');

});



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
