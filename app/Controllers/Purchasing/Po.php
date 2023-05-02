<?php

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController;
use App\Helpers\QueryPurchasing;
use Spipu\Html2Pdf\Html2Pdf;
use stdClass;

class Po extends BaseController
{
    protected $query;
    protected $db;

    public function __construct()
    {
        $this->query = new QueryPurchasing;
        $this->db = \Config\Database::connect();
        // PO: tambah barang, delete po
        // Barang Masuk: delete if nomor po > 1, hilangkan delete bahan
    }

    public function index()
    {
        $tglawal = date('Y-m-d');
        $tglakhir = date('Y-m-d');

        $data = [
            'title' => 'Data PO',
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('po/viewPo', $data);
    }

    public function loadDataPo()
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
            'result' => $this->query->getPo($tglawal, $tglakhir)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('po/dataPo', $data);
    }

    // public function createPo()
    // {
    //     $data = [
    //         'nomor' => $this->query->getNomorPo()->getRowArray(),
    //         'bulan' => $this->query->getKodeBulan()->getRowArray(),
    //         'bahan' => $this->query->getBahan()->getResultArray(),
    //         'vendor' => $this->query->getVendor()->getResultArray(),
    //     ];
    //     return view('po/createPo', $data);
    // }

    public function loadDataBahan()
    {
        $data = $this->query->getBahan()->getResultArray();

        echo json_encode($data);
    }

    public function loadDetailBahan($id_bahan = false)
    {
        if ($id_bahan) {
            $data = $this->query->getKatalog($id_bahan)->getResultArray();
            echo json_encode($data);
        }
    }

    // public function savePo()
    // {
    //     $data = new stdClass();
    //     $data->nomor = $this->request->getVar('nomor');
    //     $data_nomor = $this->query->getDuplicateNomor($data->nomor)->getRowArray();
    //     if ($data_nomor) {
    //         $response = [
    //             'status' => 500,
    //             'message' => 'Nomor PO Sudah Ada',
    //             'error' => true
    //         ];
    //         die(json_encode($response));
    //     }
    //     $row_bahan = $this->request->getVar('jumlah');

    //     $data->vendor = $this->request->getVar('vendor');
    //     $tanggal = $this->request->getVar('tanggal');
    //     $data->tanggal = date('Y-m-d', strtotime($tanggal));
    //     $data->nomor_urut = $this->request->getVar('nomor_urut');
    //     $data->total = $this->request->getVar('total');
    //     $data->ppn = $this->request->getVar('ppn');
    //     $data->grand_total = $this->request->getVar('grand_total');
    //     $data->nomor_bulan = date('m');
    //     $data->nomor_tahun = date('Y');
    //     $time = date('H:i:s');
    //     $data->datetime = $data->tanggal . " " . $time;

    //     $this->db->transBegin();

    //     $this->query->savePo($data);

    //     $id_po = $this->db->insertID();

    //     foreach (array_filter($row_bahan) as $key => $value) {
    //         $data->bahan = $this->request->getVar('bahan')[$key];
    //         $data->no_katalog = $this->request->getVar('no_katalog')[$key];
    //         $data->jumlah = $this->request->getVar('jumlah')[$key];
    //         $data->harga = $this->request->getVar('harga')[$key];
    //         $data->subtotal = $this->request->getVar('subtotal')[$key];

    //         $this->query->saveDetailPo($id_po, $data);
    //     }
    //     $this->query->saveTotalPo($id_po, $data);

    //     if ($this->db->transStatus() === false) {
    //         $this->db->transRollback();
    //         $response = [
    //             'status' => 500,
    //             'message' => 'Data Gagal Disimpan',
    //             'error' => true
    //         ];
    //     } else {
    //         $this->db->transCommit();
    //         $response = [
    //             'status' => 200,
    //             'message' => 'Data Berhasil Disimpan',
    //             'error' => false
    //         ];
    //     }
    //     return json_encode($response);
    // }

    public function detailPo($id)
    {
        $data = [
            'title' => 'Detail PO',
            'row' => $this->query->getDetailPr($id)->getRowArray(),
        ];

        return view('po/detailPo', $data);
    }

    public function loadDataDetailPo($id_po)
    {
        $data = [
            'id_po' => $id_po,
            'row' => $this->query->getDetailPr($id_po)->getRowArray(),
            'result' => $this->query->getBahanDetailPr($id_po)->getResultArray(),
        ];
        return view('po/dataDetailPo', $data);
    }

    // public function createBahanPo()
    // {
    //     $id_po = $this->request->getVar('id_po');
    //     $data = [
    //         'po' => $this->query->getDetailPo($id_po)->getRowArray(),
    //         'bahan' => $this->query->getBahan()->getResultArray(),
    //     ];

    //     return view('po/createBahanPo', $data);
    // }

    // public function saveBahanPo()
    // {
    //     $data = new stdClass();
    //     $row_bahan = $this->request->getVar('jumlah');
    //     $tanggal = date('Y-m-d');
    //     $time = date('H:i:s');
    //     $data->datetime = $tanggal . " " . $time;

    //     $id_po = $this->request->getVar('id_po');

    //     $this->db->transBegin();

