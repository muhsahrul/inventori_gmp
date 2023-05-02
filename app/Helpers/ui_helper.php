<?php

use App\Models\QueryCore;

if (!function_exists('loader')) {
    function loader()
    {
        return include_once APPPATH . 'Views/layout/loader.php';
    }
}

if (!function_exists('contentHeader')) {
    function contentHeader($status = false, $header)
    {
        if ($status == true) {
            return include_once APPPATH . 'Views/layout/content_header.php';
        } else {
            return null;
        }
    }
}

if (!function_exists('textHeader')) {
    function textHeader($title = null, $subtitle = null, $breadcrumb = null)
    {
        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'breadcrumb' => $breadcrumb,
        ];
        return $data;
    }
}

if (!function_exists('modalName')) {
    function modalName($create = null, $edit = null, $detail = null)
    {
        $data = [
            'create' => $create,
            'edit' => $edit,
            'detail' => $detail,
        ];
        return (object)$data;
    }
}

if (!function_exists('filterCabang')) {
    function filterCabang()
    {
        $qCabang = new QueryCore();
        $cabang = $qCabang->getCabang()->getResultArray();
        return $cabang;
    }
}
