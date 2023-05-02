<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report-bahan_" . date('d-m-Y') . ".xls");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Report Penyesuaian Stok</title>
</head>

<body>
    <h2>Report Penyesuaian Stok</h2>
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
                <th align="center">Tanggal Penyesuaian</th>
                <th align="center">Stok Lama</th>
                <th align="center">Stok Penyesuaian</th>
                <th align="center">Selisih</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($result as $value) { ?>
                <tr>
                    <td align="center"><?= $no++; ?></td>
                    <td align="center"><?= date('d-m-Y', strtotime($value['tgl_penyesuaian'])); ?></td>
                    <td align="right">
                        <?php if ($value['stok_lama'] > 999) {
                            $str = $value['stok_lama'];
                            $dec = strlen(substr(strrchr($str, "."), 1));
                            echo number_format($value['stok_lama'], $dec, ',', '.');
                        } else {
                            echo str_replace('.', ',', $value['stok_lama']);
                        }; ?>
                    </td>
                    <td align="right">
                        <?php
                        if ($value['stok_baru'] > 999) {
                            $str = $value['stok_baru'];
                            $dec = strlen(substr(strrchr($str, "."), 1));
                            echo number_format($value['stok_baru'], $dec, ',', '.');
                        } else {
                            echo str_replace('.', ',', $value['stok_baru']);
                        }
                        ?>
                    </td>
                    <td align="right">
                        <?php
                        if ($value['selisih'] > 999) {
                            $str = $value['selisih'];
                            $dec = strlen(substr(strrchr($str, "."), 1));
                            echo number_format($value['selisih'], $dec, ',', '.');
                        } else {
                            echo str_replace('.', ',', $value['selisih']);
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>

</html>