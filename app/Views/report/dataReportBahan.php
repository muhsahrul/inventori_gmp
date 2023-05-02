<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">No.</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Total Masuk</th>
            <th class="text-center">Total Keluar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data_bahan as $value) { ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($value['tanggal'])); ?></td>
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
            </tr>
        <?php } ?>
    </tbody>
</table>
<a href="<?= site_url(); ?>report/reportBahan/exportExcelReportBahan?tglawal=<?= $filter_tglawal; ?>&tglakhir=<?= $filter_tglakhir; ?>&bahan=<?= $filter_bahan; ?>" class="btn btn-default">Export ke Excel</a>