<?php

namespace App\Controllers;
use App\Models\Model_dep;

class Dep extends BaseController
{
    public function __construct()
    {
        $this->Model_dep = new Model_dep();
        helper('form');
    }
    public function index()
    {
        $data = array(
            'Title' => 'Departement',
            'dep' => $this->Model_dep->alldata(),
            'isi' => 'v_dep'
        );
        return view('layout/v_wrapper', $data);
    }

    public function tambah()
    {
        $data = array('nama_dep' => $this->request->getPost('nama_dep'));
        $this->Model_dep->tambah($data);
        session()->setFlashdata('pesan','Data Berhasil Ditambah !!!');
        return redirect()->to(base_url('dep'));
    }

    public function edit($id_dep)
    {
        $data = array(
            'id_dep' => $id_dep,
            'nama_dep' => $this->request->getPost('nama_dep')
        );
        $this->Model_dep->edit($data);
        session()->setFlashdata('pesan','Data Berhasil Diupdate !!!');
        return redirect()->to(base_url('dep'));
    }

    public function delete($id_dep)
    {
        $data = array(
            'id_dep' => $id_dep,
        );
        $this->Model_dep->delete_data($data);
        session()->setFlashdata('pesan','Data Berhasil Dihapus !!!');
        return redirect()->to(base_url('dep'));
    }
}
