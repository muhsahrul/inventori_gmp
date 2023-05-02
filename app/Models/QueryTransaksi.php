<?php

namespace App\Helpers;

class QueryTransaksi
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

    public function getBahanSatuan($id)
    {
        $sql = "    SELECT      i.*, s.nama AS nama_satuan
                    FROM        m_inventori_bahan_lab i
                    LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = i.m_inventori_bahan_lab_satuan
                    WHERE       i.id = $id  ";
        return $this->db->query($sql);
    }

    public function getBahanPo($id)
    {
        $sql = "    SELECT      *
                    FROM        t_po_purchasing
                    WHERE       id = $id  ";
        return $this->db->query($sql);
    }

    public function getSatuan($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT  *
                        FROM    m_inventori_bahan_lab_satuan
                        WHERE   is_delete = 0  ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab_satuan
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function getParameterUji($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT  *
                        FROM    m_parameter_uji
                        WHERE   is_delete = 0  ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT  *
                    FROM    m_parameter_uji
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

    public function getPo($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT      id, nomor
                        FROM        t_po_purchasing
                        WHERE       is_delete = 0
                        ORDER BY    id DESC  ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT      t.*, v.nama AS nama_vendor
                    FROM        t_po_purchasing t
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    WHERE       t.id = $id  ";
        return $this->db->query($sql);
    }

    public function getFilterPo()
    {
        $sql = "    SELECT      p.id, p.nomor
                    FROM        t_po_purchasing p
                    WHERE       p.is_delete = 0
                                AND p.m_status_pembayaran_inv_purchasing = 1
                    ORDER BY    p.id DESC  ";
        return $this->db->query($sql);
    }

    public function getPoByNomor($nomor)
    {
        $sql = "    SELECT      t.*
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    WHERE       t.nomor_po = '$nomor'
                                AND t.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getPoByInvoice($invoice)
    {
        $sql = "    SELECT      t.*
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    WHERE       t.nomor_invoice = '$invoice'
                                AND t.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getCountNomorPo($nomor_po)
    {
        $sql = "    SELECT      COUNT(nomor_po) AS count_po
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    WHERE       t.nomor_po = '$nomor_po'
                                AND t.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getBarangMasukByPo($id)
    {
        $sql = "    SELECT      t.*, t.tanggal AS tanggal_barang_masuk, t.tanggal_po AS tanggal, v.nama AS nama_vendor
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    WHERE       t.t_po_purchasing = '$id'
                                AND t.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getDetailPo($id)
    {
        $sql = "    SELECT      pd.*, m.kode, m.nama AS nama_bahan, m.alias, s.nama AS nama_satuan, k.no_katalog
                    FROM        t_po_purchasing_det pd
                    LEFT JOIN   m_inventori_bahan_lab m ON m.id = pd.m_inventori_bahan_lab
                    LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = m.m_inventori_bahan_lab_satuan
                    LEFT JOIN   m_inventori_bahan_lab_katalog k ON k.id = pd.m_inventori_bahan_lab_katalog AND k.is_delete = 0
                    WHERE       pd.t_po_purchasing = '$id'
                                AND pd.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getTotalMasukBarang($id_barang_masuk, $id_bahan, $jumlah)
    {
        $sql = "    SELECT      jumlah_masuk
                    FROM        t_inventori_bahan_lab_keluar_masuk_det td
                    WHERE       td.t_inventori_bahan_lab_keluar_masuk = '$id_barang_masuk'
                                AND td.m_inventori_bahan_lab = '$id_bahan'
                                AND td.jumlah = '$jumlah'
                                AND td.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getGrandTotalInvoice($nomor_invoice)
    {
        $sql = "    SELECT      SUM(grand_total) AS grand_total
                    FROM        t_inventori_bahan_lab_keluar_masuk td
                    WHERE       td.nomor_invoice = '$nomor_invoice'
                                AND td.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getTotalByDetailPo($id)
    {
        $sql = "    SELECT      SUM(total_harga) AS subtotal
                    FROM        t_inventori_bahan_lab_keluar_masuk_det td
                    WHERE       td.id = $id
                                AND td.is_delete = 0  ";
        return $this->db->query($sql);
    }

    // ------------------------------------ STOK AWAL ------------------------------------- //
    public function updateStokAwal($id, $tanggal, $jumlah)
    {
        $sql = "    UPDATE  m_inventori_bahan_lab
                    SET     tgl_stok_awal   = IF('$tanggal', '$tanggal', NULL),
                            stok_awal       = '$jumlah',
                            updated_user    = '$this->user_id',
                            updated_date    = CURRENT_TIMESTAMP
                    WHERE   id = $id    ";
        return $this->db->query($sql);
    }

    public function getStokAkhir($id)
    {
        $sql = "    SELECT  SUM(IF(is_masuk = 1,jumlah,0)) AS total_masuk, SUM(IF(is_masuk = 2,jumlah,0)) AS total_keluar
                    FROM    t_inventori_bahan_lab_keluar_masuk_det   
                    WHERE   m_inventori_bahan_lab = $id
                            AND is_delete = 0   ";
        return $this->db->query($sql);
    }

    public function getStokAkhirTstok($id)
    {
        $bulan = date('m');
        $tahun = date('Y');
        $sql = "    SELECT  *
                    FROM    t_inventori_bahan_lab_stok  
                    WHERE   m_inventori_bahan_lab = '$id'
                            AND tahun = '$tahun'
                            AND bulan = '$bulan'
                            AND is_delete = 0   ";
        return $this->db->query($sql);
    }

    public function getStokAkhirFromMaster($id)
    {
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab 
                    WHERE   id = $id
                            AND is_delete = 0   ";
        return $this->db->query($sql);
    }

    // ------------------------------------ BARANG MASUK ------------------------------------- //
    public function getBarangMasuk($tglawal, $tglakhir)
    {
        $filter = "AND (DATE(t.tanggal) BETWEEN '$tglawal' AND '$tglakhir')";
        $sql = "    SELECT      t.*, v.nama AS nama_vendor, SUM(grand_total) AS grand_total
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    WHERE       t.is_delete = 0
                                $filter
                    GROUP BY    t.nomor_invoice
                    ORDER BY    t.tanggal DESC  ";
        return $this->db->query($sql);
    }

    public function getDetailBarangMasuk($id)
    {
        $sql = "    SELECT      t.*, v.nama AS nama_vendor
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    LEFT JOIN   t_inventori_bahan_lab_keluar_masuk_det td ON td.t_inventori_bahan_lab_keluar_masuk = t.id
                    LEFT JOIN   m_inventori_bahan_lab m ON m.id = td.m_inventori_bahan_lab
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    WHERE       t.id = $id  ";
        return $this->db->query($sql);
    }

    public function getBahanDetailBarangMasuk($id)
    {
        $sql = "    SELECT      td.*, m.kode, m.nama AS nama_bahan, m.alias, s.nama AS nama_satuan, k.no_katalog
                    FROM        t_inventori_bahan_lab_keluar_masuk_det td
                    LEFT JOIN   m_inventori_bahan_lab m ON m.id = td.m_inventori_bahan_lab
                    LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = m.m_inventori_bahan_lab_satuan
                    LEFT JOIN   m_inventori_bahan_lab_katalog k ON k.id = td.m_inventori_bahan_lab_katalog AND k.is_delete = 0
                    WHERE       td.t_inventori_bahan_lab_keluar_masuk = '$id'
                                AND td.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getBarangKeluarById($id)
    {
        $sql = "    SELECT      *
                    FROM        t_inventori_bahan_lab_keluar_masuk_det
                    WHERE       id = $id
                                AND is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getBarangMasukKeluarById($id)
    {
        $sql = "    SELECT      t.*, v.nama AS nama_vendor
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    WHERE       t.id = $id  ";
        return $this->db->query($sql);
    }

    public function saveBarangMasuk($id_po, $data)
    {
        $sql = "    INSERT INTO t_inventori_bahan_lab_keluar_masuk
                    SET         tanggal          = '$data->datetime',
                                t_po_purchasing  = '$id_po',
                                tanggal_po       = IF('$data->tanggal_po', '$data->tanggal_po', NULL),
                                nomor_po         = '$data->nomor_po',
                                tanggal_invoice  = IF('$data->tanggal_invoice', '$data->tanggal_invoice', NULL),
                                nomor_invoice    = '$data->nomor_invoice',
                                m_vendor         = '$data->vendor',
                                tanggal_jt_bayar = IF('$data->tanggal_jatuh_tempo', '$data->tanggal_jatuh_tempo', NULL),
                                grand_total      = '$data->grand_total',
                                m_status_pembayaran_inv_purchasing = 1,
                                created_user     = '$this->user_id',
                                created_date     = CURRENT_TIMESTAMP    ";
        return $this->db->query($sql);
    }

    public function updateTotalBarangMasuk($id_barangmasuk, $grand_total)
    {
        $sql = "    UPDATE      t_inventori_bahan_lab_keluar_masuk
                    SET         grand_total = '$grand_total'
                    WHERE       id = $id_barangmasuk    ";
        return $this->db->query($sql);
    }

    public function saveDetailBarangMasuk($id_barang_masuk, $data)
    {
        $sql = "    INSERT INTO t_inventori_bahan_lab_keluar_masuk_det
                    SET         t_inventori_bahan_lab_keluar_masuk = '$id_barang_masuk',
                                tanggal                 = '$data->datetime',
                                m_inventori_bahan_lab   = '$data->bahan',
                                m_inventori_bahan_lab_katalog   = '$data->no_katalog',
                                gramasi                 = '$data->gramasi',
                                jumlah                  = '$data->jumlah',
                                harga                   = '$data->harga',
                                total_harga             = '$data->total_harga',
                                is_masuk                = 1,
                                total_masuk             = '$data->total_masuk',
                                jumlah_masuk            = '$data->jumlah_masuk',
                                created_user            = '$this->user_id',
                                created_date            = CURRENT_TIMESTAMP    ";
        return $this->db->query($sql);
    }

    public function updateBarangMasuk($id_barang_masuk, $data)
    {
        $sql = "    UPDATE      t_inventori_bahan_lab_keluar_masuk
                    SET         tanggal             = '$data->datetime',
                                tanggal_invoice     = IF('$data->tanggal_invoice', '$data->tanggal_invoice', NULL),
                                nomor_invoice       = '$data->nomor_invoice',
                                tanggal_jt_bayar    = IF('$data->tanggal_jatuh_tempo', '$data->tanggal_jatuh_tempo', NULL),
                                updated_user        = '$this->user_id',
                                updated_date        = CURRENT_TIMESTAMP
                    WHERE       id = $id_barang_masuk    ";
        return $this->db->query($sql);
    }

    public function saveStok($bahan, $tgl_tahun, $tgl_bulan, $stok_akhir)
    {
        $sql = "    INSERT INTO t_inventori_bahan_lab_stok
                    SET         m_inventori_bahan_lab = '$bahan',
                                tahun = '$tgl_tahun',
                                bulan = '$tgl_bulan',
                                stok_akhir = '$stok_akhir',
                                created_user = '$this->user_id',
                                created_date = CURRENT_TIMESTAMP    ";
        return $this->db->query($sql);
    }

    public function updateStok($bahan, $tgl_tahun, $tgl_bulan, $stok_akhir)
    {
        $sql = "    UPDATE  t_inventori_bahan_lab_stok
                    SET     tahun = '$tgl_tahun',
                            bulan = '$tgl_bulan',
                            stok_akhir = '$stok_akhir',
                            updated_user = '$this->user_id',
                            updated_date = CURRENT_TIMESTAMP
                    WHERE   m_inventori_bahan_lab = '$bahan'    ";
        return $this->db->query($sql);
    }

    public function updateStokDelete($bahan, $stok_akhir)
    {
        $sql = "    UPDATE  t_inventori_bahan_lab_stok
                    SET     stok_akhir = '$stok_akhir',
                            updated_user = '$this->user_id',
                            updated_date = CURRENT_TIMESTAMP
                    WHERE   m_inventori_bahan_lab = '$bahan'    ";
        return $this->db->query($sql);
    }

    public function deleteBarangMasuk($id)
    {
        $sql = "    UPDATE  t_inventori_bahan_lab_keluar_masuk
                    SET     is_delete = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id    ";
        return $this->db->query($sql);
    }

    public function deleteBahanBarangMasuk($id)
    {
        $sql = "    UPDATE  t_inventori_bahan_lab_keluar_masuk_det
                    SET     is_delete = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id   ";
        return $this->db->query($sql);
    }

    public function deleteBahanBarangMasukByIdMaster($id)
    {
        $sql = "    UPDATE  t_inventori_bahan_lab_keluar_masuk_det
                    SET     is_delete = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   t_inventori_bahan_lab_keluar_masuk = $id    ";
        return $this->db->query($sql);
    }

    // ------------------------------------ BARANG KELUAR ------------------------------------- //
    public function getBarangKeluar($tglawal, $tglakhir)
    {
        $filter = "AND (DATE(tanggal) BETWEEN '$tglawal' AND '$tglakhir')";
        $sql = "    SELECT      t.*, m.kode, m.nama, s.nama AS satuan, m.stok_akhir AS stok_bahan, pu.nama AS nama_parameter, p.nama AS nama_pegawai
                    FROM        t_inventori_bahan_lab_keluar_masuk_det t
                    LEFT JOIN   m_inventori_bahan_lab m ON m.id = t.m_inventori_bahan_lab
                    LEFT JOIN   m_parameter_uji pu ON pu.id = t.m_parameter_uji
                    LEFT JOIN   tb_pegawai p ON p.id = t.created_user
                    LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = m.m_inventori_bahan_lab_satuan
                    WHERE       t.is_masuk = 2 
                                $filter
                                AND t.is_delete = 0
                    ORDER BY    t.tanggal DESC  ";
        return $this->db->query($sql);
    }

    public function savebarangKeluar($data)
    {
        $sql = "    INSERT INTO t_inventori_bahan_lab_keluar_masuk_det
                    SET         tanggal                 = '$data->datetime',
                                m_inventori_bahan_lab   = '$data->bahan',
                                jumlah                  = '$data->jumlah',
                                keterangan              = '$data->keterangan',
                                is_masuk                = 2,
                                m_parameter_uji         = '$data->parameter',
                                created_user            = '$this->user_id',
                                created_date            = CURRENT_TIMESTAMP    ";
        return $this->db->query($sql);
    }

    public function deleteBarangKeluar($id)
    {
        $sql = "    UPDATE  t_inventori_bahan_lab_keluar_masuk_det
                    SET     is_delete = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id    ";
        return $this->db->query($sql);
    }
}
