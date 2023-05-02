<?php

namespace App\Models;

class QueryAuth
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function getLogin($email)
    {
        $sql = "    SELECT  *
                    FROM    tb_pegawai
                    WHERE   email = '$email'  ";
        return $this->db->query($sql);
    }

    public function getAccess($id)
    {
        $sql = "    SELECT      p.url
                    FROM        m_role_permission_inventori_kimia rp
                    LEFT JOIN   m_permission_inventori_kimia p ON p.id = rp.m_permission_inventori_kimia
                    WHERE       rp.tb_pegawai = $id
                                AND p.is_active = 1
                                AND rp.is_delete = 0  ";
        return $this->db->query($sql);
    }
}
