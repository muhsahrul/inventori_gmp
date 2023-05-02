<?php

namespace App\Controllers\Ga;

use App\Controllers\BaseController;
use App\Helpers\QueryGa;

class Invoice extends BaseController
{
    protected $query;
    protected $db;

    public function __construct()
    {
        $this->query = new QueryGa;
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Invoice',
        ];
        return view('invoice/viewInvoice', $data);
    }

    public function loadDataInvoice()
    {
        $data = [
            'result' => $this->query->getFilterInvoice()->getResultArray(),
        ];
        return view('invoice/dataInvoice', $data);
    }

    public function createPembayaran()
    {
        $data = [
            'invoice' => $this->query->getInvoice()->getResultArray(),
        ];
        return view('invoice/createPembayaran', $data);
    }

    public function loadDataInvoiceCreatePembayaran()
    {
        $invoice = $this->request->getVar('invoice');
        $data = [
            'nomor_invoice' => $invoice,
            'invoice' => $this->query->getBarangMasukByInvoice($invoice)->getRowArray(),
        ];
        echo json_encode($data);
    }

    public function loadDataDetailInvoice()
    {
        $invoice = $this->request->getVar('invoice');
        $data = [
            'data_po' => $this->query->getBarangMasukByInvoice($invoice)->getResultArray(),
        ];

        return view('invoice/dataDetailCreatePembayaran', $data);
    }

    public function savePembayaran()
    {
        $select_invoice = $this->request->getVar('select_invoice');
        $tgl_bayar = $this->request->getVar('tgl_bayar');
        $tgl_bayar = date('Y-m-d', strtotime($tgl_bayar));
        $jumlah_bayar = $this->request->getVar('jumlah_bayar');
        $id_inv = $this->request->getVar('id_inv');
        $id_purchasing = $this->request->getVar('id_purchasing');
        $total_po = $this->request->getVar('total_po');

        $this->db->transBegin();
        $tagihan = 0;
        $implode_po = "";
        foreach ($id_inv as $key => $value) {
            $data_barangmasuk = $this->query->getBarangMasukById($value)->getRowArray();
            $tagihan += $data_barangmasuk['grand_total'];
            $implode_po .= "'" . $id_purchasing[$key] . "',";

            $this->query->savePembayaran($value, $tgl_bayar, $total_po[$key]);
        }
        $implode_po = rtrim($implode_po, ',');

        if ($jumlah_bayar == $tagihan) {
            $status = 2;
            $this->query->updateStatusPembayaran($select_invoice, $status);
            $this->query->updateStatusPembayaranPurchasing($implode_po, $status);
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

    public function detailInvoice($id)
    {
        $data_barangmasuk = $this->query->getBarangMasukById($id)->getRowArray();
        $data = [
            'row' => $this->query->getBarangMasukByInvoice($data_barangmasuk['nomor_invoice'])->getRowArray(),
            'result' => $this->query->getBarangMasukByInvoice($data_barangmasuk['nomor_invoice'])->getResultArray(),
        ];
        return view('invoice/detailInvoice', $data);
    }

    // public function editPembayaran($id)
    // {
    //     $data_pembayaran = $this->query->getPembayaranById($id)->getRowArray();
    //     $data_barangmasuk = $this->query->getBarangMasukByInvoice($data_pembayaran['t_inventori_bahan_lab_keluar_masuk'])->getRowArray();

    //     $data = [
    //         'data' => $this->query->getPembayaranById($id)->getRowArray(),
    //         'data_bahan' => $this->query->getBahanDetailPurchasing($data_barangmasuk['t_po_purchasing'])->getResultArray(),
    //     ];
    //     return view('invoice/editInvoice', $data);
    // }

    // public function updatePembayaran($id)
    // {
    //     $tanggal = $this->request->getVar('tanggal_bayar');
    //     $data = $this->query->updatePembayaran($id, $tanggal);
    //     if ($data) {
    //         echo "Data Berhasil Disimpan";
    //     } else {
    //         echo "Data Gagal Disimpan";
    //     }
    // }

    // public function deletePembayaran($id)
    // {
    //     $data_bayar = $this->query->getPembayaranById($id)->getRowArray();
    //     $data_barangmasuk = $this->query->getPembayaranByBarangMasuk($data_bayar['t_inventori_bahan_lab_keluar_masuk'])->getResultArray();
    //     $data_status = $this->query->getBarangMasukByInvoice($id)->getRowArray();
    //     if (count($data_barangmasuk) > 1) {
    //         echo "Data gagal dihapus karena ada riwayat transaksi pembayaran";
    //     } elseif (count($data_barangmasuk) == 1) {
    //         $this->query->deletePembayaran($id);
    //         $status = 1;
    //         $this->query->updateStatusPembayaran($data_status['id'], $status);

    //         echo "Data Berhasil Dihapus";
    //     }
    // }
}
