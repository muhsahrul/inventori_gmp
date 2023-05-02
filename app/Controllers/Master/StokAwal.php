<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Helpers\QueryTransaksi;

class StokAwal extends BaseController
{
    protected $query;

    public function __construct()
    {
        $this->query = new QueryTransaksi();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Stok Awal Bahan',
        ];
        return view('stok/viewStokAwal', $data);
    }

    public function loadDataStokAwal()
    {
        $data = [
            'result' => $this->query->getBahan()->getResultArray(),
        ];
        return view('stok/dataStokAwal', $data);
    }

    public function loadDataBahan()
    {
        $data = $this->query->getBahan()->getResultArray();

        echo json_encode($data);
    }

    public function editStokAwal($id)
    {
        $data = [
            'row' => $this->query->getBahan($id)->getRowArray(),
        ];
        return view('stok/editStokAwal', $data);
    }

    public function updateStokAwal($id)
    {
        $tanggal = $this->request->getVar('tanggal');
        $tanggal = date('Y-m-d', strtotime($tanggal));
        $jumlah = $this->request->getVar('jumlah');
        if (strpos($jumlah, ',') == TRUE) {
            $conv_jumlah = str_replace(',', '.', $jumlah);
        } else {
            $conv_jumlah = $jumlah;
        }

        $proses = $this->query->updateStokAwal($id, $tanggal, $conv_jumlah);
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
