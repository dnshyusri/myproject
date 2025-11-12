<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'loginController::index');
$routes->post('/login', 'loginController::login');
$routes->get('/logout', 'loginController::logout');
$routes->get('/registerUser', 'loginController::register');
$routes->post('/registerUser', 'loginController::registerUser');
$routes->get('/dashboard', 'dashboard::index');

$routes->group('failAm', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'failAmController::index');
    $routes->post('add', 'failAmController::store');
    $routes->get('add', 'failAmController::add');
    $routes->post('filter', 'failAmController::filter');
    $routes->post('getKodSubjek', 'failAmController::getKodSubjek');
    $routes->get('edit/(:num)', 'failAmController::edit/$1');
    $routes->put('update/(:num)', 'failAmController::update/$1');
    $routes->get('delete/(:num)', 'failAmController::delete/$1');
    $routes->get('pinjam', 'failAmController::pinjam');
    $routes->get('getDetails/(:any)/(:any)/(:any)', 'failAmController::getDetails/$1/$2/$3');
    $routes->get('pinjamPulang/(:any)/(:any)/(:any)', 'failAmController::pinjamPulang/$1/$2/$3');
    $routes->get('editPinjamPulang/(:num)', 'failAmController::editPinjamPulang/$1');
    $routes->put('updatePinjamPulang/(:num)', 'failAmController::updatePinjamPulang/$1');
    $routes->delete('deletePinjamPulang/(:num)', 'failAmController::deletePinjamPulang/$1');
    $routes->post('addPinjamPulang', 'failAmController::addPinjamPulang');
    $routes->get('laporanKeseluruhan', 'failAmController::laporanKeseluruhan');
    $routes->get('laporanKeseluruhanPDF', 'failAmController::laporanKeseluruhanPDF');
    $routes->get('laporanKeseluruhanExcel', 'failAmController::laporanKeseluruhanExcel');
    $routes->get('laporanTkhBln', 'failAmController::laporanTkhBln');
    $routes->get('getAvailableYears', 'failAmController::getAvailableYears');
    $routes->get('laporanTkhBlnTbl', 'failAmController::laporanTkhBlnTbl');
    $routes->post('laporanTkhBlnTblPDF', 'failAmController::laporanTkhBlnTblPDF');
    $routes->post('laporanTkhBlnTblExcel', 'failAmController::laporanTkhBlnTblExcel');
    $routes->get('laporanSttsPmnjm', 'failAmController::laporanSttsPmnjm');
    $routes->get('laporanSttsPmnjmTbl', 'failAmController::laporanSttsPmnjmTbl');
    $routes->post('laporanSttsPmnjmTblPDF', 'failAmController::laporanSttsPmnjmTblPDF');
    $routes->post('laporanSttsPmnjmTblExcel', 'failAmController::laporanSttsPmnjmTblExcel');
});

$routes->group('failPeribadi', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'failPeribadiController::index');
    $routes->post('add', 'failPeribadiController::store');
    $routes->get('add', 'failPeribadiController::add');
    $routes->get('edit/(:num)', 'failPeribadiController::edit/$1');
    $routes->put('update/(:num)', 'failPeribadiController::update/$1');
    $routes->get('delete/(:num)', 'failPeribadiController::delete/$1');
    $routes->get('pinjam', 'failPeribadiController::pinjam');
    $routes->get('getDetails/(:any)/(:any)/(:any)', 'failPeribadiController::getDetails/$1/$2/$3');
    $routes->get('pinjamPulang/(:any)/(:any)/(:any)', 'failPeribadiController::pinjamPulang/$1/$2/$3');
    $routes->get('editPinjamPulang/(:num)', 'failPeribadiController::editPinjamPulang/$1');
    $routes->put('updatePinjamPulang/(:num)', 'failPeribadiController::updatePinjamPulang/$1');
    $routes->delete('deletePinjamPulang/(:num)', 'failPeribadiController::deletePinjamPulang/$1');
    $routes->post('addPinjamPulang', 'failPeribadiController::addPinjamPulang');
    $routes->get('laporanKeseluruhan', 'failPeribadiController::laporanKeseluruhan');
    $routes->get('laporanKeseluruhanPDF', 'failPeribadiController::laporanKeseluruhanPDF');
    $routes->get('laporanKeseluruhanExcel', 'failPeribadiController::laporanKeseluruhanExcel');
    $routes->get('laporanTkhBln', 'failPeribadiController::laporanTkhBln');
    $routes->get('getAvailableYears', 'failPeribadiController::getAvailableYears');
    $routes->get('laporanTkhBlnTbl', 'failPeribadiController::laporanTkhBlnTbl');
    $routes->post('laporanTkhBlnTblPDF', 'failPeribadiController::laporanTkhBlnTblPDF');
    $routes->post('laporanTkhBlnTblExcel', 'failPeribadiController::laporanTkhBlnTblExcel');
    $routes->get('laporanSttsPmnjm', 'failPeribadiController::laporanSttsPmnjm');
    $routes->get('laporanSttsPmnjmTbl', 'failPeribadiController::laporanSttsPmnjmTbl');
    $routes->post('laporanSttsPmnjmTblPDF', 'failPeribadiController::laporanSttsPmnjmTblPDF');
    $routes->post('laporanSttsPmnjmTblExcel', 'failPeribadiController::laporanSttsPmnjmTblExcel');
});

$routes->group('addLookup', ['filter' => 'auth'], function ($routes) {
    $routes->get('addSubjek', 'addLookupController::addSubjek');
    $routes->post('addSubjek', 'addLookupController::storeSubjek');
    $routes->get('addLokasi', 'addLookupController::addLokasi');
    $routes->post('addLokasi', 'addLookupController::storeLokasi');
    $routes->get('addPeminjam', 'addLookupController::addPeminjam');
    $routes->post('addPeminjam', 'addLookupController::storePeminjam');
    $routes->get('tablePeminjam', 'addLookupController::tablePeminjam');
    $routes->get('editPeminjam/(:num)', 'addLookupController::editPeminjam/$1');
    $routes->put('updatePeminjam/(:num)', 'addLookupController::updatePeminjam/$1');
    $routes->get('deletePeminjam/(:num)', 'addLookupController::deletePeminjam/$1');
    $routes->get('addBhgnCwgn', 'addLookupController::addBhgnCwgn');
    $routes->post('addBhgnCwgn', 'addLookupController::storeBhgnCwgn');
});

?>