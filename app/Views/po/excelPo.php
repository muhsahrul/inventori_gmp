<?php

use App\Helpers\QueryPurchasing;

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report-po_" . date('d-m-Y') . ".xls");

$query = new QueryPurchasing();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Report Stok Bahan</title>
</head>

<body>
    <h2>Report Stok Bahan</h2>
    <table border="0">
        <tbody>
            <tr>
                <td>Tanggal</td>
                <td>: <?= date('d-m-Y', strtotime($filter_tglawal)); ?> s/d <?= date('d-m-Y', strtotime($filter_tglakhir)); ?></td>
            </tr>
        </tbody>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th align="center">Tanggal PO</th>
                <th align="center">Nomor PO</th>
                <th align="center">Supplier</th>
                <th align="center">Nama Bahan (Vendor)</th>
                <th align="center">No. Katalog</th>
                <th align="center">Gramasi</th>
                <th align="center">Harga Satuan</th>
                <th align="center">Jumlah</th>
                <th align="center">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($result as $value) { ?>
                <?php $data_param = $query->getBahanDetailPr($value['id'])->getResultArray();
                foreach ($data_param as $subvalue) { ?>
                    <tr>
                        <td align="center"><?= ($value['tanggal']) ? date('d-m-Y', strtotime($value['tanggal'])) : NULL; ?></td>
                        <td align="left"><?= $value['nomor']; ?></td>
                        <td align="left"><?= $value['nama_vendor']; ?></td>
                        <td align="left"><?= $subvalue['alias']; ?></td>
                        <td align="center"><?= $subvalue['no_katalog']; ?></td>
                        <td align="center"><?= $subvalue['gramasi']; ?></td>
                        <td align="right"><?= number_format($subvalue['harga'], 0, ',', '.'); ?></td>
                        <td align="center"><?= $subvalue['jumlah']; ?></td>
                        <td align="right"><?= number_format($subvalue['total_harga'], 0, ',', '.'); ?></td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</body>

</html>