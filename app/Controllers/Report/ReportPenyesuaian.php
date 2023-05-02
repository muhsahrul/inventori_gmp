<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Helpers\QueryReport;

class ReportPenyesuaian extends BaseController
{
    protected $qReport;

    public function __construct()
    {
        $this->qReport = new QueryReport();
    }

    public function index()
    {
        $tglakhir = date('Y-m-d');

        $data = [
            'title' => 'Data Report Penyesuaian Stok',
            'bahan' => $this->qReport->getBahan()->getResultArray(),
            'filter_tglakhir' => $tglakhir,
        ];
        return view('report/viewReportPenyesuaian', $data);
    }

    public function loadReportPenyesuaian()
    {
        $tglawal = $this->request->getVar('tglawal');
        if ($tglawal) {
            $tglawal = date('Y-m-d', strtotime($tglawal));
        } else {
            $tglawal = '2017-01-01';
        }

        $tglakhir = $this->request->getVar('tglakhir');
        if ($tglakhir) {
            $tglakhir = date('Y-m-d', strtotime($tglakhir));
        } else {
            $tglakhir = date('Y-m-d');
        }

        $bahan = $this->request->getVar('bahan');

        $data = [
            'result' => $this->qReport->getReportPenyesuaian($tglawal, $tglakhir, $bahan)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_bahan' => $bahan,
        ];

        return view('report/dataReportPenyesuaian', $data);
    }

    public function exportExcelReportPenyesuaian()
    {
        $tglawal = $this->request->getVar('tglawal');
        if ($tglawal) {
            $tglawal = date('Y-m-d', strtotime($tglawal));
        } else {
            $tglawal = '2017-01-01';
        }

        $tglakhir = $this->request->getVar('tglakhir');
        if ($tglakhir) {
            $tglakhir = date('Y-m-d', strtotime($tglakhir));
        } else {
            $tglakhir = date('Y-m-d');
        }

        $bahan = $this->request->getVar('bahan');
        $detail_bahan = $this->qReport->getBahanSatuan($bahan)->getRowArray();
        $filter_bahan = $detail_bahan['nama'];

        $data = [
            'result' => $this->qReport->getReportPenyesuaian($tglawal, $tglakhir, $bahan)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_bahan' => $filter_bahan,
        ];

        return view('report/excelReportPenyesuaian', $data);
    }
}
