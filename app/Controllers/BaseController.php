<?php

namespace App\Controllers;

use App\Models\QueryCore;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];
    protected $data = [];
    protected $loader = true;

    protected $db;

    protected $qCore;
    protected $cabang;
    protected $modalName;
    protected $cabangAktif;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        session();
        date_default_timezone_set("Asia/Jakarta");

        $this->db = \Config\Database::connect();

        $this->qCore = new QueryCore();
        $this->cabang = $this->qCore->getCabang()->getResultArray();
        $this->cabangAktif = session()->get('cabang_aktif') ? session()->get('cabang_aktif') : session()->get('user_cabang');
    }

    public function alert($proses, $err = false, $msg = false)
    {
        if ($proses === false) {
            $response = [
                'status' => 500,
                'message' => $err ? $err : 'Data Gagal Disimpan',
                'error' => true
            ];
        } else {
            $response = [
                'status' => 200,
                'message' => $msg ? $msg : 'Data Berhasil Disimpan',
                'error' => false
            ];
        }
        return $response;
        // Return Method Parent Controller
        // return json_encode($this->alert($proses));
    }

    public function alertTrans($status, $err = false, $msg = false)
    {
        $this->db = \Config\Database::connect();
        if ($status === false) {
            $this->db->transRollback();
            $response = [
                'status' => 500,
                'message' => $err ? $err : 'Data Gagal Disimpan',
                'error' => true
            ];
        } else {
            $this->db->transCommit();
            $response = [
                'status' => 200,
                'message' => $msg ? $msg : 'Data Berhasil Disimpan',
                'error' => false
            ];
        }
        return $response;
        // Return Method Parent Controller
        // return json_encode($this->alertTrans($this->db->transStatus()));
    }
}
