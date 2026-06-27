<?php

namespace App\Controllers;

use App\Models\ArtikelModel;

class Admin extends BaseController
{
    // Method untuk menampilkan daftar artikel di halaman admin
    public function article()
    {
        $model = new ArtikelModel();
        // Ambil semua data artikel, diurutkan dari yang terbaru
        $artikel = $model->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title'   => 'Admin Page - Daftar Artikel',
            'artikel' => $artikel,
        ];

        // Tampilkan view dari file 'admin/article.php'
        return view('admin/article', $data);
    }
}