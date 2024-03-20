<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Login;

$routes = Services::routes();

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('dashboard', 'DashboardController::index');

$routes->get('show_audits', 'DashboardController::showAudits');

$routes->get('login', 'AuthController::login');
$routes->post('process-login', 'AuthController::processLogin');
$routes->get('logout', 'AuthController::logout');

$routes->get('dashboard', 'DashboardController::index');

$routes->get('penilaian', 'PenilaianController::index');

$routes->get('/penilaian/choose-department/(:any)', 'PenilaianController::chooseDepartment/$1');

$routes->get('audit-types/showDepartments/(:segment)', 'AuditTypesController::showDepartments/$1');

$routes->get('/show-departments', 'PenilaianController::showDepartments');
$routes->get('penilaian/(:num)', 'PenilaianController::showDepartments/$1');

$routes->get('penilaian/getSubDepartments/(:num)', 'PenilaianController::getSubDepartments/$1');

$routes->get('penilaian/showQuestions/(:num)', 'PenilaianController::showQuestions/$1');

$routes->post('penilaian/showQuestions/process_answers', 'PenilaianController::processAnswers');

$routes->add('penilaian/showQuestions/process_answers', 'PenilaianController::processAnswers');

// $routes->add('penilaian/showQuestions/process_answers/(:segment)', 'PenilaianController::processAnswers/$1');

// $routes->add('penilaian/showQuestions/process_answers/(:segment)', 'PenilaianController::processAnswers/$1');
$routes->add('penilaian/showQuestions/processAnswers/(:segment)', 'PenilaianController::processAnswers/$1');

$routes->get('show_audits/getAuditDetails/(:num)', 'ShowAuditsController::getAuditDetails/$1');

$routes->post('show_audits/submitAuditDetails', 'ShowAuditsController::submitAuditDetails');

$routes->add('showauditscontroller/submitAuditDetails', 'ShowAuditsController::submitAuditDetails');
