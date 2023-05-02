<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Helpers\QueryMaster;

class Gramasi extends BaseController
{
    protected $query;

    public function __construct()
    {
        $this->query = new QueryMaster();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Gramasi',
        ];
        return view('gramasi/viewGramasi', $data);
    }

    public function loadDataGramasi()
    {
        $data = [
            'result' => $this->query->getGramasi()->getResultArray(),
        ];
        return view('gramasi/dataGramasi', $data);
    }

    public function createGramasi()
    {
        $data = [
            'bahan' => $this->query->getBahan()->getResultArray(),
            'vendor' => $this->query->getVendor()->getResultArray(),
        ];
        return view('gramasi/createGramasi', $data);
    }

    public function saveGramasi()
    {
        $gramasi = $this->request->getVar('gramasi');
        $bahan = $this->request->getVar('bahan');

        $proses = $this->query->saveGramasi($gramasi, $bahan);
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

    public function editGramasi($id)
    {
        $data = [
            'row' => $this->query->getGramasi($id)->getRowArray(),
            'bahan' => $this->query->getBahan()->getResultArray(),
        ];
        return view('gramasi/editGramasi', $data);
    }

    public function updateGramasi($id)
    {
        $gramasi = $this->request->getVar('gramasi');
        $bahan = $this->request->getVar('bahan');

        $proses = $this->query->updateGramasi($id, $gramasi, $bahan);
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

    public function deleteGramasi($id)
    {
        $proses = $this->query->deleteGramasi($id);
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
