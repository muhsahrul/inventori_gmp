<?php

namespace App\Helpers;

class QueryReport
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

    public function getMinTglStokAwal()
    {
        $sql = "    SELECT  tgl_stok_awal
                    FROM    m_inventori_bahan_lab
                    WHERE   is_delete = 0 AND tgl_stok_awal IS NOT NULL
                    ORDER BY tgl_stok_awal ASC  ";
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

    public function getReportParameter($tglawal, $tglakhir, $parameter)
    {
        $filter1 = "AND (t.tanggal BETWEEN '$tglawal' AND '$tglakhir')";
        $filter2 = "AND t.m_parameter_uji = '$parameter'";

        $sql = "    SELECT      t.*, p.nama AS nama_parameter, i.kode, i.nama AS nama_bahan
        , SUM(t.jumlah) AS total_jumlah
                    FROM        t_inventori_bahan_lab_keluar_masuk_det t
                    LEFT JOIN   m_parameter_uji p ON p.id = t.m_parameter_uji
                    LEFT JOIN   m_inventori_bahan_lab i ON i.id = t.m_inventori_bahan_lab
                    WHERE       t.is_delete = 0
                                AND t.is_masuk = 2
                                $filter1 $filter2
                    GROUP BY    t.m_inventori_bahan_lab, DATE(t.tanggal)
                    ORDER BY    DATE(t.tanggal) DESC  ";
        return $this->db->query($sql);
    }

    public function getReportBahan($tglawal, $tglakhir, $bahan)
    {
        $filter1 = "AND (t.tanggal BETWEEN '$tglawal' AND '$tglakhir')";
        $filter2 = "AND t.m_inventori_bahan_lab = '$bahan'";

        $sql = "    SELECT      t.*, i.kode, i.nama AS nama_bahan, SUM(IF(is_masuk = 1,IF(t.gramasi>0,jumlah_masuk*t.gramasi,jumlah_masuk),0)) AS total_masuk, SUM(IF(is_masuk = 2,jumlah,0)) AS total_keluar
                    FROM        t_inventori_bahan_lab_keluar_masuk_det t
                    LEFT JOIN   m_inventori_bahan_lab i ON i.id = t.m_inventori_bahan_lab
                    WHERE       t.is_delete = 0
                                $filter1 $filter2
                    GROUP BY    DATE(t.tanggal)
                    ORDER BY    DATE(t.tanggal) DESC  ";
        return $this->db->query($sql);
    }

    public function getChartBahan($tahun, $bahan)
    {
        $filter1 = "AND (YEAR(t.tanggal) = '$tahun')";
        $filter2 = "AND t.m_inventori_bahan_lab = '$bahan'";

        $sql = "    SELECT      t.*, i.kode, i.nama AS nama_bahan, SUM(IF(is_masuk = 1,jumlah_masuk*t.gramasi,0)) AS total_masuk, SUM(IF(is_masuk = 2,jumlah,0)) AS total_keluar, MONTH(t.tanggal) AS tgl_bulan, b.nama AS nama_bulan
                    FROM        t_inventori_bahan_lab_keluar_masuk_det t
                    LEFT JOIN   m_inventori_bahan_lab i ON i.id = t.m_inventori_bahan_lab
                    LEFT JOIN   m_bulan b ON b.id = MONTH(t.tanggal)
                    WHERE       t.is_delete = 0
                                $filter1 $filter2
                    GROUP BY    MONTH(t.tanggal)
                    ORDER BY    MONTH(t.tanggal) ASC  ";
        return $this->db->query($sql);
    }

    public function getTotalKeluarMasukStokAwal($id, $tglawal)
    {
        $filter = "AND (tanggal < '$tglawal')";
        $sql = "    SELECT  SUM(IF(is_masuk = 1,IF(gramasi>0,jumlah_masuk*gramasi,jumlah_masuk),0)) AS total_masuk, SUM(IF(is_masuk = 2,jumlah,0)) AS total_keluar
                    FROM    t_inventori_bahan_lab_keluar_masuk_det t
                    WHERE   m_inventori_bahan_lab = '$id'
                            $filter
                            AND is_delete = 0   ";
        return $this->db->query($sql);
    }

    public function getTotalMasukKeluar($id, $tglawal, $tglakhir)
    {
        $filter = "AND (tanggal BETWEEN '$tglawal' AND '$tglakhir')";
        $sql = "    SELECT  SUM(IF(is_masuk = 1,IF(gramasi>0,jumlah_masuk*gramasi,jumlah_masuk),0)) AS total_masuk, SUM(IF(is_masuk = 2,jumlah,0)) AS total_keluar
                    FROM    t_inventori_bahan_lab_keluar_masuk_det  
                    WHERE   m_inventori_bahan_lab = '$id'
                            $filter
                            AND is_delete = 0   ";
        return $this->db->query($sql);
    }

    // -------------------------------------- INVOICE ------------------------------------- //
    public function getStatusPembayaran()
    {
        $sql = "    SELECT  *
                    FROM    m_status_pembayaran_inv_purchasing  ";
        return $this->db->query($sql);
    }

    public function getJatuhTempo($tglawal, $tglakhir, $status_pembayaran)
    {
        $filter1 = "AND (t.tanggal_jt_bayar BETWEEN '$tglawal' AND '$tglakhir')";
        if ($status_pembayaran) {
            $filter2 = "AND m_status_pembayaran_inv_purchasing = '$status_pembayaran'";
        } else {
            $filter2 = "";
        }
        $sql = "    SELECT      t.*, v.nama AS nama_vendor, s.nama AS status_pembayaran, SUM(grand_total) as grand_total
                    FROM        t_inventori_bahan_lab_keluar_masuk t
                    LEFT JOIN   m_vendor v ON v.id = t.m_vendor
                    LEFT JOIN   m_status_pembayaran_inv_purchasing s ON s.id = t.m_status_pembayaran_inv_purchasing
                    WHERE       t.is_delete = 0
                                $filter1 $filter2
                    GROUP BY    t.nomor_invoice
                    ORDER BY    t.tanggal_po DESC  ";
        return $this->db->query($sql);
    }

    public function getReportPenyesuaian($tglawal = false, $tglakhir = false, $id_bahan)
    {
        $filter1 = "a.m_inventori_bahan_lab = '$id_bahan'";
        if ($tglawal != false || $tglakhir != false) {
            $filter2 = "AND (a.tgl_penyesuaian BETWEEN '$tglawal' AND '$tglakhir')";
        } else {
            $filter2 = "";
        }

        $sql = "    SELECT      *
                    FROM        m_inventori_bahan_lab_penyesuaian a
                    LEFT JOIN   m_inventori_bahan_lab b ON b.id = a.m_inventori_bahan_lab AND a.is_delete = 0
                    WHERE       $filter1 $filter2   ";
        return $this->db->query($sql);
    }

    public function checkHistoryStok($id_bahan, $tglawal)
    {
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab_penyesuaian
                    WHERE   m_inventori_bahan_lab = '$id_bahan'
                            AND tgl_penyesuaian <= '$tglawal'
                    ORDER BY id DESC ";
        return $this->db->query($sql);
    }

    public function checkHistoryStokAsc($id_bahan, $tglawal)
    {
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab_penyesuaian
                    WHERE   m_inventori_bahan_lab = '$id_bahan'
                            AND tgl_penyesuaian < '$tglawal'
                    ORDER BY id DESC ";
        return $this->db->query($sql);
    }

    public function getLastStok($tglawal, $tglakhir, $bahan)
    {
        $filter1 = "AND (t.tanggal BETWEEN '$tglawal' AND '$tglakhir')";
        $filter2 = "AND t.m_inventori_bahan_lab = '$bahan'";

        $sql = "    SELECT      t.*, i.kode, i.nama AS nama_bahan, SUM(IF(is_masuk = 1,IF(t.gramasi>0,jumlah_masuk*t.gramasi,jumlah_masuk),0)) AS total_masuk, SUM(IF(is_masuk = 2,jumlah,0)) AS total_keluar
                    FROM        t_inventori_bahan_lab_keluar_masuk_det t
                    LEFT JOIN   m_inventori_bahan_lab i ON i.id = t.m_inventori_bahan_lab
                    WHERE       t.is_delete = 0
                                $filter1 $filter2
                    ORDER BY    DATE(t.tanggal) DESC  ";
        return $this->db->query($sql);
    }

    public function getStokAwal($id_bahan)
    {
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab
                    WHERE   id = '$id_bahan' ";
        return $this->db->query($sql);
    }

    public function getSumStok($tglawal, $tglakhir, $bahan)
    {
        $filter1 = "AND (t.tanggal BETWEEN '$tglawal' AND '$tglakhir')";
        $filter2 = "AND t.m_inventori_bahan_lab = '$bahan'";

        $sql = "    SELECT      SUM(IF(is_masuk = 1,IF(t.gramasi>0,jumlah_masuk*t.gramasi,jumlah_masuk),0)) AS total_masuk, SUM(IF(is_masuk = 2,jumlah,0)) AS total_keluar
                    FROM        t_inventori_bahan_lab_keluar_masuk_det t
                    LEFT JOIN   m_inventori_bahan_lab i ON i.id = t.m_inventori_bahan_lab
                    WHERE       t.is_delete = 0
                                $filter1 $filter2  ";
        return $this->db->query($sql);
    }

    public function getReportBarangMasuk($tglawal, $tglakhir)
    {
        $filter1 = "AND (a.tanggal BETWEEN '$tglawal' AND '$tglakhir')";

        $sql = "    SELECT      a.*, b.kode, b.nama AS nama_bahan, b.alias, c.nomor_po, d.no_katalog
                    FROM        t_inventori_bahan_lab_keluar_masuk_det a
                    LEFT JOIN   m_inventori_bahan_lab b ON b.id = a.m_inventori_bahan_lab
                    LEFT JOIN   t_inventori_bahan_lab_keluar_masuk c ON c.id = a.t_inventori_bahan_lab_keluar_masuk AND c.is_delete = 0
                    LEFT JOIN   m_inventori_bahan_lab_katalog d ON d.id = a.m_inventori_bahan_lab_katalog AND d.is_delete = 0
                    WHERE       is_masuk = 1
                                AND a.is_delete = 0
                                $filter1  ";
        return $this->db->query($sql);
    }
}
