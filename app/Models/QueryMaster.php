<?php

namespace App\Helpers;

class QueryMaster
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
            $sql = "    SELECT      i.*, s.nama AS nama_satuan
                        FROM        m_inventori_bahan_lab i
                        LEFT JOIN   m_inventori_bahan_lab_satuan s ON s.id = i.m_inventori_bahan_lab_satuan
                        WHERE       i.is_delete = 0
                        ORDER BY    i.kode ASC, i.nama ASC   ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab
                    WHERE   id = '$id'  ";
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

    public function getVendor($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT  *
                        FROM    m_vendor
                        WHERE   is_delete = 0
                        ORDER BY nama ASC  ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT  *
                    FROM    m_vendor
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function saveBahan($data)
    {
        $sql = "    INSERT INTO     m_inventori_bahan_lab
                    SET             kode            = '$data->kode',
                                    nama            = '$data->nama',
                                    alias           = '$data->alias',
                                    m_inventori_bahan_lab_satuan = '$data->satuan',
                                    created_user    = '$this->user_id',
                                    created_date    = CURRENT_TIMESTAMP  ";
        return $this->db->query($sql);
    }

    public function updateBahan($id, $data)
    {
        $sql = "    UPDATE  m_inventori_bahan_lab
                    SET     kode            = '$data->kode',
                            nama            = '$data->nama',
                            alias           = '$data->alias',
                            m_inventori_bahan_lab_satuan = '$data->satuan',
                            updated_user    = '$this->user_id',
                            updated_date    = CURRENT_TIMESTAMP
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function deleteBahan($id)
    {
        $sql = "    UPDATE  m_inventori_bahan_lab
                    SET     is_delete = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function saveSatuan($nama)
    {
        $sql = "    INSERT INTO     m_inventori_bahan_lab_satuan
                    SET             nama         = '$nama',
                                    created_user = '$this->user_id',
                                    created_date = CURRENT_TIMESTAMP  ";
        return $this->db->query($sql);
    }

    public function updateSatuan($id, $nama)
    {
        $sql = "    UPDATE  m_inventori_bahan_lab_satuan
                    SET     nama         = '$nama',
                            updated_user = '$this->user_id',
                            updated_date = CURRENT_TIMESTAMP
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function deleteSatuan($id)
    {
        $sql = "    UPDATE  m_inventori_bahan_lab_satuan
                    SET     is_delete    = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function saveVendor($data)
    {
        $sql = "    INSERT INTO     m_vendor
                    SET             nama            = '$data->nama',
                                    alamat          = '$data->alamat',
                                    email           = '$data->email',
                                    telp            = '$data->telp',
                                    pic_nama        = '$data->pic_nama',
                                    pic_telp        = '$data->pic_telp',
                                    created_user    = '$this->user_id',
                                    created_date    = CURRENT_TIMESTAMP  ";
        return $this->db->query($sql);
    }

    public function updateVendor($id, $data)
    {
        $sql = "    UPDATE  m_vendor
                    SET     nama            = '$data->nama',
                            alamat          = '$data->alamat',
                            email           = '$data->email',
                            telp            = '$data->telp',
                            pic_nama        = '$data->pic_nama',
                            pic_telp        = '$data->pic_telp',
                            updated_user    = '$this->user_id',
                            updated_date    = CURRENT_TIMESTAMP
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function deleteVendor($id)
    {
        $sql = "    UPDATE  m_vendor
                    SET     is_delete    = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function getKatalog($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT      a.*, b.kode, b.nama AS nama_bahan, b.alias, c.nama AS satuan, v.nama AS vendor
                        FROM        m_inventori_bahan_lab_katalog a
                        JOIN        m_inventori_bahan_lab b ON b.id = a.m_inventori_bahan_lab AND b.is_delete = 0
                        LEFT JOIN   m_inventori_bahan_lab_satuan c ON c.id = b.m_inventori_bahan_lab_satuan AND c.is_delete = 0
                        LEFT JOIN   m_vendor v ON v.id = a.m_vendor AND v.is_delete = 0
                        WHERE       a.is_delete = 0  ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT      a.*, b.kode, b.nama AS nama_bahan, b.alias, c.nama AS satuan, v.nama AS vendor
                    FROM        m_inventori_bahan_lab_katalog a
                    JOIN        m_inventori_bahan_lab b ON b.id = a.m_inventori_bahan_lab AND b.is_delete = 0
                    LEFT JOIN   m_inventori_bahan_lab_satuan c ON c.id = b.m_inventori_bahan_lab_satuan AND c.is_delete = 0
                    LEFT JOIN   m_vendor v ON v.id = a.m_vendor AND v.is_delete = 0
                    WHERE       a.id = '$id'
                                AND a.is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function saveKatalog($katalog, $bahan, $vendor, $gramasi)
    {
        $sql = "    INSERT INTO m_inventori_bahan_lab_katalog
                    SET         no_katalog              = '$katalog',
                                m_vendor                = '$vendor',
                                m_inventori_bahan_lab   = '$bahan',
                                gramasi                 = '$gramasi',
                                created_user            = '$this->user_id',
                                created_date            = CURRENT_TIMESTAMP    ";
        return $this->db->query($sql);
    }

    public function updateKatalog($id, $katalog, $bahan, $vendor, $gramasi)
    {
        $sql = "    UPDATE  m_inventori_bahan_lab_katalog
                    SET     no_katalog              = '$katalog',
                            m_inventori_bahan_lab   = '$bahan',
                            m_vendor                = '$vendor',
                            gramasi                 = '$gramasi',
                            updated_user            = '$this->user_id',
                            updated_date            = CURRENT_TIMESTAMP
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function deleteKatalog($id)
    {
        $sql = "    UPDATE  m_inventori_bahan_lab_katalog
                    SET     is_delete    = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }

    public function getGramasi($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT      a.*, b.nama AS nama_bahan, b.alias, c.nama AS satuan
                        FROM        m_inventori_bahan_lab_gramasi a
                        LEFT JOIN   m_inventori_bahan_lab b ON b.id = a.m_inventori_bahan_lab
                        LEFT JOIN   m_inventori_bahan_lab_satuan c ON c.id = b.m_inventori_bahan_lab_satuan
                        WHERE       a.is_delete = 0  ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT  *
                    FROM    m_inventori_bahan_lab_gramasi
                    WHERE   id = $id
                            AND is_delete = 0  ";
        return $this->db->query($sql);
    }

    public function saveGramasi($gramasi, $bahan)
    {
        $sql = "    INSERT INTO m_inventori_bahan_lab_gramasi
                    SET         m_inventori_bahan_lab   = '$bahan',
                                gramasi                 = '$gramasi',
                                created_user            = '$this->user_id',
                                created_date            = CURRENT_TIMESTAMP    ";
        return $this->db->query($sql);
    }

    public function updateGramasi($id, $gramasi, $bahan)
    {
        $sql = "    UPDATE  m_inventori_bahan_lab_gramasi
                    SET     m_inventori_bahan_lab   = '$bahan',
                            gramasi                 = '$gramasi',
                            updated_user            = '$this->user_id',
                            updated_date            = CURRENT_TIMESTAMP
                    WHERE   id = '$id'  ";
        return $this->db->query($sql);
    }

    public function deleteGramasi($id)
    {
        $sql = "    UPDATE  m_inventori_bahan_lab_gramasi
                    SET     is_delete    = 1,
                            deleted_user = '$this->user_id',
                            deleted_date = CURRENT_TIMESTAMP
                    WHERE   id = $id  ";
        return $this->db->query($sql);
    }
}
