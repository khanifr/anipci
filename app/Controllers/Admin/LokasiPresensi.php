<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LokasiPresensiModel;

class LokasiPresensi extends BaseController
{
    public function index()
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title' => 'Data Lokasi Presensi',
            'lokasi_presensi' => $LokasiPresensiModel->findAll()
        ];
        return view('admin/lokasi_presensi/lokasi-presensi', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Jabatan',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/jabatan/create', $data);
    }

    public function store()
    {
        $rules = [
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Nama jabatannya wajib disi sayangkuu cintaa"
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Tambah Jabatan',
                'validation' => \Config\Services::validation()
            ];
            echo view('admin/jabatan/create', $data);
        } else {
            $LokasiPresensiModel = new LokasiPresensiModel();
            $LokasiPresensiModel->insert([
                'jabatan' => $this->request->getPost('jabatan')
            ]);

            session()->setTempdata('berhasil', 'Data jabatan berhasil disimpan');

            return redirect()->to(base_url('admin/jabatan'));
        }
    }

    public function edit($id)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $data = [
            'title' => 'Edit Jabatan',
            'jabatan' => $LokasiPresensiModel->find($id),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/jabatan/edit', $data);
    }



    public function update($id)
    {
        $LokasiPresensiModel = new LokasiPresensiModel();
        $rules = [
            'jabatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => "Nama jabatannya wajib disi sayangkuu cintaa"
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Edit Jabatan',
                'jabatan' => $LokasiPresensiModel->find($id),
                'validation' => \Config\Services::validation()
            ];
            echo view('admin/jabatan/edit', $data);
        } else {
            $LokasiPresensiModel = new LokasiPresensiModel();
            $LokasiPresensiModel->update($id, [
                'jabatan' => $this->request->getPost('jabatan')
            ]);

            session()->setTempdata('berhasil', 'Data jabatan berhasil diupdate');

            return redirect()->to(base_url('admin/jabatan'));
        }
    }

    function delete($id)
    {
        $LokasiPresensiModel = new  LokasiPresensiModel();

        $jabatan = $LokasiPresensiModel->find($id);
        if ($jabatan) {
            $LokasiPresensiModel->delete($id);
            session()->setTempdata('berhasil', 'Data jabatan berhasil dihapus');

            return redirect()->to(base_url('admin/jabatan'));
        }
    }
}
