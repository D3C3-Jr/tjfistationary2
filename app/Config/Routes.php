<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index', ['filter' => 'role:Guest']);

$routes->get('barang', 'MasterController::barang', ['filter' => 'role:Administrator']);
$routes->get('/barang/read', 'MasterController::readBarang');
$routes->post('/barang/save', 'MasterController::saveBarang');
$routes->get('/barang/detail/(:num)', 'MasterController::detailBarang/$1');
$routes->get('/barang/edit/(:num)', 'MasterController::editBarang/$1');
$routes->post('/barang/update', 'MasterController::updateBarang');
$routes->delete('/barang/delete/(:num)', 'MasterController::deleteBarang/$1');
$routes->post('/exportExcelBarang', 'MasterController::exportExcelBarang');
$routes->post('/importBarangExcel', 'MasterController::importBarangExcel');

$routes->get('kategori', 'MasterController::kategori', ['filter' => 'role:Administrator']);
$routes->get('/kategori/read', 'MasterController::readKategori');
$routes->post('/kategori/save', 'MasterController::saveKategori');
$routes->get('/kategori/detail/(:num)', 'MasterController::detailkategori/$1');
$routes->get('/kategori/edit/(:num)', 'MasterController::editKategori/$1');
$routes->post('/kategori/update', 'MasterController::updateKategori');
$routes->delete('/kategori/delete/(:num)', 'MasterController::deleteKategori/$1');

$routes->get('satuan', 'MasterController::satuan', ['filter' => 'role:Administrator']);
$routes->get('/satuan/read', 'MasterController::readSatuan');
$routes->post('/satuan/save', 'MasterController::saveSatuan');
$routes->get('/satuan/detail/(:num)', 'MasterController::detailSatuan/$1');
$routes->get('/satuan/edit/(:num)', 'MasterController::editSatuan/$1');
$routes->post('/satuan/update', 'MasterController::updateSatuan');
$routes->delete('/satuan/delete/(:num)', 'MasterController::deleteSatuan/$1');

$routes->get('costcentre', 'MasterController::costcentre', ['filter' => 'role:Administrator']);
$routes->get('/costcentre/read', 'MasterController::readCostCentre');
$routes->post('/costcentre/save', 'MasterController::saveCostCentre');
$routes->get('/costcentre/detail/(:num)', 'MasterController::detailCostCentre/$1');
$routes->get('/costcentre/edit/(:num)', 'MasterController::editCostCentre/$1');
$routes->post('/costcentre/update', 'MasterController::updateCostCentre');
$routes->delete('/costcentre/delete/(:num)', 'MasterController::deleteCostCentre/$1');

$routes->get('barangmasuk', 'BarangMasukController::barangmasuk', ['filter' => 'role:Administrator']);
$routes->get('/barangmasuk/read', 'BarangMasukController::readBarangMasuk');
$routes->post('/barangmasuk/save', 'BarangMasukController::saveBarangMasuk');
$routes->get('/barangmasuk/detail/(:num)', 'BarangMasukController::detailBarangMasuk/$1');
$routes->get('/barangmasuk/edit/(:num)', 'BarangMasukController::editBarangMasuk/$1');
$routes->post('/barangmasuk/update', 'BarangMasukController::updateBarangMasuk');
$routes->delete('/barangmasuk/delete/(:num)', 'BarangMasukController::deleteBarangMasuk/$1');
$routes->get('/barangmasuk/multipleadd', 'BarangMasukController::multipleAddBarangMasuk');
$routes->post('barangmasuk/saveMultipleBarangMasuk', 'BarangMasukController::saveMultipleBarangMasuk');
$routes->post('/exportExcelBarangMasuk', 'BarangMasukController::exportExcelBarangMasuk');

$routes->get('barangkeluar', 'BarangKeluarController::barangkeluar');
$routes->get('/barangkeluar/read', 'BarangKeluarController::readBarangKeluar');
$routes->post('/barangkeluar/save', 'BarangKeluarController::saveBarangKeluar');
$routes->get('/barangkeluar/detail/(:num)', 'BarangKeluarController::detailBarangKeluar/$1');
$routes->get('/barangkeluar/edit/(:num)', 'BarangKeluarController::editBarangKeluar/$1');
$routes->post('/barangkeluar/update', 'BarangKeluarController::updateBarangKeluar');
$routes->delete('/barangkeluar/delete/(:num)', 'BarangKeluarController::deleteBarangKeluar/$1');
$routes->get('/barangkeluar/multipleadd', 'BarangKeluarController::multipleAddBarangKeluar');
$routes->post('barangkeluar/saveMultipleBarangKeluar', 'BarangKeluarController::saveMultipleBarangKeluar');
$routes->post('/exportExcelBarangKeluar', 'BarangKeluarController::exportExcelBarangKeluar');
