<?php

namespace App\Cells;

use CodeIgniter\View\Cell;
use App\Models\ArtikelModel;

class ArtikelTerkini extends Cell
{
    public function render(string $library, $params = null, int $ttl = 0, ?string $cacheName = null): string
    {
        // Ambil parameter 'kategori' dari $params
        $kategori = $params['kategori'] ?? null;
        
        $model = new ArtikelModel();
        
        // Query dengan filter kategori jika ada
        $query = $model->orderBy('created_at', 'DESC');
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        $artikel = $query->limit(5)->findAll();
        
        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
}