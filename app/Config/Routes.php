<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers'); // Set the default namespace for controllers.
$routes->setDefaultController('Home');          // Set the default controller.
$routes->setDefaultMethod('index');             // Set the default method.
$routes->setTranslateURIDashes(false);          // Disable translation of dashes to underscores in URIs.
$routes->set404Override(function () {           // Set a custom 404 handler.
    echo view('errors/html/error_404');         // Replace this with your own logic or view.
});
$routes->setAutoRoute(true);                    // Enable auto-routing.



/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Define your routes here. For example:
$routes->get('/', 'Home::index');               // Default route for the root URL.
$routes->get('/register', 'AuthController::registerForm'); // Show the registration form
$routes->post('/register', 'AuthController::register');    // Handle registration submission when click button

$routes->get('/login', 'AuthController::loginForm');       // Show the login form
$routes->post('/login', 'AuthController::login');          // Handle login submission when click button
$routes->post('/logout', 'AuthController::logout');

$routes->get('/addLetter', 'AuthController::addLetter');     // Show the addLetter form
$routes->post('/letter-in', 'LetterController::store');

$routes->get('/updateLetter', 'LetterController::updateForm');  // Show the update form
$routes->get('/notPermitted', 'LetterController::updateForm');

$routes->post('/updateLetter', 'LetterController::update');

$routes->get('/letterList', 'LetterController::list');  // Show the letter list form

$routes->get('/admin', 'AuthController::userlist');

$routes->get('/auth', 'LetterController::authlist');

$routes->get('/aboutUs', 'AuthController::aboutUs');

$routes->get('/dashboard', 'AuthController::loadDashboard');

$routes->get('letter/downloadPdf', 'LetterController::downloadPdf');

$routes->get('/user/edit/(:num)', 'AuthController::editUserForm/$1');
$routes->post('/user/edit/(:num)', 'AuthController::updateUser/$1');

$routes->get('/letter/search', 'LetterController::search');

$routes->get('/location/add', 'AuthController::add');
$routes->post('/location/addLocation', 'AuthController::addLocation');


//$routes->get('/admin', 'LetterController::admin');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * This is where you can include additional routing files if needed.
 * For example, you might separate routing by module.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
