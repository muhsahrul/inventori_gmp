<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Helpers\QueryMaster;

class Katalog extends BaseController
{
    protected $db;
    protected $query;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->query = new QueryMaster();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Katalog',
        ];
        return view('katalog/viewKatalog', $data);
    }

    public function loadDataKatalog()
    {
        $data = [
            'result' => $this->query->getKatalog()->getResultArray(),
        ];

        return view('katalog/dataKatalog', $data);
    }

    public function createKatalog()
    {
        $data = [
            'bahan' => $this->query->getBahan()->getResultArray(),
            'vendor' => $this->query->getVendor()->getResultArray(),
        ];
        return view('katalog/createKatalog', $data);
    }

    public function saveKatalog()
    {
        $katalog = $this->request->getVar('katalog');
        $bahan = $this->request->getVar('bahan');
        $vendor = $this->request->getVar('vendor');
        $gramasi = $this->request->getVar('gramasi');

        $proses = $this->query->saveKatalog($katalog, $bahan, $vendor, $gramasi);

        if ($proses === false) {
            $response = [
                'status' => 500,
                'message' => 'Data Gagal Disimpan',
                'error' => true
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Data Berhasil Disimpan',
                'error' => false
            ];
        }
        return json_encode($response);
    }

    public function editKatalog($id)
    {
        $data = [
            'row' => $this->query->getKatalog($id)->getRowArray(),
            'bahan' => $this->query->getBahan()->getResultArray(),
            'vendor' => $this->query->getVendor()->getResultArray(),
        ];
        return view('katalog/editKatalog', $data);
    }

    public function updateKatalog($id)
    {
        $katalog = $this->request->getVar('katalog');
        $bahan = $this->request->getVar('bahan');
        $vendor = $this->request->getVar('vendor');
        $gramasi = $this->request->getVar('gramasi');

        $proses = $this->query->updateKatalog($id, $katalog, $bahan, $vendor, $gramasi);

        if ($proses === false) {
            $response = [
                'status' => 500,
                'message' => 'Data Gagal Disimpan',
                'error' => true
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Data Berhasil Disimpan',
                'error' => false
            ];
        }
        return json_encode($response);
    }

    public function deleteKatalog($id)
    {
        $proses = $this->query->deleteKatalog($id);

        if ($proses === false) {
            $response = [
                'status' => 500,
                'message' => 'Data Gagal Disimpan',
                'error' => true
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Data Berhasil Disimpan',
                'error' => false
            ];
        }
        return json_encode($response);
    }
}
