<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report-barang-masuk-" . date('d-m-Y') . ".xls");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Report Barang Masuk</title>
</head>

<body>
    <h2>Report Barang Masuk</h2>
    <table border="0">
        <tbody>
            <tr>
                <td>Tanggal</td>
                <td><?= date('d-m-Y', strtotime($filter_tglawal)); ?> s/d <?= date('d-m-Y', strtotime($filter_tglakhir)); ?></td>
            </tr>
        </tbody>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th align="center" width="1%">No.</th>
                <th align="center">Tanggal Barang Masuk</th>
                <th align="center">Kode Bahan</th>
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
                <tr>
                    <td align="center"><?= $no++; ?></td>
                    <td align="center"><?= date('d-m-Y', strtotime($value['tanggal'])); ?></td>
                    <td align="center"><?= $value['kode']; ?></td>
                    <td><?= $value['alias']; ?></td>
                    <td><?= $value['no_katalog']; ?></td>
                    <td align="right"><?= $value['gramasi']; ?></td>
                    <td align="right"><?= $value['jumlah']; ?></td>
                    <td align="right"><?= number_format($value['harga'], 0, ",", "."); ?></td>
                    <td align="right"><?= number_format($value['total_harga'], 0, ",", "."); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>

</html>