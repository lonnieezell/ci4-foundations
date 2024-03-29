<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'BlogController::index');
$routes->get('post/(:segment)', 'BlogController::view/$1');

// CRUD methods
$routes->get('posts/create', 'PostController::createView');
$routes->get('posts/(:num)', 'PostController::editView/$1');
$routes->get('posts', 'PostController::manage');
$routes->post('posts', 'PostController::save');
$routes->post('posts/(:num)', 'PostController::save/$1');
$routes->post('posts/(:num)/delete', 'PostController::delete/$1');

// API
$routes->group('api', ['namespace' => 'App\Controllers\Api', 'filter' => 'throttle'], function($routes) {
	$routes->get('posts', 'PostController::index');
	$routes->post('posts', 'PostController::create');
	$routes->get('posts/(:segment)', 'PostController::show/$1');
	$routes->post('posts/(:segment)', 'PostController::update/$1');
	$routes->delete('posts/(:segment)', 'PostController::delete/$1');
	$routes->put('posts/(:segment)/set-image', 'PostController::setImage/$1');
});

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
