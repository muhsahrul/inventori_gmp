<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report-bahan_" . date('d-m-Y') . ".xls");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Report Per Bahan</title>
</head>

<body>
    <h2>Report Per Bahan</h2>
    <table border="0">
        <tbody>
            <tr>
                <td>Tanggal</td>
                <td><?= date('d-m-Y', strtotime($filter_tglawal)); ?> s/d <?= date('d-m-Y', strtotime($filter_tglakhir)); ?></td>
            </tr>
            <tr>
                <td>Bahan</td>
                <td><?= $filter_bahan; ?></td>
            </tr>
        </tbody>
    </table>
    <table border="1">
        <thead>
            <tr>
                <th align="center">No.</th>
                <th align="center">Tanggal</th>
                <th align="center">Total Masuk</th>
                <th align="center">Total Keluar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($data_bahan as $value) { ?>
                <tr>
                    <td align="center"><?= $no++; ?></td>
                    <td align="center"><?= date('d-m-Y', strtotime($value['tanggal'])); ?></td>
                    <td align="right"><?php if ($value['total_masuk'] > 999) {
                                            // if (is_float($value['total_masuk']) == TRUE) {
                                            $str = $value['total_masuk'];
                                            $dec = strlen(substr(strrchr($str, "."), 1));
                                            echo number_format($value['total_masuk'], $dec, ',', '.');
                                            // } else {
                                            //     echo (float)number_format($value['total_masuk'], 0, ',', '.');
                                            // }
                                        } else {
                                            echo str_replace('.', ',', $value['total_masuk']);
                                        }; ?></td>
                    <td align="right"><?php
                                        // ($value['total_keluar'] > 999) ? (float)number_format($value['total_keluar'], 4, ',', '.') : str_replace('.', ',', $value['total_keluar']);
                                        if ($value['total_keluar'] > 999) {
                                            // if (is_float($value['total_keluar']) == TRUE) {
                                            $str = $value['total_keluar'];
                                            $dec = strlen(substr(strrchr($str, "."), 1));
                                            echo number_format($value['total_keluar'], $dec, ',', '.');
                                            // } else {
                                            //     echo (float)number_format($value['total_keluar'], 0, ',', '.');
                                            // }
                                        } else {
                                            echo str_replace('.', ',', $value['total_keluar']);
                                        }
                                        ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>

</html>