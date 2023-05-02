<?php

namespace App\Controllers\Ga;

use App\Controllers\BaseController;
use App\Helpers\QueryGa;

class Pembayaran extends BaseController
{
    protected $query;

    public function __construct()
    {
        $this->query = new QueryGa;
    }

    public function index()
    {
        $tglawal = date('Y-m-d');
        $tglakhir = date('Y-m-d');

        $data = [
            'title' => 'Data Pembayaran',
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('pembayaran/viewPembayaran', $data);
    }

    public function loadDataPembayaran()
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

        $data = [
            'result' => $this->query->getFilterPembayaran($tglawal, $tglakhir)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];

        return view('pembayaran/dataPembayaran', $data);
    }

    public function detailPembayaran($id)
    {
        $data_barangmasuk = $this->query->getBarangMasukById($id)->getRowArray();
        $data = [
            'row' => $this->query->getBarangMasukByInvoice($data_barangmasuk['nomor_invoice'])->getRowArray(),
            'result' => $this->query->getBarangMasukByInvoice($data_barangmasuk['nomor_invoice'])->getResultArray(),
        ];
        return view('pembayaran/detailPembayaran', $data);
    }
}
