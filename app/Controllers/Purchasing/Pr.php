<?php

namespace App\Controllers\Purchasing;

use App\Controllers\BaseController;
use App\Helpers\QueryPurchasing;
use Spipu\Html2Pdf\Html2Pdf;
use stdClass;

class Pr extends BaseController
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
            'title' => 'Data PR',
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('pr/viewPr', $data);
    }

    public function loadDataPr()
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
            'result' => $this->query->getPr($tglawal, $tglakhir)->getResultArray(),
            'filter_tglawal' => $tglawal,
            'filter_tglakhir' => $tglakhir,
        ];
        return view('pr/dataPr', $data);
    }

    public function createPr()
    {
        $data = [
            'nomor' => $this->query->getNomorPo()->getRowArray(),
            'bulan' => $this->query->getKodeBulan()->getRowArray(),
            'bahan' => $this->query->getBahan()->getResultArray(),
            'vendor' => $this->query->getVendor()->getResultArray(),
        ];
        return view('pr/createPr', $data);
    }

    public function loadDataBahan()
    {
        $data = $this->query->getBahan()->getResultArray();
        return json_encode($data);
    }

    public function loadKatalogBahan($id_bahan = false)
    {
        $data = $this->query->getKatalog($id_bahan)->getResultArray();
        return json_encode($data);
    }

    public function loadGramasiBahan($id_katalog = false)
    {
        $data = $this->query->getGramasi($id_katalog)->getResultArray();
        return json_encode($data);
    }

    public function savePr()
    {
        $data = new stdClass();
        $data->nomor = $this->request->getVar('nomor');
        $data_nomor = $this->query->getDuplicateNomor($data->nomor)->getRowArray();
        if ($data_nomor) {
            $response = [
                'status' => 500,
                'message' => 'Nomor PO Sudah Ada',
                'error' => true
            ];
            die(json_encode($response));
        }
        $row_bahan = $this->request->getVar('jumlah');

        $data->vendor = $this->request->getVar('vendor');
        $tanggal = $this->request->getVar('tanggal');
        $data->tanggal = date('Y-m-d', strtotime($tanggal));
        $data->nomor_urut = $this->request->getVar('nomor_urut');
        $data->total = $this->request->getVar('total');
        $data->diskon_persen = $this->request->getVar('diskon_persen');
        $data->diskon_rupiah = $this->request->getVar('diskon_rupiah');
        $data->ppn = $this->request->getVar('ppn');
        $data->grand_total = $this->request->getVar('grand_total');
        $data->note = $this->request->getVar('note');
        $data->nomor_bulan = date('m');
        $data->nomor_tahun = date('Y');
        $time = date('H:i:s');
        $data->datetime = $data->tanggal . " " . $time;

        $this->db->transBegin();

        $this->query->savePr($data);

        $id_po = $this->db->insertID();

        $this->query->saveTotalPr($id_po, $data);

        foreach (array_filter($row_bahan) as $key => $value) {
            $data->bahan = $this->request->getVar('bahan')[$key];
            $data->no_katalog = $this->request->getVar('no_katalog')[$key];
            $data->gramasi = $this->request->getVar('gramasi')[$key];
            $data->jumlah = $this->request->getVar('jumlah')[$key];
            $data->harga = $this->request->getVar('harga')[$key];
            $data->subtotal = $this->request->getVar('subtotal')[$key];

            $this->query->saveDetailPr($id_po, $data);
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

    public function detailPr($id)
    {
        $data = [
            'title' => 'Detail PR',
            'row' => $this->query->getDetailPr($id)->getRowArray(),
        ];

        return view('pr/detailPr', $data);
    }

    public function loadDataDetailPr($id_po)
    {
        $data = [
            'id_po' => $id_po,
            'row' => $this->query->getDetailPr($id_po)->getRowArray(),
            'result' => $this->query->getBahanDetailPr($id_po)->getResultArray(),
        ];
        return view('pr/dataDetailPr', $data);
    }

    public function createBahanPr()
    {
        $id_po = $this->request->getVar('id_po');
        $data = [
            'row' => $this->query->getDetailPr($id_po)->getRowArray(),
            'bahan' => $this->query->getBahan()->getResultArray(),
        ];

        return view('pr/createBahanPr', $data);
    }

    public function saveBahanPr()
    {
        $data = new stdClass();
        $row_bahan = $this->request->getVar('jumlah');
        $tanggal = date('Y-m-d');
        $time = date('H:i:s');
        $data->datetime = $tanggal . " " . $time;

        $id_po = $this->request->getVar('id_po');
        $data_po = $this->query->getPoById($id_po)->getRowArray();

        $this->db->transBegin();

        $total = 0;
        foreach (array_filter($row_bahan) as $key => $value) {
            $data->bahan = $this->request->getVar('bahan')[$key];
            $data->no_katalog = $this->request->getVar('no_katalog')[$key];
            $data->gramasi = $this->request->getVar('gramasi')[$key];
            $data->jumlah = $this->request->getVar('jumlah')[$key];
            $data->harga = $this->request->getVar('harga')[$key];
            $data->subtotal = $this->request->getVar('subtotal')[$key];
            $total += $data->subtotal;

            $this->query->saveDetailPr($id_po, $data);
        }

        // $data_po = $this->query->getTotalHargaBahan($id_po)->getRowArray();
        // $data->total = $data_po['sum_total_harga'] + $data->subtotal;
        $data->total = $this->request->getVar('total') + $total;
        $data->diskon_rupiah = $data_po['diskon_rupiah'];

        if ($data_po['ppn'] == 0) {
            $data->ppn = 0;
        } else {
            $data->ppn = $data->total * 0.11;
        }
        $data->grand_total = $data->total - $data->diskon_rupiah + $data->ppn;
        $this->query->updateTotalHargaPr($id_po, $data);

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

    public function editPr($id)
    {
        $data = [
            'row' => $this->query->getPoById($id)->getRowArray(),
            'vendor' => $this->query->getVendor()->getResultArray(),
        ];
        return view('pr/editPr', $data);
    }

    public function updatePr($id)
    {
        $tanggal = $this->request->getVar('tanggal');
        $ftanggal = date('Y-m-d', strtotime($tanggal));
        $vendor = $this->request->getVar('vendor');
        $note = $this->request->getVar('note');

        $time = date('H:i:s');
        $datetime = $ftanggal . " " . $time;

        $this->db->transBegin();

        $this->query->updatePr($id, $ftanggal, $vendor, $note);

        $data_po = $this->query->getBahanDetailPr($id)->getResultArray();
        foreach ($data_po as $key => $value) {
            $this->query->updateDetailPr($value['id'], $datetime);
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

    public function deletePr($id)
    {
        $this->db->transBegin();

        $this->query->deletePr($id);
        $this->query->deleteBahanPrByIdPo($id);

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

    public function deleteBahanPr($id)
    {
        $this->db->transBegin();

        $this->query->deleteBahanPr($id);

        $id_po = $this->request->getVar('id_po');
        $sum_detailpo = $this->query->getTotalHargaBahan($id_po)->getRowArray();
        $data_po = $this->query->getPoById($id_po)->getRowArray();

        $data = new stdClass();
        $data->total = $sum_detailpo['sum_total_harga'];
        $data->diskon_rupiah = $data_po['diskon_rupiah'];
        if ($data_po['ppn'] == 0) {
            $data->ppn = 0;
        } else {
            $data->ppn = $data->total * 0.11;
        }
        $data->grand_total = $data->total - $data->diskon_rupiah + $data->ppn;
        $this->query->updateTotalHargaPr($id_po, $data);

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

    public function editDiskon($id)
    {
        $data = [
            'row' => $this->query->getPoById($id)->getRowArray(),
        ];
        return view('pr/editDiskon', $data);
    }

    public function updateDiskon($id)
    {
        $diskon_persen = $this->request->getVar('diskon_persen');
        $diskon_rupiah = $this->request->getVar('diskon_rupiah');
        $total = $this->request->getVar('total');
        $ppn = $this->request->getVar('ppn');
        $grand_total = $total - $diskon_rupiah + $ppn;
        $proses = $this->query->updateDiskon($id, $diskon_persen, $diskon_rupiah, $grand_total);
        if ($proses === false) {
            $response = [
                'status' => 500,
                'message' => 'Data Gagal Disimpan',
                'error' => true
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Data Berhasil Disimpan',
                'error' => false
            ];
        }
        return json_encode($response);
    }

    public function editPpn($id)
    {
        $data = [
            'row' => $this->query->getPoById($id)->getRowArray(),
        ];
        return view('pr/editPpn', $data);
    }

    public function updatePpn($id)
    {
        $total = $this->request->getVar('total');
        $diskon_rupiah = $this->request->getVar('diskon_rupiah');
        $ppn = $this->request->getVar('ppn');
        $grand_total = $total - $diskon_rupiah + $ppn;
        $proses = $this->query->updatePpn($id, $ppn, $grand_total);
        if ($proses === false) {
            $response = [
                'status' => 500,
                'message' => 'Data Gagal Disimpan',
                'error' => true
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => 'Data Berhasil Disimpan',
                'error' => false
            ];
        }
        return json_encode($response);
    }

    public function printPr($id)
    {
        ob_start();
        $data = [
            'title' => 'Detail PO',
            'row' => $this->query->getDetailReportPr($id)->getRowArray(),
        ];
        $data_pr = $this->query->getDetailReportPr($id)->getRowArray();
        echo view('pr/printPr', $data);
        $html = ob_get_contents();
        ob_end_clean();
        $nama_file = "PR_" . str_replace("/", ".", $data_pr['nomor']) . ".pdf";

        $html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(18, 8, 18, 18));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($html);
        $html2pdf->output($nama_file);
        exit();
    }
}
