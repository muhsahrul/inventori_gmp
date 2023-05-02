<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Helpers\Master\QueryPenyesuaian;
use App\Helpers\QueryReport;

class ReportStok extends BaseController
{
    protected $qReport;
    protected $qPenyesuaian;

    public function __construct()
    {
        $this->qReport = new QueryReport();
        $this->qPenyesuaian = new QueryPenyesuaian();
    }

    public function index()
    {
        $tglawal = date('Y-m-d');
        $tglakhir = date('Y-m-d');

        $data = [
            'title' => 'Data Report Stok Bahan',
            'filter_stokawal' => $this->qReport->getMinTglStokAwal()->getRowArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('report/viewReportStok', $data);
    }

    public function loadDataReportStok()
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

        $bahan = $this->qReport->getBahan()->getResultArray();
        foreach ($bahan as $key => $value) {
            $data_history_stok = $this->qReport->checkHistoryStok($value['id'], $tglawal)->getRowArray();
            if (!empty($data_history_stok)) {
                $tglawal_stok = date('Y-m-d',strtotime($data_history_stok['tgl_penyesuaian']));
                $sum_stok = $this->qReport->getLastStok($tglawal_stok, $tglawal, $value['id'])->getRowArray();
                // $stok_awal = $data_history_stok['stok_baru'];
                $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
                $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
                $stok_update = $data_history_stok['stok_baru'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
            } else {
                $data_stok_awal = $this->qReport->getStokAwal($value['id'])->getRowArray();
                $tglawal_stok = $data_stok_awal['tgl_stok_awal'];
                $sum_stok = $this->qReport->getSumStok($tglawal_stok, $tglawal, $value['id'])->getRowArray();
                // $stok_awal = $data_stok_awal['stok_awal'];
                $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
                $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
                $stok_update = $data_stok_awal['stok_awal'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
            }

            $data_transaksi = $this->qReport->getTotalMasukKeluar($value['id'], $tglawal, $tglakhir)->getRowArray();
            $arr[] = [
                'id' => $value['id'],
                'kode' => $value['kode'],
                'nama' => $value['nama'],
                'stok_awal' => $stok_update,
                'total_masuk' => $data_transaksi['total_masuk'],
                'total_keluar' => (float)$data_transaksi['total_keluar'],
                'stok_akhir' => $stok_update + $data_transaksi['total_masuk'] - $data_transaksi['total_keluar'],
            ];
        }

        $data = [
            'bahan' => $arr,
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('report/dataReportStok', $data);
    }

    public function exportExcelReportStok()
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

        $bahan = $this->qReport->getBahan()->getResultArray();
        foreach ($bahan as $key => $value) {
            $data_history_stok = $this->qReport->checkHistoryStok($value['id'], $tglawal)->getRowArray();
            if (!empty($data_history_stok)) {
                $tglawal_stok = $data_history_stok['tgl_penyesuaian'];
                $sum_stok = $this->qReport->getLastStok($tglawal_stok, $tglawal, $value['id'])->getRowArray();
                // $stok_awal = $data_history_stok['stok_baru'];
                $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
                $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
                $stok_update = $data_history_stok['stok_baru'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
            } else {
                $data_stok_awal = $this->qReport->getStokAwal($value['id'])->getRowArray();
                $tglawal_stok = $data_stok_awal['tgl_stok_awal'];
                $sum_stok = $this->qReport->getSumStok($tglawal_stok, $tglawal, $value['id'])->getRowArray();
                // $stok_awal = $data_stok_awal['stok_awal'];
                $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
                $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
                $stok_update = $data_stok_awal['stok_awal'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
            }

            $data_transaksi = $this->qReport->getTotalMasukKeluar($value['id'], $tglawal, $tglakhir)->getRowArray();
            $arr[] = [
                'id' => $value['id'],
                'kode' => $value['kode'],
                'nama' => $value['nama'],
                'stok_awal' => $stok_update,
                'total_masuk' => $data_transaksi['total_masuk'],
                'total_keluar' => (float)$data_transaksi['total_keluar'],
                'stok_akhir' => $stok_update + $data_transaksi['total_masuk'] - $data_transaksi['total_keluar'],
            ];
        }

        $data = [
            'bahan' => $arr,
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('report/excelReportStok', $data);
    }
}
