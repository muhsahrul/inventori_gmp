<table class="table table-hover table-bordered table-striped" id="data-table">
    <thead>
        <tr>
            <th class="text-center">No.</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Kode Bahan</th>
            <th class="text-center">Nama Bahan</th>
            <th class="text-center">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($parameter as $value) {
            if ($value['id']) { ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td class="text-center"><?= date('d-m-Y', strtotime($value['tanggal'])); ?></td>
                    <td class="text-center"><?= $value['kode']; ?></td>
                    <td class="text-center"><?= $value['nama_bahan']; ?></td>
                    <td class="text-center"><?php if ($value['total_jumlah'] > 999) {
                                                $str = $value['total_jumlah'];
                                                $dec = strlen(substr(strrchr($str, "."), 1));
                                                echo number_format($value['total_jumlah'], $dec, ',', '.');
                                            } else {
                                                echo str_replace('.', ',', $value['total_jumlah']);
                                            }; ?></td>
                </tr>
        <?php }
        } ?>
    </tbody>
</table>
<a href="<?= site_url(); ?>report/reportParameter/exportExcelReportParameter?tglawal=<?= $filter_tglawal; ?>&tglakhir=<?= $filter_tglakhir; ?>&parameter=<?= $filter_parameter; ?>" class="btn btn-default">Export ke Excel</a>