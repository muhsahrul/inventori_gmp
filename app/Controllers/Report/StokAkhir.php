<?php

namespace App\Controllers\Report;

use App\Controllers\BaseController;
use App\Helpers\QueryTransaksi;

class StokAkhir extends BaseController
{
    protected $qReport;

    public function __construct()
    {
        $this->qReport = new QueryTransaksi();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Stok Akhir Bahan',
        ];
        return view('stok/viewStokAkhir', $data);
    }

    public function loadDataStokAkhir()
    {
        $bahan = $this->qReport->getBahan()->getResultArray();
        foreach ($bahan as $key => $value) {
            $total_masuk_keluar = $this->qReport->getStokAkhir($value['id'])->getRowArray();

            $arr[] = [
                'kode' => $value['kode'],
                'no_katalog' => $value['no_katalog'],
                'nama' => $value['nama'],
                'nama_satuan' => $value['nama_satuan'],
                'stok_akhir' => $value['stok_awal'] + $total_masuk_keluar['total_masuk'] - $total_masuk_keluar['total_keluar']
            ];
        }
        $data = [
            'bahan' => $arr
        ];
        return view('stok/dataStokAkhir', $data);
    }
}
