<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Helpers\Master\QueryPenyesuaian;
use App\Helpers\QueryTransaksi;
use stdClass;

class BarangKeluar extends BaseController
{
    protected $qTransaksi;
    protected $qPenyesuaian;
    protected $db;

    public function __construct()
    {
        $this->qTransaksi = new QueryTransaksi();
        $this->qPenyesuaian = new QueryPenyesuaian();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $tglawal = date('Y-m-d');
        $tglakhir = date('Y-m-d');

        $data = [
            'title' => 'Data Barang Keluar',
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('barang_keluar/viewBarangKeluar', $data);
    }

    public function loadDataBarangKeluar()
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
            'result' => $this->qTransaksi->getBarangKeluar($tglawal, $tglakhir)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('barang_keluar/dataBarangKeluar', $data);
    }

    public function createBarangKeluar()
    {
        $data = [
            'bahan' => $this->qTransaksi->getBahan()->getResultArray(),
            'parameter' => $this->qTransaksi->getParameterUji()->getResultArray(),
        ];
        return view('barang_keluar/createBarangKeluar', $data);
    }

    public function loadDataBahan()
    {
        $data = $this->qTransaksi->getBahan()->getResultArray();
        $data2 = $this->qTransaksi->getParameterUji()->getResultArray();
        $datalengkap = array(
            'data_bahan' => $data,
            'data_parameter' => $data2,
        );

        return json_encode($datalengkap);
    }

    public function loadDetailBahan()
    {
        $id_bahan = $this->request->getVar('id_bahan');
        if ($id_bahan) {
            $data = $this->qTransaksi->getBahanSatuan($id_bahan)->getRowArray();
            return json_encode($data);
        }
    }

    public function saveBarangKeluar()
    {
        $row_bahan = $this->request->getVar('jumlah');
        $tanggal = $this->request->getVar('tanggal');
        $time = date('H:i:s');

        $data = new stdClass();
        $data->datetime = date('Y-m-d', strtotime($tanggal)) . " " . $time;

        $this->db->transBegin();

        foreach (array_filter($row_bahan) as $key => $value) {
            $data->bahan = $this->request->getVar('bahan')[$key];
            $data->keterangan = $this->request->getVar('keterangan')[$key];
            $jumlah = $this->request->getVar('jumlah')[$key];
            if (strpos($jumlah, ',') == TRUE) {
                $data->jumlah = str_replace(',', '.', $jumlah);
            } else {
                $data->jumlah = $jumlah;
            }
            $data->parameter = $this->request->getVar('parameter')[$key];

            // $sum_stok = $this->qTransaksi->getStokAkhir($data->bahan)->getRowArray();
            // $data_stok = $this->qTransaksi->getStokAkhirFromMaster($data->bahan)->getRowArray();
            // if ($data_stok['stok_akhir'] > 0) {
            //     $total_stok = $data_stok['stok_akhir'];
            // } else {
            //     $total_stok = $data_stok['stok_awal'];
            // }

            $data_history_stok = $this->qPenyesuaian->checkHistoryStok($data->bahan)->getRowArray();
            if (!empty($data_history_stok)) {
                $tglawal = $data_history_stok['tgl_penyesuaian'];
                $tglakhir = date('Y-m-d');
                $sum_stok = $this->qPenyesuaian->getSumStok($tglawal, $tglakhir, $data->bahan)->getRowArray();
                $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
                $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
                $stok_terbaru = $data_history_stok['stok_baru'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
            } else {
                $data_stok_awal = $this->qPenyesuaian->getStokAwal($data->bahan)->getRowArray();
                $tglawal = $data_stok_awal['tgl_stok_awal'];
                $tglakhir = date('Y-m-d');
                $sum_stok = $this->qPenyesuaian->getSumStok($tglawal, $tglakhir, $data->bahan)->getRowArray();
                $sum_stok['total_masuk'] = empty($sum_stok['total_masuk']) ? 0 : $sum_stok['total_masuk'];
                $sum_stok['total_keluar'] = empty($sum_stok['total_keluar']) ? 0 : $sum_stok['total_keluar'];
                $stok_terbaru = $data_stok_awal['stok_awal'] + $sum_stok['total_masuk'] - $sum_stok['total_keluar'];
            }

            // $sisa_stok = ($sum_stok['total_masuk'] * $data_stok['gramasi']) - $sum_stok['total_keluar'];
            if ($stok_terbaru > $data->jumlah) {
                $this->qTransaksi->saveBarangKeluar($data);
            } else {
                $data_bahan = $this->qTransaksi->getBahan($data->bahan)->getRowArray();
                $response = [
                    'status' => 500,
                    'message' => 'Data Gagal Disimpan, Jumlah Barang Keluar "' . $data_bahan['nama'] . '" Melebihi Stok',
                    'error' => true
                ];
                die(json_encode($response));
            }
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $response = [
                'status' => 500,
                'message' => 'Data Gagal Disimpan',
                'error' => true
            ];
        } else {
            $this->db->transCommit();
            $response = [
                'status' => 200,
                'message' => 'Data Berhasil Disimpan',
                'error' => false
            ];
        }
        return json_encode($response);
    }

    public function deleteBarangKeluar($id)
    {
        $this->db->transBegin();

        $this->qTransaksi->deleteBarangKeluar($id);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $response = [
                'status' => 500,
                'message' => 'Data Gagal Dihapus',
                'error' => true
            ];
        } else {
            $this->db->transCommit();
            $response = [
                'status' => 200,
                'message' => 'Data Berhasil Dihapus',
                'error' => false
            ];
        }
        return json_encode($response);
    }
}
