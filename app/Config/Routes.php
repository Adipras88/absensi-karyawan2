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
$routes->setDefaultController('SigninController');
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
// route since we don't have to scan directories.s
$routes->get('/login', 'SigninController::index');
$routes->get('/logout', 'SigninController::logout');
$routes->post('/login/submit', 'SigninController::loginAuth');
$routes->get('/register', 'SigninController::register');
$routes->post('/register/submit', 'SigninController::registerSubmit');
$routes->get('/qr/create', 'QRServiceController::create');

$routes->group('admin', ['filter' => 'authGuard'], function ($routes) {
    /** EMPLOYEE **/
    $routes->get('dashboard', 'HomeController::index');
    $routes->get('employee', 'EmployeeController::index');
    $routes->get('employee/form', 'EmployeeController::create');
    $routes->post('employee/save', 'EmployeeController::save');
    $routes->get('employee/edit/(:num)', 'EmployeeController::edit/$1');
    $routes->post('employee/update/(:num)', 'EmployeeController::update/$1');
    $routes->get('employee/detail/(:num)', 'EmployeeController::detail/$1');
    $routes->delete('employee/delete/(:num)', 'EmployeeController::delete/$1');

    /** JOBS **/
    $routes->get('job', 'JobController::index');
    $routes->get('job/form', 'JobController::form');
    $routes->get('job/form/(:num)', 'JobController::form/$1');
    $routes->post('job/save', 'JobController::save');
    $routes->get('job/edit/(:num)', 'JobController::edit/$1');
    $routes->post('job/update/(:num)', 'JobController::update/$1');
    $routes->get('job/detail/(:num)', 'JobController::detail/$1');
    $routes->delete('job/delete/(:num)', 'JobController::delete/$1');

    /** ATTENDANCE **/
    $routes->get('attendance', 'AttendanceController::index');
    $routes->post('attendance/(:num)/(:any)', 'AttendanceController::changeStatus/$1/$2');
    $routes->delete('attendance/delete/(:num)', 'AttendanceController::delete/$1');

    /** Quick Response Code **/
    $routes->get('qr', 'QRCodeController::index');
    $routes->post('qr/save', 'QRCodeController::add_data');
    $routes->post('qr/update/(:num)', 'QRCodeController::edit_data/$1');
    $routes->delete('qr/delete/(:num)', 'QRCodeController::remove_data/$1');

    /** CATEGORIES **/
    $routes->get('category', 'CategoryController::index');
    $routes->get('category/form', 'CategoryController::create');
    $routes->post('category/save', 'CategoryController::save');
    $routes->get('category/edit/(:num)', 'CategoryController::edit/$1');
    $routes->post('category/update/(:num)', 'CategoryController::update/$1');
    $routes->get('category/detail/(:num)', 'CategoryController::detail/$1');
    $routes->delete('category/delete/(:num)', 'CategoryController::delete/$1');

    /** PERFORMANCE **/
    $routes->get('evaluation', 'EvaluationController::index');
    $routes->get('evaluation/create', 'EvaluationController::create');
    $routes->post('evaluation/create/submit', 'EvaluationController::createSave');
    $routes->get('evaluation/edit/(:num)', 'EvaluationController::edit/$1');
    $routes->post('evaluation/edit/submit/(:num)', 'EvaluationController::editSave/$1');
    $routes->get('evaluation/detail/(:num)', 'EvaluationController::detail/$1');
    $routes->delete('evaluation/delete/(:num)', 'EvaluationController::delete/$1');

    /** EVALUATION **/
    $routes->get('report', 'ReportController::index');
    $routes->get('report/detail/(:num)', 'ReportController::detail/$1');
    $routes->delete('report/delete/(:num)', 'ReportController::delete/$1');
});

$routes->group('user', ['filter' => 'authGuard'], function ($routes) {
    $routes->get('/', 'UserController::index', ['filter' => 'authGuard']);
    $routes->get('profile', 'UserController::profile', ['filter' => 'authGuard']);

    /** ABSENT **/
    $routes->get('absent', 'UserController::absent', ['filter' => 'authGuard']);
    $routes->get('scan', 'AttendanceController::scanner', ['filter' => 'authGuard']);
    $routes->post('scan/submit', 'AttendanceController::scannerSave', ['filter' => 'authGuard']);

    /** PERMISSIONS **/
    $routes->get('permission', 'AttendanceController::permission', ['filter' => 'authGuard']);
    $routes->post('permission/submit', 'AttendanceController::permissionSave', ['filter' => 'authGuard']);

    /** QR CODE **/
    $routes->get('qrcode', 'AttendanceController::getQrCode', ['filter' => 'authGuard']);

    /** REPORT TASK **/
    $routes->get('report', 'UserController::report', ['filter' => 'authGuard']);
    $routes->post('report/create/submit', 'ReportController::createSave', ['filter' => 'authGuard']);

    $routes->get('report/list', 'ReportController::reportList', ['filter' => 'authGuard']);
    $routes->get('report/detail/(:num)', 'ReportController::reportDetail/$1');

    $routes->get('task', 'UserController::task', ['filter' => 'authGuard']);
    $routes->get('task/detail/(:num)', 'UserController::TaskDetail/$1', ['filter' => 'authGuard']);

    /** PRESENCE **/
    $routes->get('presence', 'AttendanceController::presence', ['filter' => 'authGuard']);
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
