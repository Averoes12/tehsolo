<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('login', 'Login::login_action');
$routes->get('logout', 'Login::logout');

//Owner
$routes->get('owner/home', 'Owner\Home::index', ['filter' => 'ownerFilter']);
$routes->get('owner/report/(:segment)', 'Owner\Report::index/$1', ['filter' => 'ownerFilter']);
//menuminuman
$routes->get('owner/menu', 'Owner\Menu::data', ['filter' => 'ownerFilter']);
$routes->get('owner/menu/data', 'Owner\Menu::data', ['filter' => 'ownerFilter']);
$routes->post('owner/menu/data', 'Owner\Menu::data', ['filter' => 'ownerFilter']);
$routes->get('owner/menu/formTambah', 'Owner\Menu::formTambah', ['filter' => 'ownerFilter']);
$routes->post('owner/menu/simpandata', 'Owner\Menu::simpandata', ['filter' => 'ownerFilter']);
$routes->get('owner/menu/edit/(:segment)', 'Owner\Menu::edit/$1', ['filter' => 'ownerFilter']);
$routes->post('owner/menu/update/(:segment)', 'Owner\Menu::update/$1', ['filter' => 'ownerFilter']);
$routes->delete('owner/menu/hapus/(:segment)', 'Owner\Menu::hapus/$1', ['filter' => 'ownerFilter']);
//users
$routes->get('owner/users', 'Owner\Users::data', ['filter' => 'ownerFilter']);
$routes->get('owner/users/data', 'Owner\Users::data', ['filter' => 'ownerFilter']);
$routes->post('owner/users/data', 'Owner\Users::data', ['filter' => 'ownerFilter']);
$routes->get('owner/users/formTambah', 'Owner\Users::formTambah', ['filter' => 'ownerFilter']);
$routes->post('owner/users/simpandata', 'Owner\Users::simpandata', ['filter' => 'ownerFilter']);
$routes->get('owner/users/edit/(:segment)', 'Owner\Users::edit/$1', ['filter' => 'ownerFilter']);
$routes->post('owner/users/update/(:segment)', 'Owner\Users::update/$1', ['filter' => 'ownerFilter']);
$routes->delete('owner/users/hapus/(:segment)', 'Owner\Users::hapus/$1', ['filter' => 'ownerFilter']);
$routes->get('owner/users/detail/(:segment)', 'Owner\Users::detail/$1', ['filter' => 'ownerFilter']);
//cabang
$routes->get('owner/cabang', 'Owner\Cabang::data', ['filter' => 'ownerFilter']);
$routes->get('owner/cabang/data', 'Owner\Cabang::data', ['filter' => 'ownerFilter']);
$routes->post('owner/cabang/data', 'Owner\Cabang::data', ['filter' => 'ownerFilter']);
$routes->get('owner/cabang/formTambah', 'Owner\Cabang::formTambah', ['filter' => 'ownerFilter']);
$routes->post('owner/cabang/simpandata', 'Owner\Cabang::simpandata', ['filter' => 'ownerFilter']);
$routes->get('owner/cabang/edit/(:segment)', 'Owner\Cabang::edit/$1', ['filter' => 'ownerFilter']);
$routes->post('owner/cabang/update/(:segment)', 'Owner\Cabang::update/$1', ['filter' => 'ownerFilter']);
$routes->delete('owner/cabang/hapus/(:segment)', 'Owner\Cabang::hapus/$1', ['filter' => 'ownerFilter']);
// transaksi
$routes->get('owner/transaksi', 'Owner\Transaksi::data', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/data', 'Owner\Transaksi::data', ['filter' => 'ownerFilter']);
$routes->post('owner/transaksi/data', 'Owner\Transaksi::data', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/formTambah', 'Owner\Transaksi::formTambah', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/formPengeluaran', 'Owner\Transaksi::formPengeluaran', ['filter' => 'ownerFilter']);
$routes->post('owner/transaksi/simpandata', 'Owner\Transaksi::simpandata', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/edit/(:segment)', 'Owner\Transaksi::edit/$1', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/editPengeluaran/(:segment)', 'Owner\Transaksi::editPengeluaran/$1', ['filter' => 'ownerFilter']);
$routes->post('owner/transaksi/update/(:segment)', 'Owner\Transaksi::update/$1', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/getMenuById/(:segment)', 'Owner\Transaksi::getMenuById/$1', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/getMenuByCabang', 'Owner\Transaksi::getMenuByCabang', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/getAllCabang', 'Owner\Transaksi::getAllCabang', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/print', 'Owner\Transaksi::print', ['filter' => 'ownerFilter']);
$routes->get('owner/transaksi/generate/(:segment)', 'Owner\Transaksi::generate/$1', ['filter'=> 'ownerFilter']);
$routes->get('owner/transaksi/cancelTrx/(:segment)', 'Owner\Transaksi::cancelTrx/$1', ['owner'=> 'ownerFilter']);
$routes->get('owner/transaksi/getDetailTransaksi/(:segment)', 'Owner\Transaksi::getDetailTransaksi/$1', ['owner'=> 'ownerFilter']);


//Pegawai
$routes->get('pegawai/home', 'Pegawai\Home::index', ['filter' => 'pegawaiFilter']);
// transaksi
$routes->get('pegawai/transaksi', 'Pegawai\Transaksi::data', ['filter' => 'pegawaiFilter']);
$routes->get('pegawai/transaksi/data', 'Pegawai\Transaksi::data', ['filter' => 'pegawaiFilter']);
$routes->post('pegawai/transaksi/data', 'Pegawai\Transaksi::data', ['filter' => 'pegawaiFilter']);
$routes->get('pegawai/transaksi/formTambah', 'Pegawai\Transaksi::formTambah', ['filter' => 'pegawaiFilter']);
$routes->get('pegawai/transaksi/formPengeluaran', 'Pegawai\Transaksi::formPengeluaran', ['filter' => 'pegawaiFilter']);
$routes->post('pegawai/transaksi/simpandata', 'Pegawai\Transaksi::simpandata', ['filter' => 'pegawaiFilter']);
$routes->get('pegawai/transaksi/edit/(:segment)', 'Pegawai\Transaksi::edit/$1', ['filter' => 'pegawaiFilter']);
$routes->get('pegawai/transaksi/editPengeluaran/(:segment)', 'Pegawai\Transaksi::editPengeluaran/$1', ['filter' => 'pegawaiFilter']);
$routes->post('pegawai/transaksi/update/(:segment)', 'Pegawai\Transaksi::update/$1', ['filter' => 'pegawaiFilter']);
$routes->get('pegawai/transaksi/getMenuById/(:segment)', 'Pegawai\Transaksi::getMenuById/$1', ['filter' => 'pegawaiFilter']);
//menu
$routes->get('pegawai/menu', 'Pegawai\Menu::data', ['filter' => 'pegawaiFilter']);
$routes->get('pegawai/menu/data', 'Pegawai\Menu::data', ['filter' => 'pegawaiFilter']);
$routes->post('pegawai/menu/data', 'Pegawai\Menu::data', ['filter' => 'pegawaiFilter']);
$routes->get('pegawai/menu/formTambah', 'Pegawai\Menu::formTambah', ['filter' => 'pegawaiFilter']);
$routes->post('pegawai/menu/simpandata', 'Pegawai\Menu::simpandata', ['filter' => 'pegawaiFilter']);
$routes->get('pegawai/menu/edit/(:segment)', 'Pegawai\Menu::edit/$1', ['filter' => 'pegawaiFilter']);
$routes->post('pegawai/menu/update/(:segment)', 'Pegawai\Menu::update/$1', ['filter' => 'pegawaiFilter']);
$routes->delete('pegawai/menu/hapus/(:segment)', 'Pegawai\Menu::hapus/$1', ['filter' => 'pegawaiFilter']);
// change password
$routes->get('pegawai/users/', 'Pegawai\Users', ['filter' => 'pegawaiFilter']);
$routes->post('pegawai/users/update/(:segment)', 'Pegawai\Users::update/$1', ['filter' => 'pegawaiFilter']);






//$routes->get('/', 'Layout::home');
//$routes->get('layout/home', 'Layout::home');
//$routes->get('menuminuman/data', 'menuminuman::data');
//$routes->post('menuminuman/data', 'MenuMinuman::data');
//$routes->get('menuminuman/formTambah', 'MenuMinuman::formTambah');
//$routes->post('/menuminuman/simpandata', 'MenuMinuman::simpandata');
//$routes->get('menuminuman/edit/(:segment)', 'MenuMinuman::edit/$1');
//$routes->post('menuminuman/update/(:segment)', 'MenuMinuman::update/$1');
//$routes->get('menuminuman/hapus/(:segment)', 'MenuMinuman::hapus/$1');
//$routes->delete('menuminuman/hapus/(:segment)', 'MenuMinuman::hapus/$1');