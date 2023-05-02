<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Helpers\QueryReport;

class ChartBahan extends BaseController
{
    protected $qReport;

    public function __construct()
    {
        $this->qReport = new QueryReport();
    }

    public function index()
    {
        $tahun = date('Y-m-d');
        $bahan = $this->request->getVar('bahan');

        $data = [
            'title' => 'Data Report Bahan',
            'bahan' => $this->qReport->getBahan()->getResultArray(),
            'filter_tahun' => $tahun,
            'filter_bahan' => $bahan,
        ];
        return view('report/viewChartBahan', $data);
    }

    public function loadChartBahan()
    {
        $tahun = $this->request->getVar('tahun');
        if (empty($tahun)) {
            $tahun = date('Y-m-d');
        }
        $bahan = $this->request->getVar('bahan');

        $data = [
            'bahan' => $this->qReport->getChartBahan($tahun, $bahan)->getResultArray(),
            'filter_tahun' => $tahun,
            'filter_bahan' => $bahan,
        ];

        return view('report/dataChartBahan', $data);
    }

    public function loadDataChartBahan()
    {
        $tahun = $this->request->getVar('tahun');
        if (empty($tahun)) {
            $tahun = date('Y-m-d');
        }
        $bahan = $this->request->getVar('bahan');

        $data = $this->qReport->getChartBahan($tahun, $bahan)->getResultArray();

        return json_encode($data);
    }
}
