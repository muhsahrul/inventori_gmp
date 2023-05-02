<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Helpers\QueryReport;

class ReportBahan extends BaseController
{
    protected $qReport;

    public function __construct()
    {
        $this->qReport = new QueryReport();
    }

    public function index()
    {
        $tglawal = date('Y-m-d');
        $tglakhir = date('Y-m-d');
        $bahan = $this->request->getVar('bahan');

        $data = [
            'title' => 'Data Report Bahan',
            'bahan' => $this->qReport->getBahan()->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_bahan' => $bahan,
        ];
        return view('report/viewReportBahan', $data);
    }

    public function loadDataReportBahan()
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

        $bahan = $this->request->getVar('bahan');

        $data = [
            'data_bahan' => $this->qReport->getReportBahan($tglawal, $tglakhir, $bahan)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_bahan' => $bahan,
        ];

        return view('report/dataReportBahan', $data);
    }

    public function exportExcelReportBahan()
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

        $bahan = $this->request->getVar('bahan');
        $detail_bahan = $this->qReport->getBahanSatuan($bahan)->getRowArray();
        $filter_bahan = $detail_bahan['nama'];

        $data = [
            'data_bahan' => $this->qReport->getReportBahan($tglawal, $tglakhir, $bahan)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_bahan' => $filter_bahan,
        ];

        return view('report/excelReportBahan', $data);
    }
}
