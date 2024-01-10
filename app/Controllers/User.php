<?php

namespace App\Controllers;
use App\Models\Model_user;
use App\Models\Model_dep;

class User extends BaseController
{
    public function __construct()
    {
        $this->Model_user = new Model_user();
        $this->Model_dep = new Model_dep();
        helper('form');
    }

    public function index()
    {
        $data = array(
            'Title' => 'User',
            'user' => $this->Model_user->alldata(),
            'isi' => 'user/v_index'
        );
        return view('layout/v_wrapper', $data);
    }

    public function add()
    {
        $data = array(
            'Title' => 'Add User',
            'dep' => $this->Model_dep->alldata(),
            'isi' => 'user/v_add'
        );
        return view('layout/v_wrapper', $data);
    }

    public function insert()
    {
        if ($this->validate([
            'nama_user' => [
                'label' => 'Nama User',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|is_unique[tbl_user.email]',
                    'errors' => [
                        'required' => '{field} Wajib Diisi !!!',
                        'is_unique' => '{field} sudah ada, input {field} lain !!!'
                    ]
                    ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                            'required' => '{field} Wajib Diisi !!!',
                        ]
                    ],
                    
                        'id_dep' => [
                            'label' => 'Departemen',
                            'rules' => 'required',
                            'errors' => [
                                    'required' => '{field} Wajib Diisi !!!',
                                ]
                            ],
                            'foto' => [
                                'label' => 'Foto',
                                'rules' => 'uploaded[foto]|max_size[foto, 1024]|mime_in[foto,image/png,image/jpg,image/jpeg,image/gif]',
                                'errors' => [
                                        'uploaded' => '{field} Wajib Diisi !!!',
                                        'max_size' => 'ukuran {field} Max 1024 KB !!!',
                                        'mime_in' => 'format {field} Wajib png,jpeg,jpg,gif !!!',
                                    ]
                                ],
        ])) {
            //foto
            $foto = $this->request->getFile('foto');
            // random foto
            $nama_file = $foto->getRandomName();
            // jika valid
            $data = array(
                'nama_user' => $this->request->getPost('nama_user'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'id_dep' => $this->request->getPost('id_dep'),
                'foto' => $nama_file,
            );
            $foto->move('foto',  $nama_file);
            $this->Model_user->tambah($data);
            session()->setFlashdata('pesan','Data Berhasil Ditambah !!!');
            return redirect()->to(base_url('user'));

        } else {
            // jika tidak valid
            session()->setFlashdata('errors',\Config\Services::validation()->getErrors());
            return redirect()->to(base_url('user/add'));
        }

    }

    public function edit($id_user)
    {
        $data = array(
            'Title' => 'Edit User',
            'dep' => $this->Model_dep->alldata(),
            'user' => $this->Model_user->detaildata($id_user),
            'isi' => 'user/v_edit'
        );
        return view('layout/v_wrapper', $data);
    }
    
    public function update($id_user)
    {
        if ($this->validate([
            'nama_user' => [
                'label' => 'Nama User',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'errors' => [
                    'required' => '{field} Wajib Diisi !!!'
                    ]
                    ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                            'required' => '{field} Wajib Diisi !!!',
                        ]
                    ],
                    
                        'id_dep' => [
                            'label' => 'Departemen',
                            'rules' => 'required',
                            'errors' => [
                                    'required' => '{field} Wajib Diisi !!!',
                                ]
                            ],
                        'foto' => [
                            'label' => 'Foto',
                            'rules' => 'max_size[foto, 1024]|mime_in[foto,image/png,image/jpg,image/jpeg,image/gif]',
                            'errors' => [
                                'max_size' => 'ukuran {field} Max 1024 KB !!!',
                                'mime_in' => 'format {field} Wajib png,jpeg,jpg,gif !!!',
                            ]
                        ],
        ])) {
            $foto = $this->request->getFile('foto');
            if ($foto->getError() == 4 ) {
                $data = array(
                    'id_user' => $id_user,
                    'nama_user' => $this->request->getPost('nama_user'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'id_dep' => $this->request->getPost('id_dep'),
                    //'foto' => $nama_file,
                );
                //$foto->move('foto',  $nama_file);
                $this->Model_user->edit($data);
            } else {
                //menghapus foto lama
                $user = $this->Model_user->detaildata($id_user);
                if ($user['foto'] != "") {
                    unlink('foto/'.$user['foto']);
                }
                $nama_file = $foto->getRandomName();
                $data = array(
                    'id_user' => $id_user,
                    'nama_user' => $this->request->getPost('nama_user'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password'),
                    'id_dep' => $this->request->getPost('id_dep'),
                    'foto' => $nama_file,
                );
                $foto->move('foto',  $nama_file);
                $this->Model_user->edit($data);

            }
            
            session()->setFlashdata('pesan','Data Berhasil DiUpdate !!!');
            return redirect()->to(base_url('user'));

        } else {
            // jika tidak valid
            session()->setFlashdata('errors',\Config\Services::validation()->getErrors());
            return redirect()->to(base_url('user/edit/'. $id_user));
        }
    }
    public function delete($id_user)
    {
        $user = $this->Model_user->detaildata($id_user);
        if ($user['foto'] != "") {
            unlink('foto/'.$user['foto']);
        }
        $data = array(
            'id_user' => $id_user,
        );
        $this->Model_user->delete_data($data);
        session()->setFlashdata('pesan','Data Berhasil Dihapus !!!');
        return redirect()->to(base_url('user'));
    }

    }

