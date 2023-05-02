<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center" width="1%">No.</th>
            <th class="text-center">Tanggal Penyesuaian</th>
            <th class="text-center">Stok Lama</th>
            <th class="text-center">Stok Penyesuaian</th>
            <th class="text-center">Selisih</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($result as $value) { ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= date('d-m-Y', strtotime($value['tgl_penyesuaian'])); ?></td>
                <td class="text-right">
                    <?php if ($value['stok_lama'] > 999) {
                        $str = $value['stok_lama'];
                        $dec = strlen(substr(strrchr($str, "."), 1));
                        echo number_format($value['stok_lama'], $dec, ',', '.');
                    } else {
                        echo str_replace('.', ',', $value['stok_lama']);
                    }; ?>
                </td>
                <td class="text-right">
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
                <td class="text-right">
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
<a href="<?= site_url(); ?>report/reportPenyesuaian/exportExcelReportPenyesuaian?tglawal=<?= $filter_tglawal; ?>&tglakhir=<?= $filter_tglakhir; ?>&bahan=<?= $filter_bahan; ?>" class="btn btn-default">Export ke Excel</a>