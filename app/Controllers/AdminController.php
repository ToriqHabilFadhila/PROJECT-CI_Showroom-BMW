<?php

namespace App\Controllers;

use App\Models\MobilModel;
use App\Models\UsersModel;
use App\Models\TransaksiModel;
use App\Models\PembayaranModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $mobilModel = new MobilModel();
        $data['mobils'] = $mobilModel->findAll(); 
        $data['title'] = 'Manajemen Showroom';
        $data['inspirational_message'] = "Keberhasilan adalah hasil dari persiapan, kerja keras, dan belajar dari kegagalan. Teruslah berinovasi dan melangkah maju!";
        if (!session()->get('popup_displayed')) {
            session()->setFlashdata('welcome_message', 'Selamat datang, Admin! Anda berada di tempat yang tepat untuk mengelola dan memaksimalkan potensi showroom BMW. Bersama kita wujudkan pengalaman terbaik bagi pelanggan!');
            session()->set('popup_displayed', true); 
        }
        $dayOfWeek = date('l');
        
        switch($dayOfWeek) {
            case 'Monday':    $data['hari'] = 'Senin'; break;
            case 'Tuesday':   $data['hari'] = 'Selasa'; break;
            case 'Wednesday': $data['hari'] = 'Rabu'; break;
            case 'Thursday':  $data['hari'] = 'Kamis'; break;
            case 'Friday':    $data['hari'] = 'Jumat'; break;
            case 'Saturday':  $data['hari'] = 'Sabtu'; break;
            case 'Sunday':    $data['hari'] = 'Minggu'; break;
        }

        $data['tanggal'] = $data['hari'] . ', ' . date('j F Y');
        
        return view('admin/dashboard', $data);
    }

    public function addUser()
    {
        $data['title'] = 'Tambah Pengguna';
        return view('admin/addUser', $data);
    }

    public function editUser($id)
    {
        $userModel = new UsersModel();
        $data['user'] = $userModel->find($id);
        
        if (!$data['user']) {
            return redirect()->to('/admin/manageUsers')->with('error', 'Users tidak ditemukan.');
        }

        $data['title'] = 'Edit User';
        return view('admin/editUser', $data);
    }

    public function updateUser($id)
    {
        $userModel = new UsersModel();
        $validation = $this->validate([
            'nama' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[users.email,id_pengguna,' . $id . ']',
            'telepon' => 'required|numeric|min_length[10]|max_length[13]',
            'alamat' => 'required|min_length[5]|max_length[255]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $updated = $userModel->update($id, [
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'telepon' => $this->request->getVar('telepon'),
            'alamat' => $this->request->getVar('alamat'),
            'role' => $this->request->getVar('role'),
        ]);

        if (!$updated) {
            return redirect()->back()->with('message', 'Terjadi kesalahan saat memperbarui users');
        }

        return redirect()->to('/admin/manageUsers')->with('message', 'Users berhasil diperbarui');
    }

    public function deleteUser($id)
    {
        $userModel = new UsersModel();
        $user = $userModel->find($id);
        
        if ($user) {
            $userModel->delete($id);
            return redirect()->to('/admin/manageUsers')->with('success', 'Users berhasil dihapus.');
        } else {
            return redirect()->to('/admin/manageUsers')->with('error', 'Users tidak ditemukan.');
        }
    }    

    public function storeUser()
    {
        $userModel = new UsersModel();
        $validation = $this->validate([
            'nama' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'alamat' => 'required',
            'telepon' => 'required|min_length[10]|max_length[13]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel->save([
            'nama' => $this->request->getVar('nama'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'alamat' => $this->request->getVar('alamat'),
            'telepon' => $this->request->getVar('telepon'),
            'role' => $this->request->getVar('role'),
        ]);

        return redirect()->to('/admin/dashboard')->with('message', 'User berhasil ditambahkan');
    }

    public function editMobil($id)
    {
        $mobilModel = new MobilModel();
        $data['mobil'] = $mobilModel->find($id);

        if (!$data['mobil']) {
            return redirect()->to('/admin/manageMobil')->with('error', 'Mobil tidak ditemukan.');
        }

        $data['title'] = 'Edit Mobil';
        return view('admin/editMobil', $data);
    }

    public function updateMobil($id)
    {
        $mobilModel = new MobilModel();

        $validation = $this->validate([
            'merk' => 'required',
            'model' => 'required',
            'harga' => 'required|numeric',
            'spesifikasi' => 'permit_empty',
            'gambar' => 'permit_empty|uploaded[gambar]|is_image[gambar]|max_size[gambar,2048]'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'merk' => $this->request->getPost('merk'),
            'model' => $this->request->getPost('model'),
            'harga' => $this->request->getPost('harga'),
            'spesifikasi' => $this->request->getPost('spesifikasi'),
        ];

        if ($this->request->getFile('gambar')->isValid()) {
            $gambar = $this->request->getFile('gambar');
            $fileName = $gambar->getRandomName();
            $gambar->move('uploads', $fileName);
            $data['gambar'] = $fileName;
        }

        $mobilModel->update($id, $data);

        return redirect()->to('/admin/manageMobil')->with('message', 'Mobil berhasil diperbarui.');
    }

    public function deleteMobil($id_mobil)
    {
        $mobilModel = new MobilModel();
        
        if ($mobilModel->delete($id_mobil)) {
            return redirect()->to('/admin/manageMobil')->with('success', 'Mobil berhasil dihapus.');
        } else {
            return redirect()->to('/admin/manageMobil')->with('error', 'Mobil gagal dihapus.');
        }
    }

    public function manageUsers()
    {
        $model = model(UsersModel::class);
        $data['users'] = $model->findAll();
        $data['title'] = 'Kelola Pengguna';
        return view('admin/manageUsers', $data);
    }
    
    public function manageMobil()
    {
        $model = model(MobilModel::class);
        $data['mobils'] = $model->findAll();
        log_message('debug', 'Data Mobil: ' . print_r($data['mobils'], true));
        $data['title'] = 'Kelola Mobil';
        return view('admin/manageMobil', $data);
    }

    public function manageTransaksi()
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('transaksi')
            ->select('transaksi.*, users.nama AS nama_pengguna, mobil.merk AS merk_mobil, mobil.model AS model')
            ->join('users', 'transaksi.id_pengguna = users.id_pengguna', 'left')
            ->join('mobil', 'transaksi.id_mobil = mobil.id_mobil', 'left')
            ->get();

        $data['transaksi'] = $query->getResultArray();
        $data['title'] = 'Kelola Transaksi';
        return view('admin/view_reports', $data);
    }

    public function deleteTransaksi($id_transaksi)
    {
        $transaksiModel = new TransaksiModel();
        $pembayaranModel = new PembayaranModel();
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $pembayaranModel->where('id_transaksi', $id_transaksi)->delete();
            $deleted = $transaksiModel->delete($id_transaksi);
            $db->transComplete();

            if ($deleted) {
                return redirect()->to('/admin/view_reports')->with('success', 'Transaksi berhasil dihapus.');
            } else {
                return redirect()->to('/admin/view_reports')->with('error', 'Transaksi gagal dihapus.');
            }
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            $db->transRollback();
            log_message('error', 'Error deleting transaction: ' . $e->getMessage());
            return redirect()->to('/admin/view_reports')->with('error', 'Terjadi kesalahan saat menghapus transaksi.');
        }
    }

    public function managePembayaran()
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('pembayaran')
            ->select('
                pembayaran.*,
                transaksi.id_transaksi,
                transaksi.status AS status_transaksi,
                users.nama AS nama_pengguna,
                mobil.merk AS merk_mobil,
                mobil.model AS model_mobil
            ')
            ->join('transaksi', 'pembayaran.id_transaksi = transaksi.id_transaksi')
            ->join('users', 'transaksi.id_pengguna = users.id_pengguna')
            ->join('mobil', 'transaksi.id_mobil = mobil.id_mobil')
            ->where('pembayaran.status !=', 'Completed')
            ->orderBy('pembayaran.updated_at', 'DESC')
            ->get();

        $data['pembayaran'] = $query->getResultArray();
        $data['title'] = 'Kelola Pembayaran';
        return view('admin/managePembayaran', $data);
    }

    public function addMobil()
    {
        $data['title'] = 'Tambah Mobil'; 
        return view('admin/addMobil', $data);
    }

    public function storeMobil()
    {
        $model = model(MobilModel::class);
        $validation = \Config\Services::validation();

        $rules = [
            'merk' => 'required',
            'model' => 'required',
            'harga' => 'required|numeric',
            'spesifikasi' => 'permit_empty',
            'gambar' => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $harga = $this->request->getPost('harga');
        if (!is_numeric($harga) || $harga <= 0) {
            return redirect()->back()->withInput()->with('errors', ['harga' => 'Harga harus berupa angka positif.']);
        }

        $gambar = $this->request->getFile('gambar');
        $fileName = '';
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $fileName = $gambar->getRandomName();
            try {
                $gambar->move('uploads', $fileName);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal mengunggah gambar: ' . $e->getMessage()]);
            }
        } else {
            return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gambar tidak valid atau gagal diunggah.']);
        }

        $data = [
            'merk' => $this->request->getPost('merk'),
            'model' => $this->request->getPost('model'),
            'harga' => $harga,
            'spesifikasi' => $this->request->getPost('spesifikasi'),
            'gambar' => $fileName
        ];

        try {
            if ($model->save($data)) {
                return redirect()->to('/admin/manageMobil')->with('message', 'Mobil berhasil ditambahkan.');
            } else {
                if (file_exists('uploads/' . $fileName)) {
                    unlink('uploads/' . $fileName);
                }
                return redirect()->back()->withInput()->with('errors', ['general' => 'Gagal menambahkan mobil: ' . implode(', ', $model->errors())]);
            }
        } catch (\Exception $e) {
            if (file_exists('uploads/' . $fileName)) {
                unlink('uploads/' . $fileName);
            }
            return redirect()->back()->withInput()->with('errors', ['general' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    public function updateStatusTransaksi($id_transaksi)
    {
        $transaksiModel = new TransaksiModel();
        $pembayaranModel = new PembayaranModel();
        $transaksi = $transaksiModel->find($id_transaksi);  
        if (!$transaksi) {
            session()->setFlashdata('error', 'Transaksi tidak ditemukan.');
            return redirect()->to('/admin/view_reports');
        }
    
        $status = $this->request->getPost('status');
        $validStatuses = ['Completed', 'Cancelled'];
        if (in_array($status, $validStatuses)) {
            if (in_array($transaksi['status'], $validStatuses)) {
                session()->setFlashdata('error', 'Transaksi ini sudah dalam status ' . $transaksi['status'] . ' dan tidak dapat diubah.');
                return redirect()->to('/admin/view_reports');
            }

            $db = \Config\Database::connect();
            $db->transStart();
    
            try {
                $transaksiModel->update($id_transaksi, [
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
    
                $pembayaranModel->where('id_transaksi', $id_transaksi)
                    ->set([
                        'status' => $status,
                        'updated_at' => date('Y-m-d H:i:s'),
                        'keterangan' => $status === 'Completed' ? 'Pembayaran telah dikonfirmasi' : 'Transaksi dibatalkan'
                    ])
                    ->update();
 
                $db->transComplete();
 
                if ($db->transStatus() === false) {
                    throw new \Exception('Gagal memperbarui status transaksi atau pembayaran.');
                }
    
                session()->setFlashdata('message', 'Status transaksi dan pembayaran berhasil diperbarui.');
    
            } catch (\Exception $e) {
                $db->transRollback();
                log_message('error', 'Error updating transaction status: ' . $e->getMessage());
                session()->setFlashdata('error', 'Terjadi kesalahan saat memperbarui status. Silakan coba lagi.');
            }
        } else {
            session()->setFlashdata('error', 'Status tidak valid.');
        }
    
        return redirect()->to('/admin/view_reports');
    }    

    public function viewReports()
    {
        $db = \Config\Database::connect();
        $transaksiModel = new TransaksiModel();
        $data['riwayat'] = $transaksiModel->findAll();
        $queryTransaksi = $db->table('transaksi')
            ->select('transaksi.*, users.nama AS nama_pengguna, mobil.merk AS merk_mobil, mobil.model AS model, 
                    pembayaran.id_pembayaran, pembayaran.bukti_pembayaran, pembayaran.status AS status_pembayaran, 
                    pembayaran.metode_pembayaran, pembayaran.tanggal_pembayaran, pembayaran.jumlah')
            ->join('users', 'transaksi.id_pengguna = users.id_pengguna')
            ->join('mobil', 'transaksi.id_mobil = mobil.id_mobil')
            ->join('pembayaran', 'transaksi.id_transaksi = pembayaran.id_transaksi', 'left')
            ->orderBy('transaksi.tanggal', 'DESC')
            ->get();

        $data['transaksi'] = $queryTransaksi->getResultArray();
        $data['title'] = 'Laporan Transaksi dan Pembayaran';
        return view('admin/view_reports', $data);
    }
}