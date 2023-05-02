<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center">Kode Bahan</th>
            <th class="text-center">Nama Bahan</th>
            <th class="text-center">Stok Awal</th>
            <th class="text-center">Total Masuk</th>
            <th class="text-center">Total Keluar</th>
            <th class="text-center">Stok Akhir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($bahan as $value) { ?>
            <tr>
                <td class="text-center"><?= $value['kode']; ?></td>
                <td><?= $value['nama']; ?></td>
                <td class="text-right"><?php if ($value['stok_awal'] > 999) {
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
                <td class="text-right"><?php if ($value['total_masuk'] > 999) {
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
                <td class="text-right"><?php
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
                <td class="text-right"><?php if ($value['stok_akhir'] > 999) {
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
<a href="<?= site_url(); ?>report/ReportStok/exportExcelReportStok?tglawal=<?= $filter_tglawal; ?>&tglakhir=<?= $filter_tglakhir; ?>" class="btn btn-default">Export ke Excel</a>