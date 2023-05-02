<?php

namespace App\Helpers\Master;

class QueryPenyesuaian
{
    protected $db;
    protected $user_id;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user_id = session()->get('user_id');
    }

    public function getPenyesuaianBahan($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT      a.*, b.tgl_penyesuaian, b.stok_lama, b.stok_baru, b.selisih, b.jenis_penyesuaian, b.harga_satuan
                        FROM        m_inventori_bahan_lab a
                        LEFT JOIN   m_inventori_bahan_lab_penyesuaian b ON b.id = (SELECT c.id FROM m_inventori_bahan_lab_penyesuaian AS c WHERE c.m_inventori_bahan_lab = a.id ORDER BY c.id DESC LIMIT 1)
                        WHERE       a.is_delete = 0
                        GROUP BY    a.id
                        ORDER BY    a.kode ASC, a.nama ASC   ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT      *
                    FROM        m_inventori_bahan_lab
                    LEFT JOIN   m_inventori_bahan_lab_penyesuaian p ON p.m_inventori_bahan_lab = i.id
                    WHERE       id = '$id'  ";
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

    public function getLastStok($tglawal, $tglakhir, $bahan)
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

    public function checkHistoryStok($id_bahan)
    {
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab_penyesuaian
                    WHERE   m_inventori_bahan_lab = '$id_bahan'
                    ORDER BY id DESC ";
        return $this->db->query($sql);
    }

    public function getStokAwal($id_bahan)
    {
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab
                    WHERE   id = '$id_bahan' ";
        return $this->db->query($sql);
    }

    public function savePenyesuaian($tanggal, $data)
    {
        $sql = "    INSERT INTO m_inventori_bahan_lab_penyesuaian
                    SET         m_inventori_bahan_lab   = '$data->bahan',
                                tgl_penyesuaian         = '$tanggal',
                                stok_lama               = '$data->stok_lama',
                                stok_baru               = '$data->stok_baru',
                                selisih                 = '$data->selisih',
                                created_user            = '$this->user_id',
                                created_date            = CURRENT_TIMESTAMP ";
        return $this->db->query($sql);
    }
}
