<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Helpers\QueryReport;

class ReportParameter extends BaseController
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

        $parameter = $this->request->getVar('parameter');

        $data = [
            'title' => 'Data Report Parameter',
            'parameter' => $this->qReport->getParameterUji()->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_parameter' => $parameter,
        ];
        return view('report/viewReportParameter', $data);
    }

    public function loadDataReportParameter()
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

        $parameter = $this->request->getVar('parameter');
        $data = [
            'parameter' => $this->qReport->getReportParameter($tglawal, $tglakhir, $parameter)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_parameter' => $parameter,
        ];

        return view('report/dataReportParameter', $data);
    }

    public function exportExcelReportParameter()
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

        $parameter = $this->request->getVar('parameter');
        $data_parameter = $this->qReport->getParameterUji($parameter)->getRowArray();
        $filter_parameter = $data_parameter['nama'];

        $data = [
            'parameter' => $this->qReport->getReportParameter($tglawal, $tglakhir, $parameter)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
            'filter_parameter' => $filter_parameter,
        ];

        return view('report/excelReportParameter', $data);
    }
}
