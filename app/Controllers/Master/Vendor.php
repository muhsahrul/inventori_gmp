<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Helpers\QueryMaster;
use stdClass;

class Vendor extends BaseController
{
    protected $query;

    public function __construct()
    {
        $this->query = new QueryMaster();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Vendor',
        ];
        return view('vendor/viewVendor', $data);
    }

    public function loadDataVendor()
    {
        $data = [
            'result' => $this->query->getVendor()->getResultArray(),
        ];
        return view('vendor/dataVendor', $data);
    }

    public function createVendor()
    {
        return view('vendor/createVendor');
    }

    public function saveVendor()
    {
        $data = new stdClass();
        $data->nama = $this->request->getVar('nama');
        $data->alamat = $this->request->getVar('alamat');
        $data->email = $this->request->getVar('email');
        $data->telp = $this->request->getVar('telp');
        $data->pic_nama = $this->request->getVar('pic_nama');
        $data->pic_telp = $this->request->getVar('pic_telp');

        $proses = $this->query->saveVendor($data);
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

    public function editVendor($id)
    {
        $data = [
            'row' => $this->query->getVendor($id)->getRowArray(),
        ];
        return view('vendor/editVendor', $data);
    }

    public function updateVendor($id)
    {
        $data = new stdClass();
        $data->nama = $this->request->getVar('nama');
        $data->alamat = $this->request->getVar('alamat');
        $data->email = $this->request->getVar('email');
        $data->telp = $this->request->getVar('telp');
        $data->pic_nama = $this->request->getVar('pic_nama');
        $data->pic_telp = $this->request->getVar('pic_telp');

        $proses = $this->query->updateVendor($id, $data);
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

    public function deleteVendor($id)
    {
        $proses = $this->query->deleteVendor($id);
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
