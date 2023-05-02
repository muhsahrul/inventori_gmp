<?php

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController;
use App\Helpers\QueryGa;

class ValidasiPr extends BaseController
{
    protected $query;
    protected $db;

    public function __construct()
    {
        $this->query = new QueryGa;
        $this->db = \Config\Database::connect();
        // PO: tambah barang, delete po
        // Barang Masuk: delete if nomor po > 1, hilangkan delete bahan
    }

    public function index()
    {
        $tglawal = date('Y-m-d');
        $tglakhir = date('Y-m-d');

        $data = [
            'title' => 'Data Purchase Requisition',
            'status_validasi' => $this->query->getStatusValidasiPr()->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('validasi_pr/viewValidasiPr', $data);
    }

    public function loadDataValidasiPr()
    {
        $tglawal = $this->request->getVar('tglawal');
        if (empty($tglawal)) {
            $tglawal = date('Y-m-d');
        }
        $tglawal = date('Y-m-d', strtotime($tglawal));

        $tglakhir = $this->request->getVar('tglakhir');
        if (empty($tglakhir)) {
            $tglakhir = date('Y-m-d');
        }
        $tglakhir = date('Y-m-d', strtotime($tglakhir));

        $status_validasi = $this->request->getVar('status_validasi');

        $data = [
            'result' => $this->query->getFilterPr($tglawal, $tglakhir, $status_validasi)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_validasi' => $status_validasi,
        ];
        return view('validasi_pr/dataValidasiPr', $data);
    }

    public function detailValidasiPr($id)
    {
        $data = [
            'row' => $this->query->getPoPurchasingById($id)->getRowArray(),
            'bahan' => $this->query->getBahanDetailPurchasing($id)->getResultArray(),
            'status_validasi' => $this->query->getStatusValidasiPr()->getResultArray(),
        ];
        return view('validasi_pr/detailValidasiPr', $data);
    }

    public function updateValidasiPr($id)
    {
        $status = $this->request->getVar('status');
        $nomor = $this->request->getVar('nomor');
        $explode = explode("/", $nomor);
        $replace = str_replace("PR", "PO", $explode[1]);
        $new_nomor = $explode[0] . "/" . $replace . "/" . $explode[2] . "/" . $explode[3] . "/" . $explode[4];
        $proses = $this->query->updateValidatePr($id, $new_nomor, $status);
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
