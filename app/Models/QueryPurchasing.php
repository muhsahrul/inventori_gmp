<?php

namespace App\Helpers;

class QueryPurchasing
{
    protected $db;
    protected $user_id;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user_id = session()->get('user_id');
    }

    public function getBahan($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT      i.*, s.id AS id_satuan, s.nama AS nama_satuan
                        FROM        m_inventori_bahan_lab i
                        LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = i.m_inventori_bahan_lab_satuan
                        WHERE       i.is_delete = 0  ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function getVendor($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT  *
                        FROM    m_vendor
                        WHERE   is_delete = 0  ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT  *
                    FROM    m_vendor
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function getKodeBulan()
    {
        $bulan = date('m');
        $sql = "    SELECT  kode_romawi
                    FROM    m_bulan
                    WHERE   kode = '$bulan'    ";
        return $this->db->query($sql);
    }

    public function getBahanSatuan($id)
    {
        $sql = "    SELECT      i.*, s.nama AS nama_satuan
                    FROM        m_inventori_bahan_lab i
                    LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = i.m_inventori_bahan_lab_satuan
                    WHERE       i.id = $id  ";
        return $this->db->query($sql);
    }

    // ------------------------------------ PO ------------------------------------- //
    public function getPr($tglawal, $tglakhir)
    {
        $filter = "AND (DATE(p.tanggal) BETWEEN '$tglawal' AND '$tglakhir')";
        $sql = "    SELECT      p.*, v.nama AS nama_vendor
                    FROM        t_po_purchasing p
                    LEFT JOIN   m_vendor v ON v.id = p.m_vendor
                    WHERE       p.is_delete = 0 AND
                                p.m_status_validasi_inv_purchasing = 1
                                $filter
                    ORDER BY    p.tanggal DESC  ";
        return $this->db->query($sql);
    }

    public function getPo($tglawal, $tglakhir)
    {
        $filter = "AND (DATE(p.tanggal) BETWEEN '$tglawal' AND '$tglakhir')";
        $sql = "    SELECT      p.*, v.nama AS nama_vendor
                    FROM        t_po_purchasing p
                    LEFT JOIN   m_vendor v ON v.id = p.m_vendor
                    WHERE       p.is_delete = 0 
                                AND p.m_status_validasi_inv_purchasing = 2
                                $filter
                    ORDER BY    p.tanggal DESC  ";
        return $this->db->query($sql);
    }

    public function getDetailPr($id)
    {
        $sql = "    SELECT      p.*, v.nama AS nama_vendor
                    FROM        t_po_purchasing p
                    LEFT JOIN   t_po_purchasing_det pd ON pd.t_po_purchasing = p.id
                    LEFT JOIN   m_inventori_bahan_lab m ON m.id = pd.m_inventori_bahan_lab
                    LEFT JOIN   m_vendor v ON v.id = p.m_vendor
                    WHERE       p.id = $id  ";
        return $this->db->query($sql);
    }

    public function getDetailReportPr($id)
    {
        $sql = "    SELECT      p.*, v.nama AS nama_vendor, v.alamat AS alamat_vendor, b.nama AS nama_bulan, b.kode_romawi
                    FROM        t_po_purchasing p
                    LEFT JOIN   t_po_purchasing_det pd ON pd.t_po_purchasing = p.id
                    LEFT JOIN   m_inventori_bahan_lab m ON m.id = pd.m_inventori_bahan_lab
                    LEFT JOIN   m_vendor v ON v.id = p.m_vendor
                    LEFT JOIN   m_bulan b ON b.kode = DATE_FORMAT(p.tanggal,'%m')
                    WHERE       p.id = $id  ";
        return $this->db->query($sql);
    }

    public function getBahanDetailPr($id)
    {
        $sql = "    SELECT      pd.*, m.kode, m.nama AS nama_bahan, m.alias, s.nama AS nama_satuan, k.no_katalog
                    FROM        t_po_purchasing_det pd
                    LEFT JOIN   m_inventori_bahan_lab m ON m.id = pd.m_inventori_bahan_lab
                    LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = m.m_inventori_bahan_lab_satuan
                    LEFT JOIN   m_inventori_bahan_lab_katalog k ON k.id = pd.m_inventori_bahan_lab_katalog AND k.is_delete = 0
                    WHERE       pd.t_po_purchasing = $id
                                AND pd.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getTotalHargaBahan($id)
    {
        $sql = "    SELECT      SUM(total_harga) AS sum_total_harga
                    FROM        t_po_purchasing_det pd
                    WHERE       pd.t_po_purchasing = $id
                                AND pd.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getPoById($id)
    {
        $sql = "    SELECT      p.*
                    FROM        t_po_purchasing p
                    WHERE       p.id = $id  ";
        return $this->db->query($sql);
    }

    public function getDetailPoById($id)
    {
        $sql = "    SELECT      p.*
                    FROM        t_po_purchasing_det p
                    WHERE       p.id = $id  ";
        return $this->db->query($sql);
    }

    public function getNomorPo()
    {
        // 135/GMP-PO/V/2022
        // NEW 135/PO-GMP/PRC/V/2022
        $tahun = date('Y');
        $sql = "    SELECT  IFNULL(MAX(nomor_urut), 0) AS max_nomor
                    FROM    t_po_purchasing
                    WHERE   nomor_tahun = '$tahun'  ";
        return $this->db->query($sql);
    }

    public function getDuplicateNomor($nomor)
    {
        $sql = "    SELECT  *
                    FROM    t_po_purchasing
                    WHERE   nomor = '$nomor'    ";
        return $this->db->query($sql);
    }

    public function savePr($data)
    {
        $sql = "    INSERT INTO t_po_purchasing
                    SET         tanggal     = '$data->tanggal',
                                nomor       = '$data->nomor',
                                nomor_urut  = '$data->nomor_urut',
                                nomor_bulan = '$data->nomor_bulan',
                                nomor_tahun = '$data->nomor_tahun',
                                m_vendor    = '$data->vendor',
                                total       = '$data->total',
                                ppn         = '$data->ppn',
                                grand_total = '$data->grand_total',
                                note         = '$data->note',
                                created_user = '$this->user_id',
                                created_date = CURRENT_TIMESTAMP    ";
        return $this->db->query($sql);
    }

    public function saveTotalPr($id, $data)
    {
        $sql = "    UPDATE      t_po_purchasing
                    SET         total = '$data->total',
                                diskon_persen = '$data->diskon_persen',
                                diskon_rupiah = '$data->diskon_rupiah',
                                ppn = '$data->ppn',
                                grand_total = '$data->grand_total',
                                created_user = '$this->user_id',
                                created_date = CURRENT_TIMESTAMP
                    WHERE       id = $id    ";
        return $this->db->query($sql);
    }

    public function saveDetailPr($id_po, $data)
    {
        $sql = "    INSERT INTO t_po_purchasing_det
                    SET         t_po_purchasing = '$id_po',
                                tanggal = '$data->datetime',
                                m_inventori_bahan_lab = '$data->bahan',
                                m_inventori_bahan_lab_katalog = '$data->no_katalog',
                                gramasi = '$data->gramasi',
                                jumlah = '$data->jumlah',
                                harga = '$data->harga',
                                total_harga = '$data->subtotal',
                                created_user = '$this->user_id',
                                created_date = CURRENT_TIMESTAMP    ";
        return $this->db->query($sql);
    }

    public function updatePr($id, $tanggal, $vendor, $note)
    {
        $sql = "    UPDATE      t_po_purchasing
                    SET         tanggal = IF('$tanggal', '$tanggal', NULL),
                                m_vendor = '$vendor',
                                note = '$note',
                                updated_user = '$this->user_id',
                                updated_date = CURRENT_TIMESTAMP
                    WHERE       id = $id    ";
        return $this->db->query($sql);
    }

    public function updateTotalHargaPr($id, $data)
    {
        $sql = "    UPDATE      t_po_purchasing
                    SET         total           = '$data->total',
                                diskon_rupiah   = '$data->diskon_rupiah',
                                ppn             = '$data->ppn',
                                grand_total     = '$data->grand_total',
                                updated_user    = '$this->user_id',
                                updated_date    = CURRENT_TIMESTAMP
                    WHERE       id = $id    ";
        return $this->db->query($sql);
    }

    public function updateDetailPr($id, $datetime)
    {
        $sql = "    UPDATE      t_po_purchasing_det
                    SET         tanggal = IF('$datetime', '$datetime', NULL),
                                updated_user = '$this->user_id',
                                updated_date = CURRENT_TIMESTAMP
                    WHERE       id = $id    ";
        return $this->db->query($sql);
    }

    public function updatePpn($id, $ppn, $grand_total)
    {
        $sql = "    UPDATE      t_po_purchasing
                    SET         ppn             = '$ppn',
                                grand_total     = '$grand_total',
                                updated_user    = '$this->user_id',
                                updated_date    = CURRENT_TIMESTAMP
                    WHERE       id              = $id    ";
        return $this->db->query($sql);
    }

    public function updateDiskon($id, $diskon_persen, $diskon_rupiah, $grand_total)
    {
        $sql = "    UPDATE      t_po_purchasing
                    SET         diskon_persen   = '$diskon_persen',
                                diskon_rupiah   = '$diskon_rupiah',
                                grand_total     = '$grand_total',
                                updated_user    = '$this->user_id',
                                updated_date    = CURRENT_TIMESTAMP
                    WHERE       id              = $id    ";
        return $this->db->query($sql);
    }

    public function deletePr($id)
    {
        $sql = "    UPDATE  t_po_purchasing
                    SET     is_delete = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id    ";
        return $this->db->query($sql);
    }

    public function deleteBahanPr($id)
    {
        $sql = "    UPDATE  t_po_purchasing_det
                    SET     is_delete = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id    ";
        return $this->db->query($sql);
    }

    public function deleteBahanPrByIdPo($id)
    {
        $sql = "    UPDATE  t_po_purchasing_det
                    SET     is_delete = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   t_po_purchasing = $id    ";
        return $this->db->query($sql);
    }

    public function getKatalog($id)
    {
        $sql = "    SELECT      k.*, v.nama AS vendor
                    FROM        m_inventori_bahan_lab_katalog k
                    LEFT JOIN   m_vendor v ON v.id = k.m_vendor AND v.is_delete = 0
                    WHERE       k.m_inventori_bahan_lab = $id
                                AND k.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getGramasi($id)
    {
        $sql = "    SELECT      *
                    FROM        m_inventori_bahan_lab_gramasi
                    WHERE       m_inventori_bahan_lab = '$id'
                                AND is_delete = 0  ";
        return $this->db->query($sql);
    }
}
