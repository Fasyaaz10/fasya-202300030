<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterFace;
use CodeIgniter\HTTP\ResponseInterFace;
use CodeIgniter\Filters\FilterInterFace;

class Filter_auth implements FilterInterFace
{
    public function before(RequestInterFace $request, $arguments = null)
    {
        if (session()->get('log') != true) {
            session()->setFlashdata('pesan','anda belum login, silahkan login');
            return redirect()->to(base_url('auth'));
        }
    }

    public function after(RequestInterFace $request, ResponseInterFace $response, $arguments = null)
    {
        if (session()->get('log') == true) {
            return redirect()->to(base_url('home'));
            return redirect()->to(base_url('pengguna'));
        }
    }

}