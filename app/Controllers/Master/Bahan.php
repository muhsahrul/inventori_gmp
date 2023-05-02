<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Helpers\QueryMaster;
use stdClass;

class Bahan extends BaseController
{
    protected $query;

    public function __construct()
    {
        $this->query = new QueryMaster();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Bahan',
        ];
        return view('bahan/viewBahan', $data);
    }

    public function loadDataBahan()
    {
        $data = [
            'result' => $this->query->getBahan()->getResultArray(),
        ];
        return view('bahan/dataBahan', $data);
    }

    public function createBahan()
    {
        $data = [
            'satuan' => $this->query->getSatuan()->getResultArray(),
            'katalog' => $this->query->getKatalog()->getResultArray(),
        ];
        return view('bahan/createBahan', $data);
    }

    public function saveBahan()
    {
        $data = new stdClass();
        $data->kode = $this->request->getVar('kode');
        $data->nama = $this->request->getVar('nama');
        $data->alias = $this->request->getVar('alias');
        $data->satuan = $this->request->getVar('satuan');

        $proses = $this->query->saveBahan($data);
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

    public function editBahan($id)
    {
        $data = [
            'row' => $this->query->getBahan($id)->getRowArray(),
            'satuan' => $this->query->getSatuan()->getResultArray(),
        ];

        return view('bahan/editBahan', $data);
    }

    public function updateBahan($id)
    {
        $data = new stdClass();
        $data->kode = $this->request->getVar('kode');
        $data->nama = $this->request->getVar('nama');
        $data->alias = $this->request->getVar('alias');
        $data->satuan = $this->request->getVar('satuan');

        $proses = $this->query->updateBahan($id, $data);
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

    public function deleteBahan($id)
    {
        $proses = $this->query->deleteBahan($id);
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
