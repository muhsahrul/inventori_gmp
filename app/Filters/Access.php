<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Access implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $request = \Config\Services::request();
        $data_access = session()->get('data_access');
        $select_url = implode("|", array_column($data_access, 'url'));
        $data_url = explode("|", $select_url);

        $url = uri_string(true);
        $explode_url = explode("/", $url);
        $sliced_url = array_slice($explode_url, 1, 2);
        $map_url = array_map('strtolower', $sliced_url);

        if (count(array_intersect($data_url, $map_url)) !== count($map_url) && substr($map_url[array_key_last($map_url)], 0, 4) != 'load') {
            if ($request->isAJAX() === true) {
                die('<script>accessAlert();</script>');
            }
            die(view('errors/html/error_access.html'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
