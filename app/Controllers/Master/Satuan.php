<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Helpers\QueryMaster;

class Satuan extends BaseController
{
    protected $query;

    public function __construct()
    {
        $this->query = new QueryMaster();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Satuan',
        ];
        return view('satuan/viewSatuan', $data);
    }

    public function loadDataSatuan()
    {
        $data = [
            'result' => $this->query->getSatuan()->getResultArray(),
        ];
        return view('satuan/dataSatuan', $data);
    }

    public function createSatuan()
    {
        return view('satuan/createSatuan');
    }

    public function saveSatuan()
    {
        $nama = $this->request->getVar('nama');

        $proses = $this->query->saveSatuan($nama);
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

    public function editSatuan($id)
    {
        $data = [
            'row' => $this->query->getSatuan($id)->getRowArray(),
        ];
        return view('satuan/editSatuan', $data);
    }

    public function updateSatuan($id)
    {
        $nama = $this->request->getVar('nama');
        $proses = $this->query->updateSatuan($id, $nama);
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

    public function deleteSatuan($id)
    {
        $proses = $this->query->deleteSatuan($id);
        if ($proses === false) {
            $response = [
                'status' => 500,
                'message' => 'Data Gagal Dihapus',
                'error' => true
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Data Berhasil Dihapus',
                'error' => false
            ];
        }
        return json_encode($response);
    }
}
