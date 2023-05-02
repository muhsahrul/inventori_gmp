<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Helpers\QueryTransaksi;
use stdClass;

class BarangMasuk extends BaseController
{
    protected $query;
    protected $db;

    public function __construct()
    {
        $this->query = new QueryTransaksi();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $tglawal = date('Y-m-d');
        $tglakhir = date('Y-m-d');

        $data = [
            'title' => 'Data Barang Masuk',
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('barang_masuk/viewBarangMasuk', $data);
    }

    public function loadDataBarangMasuk()
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
            'result' => $this->query->getBarangMasuk($tglawal, $tglakhir)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('barang_masuk/dataBarangMasuk', $data);
    }

    public function createBarangMasuk()
    {
        $data = [
            'po' => $this->query->getFilterPo()->getResultArray(),
        ];

        return view('barang_masuk/createBarangMasuk', $data);
    }

    public function loadDataPo()
    {
        $id_po = $this->request->getVar('id_po');
        $data = [
            'id_po' => $id_po,
        ];
        return view('barang_masuk/dataDetailCreateBarangMasuk', $data);
    }

    // public function loadDataDetailPo()
    // {
    //     $barangmasuk = $this->request->getVar('barangmasuk');
    //     $id_po = $this->request->getVar('id_po');

    //     $data = [
    //         'id_po' => $id_po,
    //         'barangmasuk' => $barangmasuk,
    //         // 'data_po' => $this->query->getPo($id_po)->getRowArray(),
    //         // 'bahan' => $this->query->getDetailPo($id_po)->getResultArray(),
    //     ];
    //     return view('transaksi/dataDetailCreateBarangMasuk', $data);
    // }

    public function loadDataBahan()
    {
        $data = $this->query->getBahan()->getResultArray();

        echo json_encode($data);
    }

    public function loadDetailBahan()
    {
        $id_bahan = $this->request->getVar('id_bahan');
        if ($id_bahan) {
            $data = $this->query->getBahanSatuan($id_bahan)->getRowArray();
            echo json_encode($data);
        }
    }

