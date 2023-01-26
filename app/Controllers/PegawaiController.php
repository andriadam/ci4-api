<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class PegawaiController extends ResourceController
{
    protected $modelName = 'App\Models\Pegawai';
    protected $format    = 'json';
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = [
            'message' => 'success',
            'data' => $this->model->orderBy('id', 'DESC')->findAll()
        ];
        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $data = [
            'message' => 'success',
            'data' => $this->model->find($id)
        ];

        if ($data['data'] == null) {
            return $this->failNotFound('Pegawai tidak ditemukan.');
        }

        return $this->respond($data, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $rules = $this->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'jabatan' => 'required',
            'bidang' => 'required',
            'gambar' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        // Proses upload gambar
        $fileGambar = $this->request->getFile('gambar');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('img/pegawai', $namaGambar);

        $this->model->insert([
            'nama'      => esc($this->request->getVar('nama')),
            'alamat'    => esc($this->request->getVar('alamat')),
            'email'     => esc($this->request->getVar('email')),
            'jabatan'   => esc($this->request->getVar('jabatan')),
            'bidang'    => esc($this->request->getVar('bidang')),
            'gambar'    => $namaGambar,
        ]);

        $response = [
            'message' => 'Data Pegawai berhasil ditambahkan.'
        ];

        return $this->respondCreated($response);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $rules = $this->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'jabatan' => 'required',
            'bidang' => 'required',
            'gambar' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ]);

        if (!$rules) {
            $response = [
                'message' => $this->validator->getErrors()
            ];

            return $this->failValidationErrors($response);
        }

        $fileGambar = $this->request->getFile('gambar');

        // Jika user tidak upload gambar/Ubah gambar
        if ($fileGambar->getError() == 4) {
            $namaGambar = $this->request->getVar('gambarLama');
        } else { // Jika user upload gambar
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('img/pegawai', $namaGambar);

            // hapus file yang lama
            unlink('img/pegawai/' . $this->request->getVar('gambarLama'));
        }

        $this->model->update($id, [
            'nama'      => esc($this->request->getVar('nama')),
            'alamat'    => esc($this->request->getVar('alamat')),
            'email'     => esc($this->request->getVar('email')),
            'jabatan'   => esc($this->request->getVar('jabatan')),
            'bidang'    => esc($this->request->getVar('bidang')),
            'gambar'    => $namaGambar
        ]);

        // if ($pegawai) {
        $response = [
            'message' => 'Data Pegawai berhasil diubah.'
        ];
        // } else {
        //     $response = [
        //         'message' => 'Data Pegawai gagal diubah.'
        //     ];
        // }

        return $this->respondUpdated($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->model->delete($id);

        $response = [
            'message' => 'Data Pegawai berhasil dihapus.'
        ];

        return $this->respondDeleted($response);
    }
}
