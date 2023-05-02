<?php

namespace App\Controllers\Master;

use App\Controllers\BaseController;
use App\Helpers\Master\QueryPenyesuaian;
use App\Helpers\QueryPurchasing;
use stdClass;

class Penyesuaian extends BaseController
{
    protected $qPenyesuaian;
    protected $qPurchasing;
    protected $db;

    public function __construct()
    {
        $this->qPenyesuaian = new QueryPenyesuaian();
        $this->qPurchasing = new QueryPurchasing();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Penyesuaian',
        ];
        return view('penyesuaian_bahan/viewPenyesuaian', $data);
    }

    public function loadPenyesuaian()
    {
        $data = $this->qPenyesuaian->getPenyesuaianBahan()->getResultArray();
        $tglakhir = date('Y-m-d H:i:s');
        foreach ($data as $value) {
            $data_history_stok = $this->qPenyesuaian->checkHistoryStok($value['id'])->getRowArray();
            if (!empty($data_history_stok)) {
                $tglawal = $data_history_stok['tgl_penyesuaian'];
                $sum_stok = $this->qPenyesuaian->getSumStok($tglawal, $tglakhir, $value['id'])->getRowArray();
                $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
                $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
                $stok_update = $data_history_stok['stok_baru'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
            } else {
                $data_stok_awal = $this->qPenyesuaian->getStokAwal($value['id'])->getRowArray();
                $tglawal = $data_stok_awal['tgl_stok_awal'];
                $sum_stok = $this->qPenyesuaian->getSumStok($tglawal, $tglakhir, $value['id'])->getRowArray();
                $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
                $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
                $stok_update = $data_stok_awal['stok_awal'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
            }

            $arr[] = [
                'id' => $value['id'],
                'kode' => $value['kode'],
                'nama' => $value['nama'],
                'alias' => $value['alias'],
                'stok_lama' => $value['stok_lama'],
                'stok_baru' => $value['stok_baru'],
                'selisih' => $value['selisih'],
                'tgl_penyesuaian' => $value['tgl_penyesuaian'],
                'stok_update' => $stok_update,
                'sum_stok_masuk' => $sum_stok['total_masuk'],
                'sum_stok_keluar' => $sum_stok['total_keluar'],
            ];
        }
        
        $data = [
            'result' => $arr,
        ];
        return view('penyesuaian_bahan/dataPenyesuaian', $data);
    }

    public function loadBahan()
    {
        $data = $this->qPurchasing->getBahan()->getResultArray();

        return json_encode($data);
    }

    public function createPenyesuaian()
    {
        $data = [
            'title' => 'Penyesuaian Stok Bahan',
            'bahan' => $this->qPurchasing->getBahan()->getResultArray()
        ];

        return view('penyesuaian_bahan/createPenyesuaian', $data);
    }

    public function loadDetailBahan($id_bahan)
    {
        $data_history_stok = $this->qPenyesuaian->checkHistoryStok($id_bahan)->getRowArray();
        if (!empty($data_history_stok)) {
            $tglawal = $data_history_stok['tgl_penyesuaian'];
            $tglakhir = date('Y-m-d H:i:s');
            $sum_stok = $this->qPenyesuaian->getSumStok($tglawal, $tglakhir, $id_bahan)->getRowArray();
            $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
            $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
            $stok_lama = $data_history_stok['stok_baru'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
        } else {
            $data_stok_awal = $this->qPenyesuaian->getStokAwal($id_bahan)->getRowArray();
            $tglawal = $data_stok_awal['tgl_stok_awal'];
            $tglakhir = date('Y-m-d H:i:s');
            $sum_stok = $this->qPenyesuaian->getSumStok($tglawal, $tglakhir, $id_bahan)->getRowArray();
            $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
            $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
            $stok_lama = $data_stok_awal['stok_awal'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
        }
        return json_encode($stok_lama);
    }

    public function savePenyesuaian()
    {
        $tgl = $this->request->getVar('tanggal');
        $tanggal = date('Y-m-d', strtotime($tgl));
        $waktu = date('H:i:s');
        $tanggal = $tanggal.' '.$waktu;
        $data_stok_baru = $this->request->getVar('stok_baru');

        $this->db->transBegin();

        foreach ($data_stok_baru as $key => $value) {
            $data = new stdClass();
            $data->bahan = $this->request->getVar('bahan')[$key];
            $data->stok_lama = $this->request->getVar('stok_lama')[$key];
            $data->stok_baru = $this->request->getVar('stok_baru')[$key];
            $data->selisih = $data->stok_lama - $data->stok_baru;

            $this->qPenyesuaian->savePenyesuaian($tanggal, $data);
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $response =  'Data Gagal Disimpan';
            session()->setFlashdata('err', $response);
        } else {
            $this->db->transCommit();
            $response = 'Data Berhasil Disimpan';
            session()->setFlashdata('msg', $response);
        }
        return redirect()->to('/master/penyesuaian');
    }
}
