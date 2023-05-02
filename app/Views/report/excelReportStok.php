<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report-stok-bahan_" . date('d-m-Y') . ".xls");
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
                <th align="center">Kode Bahan</th>
                <th align="center">Nama Bahan</th>
                <th align="center">Stok Awal</th>
                <th align="center">Total Masuk</th>
                <th align="center">Total Keluar</th>
                <th align="center">Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($bahan as $value) { ?>
                <tr>
                    <td align="center"><?= $value['kode']; ?></td>
                    <td align="center"><?= $value['nama']; ?></td>
                    <td align="right">
                        <?php if ($value['stok_awal'] > 999) {
                            // if (is_float($value['stok_awal']) == TRUE) {
                            $str = $value['stok_awal'];
                            $dec = strlen(substr(strrchr($str, "."), 1));
                            echo number_format($value['stok_awal'], $dec, ',', '.');
                            // } else {
                            //     echo (float)number_format($value['stok_awal'], 0, ',', '.');
                            // }
                        } else {
                            echo str_replace('.', ',', $value['stok_awal']);
                        }; ?></td>
                    <td align="right">
                        <?php if ($value['total_masuk'] > 999) {
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
                    <td align="right">
                        <?php
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
                    <td align="right">
                        <?php if ($value['stok_akhir'] > 999) {
                            // if (is_float($value['stok_akhir']) == TRUE) {
                            $str = $value['stok_akhir'];
                            $dec = strlen(substr(strrchr($str, "."), 1));
                            echo number_format($value['stok_akhir'], $dec, ',', '.');
                            // } else {
                            //     echo (float)number_format($value['stok_akhir'], 0, ',', '.');
                            // }
                        } else {
                            echo str_replace('.', ',', $value['stok_akhir']);
                        }; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>

</html>