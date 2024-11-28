<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilters implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Cek apakah pengguna sudah login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        // Pastikan $arguments adalah array sebelum melakukan in_array
        if (is_array($arguments) && in_array('admin', $arguments) && $session->get('role') !== 'admin') {
            return redirect()->to('/user/dashboard')->with('msg', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }    

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Logika setelah permintaan diproses
    }
}