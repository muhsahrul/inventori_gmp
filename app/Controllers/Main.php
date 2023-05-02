<?php

namespace App\Controllers;

use App\Helpers\QueryMaster;

class Main extends BaseController
{
    protected $query;

    public function index()
    {
        $this->data = [
            'header' => textHeader("Dashboard", "Dashboard"),
            'content_header' => true,
            'content' => 'Selamat Datang <b>' . session()->get('user_name') . '</b> di Aplikasi RKAP',
        ];
        return view('dashboard', $this->data);
    }

    public function changeActiveCabang($cabang)
    {
        $proses = session()->set('cabang_aktif', $cabang);
        return json_encode($this->alert($proses, "Cabang Gagal Diubah", "Cabang Berhasil Diubah"));
    }

    public function backupDb()
    {
        helper('filesystem');
        $db = \Config\Database::connect();
        $dbname = $db->database;
        $path = FCPATH;            // change path here
        $filename = $dbname . '_' . date('ymd_Hi') . '.sql';   // change file name here
        $prefs = ['filename' => $filename];              // I only set the file name, for complete prefs see below 

        $util = (new \CodeIgniter\Database\Database())->loadUtils($db);
        $backup = $util->backup($prefs, $db);

        write_file($path . $filename . '.gz', $backup);
        return $this->response->download($path . $filename . '.gz', null);
    }
}
