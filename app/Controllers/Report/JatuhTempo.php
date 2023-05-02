<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Helpers\QueryReport;

class JatuhTempo extends BaseController
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
            'title' => 'Data Jatuh Tempo',
            'status_pembayaran' => $this->qReport->getStatusPembayaran()->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('report/viewReportJatuhTempo', $data);
    }

    public function loadDataJatuhTempo()
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

        $status_pembayaran = $this->request->getVar('status_pembayaran');

        $data = [
            'jatuhtempo' => $this->qReport->getJatuhTempo($tglawal, $tglakhir, $status_pembayaran)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_status_pembayaran' => $status_pembayaran,
        ];
        return view('report/dataReportJatuhTempo', $data);
    }

    public function exportExcelReportJatuhTempo()
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

        $status_pembayaran = $this->request->getVar('status_pembayaran');

        $data = [
            'jatuhtempo' => $this->qReport->getJatuhTempo($tglawal, $tglakhir, $status_pembayaran)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_status_pembayaran' => $status_pembayaran,
        ];

        return view('report/excelReportJatuhTempo', $data);
    }
}
