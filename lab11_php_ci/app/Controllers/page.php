<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function home()
    {
        return view('home', [
            'title' => 'Home',
            'content' => 'Selamat datang di halaman home.'
        ]);
    }

    public function about()
    {
        return view('about', [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Kontak Kami',
            'content' => 'Email: info@example.com<br>Telepon: 0812-3456-7890'
        ]);
    }

    public function artikel()
    {
        return view('artikel', [
            'title' => 'Artikel',
            'content' => 'Daftar artikel akan ditampilkan di sini.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title' => 'FAQ',
            'content' => '1. Apa itu CodeIgniter? <br> Jawab: Framework PHP.'
        ]);
    }
}