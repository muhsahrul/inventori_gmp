<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Helpers\QueryReport;

class ReportBarangMasuk extends BaseController
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

        $data = [
            'title' => 'Data Report Bahan',
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('report/viewReportBarangMasuk', $data);
    }

    public function loadReportBarangMasuk()
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
            'result' => $this->qReport->getReportBarangMasuk($tglawal, $tglakhir)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];

        return view('report/dataReportBarangMasuk', $data);
    }

    public function exportExcelReportBarangMasuk()
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
            'result' => $this->qReport->getReportBarangMasuk($tglawal, $tglakhir)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];

        return view('report/excelReportBarangMasuk', $data);
    }
}
