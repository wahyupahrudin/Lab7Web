<?php

namespace Config;

$routes = Services::routes();

if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

// Route untuk halaman statis (dari praktikum 1)
$routes->get('/', 'Page::home');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');

// ========= ROUTE UNTUK ARTIKEL (CRUD) =========
// Halaman daftar artikel (dari database)
$routes->get('/artikel', 'Artikel::index');

// Halaman detail artikel (berdasarkan slug)
$routes->get('/artikel/(:any)', 'Artikel::view/$1');
// Route untuk halaman login (menampilkan form dan memproses POST)
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');

// Jika Anda juga ingin route untuk daftar user (index)
$routes->get('/user', 'User::index');

// Route logout
$routes->get('/user/logout', 'User::logout');
// Contoh: kelompok route admin dengan filter 'auth'
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('article', 'Admin::article');
    // route admin lainnya
});

// Group route untuk admin (CRUD)
$routes->group('admin', function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');      // untuk form tambah & proses tambah
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1'); // untuk form edit & proses edit
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

// Additional Routing (biarkan seperti default)
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}