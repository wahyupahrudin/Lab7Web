<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    // ================================================================
    // HALAMAN DEPAN - DAFTAR ARTIKEL
    // ================================================================
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->getArtikelDenganKategori();
        return view('artikel/index', compact('artikel', 'title'));
    }

    // ================================================================
    // HALAMAN DETAIL ARTIKEL
    // ================================================================
    public function view(string $slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->db->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->where('artikel.slug', $slug)
            ->get()
            ->getRowArray();

        if (!$artikel) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];
        return view('artikel/detail', compact('artikel', 'title'));
    }

    // ================================================================
    // ADMIN - DAFTAR ARTIKEL (DENGAN FILTER & PAGINATION)
    // ================================================================
    public function admin_index()
    {
        $title = 'Daftar Artikel (Admin)';
        $model = new ArtikelModel();
        
        // Ambil parameter filter dari URL
        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $page = $this->request->getVar('page') ?? 1;
        
        // Query builder dengan join ke tabel kategori
        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');
        
        // Filter pencarian judul
        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }
        
        // Filter kategori
        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }
        
        // Pagination
        $artikel = $builder->paginate(10, 'default', $page);
        $pager = $model->pager;
        
        // Ambil semua kategori untuk dropdown filter
        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->findAll();
        
        // Cek apakah request dari AJAX
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'artikel' => $artikel,
                'pager' => $pager,
                'q' => $q,
                'kategori_id' => $kategori_id
            ]);
        }
        
        // Kirim semua data ke view
        return view('artikel/admin_index', [
            'title' => $title,
            'artikel' => $artikel,
            'pager' => $pager,
            'q' => $q,
            'kategori_id' => $kategori_id,
            'kategori' => $kategori
        ]);
    }

    // ================================================================
    // ADMIN - TAMBAH ARTIKEL
    // ================================================================
    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'id_kategori' => 'required|integer'
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $model = new ArtikelModel();
            $slug = url_title($this->request->getPost('judul'), '-', true);
            
            // Upload gambar
            $file = $this->request->getFile('gambar');
            $namaGambar = null;
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $namaGambar = $file->getRandomName();
                $file->move('public/gambar', $namaGambar);
            }
            
            // Simpan ke database
            $model->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => $slug,
                'id_kategori' => $this->request->getPost('id_kategori'),
                'status' => $this->request->getPost('status') ?? 0,
                'gambar' => $namaGambar
            ]);
            
            return redirect()->to('/admin/artikel');
        }

        // Tampilkan form tambah
        $title = 'Tambah Artikel';
        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->findAll();
        
        return view('artikel/form_add', [
            'title' => $title,
            'kategori' => $kategori
        ]);
    }

    // ================================================================
    // ADMIN - EDIT ARTIKEL
    // ================================================================
    public function edit(int $id)
    {
        $model = new ArtikelModel();
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'id_kategori' => 'required|integer'
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $slug = url_title($this->request->getPost('judul'), '-', true);
            $data = [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => $slug,
                'id_kategori' => $this->request->getPost('id_kategori'),
                'status' => $this->request->getPost('status') ?? 0
            ];
            
            // Upload gambar baru
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Hapus gambar lama
                $oldData = $model->find($id);
                if (!empty($oldData['gambar']) && file_exists('public/gambar/' . $oldData['gambar'])) {
                    unlink('public/gambar/' . $oldData['gambar']);
                }
                
                // Simpan gambar baru
                $namaGambar = $file->getRandomName();
                $file->move('public/gambar', $namaGambar);
                $data['gambar'] = $namaGambar;
            }
            
            $model->update($id, $data);
            return redirect()->to('/admin/artikel');
        }

        // Tampilkan form edit
        $data = $model->find($id);
        $title = 'Edit Artikel';
        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->findAll();
        
        return view('artikel/form_edit', [
            'title' => $title,
            'data' => $data,
            'kategori' => $kategori
        ]);
    }

    // ================================================================
    // ADMIN - HAPUS ARTIKEL
    // ================================================================
    public function delete(int $id)
    {
        $model = new ArtikelModel();
        
        // Hapus gambar jika ada
        $data = $model->find($id);
        if (!empty($data['gambar']) && file_exists('public/gambar/' . $data['gambar'])) {
            unlink('public/gambar/' . $data['gambar']);
        }
        
        $model->delete($id);
        return redirect()->to('/admin/artikel');
    }
}