    //     foreach (array_filter($row_bahan) as $key => $value) {
    //         $data->bahan = $this->request->getVar('bahan')[$key];
    //         $data->no_katalog = $this->request->getVar('no_katalog')[$key];
    //         $data->jumlah = $this->request->getVar('jumlah')[$key];
    //         $data->harga = $this->request->getVar('harga')[$key];
    //         $data->subtotal = $this->request->getVar('subtotal')[$key];

    //         $data_po = $this->query->getTotalHargaBahan($id_po)->getRowArray();
    //         $data->total = $data_po['sum_total_harga'] + $data->subtotal;
    //         $data->ppn = $data->total * 0.11;
    //         $data->grand_total = $data->total + $data->ppn;
    //         $this->query->updateTotalHargaPo($id_po, $data->total, $data->ppn, $data->grand_total);

    //         $this->query->saveDetailPo($id_po, $data);
    //     }

    //     if ($this->db->transStatus() === false) {
    //         $this->db->transRollback();
    //         $response = [
    //             'status' => 500,
    //             'message' => 'Data Gagal Disimpan',
    //             'error' => true
    //         ];
    //     } else {
    //         $this->db->transCommit();
    //         $response = [
    //             'status' => 200,
    //             'message' => 'Data Berhasil Disimpan',
    //             'error' => false
    //         ];
    //     }
    //     return json_encode($response);
    // }

    // public function editPo($id)
    // {
    //     $data = [
    //         'po' => $this->query->getPoById($id)->getRowArray(),
    //         'vendor' => $this->query->getVendor()->getResultArray(),
    //     ];
    //     return view('po/editPo', $data);
    // }

    // public function updatePo($id)
    // {
    //     $tanggal = $this->request->getVar('tanggal');
    //     $ftanggal = date('Y-m-d', strtotime($tanggal));
    //     $vendor = $this->request->getVar('vendor');

    //     $time = date('H:i:s');
    //     $datetime = $ftanggal . " " . $time;

    //     $this->db->transBegin();

    //     $this->query->updatePo($id, $ftanggal, $vendor);

    //     $data_po = $this->query->getBahanDetailPo($id)->getResultArray();
    //     foreach ($data_po as $key => $value) {
    //         $this->query->updateDetailPo($value['id'], $datetime);
    //     }

    //     if ($this->db->transStatus() === false) {
    //         $this->db->transRollback();
    //         $response = [
    //             'status' => 500,
    //             'message' => 'Data Gagal Disimpan',
    //             'error' => true
    //         ];
    //     } else {
    //         $this->db->transCommit();
    //         $response = [
    //             'status' => 200,
    //             'message' => 'Data Berhasil Disimpan',
    //             'error' => false
    //         ];
    //     }
    //     return json_encode($response);
    // }

    // public function deletePo($id)
    // {
    //     $data_detail = $this->query->getBahanDetailPo($id)->getResultArray();

    //     $this->db->transBegin();

    //     $this->query->deletePo($id);
    //     foreach ($data_detail as $key => $value) {
    //         $this->query->deleteBahanPo($value['id']);
    //     }

    //     if ($this->db->transStatus() === false) {
    //         $this->db->transRollback();
    //         $response = [
    //             'status' => 500,
    //             'message' => 'Data Gagal Dihapus',
    //             'error' => true
    //         ];
    //     } else {
    //         $this->db->transCommit();
    //         $response = [
    //             'status' => 200,
    //             'message' => 'Data Berhasil Dihapus',
    //             'error' => false
    //         ];
    //     }
    //     return json_encode($response);
    // }

    // public function deleteBahanPo($id)
    // {
    //     $this->db->transBegin();

    //     $this->query->deleteBahanPo($id);

    //     $id_po = $this->request->getVar('id_po');
    //     $data_po = $this->query->getTotalHargaBahan($id_po)->getRowArray();
    //     $total = $data_po['sum_total_harga'];
    //     $ppn = $total * 0.11;
    //     $grand_total = $total + $ppn;
    //     $this->query->updateTotalHargaPo($id_po, $total, $ppn, $grand_total);

    //     if ($this->db->transStatus() === false) {
    //         $this->db->transRollback();
    //         $response = [
    //             'status' => 500,
    //             'message' => 'Data Gagal Disimpan',
    //             'error' => true
    //         ];
    //     } else {
    //         $this->db->transCommit();
    //         $response = [
    //             'status' => 200,
    //             'message' => 'Data Berhasil Disimpan',
    //             'error' => false
    //         ];
    //     }
    //     return json_encode($response);
    // }

    public function printPo($id)
    {
        ob_start();
        $data = [
            'title' => 'Detail PO',
            'row' => $this->query->getDetailReportPr($id)->getRowArray(),
        ];
        $data_po = $this->query->getDetailReportPr($id)->getRowArray();
        echo view('po/printPo', $data);
        $html = ob_get_contents();
        ob_end_clean();
        $nama_file = "PO_" . str_replace("/", ".", $data_po['nomor']) . ".pdf";

        $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(18, 8, 18, 18));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($html);
        $html2pdf->output($nama_file);
        exit();
    }

    public function exportExcelPo()
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
            'title' => 'Data PO',
            'result' => $this->query->getPo($tglawal, $tglakhir)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];

        return view('po/excelPo', $data);
    }
}
