<?php

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController;
use App\Helpers\QueryGa;

class ListPr extends BaseController
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
        return view('list_pr_purchasing/viewListPr', $data);
    }

    public function loadDataListPr()
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
        return view('list_pr_purchasing/dataListPr', $data);
    }

    public function detailListPr($id)
    {
        $data = [
            'row' => $this->query->getPoPurchasingById($id)->getRowArray(),
            'result' => $this->query->getBahanDetailPurchasing($id)->getResultArray(),
        ];
        return view('list_pr_purchasing/detailListPr', $data);
    }
}
