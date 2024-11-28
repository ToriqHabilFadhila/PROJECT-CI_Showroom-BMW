<?php

namespace App\Controllers;

use App\Models\MobilModel;
use App\Models\PembayaranModel;
use App\Models\TransaksiModel;

class UserController extends BaseController
{
    public function dashboard()
    {
        $mobilModel = new MobilModel();
        $data['mobils'] = $mobilModel->findAll();
        $data['title'] = 'Dashboard Pengguna';
        $data['inspirational_message'] = "Jelajahi koleksi mobil eksklusif kami dan temukan sensasi berkendara yang berbeda.";
        if (!session()->get('popup_displayed')) {
            session()->setFlashdata('welcome_message', 'Selamat datang di showroom BMW! Kami siap membantu Anda menemukan mobil yang sesuai dengan gaya dan kebutuhan Anda.');
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

        return view('user/dashboard', $data);
    }

    public function transaksi($id_mobil)
    {
        $mobilModel = new MobilModel();
        $mobil = $mobilModel->find($id_mobil);

        // Pass data to the view
        return view('user/transaksi', [
            'mobil' => $mobil,
        ]);
    }

    public function confirmTransaction()
    {
        $id_mobil = $this->request->getPost('id_mobil');
        $harga = $this->request->getPost('harga');
        $userId = session()->get('id_pengguna');

        if (!$harga || !$id_mobil) {
            return redirect()->to('/user/dashboard')->with('error', 'Data transaksi tidak lengkap.');
        }

        $transaksiModel = model(TransaksiModel::class);
        $data = [
            'id_pengguna' => $userId,
            'id_mobil' => $id_mobil,
            'tanggal' => date('Y-m-d H:i:s'),
            'total_harga' => $harga,
            'status' => 'Pending',
        ];

        if ($transaksiModel->save($data)) {
            $id_transaksi = $transaksiModel->insertID();
            return redirect()->to("/user/pembayaran/$id_transaksi")->with('msg', 'Transaksi berhasil. Silakan lanjut ke pembayaran.');
        } else {
            return redirect()->to('/user/dashboard')->with('error', 'Transaksi gagal. Silakan coba lagi.');
        }
    }

    public function pembayaran($id_transaksi)
    {
        $transaksiModel = model(TransaksiModel::class);
        $mobilModel = model(MobilModel::class);  // Model untuk mengakses data mobil

        // Ambil data transaksi berdasarkan ID
        $transaksi = $transaksiModel->find($id_transaksi);

        if (!$transaksi) {
            return redirect()->to('/user/dashboard')->with('error', 'Transaksi tidak ditemukan.');
        }

        // Ambil data mobil berdasarkan ID mobil yang ada di transaksi
        $mobil = $mobilModel->find($transaksi['id_mobil']);
        
        if (!$mobil) {
            return redirect()->to('/user/dashboard')->with('error', 'Mobil tidak ditemukan.');
        }

        // Data yang akan dikirim ke view
        $data = [
            'transaksi' => $transaksi,
            'mobil' => $mobil
        ];

        return view('user/pembayaran', $data);
    }

    public function makePayment()
    {
        // Validasi input terlebih dahulu
        if (!$this->validate([
            'id_transaksi' => 'required',
            'metode_pembayaran' => 'required',
            'jumlah' => 'required|numeric',
            'bukti_pembayaran' => 'uploaded[bukti_pembayaran]|is_image[bukti_pembayaran]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Formulir pembayaran tidak valid.');
        }

        $idTransaksi = $this->request->getPost('id_transaksi');
        $metodePembayaran = $this->request->getPost('metode_pembayaran');
        $jumlah = $this->request->getPost('jumlah');
        
        // Mengambil file bukti pembayaran
        $fileBukti = $this->request->getFile('bukti_pembayaran');
        
        // Folder untuk menyimpan bukti pembayaran di public directory
        $uploadPath = ROOTPATH . 'public/uploads/bukti_pembayaran/';
        
        // Jika folder tidak ada, buat folder
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true); // Membuat folder jika belum ada
        }

        if ($fileBukti->isValid() && !$fileBukti->hasMoved()) {
            // Memindahkan file ke folder yang ditentukan
            $buktiFile = $fileBukti->getRandomName();  // Mendapatkan nama file acak
            $fileBukti->move($uploadPath, $buktiFile);  // Menyimpan file dengan nama acak
        } else {
            return redirect()->back()->with('error', 'Upload bukti pembayaran gagal.');
        }

        // Data yang akan disimpan
        $dataPembayaran = [
            'id_transaksi' => $idTransaksi,
            'jumlah' => $jumlah,
            'metode_pembayaran' => $metodePembayaran,
            'bukti_pembayaran' => $buktiFile,
            'status' => 'Pending',
            'tanggal_pembayaran' => date('Y-m-d H:i:s')
        ];

        $pembayaranModel = new PembayaranModel();

        // Menyimpan data pembayaran ke database
        if ($pembayaranModel->save($dataPembayaran)) {
            return redirect()->to('/user/riwayatTransaksi')->with('message', 'Pembayaran berhasil dilakukan. Menunggu konfirmasi.');
        } else {
            return redirect()->back()->with('error', 'Pembayaran gagal. Silakan coba lagi.');
        }
    }

    public function prosesPembayaran()
    {
        $idTransaksi = $this->request->getPost('id_transaksi');
        $jumlah = $this->request->getPost('jumlah');
        $metodePembayaran = $this->request->getPost('metode_pembayaran');

        $pembayaranModel = new PembayaranModel();
        $transaksiModel = new TransaksiModel();

        // Validate if transaction exists and belongs to the user
        $transaksi = $transaksiModel->find($idTransaksi);
        if (!$transaksi || $transaksi['status'] != 'Pending') {
            return redirect()->to('/user/dashboard')->with('error', 'Transaksi tidak valid.');
        }

        $dataPembayaran = [
            'id_transaksi' => $idTransaksi,
            'jumlah' => $jumlah,
            'metode_pembayaran' => $metodePembayaran,
            'tanggal_pembayaran' => date('Y-m-d H:i:s'),
        ];

        if ($pembayaranModel->save($dataPembayaran)) {
            $transaksiModel->update($idTransaksi, ['status' => 'Completed']);
            return redirect()->to('/user/riwayatTransaksi')->with('msg', 'Pembayaran berhasil. Transaksi telah diselesaikan.');
        } else {
            return redirect()->to('/user/dashboard')->with('error', 'Pembayaran gagal. Silakan coba lagi.');
        }
    }

    public function riwayatTransaksi()
    {
        $transaksiModel = model(TransaksiModel::class);
        $pembayaranModel = model(PembayaranModel::class);
    
        // Mendapatkan id_pengguna dari session
        $id_pengguna = session()->get('id_pengguna');
    
        // Mengambil semua transaksi berdasarkan id_pengguna
        $transaksi = $transaksiModel->where('id_pengguna', $id_pengguna)->findAll();
    
        // Menambahkan data pembayaran untuk setiap transaksi
        foreach ($transaksi as &$item) {
            // Mengambil pembayaran terkait dengan transaksi
            $pembayaran = $pembayaranModel->where('id_transaksi', $item['id_transaksi'])->first();
            
            // Menyimpan pembayaran di dalam transaksi jika ada
            $item['pembayaran'] = $pembayaran ? $pembayaran : null;
        }
    
        // Mengirim data transaksi ke view
        $data['transaksi'] = $transaksi;
        return view('user/riwayatTransaksi', $data);
    }    
}