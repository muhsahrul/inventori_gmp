<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report-jatuh-tempo_" . date('d-m-Y') . ".xls");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Report Jatuh Tempo</title>
</head>

<body>
    <h2>Report Jatuh Tempo</h2>
    <table border="0">
        <tbody>
            <tr>
                <td>Tanggal</td>
                <td><?= date('d-m-Y', strtotime($filter_tglawal)); ?> s/d <?= date('d-m-Y', strtotime($filter_tglakhir)); ?></td>
            </tr>
            <tr>
                <td>Status Pembayaran</td>
                <td><?= ($filter_status_pembayaran) ? $filter_status_pembayaran : 'Tampil Semua'; ?></td>
            </tr>
        </tbody>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th align="center" width="1%">No.</th>
                <th align="center">Tanggal PO</th>
                <th align="center">Nomor PO</th>
                <th align="center">Supplier</th>
                <th align="center">Tanggal Barang Masuk</th>
                <th align="center">Tanggal Invoice</th>
                <th align="center">Nomor Invoice</th>
                <th align="center">Total Tagihan</th>
                <th align="center">Tanggal Jatuh Tempo</th>
                <th align="center">Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($jatuhtempo as $value) { ?>
                <tr>
                    <td align="center"><?= $no++; ?></td>
                    <td align="center"><?= ($value['tanggal_po']) ? date('d-m-Y', strtotime($value['tanggal_po'])) : NULL; ?></td>
                    <td><?= $value['nomor_po']; ?></td>
                    <td><?= $value['nama_vendor']; ?></td>
                    <td align="center"><?= ($value['tanggal']) ? date('d-m-Y', strtotime($value['tanggal'])) : NULL; ?></td>
                    <td align="center"><?= ($value['tanggal_invoice']) ? date('d-m-Y', strtotime($value['tanggal_invoice'])) : NULL; ?></td>
                    <td align="center"><?= $value['nomor_invoice']; ?></td>
                    <td align="right"><?= number_format($value['grand_total'], 0, ',', '.'); ?></td>
                    <td align="center"><?= ($value['tanggal_jt_bayar']) ? date('d-m-Y', strtotime($value['tanggal_jt_bayar'])) : NULL; ?></td>
                    <td align="center"><?= $value['status_pembayaran']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>

</html>