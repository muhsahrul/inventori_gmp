<?php

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController;
use App\Helpers\QueryPurchasing;

class Pembelanjaan extends BaseController
{
    protected $qPurchasing;

    public function __construct()
    {
        $this->qPurchasing = new QueryPurchasing;
    }

    public function index()
    {
        $tglawal = date('Y-m-d');
        $tglakhir = date('Y-m-d');

        $data = [
            'title' => 'List Pembelanjaan Purchasing',
            'subtitle' => 'Data Pembelanjaan',
            'menu' => 'Purchasing',
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('pembelanjaan/viewPembelanjaan', $data);
    }

    public function loadDataPembelanjaan()
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
            'query' => new QueryPurchasing,
            'result' => $this->qPurchasing->getPo($tglawal, $tglakhir)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];

        return view('pembelanjaan/dataPembelanjaan', $data);
    }
}
