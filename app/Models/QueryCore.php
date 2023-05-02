<?php

namespace App\Models;

class QueryCore
{
    protected $db;
    protected $user_cabang;
    protected $user_id;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->user_cabang = session()->get('user_cabang');
        $this->user_id = session()->get('user_id');
    }

    public function getCabang($id = false)
    {
        if ($id === false) {
            $sql = "    SELECT      id,nama
                        FROM        m_cabang_alt
                        WHERE       is_delete = 0    ";
            return $this->db->query($sql);
        }
        $sql = "    SELECT  id,nama
                    FROM    m_cabang_alt
                    WHERE   id = $id    ";
        return $this->db->query($sql);
    }

    public function setWhere($data)
    {
        $where = "";
        foreach ($data as $key => $value) {
            $where .= "AND " . $key . "='" . $value . "',";
        }
        return ltrim($where, 'AND');
    }

    public function setValue($data)
    {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= $key . "='" . $value . "',";
        }
        // return rtrim($set, ',');
        return $set;
    }
}
