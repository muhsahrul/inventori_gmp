<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report-parameter_" . date('d-m-Y') . ".xls");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Report Per Parameter</title>
</head>

<body>
    <h2>Report Per Parameter</h2>
    <table border="0">
        <tbody>
            <tr>
                <td>Tanggal</td>
                <td>: <?= date('d-m-Y', strtotime($filter_tglawal)); ?> s/d <?= date('d-m-Y', strtotime($filter_tglakhir)); ?></td>
            </tr>
            <tr>
                <td>Parameter Uji</td>
                <td>: <?= $filter_parameter; ?></td>
            </tr>
            <tr>
                <table border="1">
                    <thead>
                        <tr>
                            <th align="center">No.</th>
                            <th align="center">Kode Bahan</th>
                            <th align="center">Nama</th>
                            <th align="center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($parameter as $value) { ?>
                            <tr>
                                <td align="center"><?= $no++; ?></td>
                                <td align="center"><?= $value['kode']; ?></td>
                                <td align="center"><?= $value['nama_bahan']; ?></td>
                                <td align="center"><?= ($value['jumlah']) ? str_replace('.', ',', $value['jumlah']) : 0; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
        </tbody>
    </table>
</body>

</html>