    public function saveBarangMasuk()
    {
        $data = new stdClass();
        $tanggal_barang_masuk = $this->request->getVar('tgl_barang_masuk');
        $data->nomor_invoice = $this->request->getVar('nomor_invoice');
        if (empty($data->nomor_invoice) == TRUE) {
            $response = [
                'status' => 500,
                'message' => 'Nomor Invoice Kosong',
                'error' => true
            ];
            die(json_encode($response));
        }

        $id_po = $this->request->getVar('select_po');
        $tanggal_invoice = $this->request->getVar('tgl_invoice');
        $data->tanggal_invoice = ($tanggal_invoice) ? date('Y-m-d', strtotime($tanggal_invoice)) : false;
        $tanggal_jatuh_tempo = $this->request->getVar('tgl_jatuh_tempo');
        $data->tanggal_jatuh_tempo = ($tanggal_jatuh_tempo) ? date('Y-m-d', strtotime($tanggal_jatuh_tempo)) : false;

        $time = date('H:i:s');
        $data->datetime = date('Y-m-d', strtotime($tanggal_barang_masuk)) . " " . $time;

        $this->db->transBegin();

        foreach ($id_po as $key => $value) {
            $row_jumlah = $this->request->getVar('jumlah_' . $value);
            $row_jumlah_masuk = $this->request->getVar('jumlah_masuk_' . $value);
            $row_total_masuk = $this->request->getVar('total_masuk_' . $value);
            foreach (array_filter($row_jumlah_masuk) as $filterkey => $filtervalue) {
                if ($row_jumlah[$filterkey] < ($row_jumlah_masuk[$filterkey] + $row_total_masuk[$filterkey])) {
                    $response = [
                        'status' => 500,
                        'message' => 'Data jumlah masuk lebih besar dari jumlah pesanan',
                        'error' => true
                    ];
                    die(json_encode($response));
                }
            }

            $data->nomor_po = $this->request->getVar('nomor_po_' . $value);
            $tanggal_po = $this->request->getVar('tanggal_po_' . $value);
            $data->tanggal_po = date('Y-m-d', strtotime($tanggal_po));
            $data->vendor = $this->request->getVar('vendor_' . $value);
            $data->grand_total = $this->request->getVar('grand_total_' . $value);

            $this->query->saveBarangMasuk($value, $data);

            $id_barang_masuk = $this->db->insertID();

            // $total_barang = 0;
            foreach (array_filter($row_jumlah_masuk) as $subkey => $subvalue) {

                $data->bahan = $this->request->getVar('bahan_' . $value)[$subkey];
                $data->no_katalog = $this->request->getVar('no_katalog_' . $value)[$subkey];
                $data->gramasi = $this->request->getVar('gramasi_' . $value)[$subkey];
                $data->jumlah = $this->request->getVar('jumlah_' . $value)[$subkey];
                $data->harga = $this->request->getVar('harga_' . $value)[$subkey];
                $data->total_harga = $this->request->getVar('subtotal_' . $value)[$subkey];
                $data->total_masuk = $this->request->getVar('total_masuk_' . $value)[$subkey];
                $data->jumlah_masuk = $this->request->getVar('jumlah_masuk_' . $value)[$subkey];

                $this->query->saveDetailBarangMasuk($id_barang_masuk, $data);
            }

            // $this->query->updateTotalBarangMasuk($id_barang_masuk, $total_barang);
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

    public function detailBarangMasuk($id)
    {
        $data_po = $this->query->getDetailBarangMasuk($id)->getRowArray();
        $data = [
            'title' => 'Detail Barang Masuk',
            'row' => $this->query->getDetailBarangMasuk($id)->getRowArray(),
            'result' => $this->query->getPoByInvoice($data_po['nomor_invoice'])->getResultArray(),
        ];

        return view('barang_masuk/detailBarangMasuk', $data);
    }

    // public function createBahanBarangMasuk()
    // {
    //     $id = $this->request->getVar('id_barangmasuk');
    //     $data = [
    //         'barangmasuk' => $this->query->getDetailBarangMasuk($id)->getRowArray(),
    //         'bahan' => $this->query->getBahan()->getResultArray(),
    //     ];

    //     return view('barang_masuk/createBahanBarangMasuk', $data);
    // }

    // public function saveBahanBarangMasuk()
    // {
    //     $row_bahan = $this->request->getVar('jumlah');
    //     $tanggal = $this->request->getVar('tanggal');
    //     $time = date('H:i:s');
    //     $datetime = $tanggal . " " . $time;

    //     $id_barang_masuk = $this->request->getVar('id_barang_masuk');
    //     foreach (array_filter($row_bahan) as $key => $value) {
    //         $bahan = $this->request->getVar('bahan')[$key];
    //         $jumlah = $this->request->getVar('jumlah')[$key];
    //         $harga = $this->request->getVar('harga')[$key];

    //         $data = $this->query->saveDetailBarangMasuk($id_barang_masuk, $datetime, $bahan, $jumlah, $harga);
    //     }

    //     if ($data) {
    //         echo "Data Berhasil Disimpan";
    //     } else {
    //         echo "Data Gagal Disimpan";
    //     }
    // }

    public function editBarangMasuk($id)
    {
        $data = [
            'row' => $this->query->getBarangMasukKeluarById($id)->getRowArray(),
        ];
        return view('barang_masuk/editBarangMasuk', $data);
    }

    public function updateBarangMasuk($id)
    {
        $data_po = $this->query->getDetailBarangMasuk($id)->getRowArray();
        $data = new stdClass();
        $tanggal = $this->request->getVar('tanggal');
        $tanggal_invoice = $this->request->getVar('tgl_invoice');
        $data->tanggal_invoice = date('Y-m-d', strtotime($tanggal_invoice));
        $data->nomor_invoice = $this->request->getVar('nomor_invoice');
        $tanggal_jatuh_tempo = $this->request->getVar('tgl_jatuh_tempo');
        $data->tanggal_jatuh_tempo = date('Y-m-d', strtotime($tanggal_jatuh_tempo));

        $data_invoice = $this->query->getPoByInvoice($data_po['nomor_invoice'])->getResultArray();

        $this->db->transBegin();

        foreach ($data_invoice as $key => $value) {

            $time = date('H:i:s');
            $data->datetime = date('Y-m-d', strtotime($tanggal)) . " " . $time;

            $this->query->updateBarangMasuk($value['id'], $data);
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

    public function deleteBarangMasuk($id)
    {
        $get_po = $this->query->getDetailBarangMasuk($id)->getRowArray();

        // $check_invoice = $this->query->getPoByUniqueInvoice($get_po['nomor_invoice'])->getResultArray();
        $data_invoice = $this->query->getPoByInvoice($get_po['nomor_invoice'])->getResultArray();
        // if (count($check_invoice) > 1) {
        //     $response = [
        //         'status' => 200,
        //         'message' => 'Data Gagal Dihapus, ada riwayat transaksi Barang Masuk',
        //         'error' => false
        //     ];
        //     return json_encode($response);
        // } else {

        $this->db->transBegin();

        foreach ($data_invoice as $key => $value) {
            $this->query->deleteBarangMasuk($value['id']);
            $this->query->deleteBahanBarangMasukByIdMaster($value['id']);
        }

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
        // }
    }

    // public function deleteBahanBarangMasuk($id)
    // {

    //     $data = $this->query->deleteBahanBarangMasuk($id);

    //     if ($data) {
    //         echo "Data Berhasil Dihapus";
    //     } else {
    //         echo "Data Gagal Dihapus";
    //     }
    // }
}
