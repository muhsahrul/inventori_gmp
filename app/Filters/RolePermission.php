<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Helpers\QueryMaster;

class RolePermission implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $query = new QueryMaster;
        $url = current_url(true);
        $segments = $url->getSegments();
        $role = session()->get('user_id');

        $getRole = $query->getAccess($role)->getResultArray();
        $data_url = implode(',', array_column($getRole, 'url'));
        $data_url = explode(',', $data_url);
        $data_url = array_map('strtolower', $data_url);
        // // $data = implode(" | ", $url);
        // // $data = explode(" | ", $data);
        if (count($segments) == 4) {
            $slice_url = array_slice($segments, 2, 2);
            $implode_url = strtolower(implode('/', $slice_url));
        } elseif (count($segments) > 4) {
            $slice_url = array_slice($segments, 3, 2);
            $implode_url = strtolower(implode('/', $slice_url));
        }
        // dd($slice_url);
        // die;

        if (!in_array($implode_url, $data_url)) {
            if (substr($slice_url[1], 0, 4) != 'load' and substr($slice_url[1], 0, 5) != 'print' and substr($slice_url[1], 0, 6) != 'export') {
                echo view('errors/html/error_404');
                return die;
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
