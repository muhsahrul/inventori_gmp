<?php

namespace App\Helpers;

class QueryGa
{
    protected $db;
    protected $user_id;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user_id = session()->get('user_id');
    }

    // ------------------------------------ PEMBAYARAN ------------------------------------- //
    public function getInvoice($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT      *
                        FROM        t_inventori_bahan_lab_keluar_masuk
                        WHERE       nomor_invoice IS NOT NULL
                                    AND is_delete = 0
                                    AND m_status_pembayaran_inv_purchasing = 1
                        GROUP BY    nomor_invoice  ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT      t.*, v.nama AS nama_vendor
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    LEFT JOIN   m_status_pembayaran_inv_purchasing s ON s.id = t.m_status_pembayaran_inv_purchasing
                    WHERE       t.id = $id  ";
        return $this->db->query($sql);
    }

    public function getFilterInvoice()
    {
        $sql = "    SELECT      t.*, v.nama AS nama_vendor, s.nama AS status_pembayaran, SUM(t.grand_total) AS grand_total
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    LEFT JOIN   m_status_pembayaran_inv_purchasing s ON s.id = t.m_status_pembayaran_inv_purchasing
                    WHERE       t.is_delete = 0
                                AND t.m_status_pembayaran_inv_purchasing = 1
                    GROUP BY    t.nomor_invoice
                    ORDER BY    t.tanggal_invoice ASC   ";
        return $this->db->query($sql);
    }

    public function getFilterPembayaran($tglawal, $tglakhir)
    {
        $filter = "AND (tp.tanggal_bayar BETWEEN '$tglawal' AND '$tglakhir')";

        $sql = "    SELECT      tp.*, t.*, tp.id AS id, v.nama AS nama_vendor, s.nama AS status_pembayaran, SUM(t.grand_total) AS grand_total, SUM(tp.jumlah) AS total_bayar
                    FROM        t_po_purchasing_pembayaran tp
                    LEFT JOIN   t_inventori_bahan_lab_keluar_masuk t ON t.id = tp.t_inventori_bahan_lab_keluar_masuk
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    LEFT JOIN   m_status_pembayaran_inv_purchasing s ON s.id = t.m_status_pembayaran_inv_purchasing
                    WHERE       tp.is_delete = 0
                                AND tp.tanggal_bayar IS NOT NULL
                                -- AND t.m_status_pembayaran_inv_purchasing = 2
                                $filter
                    GROUP BY    t.nomor_invoice
                    ORDER BY    tp.tanggal_bayar DESC  ";
        return $this->db->query($sql);
    }

    public function getPembayaranById($id)
    {
        $sql = "    SELECT      tp.*, t.*, tp.id AS id, v.nama AS nama_vendor, s.nama AS status_pembayaran
                    FROM        t_po_purchasing_pembayaran tp
                    LEFT JOIN   t_inventori_bahan_lab_keluar_masuk t ON t.id = tp.t_inventori_bahan_lab_keluar_masuk
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    LEFT JOIN   m_status_pembayaran_inv_purchasing s ON s.id = t.m_status_pembayaran_inv_purchasing
                    WHERE       tp.id = $id  ";
        return $this->db->query($sql);
    }

    public function getPembayaranByBarangMasuk($id)
    {
        $sql = "    SELECT      tp.*
                    FROM        t_po_purchasing_pembayaran tp
                    WHERE       tp.t_inventori_bahan_lab_keluar_masuk = $id
                                AND is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getBarangMasukByInvoice($nomor)
    {
        $sql = "    SELECT      t.*, v.nama AS nama_vendor
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    WHERE       t.nomor_invoice = '$nomor'  ";
        return $this->db->query($sql);
    }

    public function getBarangMasukById($nomor)
    {
        $sql = "    SELECT      t.*, v.nama AS nama_vendor
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    WHERE       t.id = '$nomor'  ";
        return $this->db->query($sql);
    }

    public function getPoPurchasingById($id)
    {
        $sql = "    SELECT      t.*
                    FROM        t_po_purchasing t
                    WHERE       t.id = $id  ";
        return $this->db->query($sql);
    }

    public function getStatusValidasiPr()
    {
        $sql = "    SELECT      *
                    FROM        m_status_validasi_inv_purchasing  ";
        return $this->db->query($sql);
    }

    public function getBahanDetailBarangMasuk($id)
    {
        $sql = "    SELECT      td.*, m.kode, m.nama AS nama_bahan, m.alias, s.nama AS nama_satuan, k.no_katalog
                    FROM        t_inventori_bahan_lab_keluar_masuk_det td
                    LEFT JOIN   m_inventori_bahan_lab m ON m.id = td.m_inventori_bahan_lab
                    LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = m.m_inventori_bahan_lab_satuan
                    LEFT JOIN   m_inventori_bahan_lab_katalog k ON k.id = td.m_inventori_bahan_lab_katalog AND k.is_delete = 0
                    WHERE       td.t_inventori_bahan_lab_keluar_masuk = $id
                                AND td.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getBahanDetailPurchasing($id)
    {
        $sql = "    SELECT      td.*, m.kode, m.nama AS nama_bahan, m.alias, k.no_katalog, s.nama AS nama_satuan
                    FROM        t_po_purchasing_det td
                    LEFT JOIN   m_inventori_bahan_lab m ON m.id = td.m_inventori_bahan_lab
                    LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = m.m_inventori_bahan_lab_satuan
                    LEFT JOIN   m_inventori_bahan_lab_katalog k ON k.id = td.m_inventori_bahan_lab_katalog AND k.is_delete = 0
                    WHERE       td.t_po_purchasing = $id
                                AND td.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getTotalMasukBarang($id_barang_masuk, $id_bahan)
    {
        $sql = "    SELECT      jumlah_masuk
                    FROM        t_inventori_bahan_lab_keluar_masuk_det td
                    WHERE       td.t_inventori_bahan_lab_keluar_masuk = '$id_barang_masuk'
                                AND td.m_inventori_bahan_lab = '$id_bahan'
                                AND td.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getTotalByPo($nomor_invoice)
    {
        $sql = "    SELECT      SUM(grand_total) AS grand_total
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    WHERE       t.nomor_invoice = '$nomor_invoice'
                                AND t.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getTotalByDetailPo($id)
    {
        $sql = "    SELECT      SUM(td.total_harga) AS subtotal
                    FROM        t_inventori_bahan_lab_keluar_masuk_det td
                    WHERE       td.t_inventori_bahan_lab_keluar_masuk = $id
                                AND td.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function getTotalBayarInvoice($id_barangmasuk)
    {
        $sql = "    SELECT      t.jumlah AS total_bayar
                    FROM        t_po_purchasing_pembayaran t
                    WHERE       t.t_inventori_bahan_lab_keluar_masuk = $id_barangmasuk
                                AND t.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function savePembayaran($id_barangmasuk, $tanggal_bayar, $jumlah_bayar)
    {
        $sql = "    INSERT INTO t_po_purchasing_pembayaran
                    SET         t_inventori_bahan_lab_keluar_masuk = '$id_barangmasuk',
                                tanggal_bayar = '$tanggal_bayar',
                                jumlah = '$jumlah_bayar',
                                created_user = '$this->user_id',
                                created_date = CURRENT_TIMESTAMP    ";
        return $this->db->query($sql);
    }

    public function updateStatusPembayaran($id_invoice, $status)
    {
        $sql = "    UPDATE      t_inventori_bahan_lab_keluar_masuk
                    SET         m_status_pembayaran_inv_purchasing = '$status',
                                updated_user = '$this->user_id',
                                updated_date = CURRENT_TIMESTAMP
                    WHERE       nomor_invoice = '$id_invoice'    ";
        return $this->db->query($sql);
    }

    public function updateStatusPembayaranPurchasing($implode_po, $status)
    {
        $sql = "    UPDATE      t_po_purchasing
                    SET         m_status_pembayaran_inv_purchasing = '$status',
                                updated_user = '$this->user_id',
                                updated_date = CURRENT_TIMESTAMP
                    WHERE       id IN ($implode_po)    ";
        return $this->db->query($sql);
    }

    public function updatePembayaran($id, $tanggal)
    {
        $sql = "    UPDATE      t_po_purchasing_pembayaran
                    SET         tanggal_bayar = '$tanggal',
                                updated_user = '$this->user_id',
                                updated_date = CURRENT_TIMESTAMP
                    WHERE       id = $id    ";
        return $this->db->query($sql);
    }

    public function deletePembayaran($id)
    {
        $sql = "    UPDATE      t_po_purchasing_pembayaran
                    SET         is_delete = 1,
                                deleted_user = '$this->user_id',
                                deleted_date = CURRENT_TIMESTAMP
                    WHERE       id = $id    ";
        return $this->db->query($sql);
    }

    public function getFilterPr($tglawal, $tglakhir, $status_validasi)
    {
        $filter = "AND (DATE(p.tanggal) BETWEEN '$tglawal' AND '$tglakhir')";
        if ($status_validasi) {
            $filter2 = "AND p.m_status_validasi_inv_purchasing = '$status_validasi'";
        } else {
            $filter2 = "";
        }
        $sql = "    SELECT      p.*, v.nama AS nama_vendor, s.nama AS status_validasi
                    FROM        t_po_purchasing p
                    LEFT JOIN   m_vendor v ON v.id = p.m_vendor
                    LEFT JOIN   m_status_validasi_inv_purchasing s ON s.id = p.m_status_validasi_inv_purchasing
                    WHERE       p.is_delete = 0
                                $filter $filter2
                    ORDER BY    p.m_status_validasi_inv_purchasing ASC, p.tanggal DESC  ";
        return $this->db->query($sql);
    }

    public function updateValidatePr($id, $new_nomor, $status)
    {
        $sql = "    UPDATE  t_po_purchasing
                    SET     nomor             = '$new_nomor',
                            m_status_validasi_inv_purchasing = '$status',
                            user_validasi     = '$this->user_id',
                            tanggal_validasi  = CURRENT_TIMESTAMP,
                            updated_user      = '$this->user_id',
                            updated_date      = CURRENT_TIMESTAMP
                    WHERE   id                = $id  ";
        return $this->db->query($sql);
    }
}
